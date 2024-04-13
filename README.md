
invoice management system for debt collection company created by laravel and mysql  
## features

- sections (add - edit - delete)
- products (add - edit - delete)
- invoices (add - edit - delete - print -  change payment status - export excel)
- sent notification to all members after adding a new invoice
- sent an email to all members after adding a new invoice
- admin can add new users and define their permissions and roles
- page for reports 
- pagination to all tables

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## installation 

```
$ git clone git@github.com:johndavedecano/laragym.git project
$ cd project
$ composer install
$ cp .env.example .env # THEN EDIT YOUR ENV FILE ACCORDING TO YOUR OWN SETTINGS.
$ php artisan migrate
$ php artisan db:seed
$ php artisan serve
```



## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
