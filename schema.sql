DROP DATABASE IF EXISTS cafeteria_db;
CREATE DATABASE IF NOT EXISTS cafeteria_db;
USE cafeteria_db;

-- 1. Table: users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Table: rooms
CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(10) UNIQUE
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
    user_id INT NOT NULL,
    room_id INT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('processing','out_for_delivery','delivered','cancelled') DEFAULT 'processing',
    notes TEXT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 6. Table: order_items
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- 7. Table: carts
CREATE TABLE carts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 8. Table: cart_items
CREATE TABLE cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    unit_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id),
    UNIQUE(cart_id, product_id)
);

-- Rooms demo
INSERT INTO rooms (room_number) VALUES 
('101'), ('102'), ('103'), ('104'), ('105');

-- Users demo
INSERT INTO users (name, email, password, role) VALUES
('Seif Admin', 'admin@cafeteria.com', '123456', 'admin'),
('Ahmed Ali', 'ahmed@example.com', '123456', 'user'),
('Mona Khaled', 'mona@example.com', '123456', 'user'),
('Omar Tarek', 'omar@example.com', '123456', 'user'),
('Laila Hassan', 'laila@example.com', '123456', 'user');

-- Categories demo
INSERT INTO categories (name) VALUES ('Drinks'), ('Snacks'), ('Desserts');

-- Products demo
INSERT INTO products (name, price, category_id, image,  status) VALUES
('Turkish Coffee', 35.00, 1, 'available'),
('Espresso', 30.00, 1, 'available'),
('Club Sandwich', 75.50, 2, 'available'),
('Cheese Sandwich', 60.00, 2, 'available'),
('Chocolate Cake', 50.00, 3, 'available'),
('Cupcake', 25.00, 3, 'available');

-- Orders demo
INSERT INTO orders (user_id, room_id, total_price, status, notes) VALUES
(2, 1, 110.50, 'processing', 'No sugar in coffee'),
(3, 2, 85.00, 'out_for_delivery', 'Extra cheese sandwich'),
(4, 3, 75.50, 'delivered', ''),
(5, 4, 110.00, 'cancelled', 'Customer changed mind');
-- Order_items demo
INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES
(1, 1, 1, 35.00),  -- Turkish Coffee
(1, 3, 1, 75.50),  -- Club Sandwich
(2, 4, 1, 60.00),  -- Cheese Sandwich
(2, 6, 1, 25.00),  -- Cupcake
(3, 3, 1, 75.50),
(4, 1, 2, 35.00);  -- Turkish Coffee x2

-- Carts demo
INSERT INTO carts (user_id) VALUES
(2), (3), (4), (5);

-- Cart_items demo
INSERT INTO cart_items (cart_id, product_id, quantity, unit_price) VALUES
(1, 1, 1, 35.00),
(1, 3, 1, 75.50),
(2, 4, 2, 60.00),
(3, 6, 3, 25.00),
(4, 1, 1, 35.00);