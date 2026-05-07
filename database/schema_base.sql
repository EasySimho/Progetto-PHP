CREATE DATABASE IF NOT EXISTS lanificio_sella;
USE lanificio_sella;

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- (password: test1234, username: simho)
INSERT INTO admins (username, password_hash) VALUES ('simho', '$2y$12$lcFYjyRIIt.USX4UZQEw.OzygkXXIJWIafc4zrXFADuzZpR3JDZtW');

CREATE TABLE media_contents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category ENUM('Tradizione', 'Innovazione') NOT NULL,
    media_type ENUM('video', 'image', 'youtube') NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
