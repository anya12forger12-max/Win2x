<?php namespace App\Support;

/**
 * Normalised identity extracted from a Socialite user.
 *
 * Socialite exposes mapped attributes on the object itself, not through a
 * `user` property. Older code in this application dereferenced `->user` for
 * vkontakte and google, which crashes with current Socialite versions. Raw
 * provider fields are accepted as a fallback so existing sessions keep working.
 */
final class SocialProfile
{
    public function __construct(
        public readonly string $provider,
        public readonly string $providerId,
        public readonly string $name,
        public readonly string $avatar,
    ) {
    }

    public static function fromSocialite(object $user, string $provider): self
    {
        $raw = isset($user->user) && is_object($user->user) ? $user->user : null;

        $providerId = self::firstNonEmpty([
            $user->id ?? null,
            $raw->id ?? null,
        ]);

        $name = trim(self::firstNonEmpty([
            $user->name ?? null,
            $user->nickname ?? null,
            isset($raw->first_name, $raw->last_name)
                ? trim($raw->first_name.' '.$raw->last_name)
                : null,
            $raw->displayName ?? null,
            $raw->name ?? null,
        ], ''));

        $avatar = self::firstNonEmpty([
            $user->avatar ?? null,
            $raw->photo_max ?? null,
            $raw->photo_200 ?? null,
            $raw->picture ?? null,
            isset($raw->image) && is_object($raw->image) ? ($raw->image->url ?? null) : null,
        ], '');

        return new self(
            strtolower($provider),
            $providerId !== '' ? $providerId : 'unknown',
            $name !== '' ? $name : 'Player',
            $avatar,
        );
    }

    /**
     * Provider-scoped value for the legacy `users.user_id` column.
     *
     * Provider ids are only unique inside their own provider. Namespacing them
     * stops a vkontakte id from resolving to a facebook/google account (and the
     * reverse), which would otherwise hand one player control of another.
     */
    public function identity(): string
    {
        return $this->provider.':'.$this->providerId;
    }

    /**
     * Legacy rows stored the bare provider id; keep accepting them for existing
     * accounts so upgrading does not duplicate or lock out players.
     *
     * @return string[]
     */
    public function lookupIds(): array
    {
        return array_values(array_unique([$this->identity(), $this->providerId]));
    }

    private static function firstNonEmpty(array $values, string $default = ''): string
    {
        foreach ($values as $value) {
            if ($value === null || $value === '') {
                continue;
            }
            if (is_scalar($value)) {
                return (string) $value;
            }
        }

        return $default;
    }
}
