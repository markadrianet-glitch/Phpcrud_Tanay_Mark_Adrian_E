CREATE DATABASE IF NOT EXISTS phpcrud_tanay_mark_adrian;

USE phpcrud_tanay_mark_adrian;

CREATE TABLE IF NOT EXISTS students (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Firstname VARCHAR(100) NOT NULL,
    Lastname VARCHAR(100) NOT NULL
);
phpcrud_tanay_mark_adrian