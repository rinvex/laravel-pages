# Rinvex Pages Change Log

All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](CONTRIBUTING.md).


## [v4.0.1] - 2020-03-20
- Convert into bigInteger database fields
- Add shortcut -f (force) for artisan publish commands
- Fix migrations path

## [v4.0.0] - 2020-03-15
- Upgrade to Laravel v7.1.x & PHP v7.4.x

## [v3.0.2] - 2020-03-13
- Tweak TravisCI config
- Add migrations autoload option to the package
- Tweak service provider `publishesResources`
- Remove indirect composer dependency
- Drop using global helpers
- Update StyleCI config

## [v3.0.1] - 2019-12-18
- Fix `migrate:reset` args as it doesn't accept --step
- Create event classes and map them in the model

## [v3.0.0] - 2019-09-23
- Upgrade to Laravel v6 and update dependencies

## [v2.1.1] - 2019-06-03
- Enforce latest composer package versions

## [v2.1.0] - 2019-06-02
- Update composer deps
- Drop PHP 7.1 travis test
- Refactor migrations and artisan commands, and tweak service provider publishes functionality

## [v2.0.0] - 2019-03-03
- Rename environment variable QUEUE_DRIVER to QUEUE_CONNECTION
- Require PHP 7.2 & Laravel 5.8

## [v1.0.2] - 2018-12-22
- Update composer dependencies
- Add PHP 7.3 support to travis
- Fix MySQL / PostgreSQL json column compatibility

## [v1.0.1] - 2018-10-24
- Catch pre-db connection exceptions

## [v1.0.0] - 2018-10-01
- Enforce Consistency
- Support Laravel 5.7+
- Rename package to rinvex/laravel-pages

## [v0.0.2] - 2018-09-22
- Update travis php versions
- Drop StyleCI multi-language support (paid feature now!)
- Update composer dependencies
- Prepare and tweak testing configuration
- Update StyleCI options
- Update PHPUnit options
- Rename model activation and deactivation methods
- Add page model factory

## v0.0.1 - 2018-02-18
- Tag first release

[v4.0.1]: https://github.com/rinvex/laravel-pages/compare/v4.0.0...v4.0.1
[v4.0.0]: https://github.com/rinvex/laravel-pages/compare/v3.0.2...v4.0.0
[v3.0.2]: https://github.com/rinvex/laravel-pages/compare/v3.0.1...v3.0.2
[v3.0.1]: https://github.com/rinvex/laravel-pages/compare/v3.0.0...v3.0.1
[v3.0.0]: https://github.com/rinvex/laravel-pages/compare/v2.1.1...v3.0.0
[v2.1.1]: https://github.com/rinvex/laravel-pages/compare/v2.1.0...v2.1.1
[v2.1.0]: https://github.com/rinvex/laravel-pages/compare/v2.0.0...v2.1.0
[v2.0.0]: https://github.com/rinvex/laravel-pages/compare/v1.0.2...v2.0.0
[v1.0.2]: https://github.com/rinvex/laravel-pages/compare/v1.0.1...v1.0.2
[v1.0.1]: https://github.com/rinvex/laravel-pages/compare/v1.0.0...v1.0.1
[v1.0.0]: https://github.com/rinvex/laravel-pages/compare/v0.0.2...v1.0.0
[v0.0.2]: https://github.com/rinvex/laravel-pages/compare/v0.0.1...v0.0.2
