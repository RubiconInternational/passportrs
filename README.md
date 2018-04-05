# Laravel Passport Customized with Relationships support

## Installation
```
   composer require rubiconinternational/passportrs
```
[packagist](https://packagist.org/packages/rubiconinternational/passportrs)

## File Modifications Made for Relationships Support
1.  **File Modified:**
    [```2016_06_01_000002_create_oauth_access_tokens_table.php```](https://github.com/rubiconinternational/passportrs/blob/master/database/migrations/2016_06_01_000002_create_oauth_access_tokens_table.php)

  **Modification Description:**
    Add incremental primary key to table. Lines 17-18

    **Modification Reason:**
        For other projects middlware to associate other relational data and better data structure.

2.  **File Modified:**
    [```PersonalAccessTokenController.php```](https://github.com/rubiconinternational/passportrs/blob/master/src/Http/Controllers/PersonalAccessTokenController.php)

    **Modification Description:**
      Updated store() method to build token Relationship before returning token. Lines 6, and 67-79

    **Modification Reason:**
        Create token relationship to carry additional data and join ```oauth_access_tokens``` table to ```relationship``` table.

3.  **File Modified:**
    [```PersonalAccessTokens.vue```](https://github.com/rubiconinternational/passportrs/blob/master/resources/assets/js/components/PersonalAccessTokens.vue)

    **Modification Description:**
      Added form fields, updated data() fields and store() function to handle fields, and added minor styling. Lines 9-19, 51-55, 76-87, 149-174, 254-256, and 327-329

    ```
        api_client_id
        api_application_id
        api_token_type
    ```
    **Modification Description:**
         For relational data.

4. Add custom logging call. This will not work on other systems.

<p align="center"><img src="https://laravel.com/assets/img/components/logo-passport.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/passport"><img src="https://travis-ci.org/laravel/passport.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/passport"><img src="https://poser.pugx.org/laravel/passport/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/passport"><img src="https://poser.pugx.org/laravel/passport/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/passport"><img src="https://poser.pugx.org/laravel/passport/license.svg" alt="License"></a>
</p>

## Introduction

Laravel Passport is an OAuth2 server and API authentication package that is simple and enjoyable to use.

## Official Documentation

Documentation for Passport can be found on the [Laravel website](http://laravel.com/docs/master/passport).

## License

Laravel Passport is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
