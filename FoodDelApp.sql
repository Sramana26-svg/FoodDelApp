-- Create Database
CREATE DATABASE fooddel;
USE fooddel;

-- 1. USERS
DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('customer','restaurant','delivery','admin') NOT NULL
);

-- 2. RESTAURANTS
DROP TABLE IF EXISTS restaurants;
CREATE TABLE restaurants (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  address VARCHAR(255) NOT NULL,
  owner_id INT NOT NULL,
  FOREIGN KEY (owner_id) REFERENCES users(id)
);

-- 3. MENU ITEMS
DROP TABLE IF EXISTS menu_items;
CREATE TABLE menu_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  restaurant_id INT NOT NULL,
  name VARCHAR(150) NOT NULL,
  price DECIMAL(7,2) NOT NULL,
  stock INT NOT NULL DEFAULT 100,
  FOREIGN KEY (restaurant_id) REFERENCES restaurants(id)
);

-- 4. ORDERS
DROP TABLE IF EXISTS orders;
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NOT NULL,
  restaurant_id INT NOT NULL,
  order_time DATETIME DEFAULT CURRENT_TIMESTAMP,
  status ENUM('placed','preparing','picked_up','delivered') DEFAULT 'placed',
  total_amount DECIMAL(9,2) NOT NULL,
  FOREIGN KEY (customer_id) REFERENCES users(id),
  FOREIGN KEY (restaurant_id) REFERENCES restaurants(id)
);

-- 5. ORDER ITEMS
DROP TABLE IF EXISTS order_items;
CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  menu_item_id INT NOT NULL,
  quantity INT NOT NULL,
  price_each DECIMAL(7,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (menu_item_id) REFERENCES menu_items(id)
);

-- 6. DELIVERY ASSIGNMENTS
DROP TABLE IF EXISTS delivery_assignments;
CREATE TABLE delivery_assignments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  agent_id INT NOT NULL,
  assigned_time DATETIME DEFAULT CURRENT_TIMESTAMP,
  delivered_time DATETIME NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (agent_id) REFERENCES users(id)
);

-- Insert USERS
INSERT INTO users (name,email,password_hash,role) VALUES
('Alice','alice@example.com',SHA2('password1',256),'customer'),
('Bob','bob@example.com',SHA2('password2',256),'restaurant'),
('Carol','carol@example.com',SHA2('password3',256),'delivery'),
('Dave','dave@example.com',SHA2('password4',256),'admin'),
('Eve','eve@example.com',SHA2('password5',256),'customer');

-- Insert RESTAURANTS
INSERT INTO restaurants (name,address,owner_id) VALUES
('Pasta Palace','123 Noodle Rd',2),
('Burger Barn','456 Patty St',2);

-- Insert MENU ITEMS
INSERT INTO menu_items (restaurant_id,name,price,stock) VALUES
(1,'Spaghetti',12.50,50),
(1,'Fettuccine Alfredo',14.00,30),
(2,'Classic Burger',10.00,40),
(2,'Veggie Burger',9.50,25),
(2,'Fries',3.00,100);

-- Insert ORDERS & ORDER_ITEMS
START TRANSACTION;
INSERT INTO orders (customer_id,restaurant_id,total_amount) VALUES (1,1,25.00);
SET @oid = LAST_INSERT_ID();
INSERT INTO order_items (order_id,menu_item_id,quantity,price_each) VALUES
(@oid,1,2,12.50);
COMMIT;

-- Insert DELIVERY ASSIGNMENTS
INSERT INTO delivery_assignments (order_id,agent_id) VALUES (1,3);

select * from users;
select * from restaurants;
select * from orders;
select * from order_items;
select * from menu_items;
select * from delivery_assignments; 