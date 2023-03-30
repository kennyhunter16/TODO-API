# TODO-API
This is a simple To-do application written in the PHP Slim Framework

## Requirements for Install
- Apache2
- PHP 7.4 +
- MySQL Database

## Installation
1. Clone the repository: https://github.com/kennyhunter16/TODO-API.git
2. Install dependencies: `composer install`
3. Create a database in your MySQL and import the `todo.sql` table located in the root of the folder
4. Copy the .env.example folder and name it .env in the root of the directory. Please fill out the enviroment variables

| VARIABLE      | Description |
| ----------- | ----------- |
| DB_HOST      | The host URL of the MySQL database, most likely 'localhost'       |
| DB_USER   | The user account that has read/write access to the 'todo' table       |
| DB_PASS   | The password to the database user provided    |
| DB_NAME  | The name of the table, defaulted as 'todo' if imported with .sql file   |
| API_USER  | The username used to connect to the API using Basic Auth  |
| API_PASS  | The password used to connect to the API using Basic Auth  |