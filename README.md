# Filipino Cookbook API

A RESTful API developed using *PHP*, *Slim Framework*, *MySQL*, and *Bearer Token Authentication* for managing and retrieving information about Filipino dishes.

This API provides endpoints for retrieving Filipino foods, viewing categories and ingredients, searching for specific dishes, and adding new food records. All API responses are returned in *JSON* format and protected using Bearer Token authentication.

---

# Project Description

The Filipino Cookbook API was developed as part of the API Development Laboratory Activity. It displays the integration of a secure RESTful API using PHP and the Slim Framework.

The API serves as a source of Filipino food information.

The project demonstrates:

- REST API development
- HTTP request handling
- JSON responses
- Database integration
- Bearer Token Authentication
- CRUD operations
- API documentation
- Git and GitHub version control

---

# Features

- Retrieve all Filipino foods
- Retrieve a food by its ID
- Search for a specific food
- Retrieve all food categories
- Retrieve all food ingredients
- Add a new Filipino food
- Welcome endpoint
- Bearer Token Authentication
- JSON formatted responses
- MySQL database integration

---

# Technologies Used

| Technology     |           Purpose             |
|    PHP         | Backend Programming Language  |
| Slim Framework |        REST API Framework     |
| MySQL          |             Database          |
| Composer       |    Dependency Management      |
| Apache         |          Web Server           |
| XAMPP          | Local Development Environment |
| JSON           |       Data Exchange Format    |
| Thunder Client |        API Testing            |
| Git            |         Version Control       |
| GitHub         |       Repository Hosting      |

---

# Project Structure

```
Filipino-Cookbook-API/
│
├── database/
│   └── filipino_foods_relational.sql
│
├── screenshots/
│
├── public/
│
├── vendor/
│
├── composer.json
├── composer.lock
├── README.md
└── .gitignore
```
---

# Installation Guide

## 1. Clone the repository

```bash
git clone https://github.com/DizonDawn/Filipino-Cookbook-API.git
```

---

## 2. Open the project folder

```bash
cd Filipino-Cookbook-API
```

---

## 3. Install dependencies

```bash
composer install
```

---

## 4. Import the database

Open **phpMyAdmin**.

Create a new database named
filipino_cookbook_api

Import
database/filipino_foods_relational.sql

---

## 5. Configure the database connection

Update your database configuration file with your local database credentials.

Example:

```php
$dbHost = "localhost";
$dbName = "filipino_cookbook_api";
```

## 6. Start XAMPP

Start:
- Apache
- MySQL

## 7. Run the API

http://localhost/filipino-cookbook-api/public/

---

# Database Information

**Database Name**

filipino_cookbook_api

**SQL File**

database/filipino_foods_relational.sql

## Database Tables

- foods
- categories
- ingredients
- food_ingredients

The database stores information about Filipino dishes together with their categories and ingredients.

---

# Authentication

This API uses **Bearer Token Authentication**.

Every protected request must include the following header:
Authorization: Bearer dmmmsu-cookbook-token-2026
Requests without a valid Bearer Token will be rejected.

# Base URL : http://localhost/filipino-cookbook-api/public/

---

# API Endpoints

## 1. Welcome Endpoint

GET Method
Description: Returns the welcome message of the API.
GET http://localhost/filipino-cookbook-api/public/

## 2. Retrieve All Foods

GET Method, Endpoint: /api/foods
Description: Returns all Filipino food records.

## 3. Retrieve Food by ID

GET Method, Endpoint: /api/foods/{id}
Description: Returns a specific food using its ID.

## 4. Search for a Specific Food

GET Method, Endpoint: /api/foods/search
Description: Returns a specific Filipino food based on the provided search parameter.

## 5. Retrieve Categories

GET Method, Endpoint: /api/categories
Description: Returns all food categories.

## 6. Retrieve Ingredients

GET Method, Endpoint: /api/ingredients
Description: Returns all ingredients.

## 7. Add New Food

POST Method, Endpoint: /api/foods
Description: Creates a new Filipino food record.


# Endpoint Testing

Included screenshots:

- Welcome Endpoint
- GET All Foods
- GET Food by ID
- GET Specific Food
- GET Categories
- GET Ingredients
- POST New Food
- Successful Bearer Token Authentication
- Invalid or Missing Token Response

---

# HTTP Status Codes

| Code| Description |
| 200 | Request completed successfully |
| 201 | Resource created successfully |
| 400 | Invalid request |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Resource not found |
| 500 | Internal Server Error |

---

# Testing

The API was tested using **Thunder Client**.

Testing verified:

- Successful authentication
- Successful endpoint requests
- JSON responses
- Database connectivity
- Resource retrieval
- Resource creation

---

# Developer Information

*Developer* Dizon Dawn

*Program* Bachelor of Science in Information Technology

*Major* Business Analytics

//GitHub Username : DizonDawn

//Repository : https://github.com/DizonDawn/Filipino-Cookbook-API

//Date Completed : August 2026

---

# License
This project was developed for educational purposes as part of the API Development Laboratory Activity.