CREATE DATABASE IF NOT EXISTS lanificio_sella;
USE lanificio_sella;

-- Tabella per gli amministratori
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserimento di un admin di test (password: admin123)
-- Hash generato con password_hash('admin123', PASSWORD_BCRYPT)
INSERT INTO admins (username, password_hash) VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Tabella per i contenuti multimediali (video e immagini)
CREATE TABLE media_contents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category ENUM('Tradizione', 'Innovazione') NOT NULL,
    media_type ENUM('video', 'image') NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
