-- Create the database
CREATE DATABASE IF NOT EXISTS housemaidDB;
USE housemaidDB;

-- Create users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    uname VARCHAR(50) NOT NULL,
    uemail VARCHAR(50) NOT NULL UNIQUE,
    upass VARCHAR(255) NOT NULL,
    place VARCHAR(50) NOT NULL,
    privilege VARCHAR(50) NOT NULL
);

-- Create cart table
CREATE TABLE cart (
    id INT PRIMARY KEY AUTO_INCREMENT,
    uid INT NOT NULL,
    hname VARCHAR(500) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    date DATE NOT NULL,
    image VARCHAR(255) NOT NULL,
    FOREIGN KEY (uid) REFERENCES users(id)
);

-- Create rent table
CREATE TABLE rent (
    id INT PRIMARY KEY AUTO_INCREMENT,
    uid INT NOT NULL,
    hname VARCHAR(500) NOT NULL,
    date DATE NOT NULL,
    image VARCHAR(255) NOT NULL,
    FOREIGN KEY (uid) REFERENCES users(id)
);

-- Create cont table
CREATE TABLE cont (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fname VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    msg VARCHAR(540) NOT NULL
);

-- Create housemaid table
CREATE TABLE housemaid (
    id INT PRIMARY KEY AUTO_INCREMENT,
    hname VARCHAR(500) NOT NULL,
    pass VARCHAR(255) NOT NULL,
    img VARCHAR(500) NOT NULL,
    place VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL
);

-- Insert sample data into housemaid table
INSERT INTO housemaid (hname, pass, img, place, status) VALUES
('Amina Yusuf', '1', 'Al Batinah (1).png', 'Al Batinah', 'Available'),
('Maria Lopez', '1', 'Al Batinah (2).png', 'Al Batinah', 'Busy'),
('Sofia Ahmed', '1', 'Al Batinah (3).png', 'Al Batinah', 'Available'),
('Grace Kim', '1', 'Al Batinah (4).png', 'Al Batinah', 'Busy'),
('Fatima Noor', '1', 'Al Batinah (5).png', 'Al Batinah', 'Available'),
('Linda Brown', '1', 'Al Dhahirah (1).png', 'Al Dhahirah', 'Available'),
('Anita Desai', '1', 'Al Dhahirah (2).png', 'Al Dhahirah', 'Busy'),
('Sara Ali', '1', 'Al Dhahirah (3).png', 'Al Dhahirah', 'Available'),
('Nora James', '1', 'Al Dhahirah (4).png', 'Al Dhahirah', 'Available'),
('Leila Hassan', '1', 'Al Sharqiyah (1).png', 'Al Sharqiyah', 'Busy'),
('Emma Watson', '1', 'Al Sharqiyah (2).png', 'Al Sharqiyah', 'Available'),
('Zara Khan', '1', 'Al Sharqiyah (3).png', 'Al Sharqiyah', 'Available'),
('Maya Singh', '1', 'Al Sharqiyah (4).png', 'Al Sharqiyah', 'Busy'),
('Olivia Brown', '1', 'Al Wusta (1).png', 'Al Wusta', 'Available'),
('Layla Salem', '1', 'Al Wusta (2).png', 'Al Wusta', 'Available'),
('Emily Stone', '1', 'Al Wusta (3).png', 'Al Wusta', 'Busy'),
('Huda Ibrahim', '1', 'Muscat (1).png', 'Muscat', 'Busy'),
('Sophia Hill', '1', 'Muscat (2).png', 'Muscat', 'Available'),
('Mona Zayed', '1', 'Muscat (3).png', 'Muscat', 'Available'),
('Sara White', '1', 'Muscat (4).png', 'Muscat', 'Busy'),
('Nada Omar', '1', 'Muscat (5).png', 'Muscat', 'Available'),
('Mariam Salah', '1', 'Muscat (6).png', 'Muscat', 'Available');
-- Insert sample data into users table
INSERT INTO users (uname, uemail, upass, place, privilege) VALUES
('Admin', 'admin@gmail.com', 'admin', 'Al Batinah', '0'),
('Amina Yusuf', 'Amina Yusuf@gmail.com', 'pass', 'Al Batinah', '1'),
('Maria Lopez', 'Maria Lopez@gmail.com', 'pass', 'Al Batinah', '1'),
('Sofia Ahmed', 'Sofia Ahmed@gmail.com', 'pass', 'Al Batinah', '1'),
('Grace Kim', 'Grace Kim@gmail.com', 'pass', 'Al Batinah', '1'),
('Fatima Noor', 'Fatima Noor@gmail.com', 'pass', 'Al Batinah', '1'),
('Linda Brown', 'Linda Brown@gmail.com', 'pass', 'Al Dhahirah', '1'),
('Anita Desai', 'Anita Desai@gmail.com', 'pass', 'Al Dhahirah', '1'),
('Sara Ali', 'Sara Ali@gmail.com', 'pass', 'Al Dhahirah', '1'),
('Nora James', 'Nora James@gmail.com', 'pass', 'Al Dhahirah', '1'),
('Leila Hassan', 'Leila Hassan@gmail.com', 'pass', 'Al Sharqiyah', '1'),
('Emma Watson', 'Emma Watson@gmail.com', 'pass', 'Al Sharqiyah', '1'),
('Zara Khan', 'Zara Khan@gmail.com', 'pass', 'Al Sharqiyah', '1'),
('Maya Singh', 'Maya Singh@gmail.com', 'pass', 'Al Sharqiyah', '1'),
('Olivia Brown', 'Olivia Brown@gmail.com', 'pass', 'Al Wusta', '1'),
('Layla Salem', 'Layla Salem@gmail.com', 'pass', 'Al Wusta', '1'),
('Emily Stone', 'Emily Stone@gmail.com', 'pass', 'Al Wusta', '1'),
('Huda Ibrahim', 'Huda Ibrahim@gmail.com', 'pass', 'Muscat', '1'),
('Sophia Hill', 'Sophia Hill@gmail.com', 'pass', 'Muscat', '1'),
('Mona Zayed', 'Mona Zayed@gmail.com', 'pass', 'Muscat', '1'),
('Sara White', 'Sara White@gmail.com', 'pass', 'Muscat', '1'),
('Nada Omar', 'Nada Omar@gmail.com', 'pass', 'Muscat', '1'),
('Mariam Salah', 'Mariam Salah@gmail.com', 'pass', 'Muscat', '1');