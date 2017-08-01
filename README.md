# Rinvex Pages

**Rinvex Pages** is an integral part of your content management system (CMS), it affords an easy, yet powerful way to create and manage pages with full control over their URLs, active status, titles, content, and other attributes.

[![Packagist](https://img.shields.io/packagist/v/rinvex/pages.svg?label=Packagist&style=flat-square)](https://packagist.org/packages/rinvex/pages)
[![VersionEye Dependencies](https://img.shields.io/versioneye/d/php/rinvex:pages.svg?label=Dependencies&style=flat-square)](https://www.versioneye.com/php/rinvex:pages/)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/rinvex/pages.svg?label=Scrutinizer&style=flat-square)](https://scrutinizer-ci.com/g/rinvex/pages/)
[![Code Climate](https://img.shields.io/codeclimate/github/rinvex/pages.svg?label=CodeClimate&style=flat-square)](https://codeclimate.com/github/rinvex/pages)
[![Travis](https://img.shields.io/travis/rinvex/pages.svg?label=TravisCI&style=flat-square)](https://travis-ci.org/rinvex/pages)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/7923f41b-09fc-40f1-ae8e-7d19afae897c.svg?label=SensioLabs&style=flat-square)](https://insight.sensiolabs.com/projects/7923f41b-09fc-40f1-ae8e-7d19afae897c)
[![StyleCI](https://styleci.io/repos/98805007/shield)](https://styleci.io/repos/98805007)
[![License](https://img.shields.io/packagist/l/rinvex/pages.svg?label=License&style=flat-square)](https://github.com/rinvex/pages/blob/develop/LICENSE)


## Installation

1. Install the package via composer:
    ```shell
    composer require rinvex/pages
    ```

2. Execute migrations via the following command:
    ```
    php artisan migrate --path="vendor/rinvex/contacts/database/migrations"
    ```

3. **Optionally** you can publish migrations and config files by running the following commands:
    ```shell
    // Publish migrations
    php artisan vendor:publish --tag="rinvex-contacts-migrations"

    // Publish config
    php artisan vendor:publish --tag="rinvex-contacts-config"
    ```

4. Done!

## Usage

### Create Your Page

To get started, you simply create a new page as follows:

```php
$page = \Rinvex\Pages\Models\Page::create([
    'uri' => 'test',
    'slug' => 'test-page',
    'title' => 'Test Page',
    'view' => 'tes-page',
]);

// Deactivate the page
$page->deactivate();

// Activate the page
$page->activate();

// Get all pages
$pages = \Rinvex\Pages\Models\Page::all();

// Get active pages
$pages = \Rinvex\Pages\Models\Page::active()->get();

// Get inactive pages
$pages = \Rinvex\Pages\Models\Page::inactive()->get();
```

> **Notes:**
> - All active pages are registered automatically into your application router with page's attributes, so the example page we created above could be accessed via the URL `http://your-project/test`, and you can generate page's URL using the named route `route('rinvex.pages.test-page')` where the route name consistes of `rinvex.pages.` prefix plus the page's slug. The result of accessing that page is the content of the page's rendered view.
> - **Rinvex Pages** auto register routes for your active pages, but you can disable routes auto registration in case you need more flexibility writing your own routes and maybe linking to your custom controllers, and that could be done from the config file `config/rinvex.pages.php` if you already published it in the installation step.


## Changelog

Refer to the [Changelog](CHANGELOG.md) for a full history of the project.


## Support

The following support channels are available at your fingertips:

- [Chat on Slack](http://chat.rinvex.com)
- [Help on Email](mailto:help@rinvex.com)
- [Follow on Twitter](https://twitter.com/rinvex)


## Contributing & Protocols

Thank you for considering contributing to this project! The contribution guide can be found in [CONTRIBUTING.md](CONTRIBUTING.md).

Bug reports, feature requests, and pull requests are very welcome.

- [Versioning](CONTRIBUTING.md#versioning)
- [Pull Requests](CONTRIBUTING.md#pull-requests)
- [Coding Standards](CONTRIBUTING.md#coding-standards)
- [Feature Requests](CONTRIBUTING.md#feature-requests)
- [Git Flow](CONTRIBUTING.md#git-flow)


## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to [help@rinvex.com](help@rinvex.com). All security vulnerabilities will be promptly contacted.


## About Rinvex

Rinvex is a software solutions startup, specialized in integrated enterprise solutions for SMEs established in Alexandria, Egypt since June 2016. We believe that our drive The Value, The Reach, and The Impact is what differentiates us and unleash the endless possibilities of our philosophy through the power of software. We like to call it Innovation At The Speed Of Life. That’s how we do our share of advancing humanity.


## License

This software is released under [The MIT License (MIT)](LICENSE).

(c) 2016-2017 Rinvex LLC, Some rights reserved.
