# Rinvex Pages

**Rinvex Pages** is an integral part for your Laravel content management system (CMS), it affords an easy, yet powerful way to create and manage pages with full control over their URLs, active status, titles, content, and other attributes.

[![Packagist](https://img.shields.io/packagist/v/rinvex/laravel-pages.svg?label=Packagist&style=flat-square)](https://packagist.org/packages/rinvex/laravel-pages)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/rinvex/laravel-pages.svg?label=Scrutinizer&style=flat-square)](https://scrutinizer-ci.com/g/rinvex/laravel-pages/)
[![Code Climate](https://img.shields.io/codeclimate/github/rinvex/laravel-pages.svg?label=CodeClimate&style=flat-square)](https://codeclimate.com/github/rinvex/laravel-pages)
[![Travis](https://img.shields.io/travis/rinvex/laravel-pages.svg?label=TravisCI&style=flat-square)](https://travis-ci.org/rinvex/laravel-pages)
[![StyleCI](https://styleci.io/repos/98953486/shield)](https://styleci.io/repos/98953486)
[![License](https://img.shields.io/packagist/l/rinvex/laravel-pages.svg?label=License&style=flat-square)](https://github.com/rinvex/laravel-pages/blob/develop/LICENSE)


## Installation

1. Install the package via composer:
    ```shell
    composer require rinvex/laravel-pages
    ```

2. Execute migrations via the following command:
    ```
    php artisan rinvex:migrate:pages
    ```

3. Done!

## Usage

### Create Your Page

To get started, you simply create a new page as follows:

```php
$page = app('rinvex.pages.page')->create([
    'uri' => 'test',
    'slug' => 'test-page',
    'route' => 'frontend.pages.test',
    'title' => 'Test Page',
    'view' => 'test-page',
]);

// Deactivate the page
$page->deactivate();

// Activate the page
$page->activate();

// Get all pages
$pages = app('rinvex.pages.page')->all();

// Get active pages
$pages = app('rinvex.pages.page')->where('is_active', true)->get();
```

> **Notes:**
> - All active pages are registered automatically into your application router with page's attributes, so the example page we created above could be accessed via the URL `http://your-project/test`, and you can generate page's URL using the named route `route('frontend.pages.test')` as you may expect. The result of accessing that page is the content of the page's rendered view.
> - **Rinvex Pages** auto register routes for your active pages, but you can disable routes auto registration in case you need more flexibility writing your own routes and maybe linking to your custom controllers, and that could be done from the config file `config/rinvex.pages.php` if you already published it in the installation step.
> - **Rinvex Pages** expects you to create your own views before setting in page records, and that view could be anywhere and contain anything. It's important to know that all page views have access to the `$page` instance variable by default, so you can access any of the page's attributes.


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

(c) 2016-2018 Rinvex LLC, Some rights reserved.
