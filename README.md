# Expenses Tracker - Easy way to keep track of your money

## Back-end Architecture - Laravel

### Getting Started:

The Vagrant Box set up to use Laravel's Homestead image. To get started:

1. Clone this repo and `cd` into the new directory
1. In your new directory, run `composer install`
1. Run `vendor/bin/homestead make`
1. Copy the `.env.example` file to a new `.env` file by running `cp .env.example .env`
1. Update env variables in your `.env` file
    - DB_DATABASE=homestead
    - DB_USERNAME=root
    - DB_PASSWORD=secret


    add and fill these 2 variables below after generating the authentication keys 
    - PASSPORT_PERSONAL_ACCESS_CLIENT_ID=
    - PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=

1. Run `vagrant up`
1. ssh to the virtual machine: `vagrant ssh`
1. If prompted for a password, insert `vagrant`
1. Navigate to `code` folder: `cd code`
1. Run `artisan key:generate`
1. Run the database migrations: `artisan migrate`
1. Create the Passport authentication keys: `php artisan passport:install`

Visit `http://homestead.test` on Mac or `http://localhost:8000` on Windows:

---

# Expenses Tracker - API

## General

All requests should:

- For non-production use the basename `http://localhost:8000/api/`
- Be sent with the `Accept: application/json` header.

## End points:
Registration and Login
- `POST /users`
- `POST /login`

Users
- `GET /user/:user-id`
- `PUT /user/:user-id`
- `DELETE /user/:user-id`

Transactions
- `GET /transactions/:transaction-id`
- `POST /transactions`
- `PATCH /transactions/:transaction-id`
- `DELETE /transactions/:transaction-id`

### Register User - POST `/users`

#### Request
```json
{
    "name": "<username>",
    "password": "<password>"
}
```

#### Response
```json
{
    "data": {
        "id": 30,
        "name": "testing123",
        "email": null,
        "balance": 0,
        "balance_with_currency": "£0.00",
        "total_income": 0,
        "total_income_with_currency": "£0.00",
        "total_expense": 0,
        "total_expense_with_currency": "£0.00",
        "total_expense_by_category": [],
        "transactions": []
    }
}
```

### Login User - POST `/login`

#### Request
```json
{
    "username": "<username>",
    "password": "<password>"
}
```

#### Response
```json
{
    "id": 12345,
    "name": "<username>",
    "access_token": "<token>",
}
```

### Edit User - POST `/users/:user-id`

#### Request
```json
{
    "username": "<username>",
    "email": "<email>"
}
```

#### Response
```json
{
    "data": {
        "id": 12345,
        "name": "<new username>",
        "email": "<new email>",
        "balance": 0,
        "balance_with_currency": "£0.00",
        "total_income": 0,
        "total_income_with_currency": "£0.00",
        "total_expense": 0,
        "total_expense_with_currency": "£0.00",
        "total_expense_by_category": [],
        "transactions": []
    }
}
```

### Create New transaction - POST `/transactions`

#### Request
```json
{
    "amount": 12.2548,
    "type": "<type>",
    "category": "<category>",
    "user_id": 12345
}
```

#### Response
```json
{
    "data": {
        "transaction_id": 12345,
        "amount": 50.25,
        "amount_with_currency": "£50.25",
        "type": "<type>",
        "category": "<category>",
        "created_at": "<date>",
        "unformatted_created_at": "<date + time>",
        "balance_at_the_time": 5154.60
    }
}
```

### Delete Transaction - POST `/transactions/:transaction-id`

#### Request
```json
{

}
```

#### Response
```json
{
    "message": "Transaction deleted successfully"
}
```

`// replace the parameters inclosed in *param* with the ones you wish to apply`
### Request Filtered Transactions - GET `/transactions/by-date-range?user_id=*user-id*&from=*yyy-mm-dd*&to=*yyy-mm-dd*&currency=*currency*`

#### Request
```json
{

}
```

#### Response
```json
{
    "data": {
        "balance": 85413.65,
        "balance_with_currency": "£85413.65",
        "total_income": 8465.45,
        "total_income_with_currency": "£8465.45",
        "total_expense": 60.90,
        "total_expense_with_currency": "£60.90",
        "total_expense_by_category": [],
        "transactions": []
    }
}
```