CREATE DATABASE IF NOT EXISTS cafeteria_db;
USE cafeteria_db;

-- 1. Table: users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    room_id INT,
    image VARCHAR(255),
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Table: rooms
CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(10) NOT NULL UNIQUE
);

-- 3. Table: categories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- 4. Table: products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    category_id INT,
    image VARCHAR(255),
    status ENUM('available', 'unavailable') DEFAULT 'available',
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- 5. Table: orders
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('processing', 'out_for_delivery', 'delivered', 'cancelled') DEFAULT 'processing',
    notes TEXT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 6. Table: order_items (العلاقة بين المنتجات والطلبات)
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);


ALTER TABLE users ADD FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE SET NULL;

-- عشان الدنيا متبقاش صحراااااااااا

INSERT INTO rooms (room_number) VALUES ('201'), ('202'), ('Cloud Lab');

INSERT INTO users (name, email, password, room_id, role) 
VALUES ('Seif Admin', 'admin@cafeteria.com', '123456', 1, 'admin');

INSERT INTO categories (name) VALUES ('Drinks'), ('Sandwiches');

INSERT INTO products (name, price, category_id, status) 
VALUES ('Espresso', 45.00, 1, 'available'), ('Chicken Burger', 85.50, 2, 'available');