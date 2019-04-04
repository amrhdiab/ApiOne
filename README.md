# ApiOne
Simple Api for users (register/login/details/verify/logout), with admin dashboard to control users.

## Laravel Version
Built on laravel 5.8

## Technologies Used
- Javascript.
- JQuery.
- Ajax.
- HTML.
- CSS.
- Bootstrap.
- PHP.

## Packages Used
- laravel/passport
- Nexmo Api (Phone Verification)
- yajra/laravel-datatables-oracle

## Features
- User register, login, details, verify, logout APIs.
- Tokens based Authentication using laravel passport.
- Phone verification using Nexmo.
- Modified the Exception handler to respond based on the type of the request JSON,Web.
- Admin dashboard with CRUD operations on users built on ajax and DataTables.

## Notes
- Created a separate login system for "Admins", with separate guard, routes and views.
- Tested all the Apis (Login, Register, Details, Verify) with "Postman", find screenshots of the results under (public/img).
- After migration you gonna need to install Passport in order to get new keys
```php
php artisan passport:install
```
- You will need to add (NEXMO_KEY) & (NEXMO_SECRET) values to your .env file.

## About me
Junior PHP/Laravel web developer with unique vision and exceptional dedication.
Amr H. Diab
