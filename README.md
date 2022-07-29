## Mini CRM

This project handles management of companies and their employees.
It has two menu items:
- Companies
- Employees

The admin can create, update and delete companies and employees.
The system can be accessed with the following details:
- admin@example.com
- password

## Running the Project
- download the project
- run composer install
- rename .env.example file to .env, and set up your configurations
- create a database and set the name in the .env file, alongside your other DB configurations
- run the following commands:

```
php artisan key:generate
```

```
php artisan migrate
```

```
php artisan db:seed
```

```
php artisan serve
```

- access the project from your browser with 127.0.01:8000 or localhost:8000 (depending on your configuration).
