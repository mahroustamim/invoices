## invoices management system
invoice management system for debt collection company created by laravel and MySQL 


![Alt text](https://github.com/mahroustamim/invoices/blob/main/home.png)


## features

- sections (add - edit - delete)
- products (add - edit - delete)
- invoices (add - edit - delete - print -  change payment status - export excel)
- invoice attachments (add - edit)
- sent notification to all members after adding a new invoice
- sent an email to all members after adding a new invoice
- admin can add new users and define their permissions and roles
- page for reports 
- pagination to all tables

## installation 

```
$ git clone https://github.com/mahroustamim/invoices.git
$ cd invoices
$ composer install
$ cp .env.example .env # THEN EDIT YOUR ENV FILE ACCORDING TO YOUR OWN SETTINGS.
$ php artisan key:generate
$ php artisan migrate
$ php artisan db:seed
$ php artisan serve
```



## database

![Alt text](https://github.com/mahroustamim/invoices/blob/main/database.png)

## License

gym management systeme is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
