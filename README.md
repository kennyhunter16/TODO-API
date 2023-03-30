# TODO-API
This is a simple To-do application written in the PHP Slim Framework

## Requirements for Install
- Apache2
- PHP 8.1
- MySQL Database
- Composer

## Setup Apache + DB + PHP
- XAMPP - https://www.apachefriends.org/index.html

## Installation
1. Clone the repository: https://github.com/kennyhunter16/TODO-API.git
2. Install dependencies: `composer install`
3. Create a database in your MySQL and import the `todo.sql` table located in the root of the folder
4. Copy the .env.example folder and name it .env in the root of the directory. Please fill out the enviroment variables

| Variable     | Description |
| ----------- | ----------- |
| DB_HOST      | The host URL of the MySQL database, most likely 'localhost'       |
| DB_USER   | The user account that has read/write access to the 'todo' table       |
| DB_PASS   | The password to the database user provided    |
| DB_NAME  | The name of the table, defaulted as 'todo' if imported with .sql file   |
| API_USER  | The username used to connect to the API using Basic Auth  |
| API_PASS  | The password used to connect to the API using Basic Auth  |

## How to use this API
For this example I will be using Postman https://www.postman.com/ and XAMPP https://www.apachefriends.org/index.html

1. Once you have configured XAMPP on your machine. Move the repo into your htdocs for XAMMP.
2. In the control panel of XAMPP go to Apache -> Config -> httpd.conf  set your DocumentRoot to (htdocs location)/todo/public
3. Restart Apache and nagivate to your localhost in Postman using a GET Request
4. In Postman, create a new Colleciton and under Authorization -> Basic Auth fill in the API_USER & API_PASS you setup earlier

## GET Requests
| End Point     | Description |
| ----------- | ----------- |
| /todos      | Returns a array list of all the Todo items |
| /todo/{id}   | Returns an object of all the todo contents

## POST Requests
| End Point     | Description |
| ----------- | ----------- |
| /todo    | Adds a new note in the field

### An example body request in JSON is
{
    "name": "Note Header",
    "comment": "Testing",
    "status": "todo"
}
## PUT Requests
| End Point     | Description |
| ----------- | ----------- |
| /todo/{id}     | Updates an existing Note

### An example body request in JSON is
{
    "name": "Note Header",
    "comment": "Testing",
    "status": "todo"
}

## DELETE Requests
| End Point     | Description |
| ----------- | ----------- |
| /todo/{id}     | Deletes a note

