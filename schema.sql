-- 1. إنشاء قاعدة البيانات
CREATE DATABASE IF NOT EXISTS cafeteria_db;
USE cafeteria_db;

-- 2. جدول المستخدمين  الـ 
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. جدول التصنيفات (Categories)
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- 4. جدول المنتجات
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    category_id INT,
    image VARCHAR(255),
    status ENUM('available', 'unavailable') DEFAULT 'available',
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- 5. جدول الطلبات (Orders)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('processing', 'out_for_delivery', 'delivered', 'cancelled') DEFAULT 'processing',
    notes TEXT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 6. جدول تفاصيل الطلب (Order Items)
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);


-- مستخدم أدمن (الايميل: admin@cafeteria.com | الباسورد: 123456)
INSERT INTO users (name, email, password, role) 
VALUES ('Seif Admin', 'admin@cafeteria.com', '123456', 'admin');

-- تصنيفات
INSERT INTO categories (name) VALUES ('Drinks'), ('Snacks'), ('Desserts');

-- منتجات تجريبية
INSERT INTO products (name, price, category_id, status) 
VALUES 
('Turkish Coffee', 35.00, 1, 'available'),
('Club Sandwich', 75.50, 2, 'available'),
('Chocolate Cake', 50.00, 3, 'available');