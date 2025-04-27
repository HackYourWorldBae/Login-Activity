CREATE DATABASE IF NOT EXISTS login_activity;
USE login_activity;
CREATE TABLE user_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    pass VARCHAR(255) NOT NULL,
    remember_token VARCHAR(64),
    token_expires DATETIME
);
