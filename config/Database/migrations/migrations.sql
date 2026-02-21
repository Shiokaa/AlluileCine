CREATE DATABASE IF NOT EXISTS AlluileCine;

USE AlluileCine;

CREATE TABLE
    IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        role ENUM ("user", "admin") DEFAULT "user",
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
    IF NOT EXISTS rooms (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        capacity TINYINT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        delete_at TIMESTAMP NULL DEFAULT NULL
    );

CREATE TABLE
    IF NOT EXISTS sessions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        movie_id INT NOT NULL,
        room_id INT NOT NULL,
        start_event DATETIME NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        delete_at TIMESTAMP NULL DEFAULT NULL,
        FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE,
        FOREIGN KEY (room_id) REFERENCES rooms (id) ON DELETE CASCADE,
        UNIQUE (room_id, start_event)
    );

CREATE TABLE
    IF NOT EXISTS seats (
        id INT AUTO_INCREMENT PRIMARY KEY,
        room_id INT NOT NULL,
        number TINYINT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        delete_at TIMESTAMP NULL DEFAULT NULL,
        FOREIGN KEY (room_id) REFERENCES rooms (id) ON DELETE CASCADE
    );

CREATE TABLE
    IF NOT EXISTS reservations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        session_id INT NOT NULL,
        seat_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        delete_at TIMESTAMP NULL DEFAULT NULL,
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
        FOREIGN KEY (session_id) REFERENCES sessions (id) ON DELETE CASCADE,
        FOREIGN KEY (seat_id) REFERENCES seats (id) ON DELETE CASCADE,
        UNIQUE (session_id, seat_id)
    );