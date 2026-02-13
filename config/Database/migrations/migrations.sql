CREATE DATABASE IF NOT EXISTS AlluileCine;

USE AlluileCine;

CREATE TABLE
    IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        role ENUM ("user", "admin") DEFAULT "user",
        avatar VARCHAR(255) NOT NULL DEFAULT "",
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        delete_at TIMESTAMP NULL DEFAULT NULL
    );

CREATE TABLE
    IF NOT EXISTS movies (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        genre VARCHAR(255) NOT NULL,
        director VARCHAR(255),
        casting TEXT,
        duration INT NOT NULL,
        cover_image VARCHAR(255),
        release_date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        delete_at TIMESTAMP NULL DEFAULT NULL
    );

CREATE TABLE
    IF NOT EXISTS sessions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        movie_id INT NOT NULL,
        start_time DATETIME NOT NULL,
        room_number VARCHAR(50),
        total_seats INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        delete_at TIMESTAMP NULL DEFAULT NULL,
        FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE
    );

CREATE TABLE
    IF NOT EXISTS reservations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        session_id INT NOT NULL,
        number_of_seats INT DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        delete_at TIMESTAMP NULL DEFAULT NULL,
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
        FOREIGN KEY (session_id) REFERENCES sessions (id) ON DELETE CASCADE
    );