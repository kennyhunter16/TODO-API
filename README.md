# TODO-API
This is a simple To-do application written in the PHP Slim Framework

## Requirements for Install
- Apache2
- PHP 7.4 +
- MySQL Database

## Installation
1. Clone the repository: https://github.com/kennyhunter16/TODO-API.git
2. Install dependencies: `composer install`
3. Create a database in your MySQL and import the `todo.sql` table. You can also import the SQL table below
    ``SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `todo` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `comment` varchar(5000) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `todo`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `todo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;``
