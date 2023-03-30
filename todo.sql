SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
COMMIT;