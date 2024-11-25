CREATE DATABASE CoffeeShopDB;
USE CoffeeShopDB;

-- Tabel user
CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password CHAR(32) NOT NULL, -- Enkripsi menggunakan MD5 menghasilkan 32 karakter
    status ENUM('active', 'inactive') DEFAULT 'active',
    level ENUM('cashier', 'admin') NOT NULL
);

-- Tabel customers
CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(40) NOT NULL,
    phone_number VARCHAR(13) UNIQUE NOT NULL,
    points INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- Tabel menu_items
CREATE TABLE menu_items (
    menu_item_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(40) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    type ENUM('food', 'beverage'),
    status ENUM('active', 'inactive') DEFAULT 'active',
    redeemable_points INT DEFAULT 0
);

-- Tabel discount
CREATE TABLE discount (
    status ENUM('active', 'inactive') NOT NULL,
    discount_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    percentage INT NOT NULL,
    range_days INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL,
    applied_at DATETIME DEFAULT NULL
);

-- Tabel orders (dengan penambahan foreign key ke discount)
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    cashier INT,
    discount_id INT NULL, -- foreign key untuk menyimpan diskon yang digunakan, bisa NULL jika tidak ada diskon
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2),
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE SET NULL,
    FOREIGN KEY (cashier) REFERENCES user(user_id) ON DELETE SET NULL,
    FOREIGN KEY (discount_id) REFERENCES discount(discount_id) ON DELETE SET NULL
);

-- Tabel order_items
CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NULL,
    menu_item_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2),
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE SET NULL,
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(menu_item_id)
);

-- Tabel log untuk user
CREATE TABLE log_user (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    operation ENUM('CREATE', 'UPDATE', 'DELETE') NOT NULL,
    old_data TEXT,
    new_data TEXT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    performed_by VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES user(user_id)
);

-- Tabel log untuk customers
CREATE TABLE log_customers (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    operation ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    old_data TEXT,
    new_data TEXT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    performed_by VARCHAR(50),
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
);

-- Tabel log untuk orders
CREATE TABLE log_orders (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    operation ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    old_data TEXT,
    new_data TEXT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    performed_by VARCHAR(50),
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
);

-- Tabel log untuk order_items
CREATE TABLE log_order_items (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    order_item_id INT,
    order_id INT,
    operation ENUM('UPDATE', 'DELETE') NOT NULL,
    old_data TEXT,
    new_data TEXT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    performed_by VARCHAR(50),
    FOREIGN KEY (order_item_id) REFERENCES order_items(order_item_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
);

-- Tabel log untuk discount
CREATE TABLE log_discount (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    discount_id INT,
    operation ENUM('CREATE', 'UPDATE', 'DELETE') NOT NULL,
    old_data TEXT,
    new_data TEXT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    performed_by VARCHAR(50),
    FOREIGN KEY (discount_id) REFERENCES discount(discount_id)
);



