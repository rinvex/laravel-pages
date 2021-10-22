# Rinvex Pages Change Log

All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](CONTRIBUTING.md).


## [v6.0.1] - 2021-10-22
- Update .styleci.yml fixers
- Fix page route domain definition
- Check before detaching pages if deleted entity was soft deleted

## [v6.0.0] - 2021-08-22
- Drop PHP v7 support, and upgrade rinvex package dependencies to next major version
- Update composer dependencies

## [v5.0.7] - 2021-05-24
- Merge rules instead of resetting, to allow adequate model override
- Update spatie/eloquent-sortable composer package to v4.0.0
- Update spatie/laravel-translatable composer package to v5.0.0
- Update spatie/laravel-sluggable composer package to v3.0.0

## [v5.0.6] - 2021-05-11
- Fix constructor initialization order (fill attributes should come next after merging fillables & rules)

## [v5.0.5] - 2021-05-07
- Drop old MySQL versions support that doesn't support json columns
- Upgrade to GitHub-native Dependabot
- Utilize SoftDeletes
- Update pageable usage example to utilize runtime service container instead of hardcoded model
- Update usage example to utilize dynamic relashionships

## [v5.0.4] - 2021-02-06
- Simplify service provider model registration into IoC

## [v5.0.3] - 2021-01-16
- Update missing pages config option

## [v5.0.2] - 2021-01-15
- Attach resources to page "Pageables"
- Enable StyleCI risky mode

## [v5.0.1] - 2020-12-25
- Add support for PHP v8

## [v5.0.0] - 2020-12-22
- Upgrade to Laravel v8
- Move custom eloquent model events to module layer from core package layer
- Refactor and tweak Eloquent Events

## [v4.1.2] - 2020-08-04
- Update content field validation rule

## [v4.1.1] - 2020-07-16
- Update validation rules

## [v4.1.0] - 2020-06-15
- Update validation rules
- Drop using rinvex/laravel-cacheable from core packages for more flexibility
  - Caching should be handled on the application layer, not enforced from the core packages
- Drop PHP 7.2 & 7.3 support from travis

## [v4.0.6] - 2020-05-30
- Remove default indent size config
- Add strip_tags validation rule to string fields
- Specify events queue
- Explicitly specify relationship attributes
- Add strip_tags validation rule
- Explicitly define relationship name

## [v4.0.5] - 2020-04-12
- Fix ServiceProvider registerCommands method compatibility

## [v4.0.4] - 2020-04-09
- Tweak artisan command registration
- Reverse commit "Convert database int fields into bigInteger"
- Refactor publish command and allow multiple resource values

## [v4.0.3] - 2020-04-04
- Fix namespace issue

## [v4.0.2] - 2020-04-04
- Enforce consistent artisan command tag namespacing
- Enforce consistent package namespace
- Drop laravel/helpers usage as it's no longer used

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

[v6.0.1]: https://github.com/rinvex/laravel-pages/compare/v6.0.0...v6.0.1
[v6.0.0]: https://github.com/rinvex/laravel-pages/compare/v5.0.7...v6.0.0
[v5.0.7]: https://github.com/rinvex/laravel-pages/compare/v5.0.6...v5.0.7
[v5.0.6]: https://github.com/rinvex/laravel-pages/compare/v5.0.5...v5.0.6
[v5.0.5]: https://github.com/rinvex/laravel-pages/compare/v5.0.4...v5.0.5
[v5.0.4]: https://github.com/rinvex/laravel-pages/compare/v5.0.3...v5.0.4
[v5.0.3]: https://github.com/rinvex/laravel-pages/compare/v5.0.2...v5.0.3
[v5.0.2]: https://github.com/rinvex/laravel-pages/compare/v5.0.1...v5.0.2
[v5.0.1]: https://github.com/rinvex/laravel-pages/compare/v5.0.0...v5.0.1
[v5.0.0]: https://github.com/rinvex/laravel-pages/compare/v4.1.2...v5.0.0
[v4.1.2]: https://github.com/rinvex/laravel-pages/compare/v4.1.1...v4.1.2
[v4.1.1]: https://github.com/rinvex/laravel-pages/compare/v4.1.0...v4.1.1
[v4.1.0]: https://github.com/rinvex/laravel-pages/compare/v4.0.6...v4.1.0
[v4.0.6]: https://github.com/rinvex/laravel-pages/compare/v4.0.5...v4.0.6
[v4.0.5]: https://github.com/rinvex/laravel-pages/compare/v4.0.4...v4.0.5
[v4.0.4]: https://github.com/rinvex/laravel-pages/compare/v4.0.3...v4.0.4
[v4.0.3]: https://github.com/rinvex/laravel-pages/compare/v4.0.2...v4.0.3
[v4.0.2]: https://github.com/rinvex/laravel-pages/compare/v4.0.1...v4.0.2
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
