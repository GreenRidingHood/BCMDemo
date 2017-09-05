--
-- Create Database: `bcm_wordpress`
--
DROP DATABASE IF EXISTS `bcm_wordpress`;
CREATE DATABASE `bcm_wordpress` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

--
-- Create User: `bcm_wordpress_usr`
--

--GRANT USAGE ON *.* TO 'bcm_wordpress_usr'@'localhost';
--GRANT USAGE ON *.* TO 'bcm_wordpress_usr'@'%';
--DROP USER 'bcm_wordpress_usr'@'%';
--DROP USER 'bcm_wordpress_usr'@'localhost';
CREATE USER 'bcm_wordpress_usr'@'%' IDENTIFIED BY 'alluminum-+X4r9Z-surfboard';
CREATE USER 'bcm_wordpress_usr'@'localhost' IDENTIFIED BY 'alluminum-+X4r9Z-surfboard';
GRANT ALL ON bcm_wordpress.* TO 'bcm_wordpress_usr'@'%';
GRANT ALL ON bcm_wordpress.* TO 'bcm_wordpress_usr'@'localhost';
FLUSH PRIVILEGES;

--
-- Create tables and insert data
--

USE `bcm_wordpress`;