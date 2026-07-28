# 🍽️ Filipino Cookbook API

A RESTful API developed using **PHP**, **Slim Framework**, and **MySQL** that manages a collection of Filipino food recipes. The API allows users to retrieve information about dishes, categories, origins, and ingredients through HTTP requests.

This project was developed as part of an academic requirement to demonstrate the fundamentals of REST API development, routing, database connectivity, and CRUD operations.

---

##Features

- Retrieve all Filipino dishes
- Retrieve a specific dish by ID
- Retrieve dishes by category
- Retrieve dishes by place of origin
- Retrieve ingredients for each dish
- RESTful API endpoints
- JSON-formatted responses
- MySQL database integration
- Slim Framework routing

---

##Tech Used

- PHP
- Slim Framework 4
- Composer
- MySQL
- XAMPP
- Apache
- REST API
- JSON

---

##Project Structure

```
Filipino-Cookbook-API/
│
├── public/
│   ├── index.php
│   └── .htaccess
│
├── vendor/
│
├── composer.json
├── composer.lock
└── README.md
```

---

##Installation

###1. Clone the repository

```bash
git clone https://github.com/DizonDawn/Filipino-Cookbook-API.git
```

###2. Open the project folder

```bash
cd Filipino-Cookbook-API
```

###3. Install dependencies

```bash
composer install
```

###4. Import the MySQL database

Import your SQL file into phpMyAdmin.

###5. Start Apache and MySQL

Open XAMPP and start:

- Apache
- MySQL

###6. Run the API

Example:

```
http://localhost/Filipino-Cookbook-API/public/
```

---

##Sample API Endpoints

| Method | Endpoint | Description |
|---------|----------|-------------|
| GET | /foods | Retrieve all dishes |
| GET | /foods/{id} | Retrieve a dish by ID |
| GET | /categories | Retrieve all categories |
| GET | /origins | Retrieve all origins |
| GET | /ingredients | Retrieve all ingredients |

---

##Sample JSON Response

```json
{
    "id": 1,
    "name": "Adobo",
    "category": "Main Dish",
    "origin": "Luzon"
}
```

---

##Learning Objectives

This project demonstrates:

- REST API development
- HTTP request handling
- CRUD operations
- Database integration
- JSON serialization
- Slim Framework routing
- Composer dependency management

---

##Author

**Dizon Dawn Aleeah V, 4C**

Bachelor of Science in Information Technology  
Major in Business Analytics

---

##License

This project is intended for educational purposes.