## Initial Setup Readme

### JWT 

Reference: [JWT Tutorial](https://medium.com/employbl/build-authentication-into-your-laravel-api-with-json-web-tokens-jwt-cd223ace8d1a) 

1. After running `composer install` just run: `php artisan jwt:secret`
2. Run php artisan test and `AuthenticationTest.php` should pass 

```bash 

  PASS  Tests\Feature\AuthenticationTest
  ✓ it will register a user
  ✓ it will log a user in
  ✓ it will not log an invalid user in

``` 
