## invoices management system
invoice management system for debt collection company created by laravel and MySQL 


![Alt text](https://github.com/mahroustamim/invoices/blob/main/home.png)


## features

- Sections: Add, edit, delete
- Products: Add, edit, delete
- Invoices: Add, edit, delete, print, change payment status, export to Excel
- Invoice Attachments: Add, edit
- Notifications: Send notifications to all members after adding a new invoice
- Email Alerts: Send emails to all members after adding a new invoice
- User Management: Admins can add new users and define roles and permissions
- Reports Page: View reports
- Pagination: Applied to all tables for easy navigation

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


## License

Invoices management systeme is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
