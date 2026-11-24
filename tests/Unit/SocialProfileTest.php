<?php namespace Tests\Unit;

use App\Support\SocialProfile;
use Tests\TestCase;

final class SocialProfileTest extends TestCase
{
    public function testItReadsMappedSocialiteAttributes(): void
    {
        $socialiteUser = (object) [
            'id' => '123456789',
            'name' => 'Ada Lovelace',
            'nickname' => 'ada',
            'avatar' => 'https://cdn.example/ada.png',
        ];

        $profile = SocialProfile::fromSocialite($socialiteUser, 'vkontakte');

        $this->assertSame('vkontakte', $profile->provider);
        $this->assertSame('123456789', $profile->providerId);
        $this->assertSame('Ada Lovelace', $profile->name);
        $this->assertSame('https://cdn.example/ada.png', $profile->avatar);
    }

    public function testItFallsBackToRawVkontakteFields(): void
    {
        $socialiteUser = (object) [
            'user' => (object) [
                'id' => 42,
                'first_name' => 'Grace',
                'last_name' => 'Hopper',
                'photo_max' => 'https://cdn.example/grace.png',
            ],
        ];

        $profile = SocialProfile::fromSocialite($socialiteUser, 'vkontakte');

        $this->assertSame('42', $profile->providerId);
        $this->assertSame('Grace Hopper', $profile->name);
        $this->assertSame('https://cdn.example/grace.png', $profile->avatar);
    }

    public function testItFallsBackToRawGoogleFields(): void
    {
        $socialiteUser = (object) [
            'user' => (object) [
                'id' => '109876543210',
                'displayName' => 'Alan Turing',
                'image' => (object) ['url' => 'https://cdn.example/alan.png'],
            ],
        ];

        $profile = SocialProfile::fromSocialite($socialiteUser, 'google');

        $this->assertSame('109876543210', $profile->providerId);
        $this->assertSame('Alan Turing', $profile->name);
        $this->assertSame('https://cdn.example/alan.png', $profile->avatar);
    }

    public function testIdentitiesFromDifferentProvidersCannotCollide(): void
    {
        $facebook = SocialProfile::fromSocialite((object) ['id' => '1000000001'], 'facebook');
        $google = SocialProfile::fromSocialite((object) ['id' => '1000000001'], 'google');

        $this->assertSame('facebook:1000000001', $facebook->identity());
        $this->assertSame('google:1000000001', $google->identity());
        $this->assertNotSame($facebook->identity(), $google->identity());
    }

    public function testLegacyBareIdsRemainLookupable(): void
    {
        $profile = SocialProfile::fromSocialite((object) ['id' => '777'], 'facebook');

        $this->assertSame(['facebook:777', '777'], $profile->lookupIds());
    }

    public function testMissingDisplayFieldsUseSafeDefaults(): void
    {
        $profile = SocialProfile::fromSocialite((object) [], 'google');

        $this->assertSame('unknown', $profile->providerId);
        $this->assertSame('Player', $profile->name);
        $this->assertSame('', $profile->avatar);
    }
}
