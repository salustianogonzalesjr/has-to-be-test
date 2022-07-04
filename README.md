# has-to-be

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

**has-to-be** is created using [Lumen](https://lumen.laravel.com/docs). This API is designed using a [Service Design Pattern](https://blackdeerdev.com/laravel-services-pattern/)

## How to Setup
- clone the repo `https://github.com/salustianogonzalesjr/has-to-be-test.git`
- cd to `has-to-be-test` and run `composer install`
- setup your `.env` file
- start default server `php -S localhost:8000 -t public`

## How to Test
You can test the API endpoint using [Postman](https://www.postman.com/downloads/) once you have started the built-in server.

- on your Postman enter this URL/Endpoint `http://localhost:8000/api/rate` with `POST` method.
- enter these paramters on Body as `raw` `JSON`  
```
{
    "cdr": 
    { 
        "meterStart": 1204307, 
        "timestampStart": "2021-04-05",
        "meterStop": 1215230,
        "timestampStop": "2021-04-05" 
    }
}
```
- you should see this response with `status 200 OK`
```
{
    "overall": "4.28",
    "components": {
        "energy": "3.277",
        "time": "0.000",
        "transaction": "1"
    }
}
```

## Screenshots

## Improvements
Future enhancements 
- setup [JWT](https://jwt.io/) to secure API
- should accept multiple transactions

## Security Vulnerabilities

The endpoint is publicly accessible and doesn't have authentication yet. See [Improvements](https://github.com/salustianogonzalesjr/has-to-be-test#improvements)
## License

This API is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).



