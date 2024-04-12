CREATE DATABASE books_system; 

CREATE TABLE users(  
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(32) NOT NULL,
    last_name VARCHAR(32) NOT NULL,
    email VARCHAR(32) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    is_active BOOLEAN NOT NULL DEFAULT true,
    is_admin BOOLEAN NOT NULL DEFAULT false,
    create_time DATETIME DEFAULT CURRENT_TIMESTAMP
);

