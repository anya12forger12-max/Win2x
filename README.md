# Win2x — Laravel gaming platform snapshot

A Laravel application implementing a suite of casino-style mini-games — jackpot, wheel, crash, coin flip, battle, dice, and bomb — together with user accounts, social login, chat, promotions, an affiliate area, and an admin console.

> **Scope and legal note:** The codebase contains deposit and withdrawal routes and admin payout controls. This snapshot is for code study only. Do **not** deploy it for real money without the required licensing, KYC/AML controls, security review, and regulatory approval. No production deployment is implied or endorsed.

## Stack

- PHP `^8.3`, Laravel `^13.43`, Composer
- MySQL for persistence; Redis via `predis/predis` for cache/session/broadcasting
- Laravel Socialite with Facebook, Google, and VK providers
- `yajra/laravel-datatables-oracle` for admin tables, `anhskohbo/no-captcha` for verification
- PHPUnit and Mockery for tests

## Games and routes

`routes/web.php` is the best map of the app. Public game pages include:

| Page | Route | Controller |
| --- | --- | --- |
| Jackpot | `/` | `JackpotController@index` |
| Wheel | `/wheel` | `WheelController@index` |
| Crash | `/crash` | `CrashController@index` |
| Coin flip | `/coinflip` | `CoinFlipController@index` |
| Battle | `/battle` | `BattleController@index` |
| Dice | `/dice` | `DiceController@index` |
| Bomb | `/bomb` | `BombController@index` |

Authenticated users get betting endpoints (`/jackpot/newBet`, `/crash/newBet`, `/crash/cashout`, `/dice/play`, `/wheel/newBet`, `/battle/newBet`, and the bomb/coin-flip room flows), profile history, affiliate tools, promo activation, chat, exchange, deposit (`/pay`), and withdrawal (`/withdraw`).

An `/admin` group guarded by `auth` and an `access:admin` middleware covers users, settings, bonuses, promos, filters, withdrawals, fake-user controls, and chat moderation.

Social login is handled under `/auth/{provider}` and `/auth/callback/{provider}`.

## Quick start — 1 or 2 commands

```bash
./setup.sh          # install dependencies
./setup.sh run      # start the project (when a run target exists)
```

`setup.sh` detects this repository's build system and installs the right toolchain
dependencies. Use `./setup.sh test` to run the available checks. If a project has no
standard run target, the script prints the correct command from the sections above.

For this Laravel app, `setup.sh` runs `composer install`. To boot it manually:

```bash
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Configure `DB_*`, `REDIS_*`, and any mail/provider credentials in `.env` first. Never commit real credentials.

## Tests

`composer test` runs the PHPUnit suite under `tests/`. The included tests are a small smoke set (`ExampleTest`) plus `SocialProfileTest`; they do not require external services.

## Project layout

```
app/                Eloquent models (games, bets, users, payments) and service classes
app/Http/           controllers, middleware, requests
config/             Laravel configuration
database/           migrations, factories, seeds, and data.sql
public/             front-end assets and entry point
resources/          Blade views and front-end sources
routes/             web.php, api.php, channels.php, console.php
tests/              PHPUnit smoke tests
```

## Security notes

- `data.sql` no longer seeds an administrator account. The upstream dump contained a known bcrypt admin hash; that seed was removed. Register the first account and promote it explicitly by setting `is_admin = 1` on its `users` row.
- `.env.example` contains placeholders only. Replace all secrets locally and keep `.env` out of version control.
- The withdrawal and admin routes are privileged surfaces; review authorization middleware before exposing this app anywhere.

## License

There is no `LICENSE` file in this repository. `composer.json` declares `MIT` (the Laravel framework default), but no project-specific copyright or license notice is present, so confirm terms with the original authors before reuse.

## Historical notes

The original installation instructions (written in Russian, targeting PHP 7.2 and `betbase.gg`) are retained in the git history of `README.md`. They are outdated relative to this snapshot, which requires PHP 8.3 and Laravel 13, and they contain example passwords that must never be reused.
