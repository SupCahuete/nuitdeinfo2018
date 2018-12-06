<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>



## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent) .
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications.



## About Laravel Ada

Laravel Ada is a extension from Laravel 5.5 for the medium and large web application. The extension is based on a system of mutiple guards, a level's system (example: guest, frontuser, backuser, admin, master). Ada supports the groups web and api by token.

Laravel Ada included:

- New commands's interpretor: `adn`
- New helpers
- New Blade directives
- A views pre-compiler
- A sass compiler

### Adn, a new Artisan

A new `artisan`, named `adn`, for added a resources constructor (controllers, views, sass, guards, models, requests, middlewares, migrations, seeders, commands and facades) with multiple customizable templates and automatique an automatic generation of folders and layouts. Use the mutiple guard's system.

### Rappel

Les différents guards sont dans le fichier de configuration `config/auth.php`.

## Laravel Ada Docs

### New helpers

See `ada/Support/helpers.php`


- `d()`
- `asset_url_image()`
- `asset_url_css()`
- `asset_url_js()`

### New Blade directives.

Adds of new blade directives.

- `{{ d() }}` => `@d()`
- `{{ dd() }}` => `@dd()`
- `{{ var_dump() }}` => `@var_dump()`
- `{{ config() }}` => `@config()`
- `{{ route() }}` => `@route()`
- `{{ asset_url_image() }}` => `@image()`
- `{{ asset_url_css() }}` => `@css()`
- `{{ asset_url_js() }}` => `@js()`

### View's pre-compiler

A view's pre-compiler. Compilation supports the blade directive `@config()`, `@lang()`, `@choice()` and `{{ trans() }}`, `{{ trans_choice() }}`. Pas besoin de compiler en developpement local.

Uses the `adn` command for compiled : `php adn compiler:view`

### Sass's compiler

Uses the `adn` command for compiled : `php adn compiler:sass`

Compiled in `public/assets/css/*`

### Adn commands

#### make:guard (nouveau niveau d'authentification):

Base syntax: `php adn make:guard NAME GROUP` (nom du guard + nom du groupe (`web`, `api`, `all`)).

Le guard sera créer dans le fichier de configuration `config/auth.php`. Il sera accompagné d'un model correspondant, d'un middleware d'authentification et de redirection pour les guests, de controllers authentification (login, register, reset password), d'un fichier(s) de routes, de views et sass coorespondant à l'authentification. 

Certains fichiers seront mis à jour comme le provider de routage (`app/Providers/RouteServiceProvider.php`) et le kernel pour les middlewares (`app/Http/Kernel.php`)

Le groupe par défaut est web.

Le guard par défaut est 'guest'. (Exemple : `php adn make:controller contact` créera un controller invité (guest)).

Exemple avec un guard `backuser` :
- `php adn make:guard backuser web --guard`

Autres options :
- `--data` : Utilisé le fichier `config/consoleData.php` pour remplacer les valeurs par défaut dans les différents fichiers créés.
- `--all` : spécifie tout les groupes supportés (`web` + `api`).

#### make:controller (controller + route + view + sass):

Base syntax: `php adn make:controller CONTROLLER_NAME` (nom du controller).

Le controller créera automatiquement la view `index` correspondante à sa méthode `index` :
- `php adn make:controller CONTROLLER_NAME { --guard=GUARD_NAME } { --group=[web|api] }`

Le groupe par défaut est web.

Le guard par défaut est 'guest'. (Exemple : `php adn make:controller contact` créera un controller invité (guest)).

Exemple avec un guard `backuser` :
- `php adn make:controller contact --guard=backuser`

Autres options :
- `--guard` : spécifie le guard utilisé.
- `--group` : spécifie le groupe utilisé.
- `--viewAll` : créer 3 views pour les méthodes index, create et edit.
- `--noview` : ne crée pas de views pour les méthodes du controller.
- `--guest` : n'ajoute pas de middleware d'autentification (accès invité).
- `--singular` : forcer le nom du controller au singulier.
- `--noroute` : n'ajoute pas de routes automatiquement pour ce controller.


#### make:view (view + sass):

Base syntax: `php adn make:view CRONTOLER.METHOD` (nom du controller + point + nom de la méthode). Example: `php adn make:view contact.index`

La view créera automatiquement un fichier sass du même nom qui lui est lié:
- `php adn make:controller VIEW_NAME { --guard=GUARD_NAME }`

Le guard par défaut est 'guest'. (Exemple : `php adn make:view contact` créera une view invité (guest)).

Exemple avec un guard `backuser` :
- `php adn make:view contact --guard=backuser`

Autres options :
- `--template` : spécifie un template précis.
- `--guard` : spécifie le guard utilisé (example: backuser, admin, ...).
- `--extend` : spécifie l'extension blade (le layout) a utilisé entre `main` (par défaut), `email` et `menu`.


## Security Vulnerabilities

If you discover a security vulnerability within Laravel Ada, please send an e-mail to Mehdi Mayer via [mehdi@hexago-on.com](mailto:mehdi@hexago-on.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
