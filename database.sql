CREATE DATABASE IF NOT EXISTS projetb2;


CREATE USER IF NOT EXISTS 'projetb2'@'localhost' IDENTIFIED BY 'password';

GRANT ALL PRIVILEGES ON projetb2.* TO 'projetb2'@'localhost';

FLUSH PRIVILEGES;

USE projetb2;

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des compétences
CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- Table des compétences des utilisateurs
CREATE TABLE user_skills (
    user_id INT,
    skill_id INT,
    level ENUM('débutant', 'intermédiaire', 'avancé', 'expert') NOT NULL,
    PRIMARY KEY (user_id, skill_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (skill_id) REFERENCES skills(id) ON DELETE CASCADE
);

-- Table des projets
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255),
    project_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO skills (name) VALUES
('PHP'), ('JavaScript'), ('SQL'), ('HTML/CSS'), ('Linux');

INSERT INTO projects (user_id, title, description, image_url,  project_url) VALUES
(1, 'Projet Admin', 'Projet de test administrateur', NULL, 'https://example.com'),
(2, 'Projet User1', 'Projet test utilisateur 1', NULL, 'https://example.com'),
(3, 'Projet User2', 'Projet test utilisateur 2', NULL, 'https://example.com');


