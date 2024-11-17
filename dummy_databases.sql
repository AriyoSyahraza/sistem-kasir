-- Dummy Data untuk tabel user
INSERT INTO user (username, password, status, level) VALUES
('admin1', MD5('adminpass123'), 'active', 'admin'),
('admin2', MD5('adminpass456'), 'active', 'admin'),
('cashier1', MD5('cashierpass123'), 'active', 'cashier'),
('cashier2', MD5('cashierpass456'), 'active', 'cashier');

-- Dummy Data untuk tabel customers
INSERT INTO customers (name, phone_number, points, status) VALUES
('Budi', '081212345678', 250, 'active'),
('Siti', '081298765432', 180, 'active'),
('Agus', '081234567890', 320, 'inactive'),
('Rina', '081276543210', 400, 'active'),
('Dewi', '081255566677', 150, 'inactive'),
('Joko', '081244332211', 500, 'active'),
('Wulan', '081233445566', 275, 'active'),
('Tono', '081288776655', 320, 'inactive'),
('Sari', '081266778899', 210, 'active'),
('Anton', '081277889900', 380, 'active');

-- Dummy Data untuk tabel menu_items
INSERT INTO menu_items (name, price, redeemable_points) VALUES
('Espresso', 20000.00, 150),
('Cappuccino', 25000.00, 180),
('Latte', 30000.00, 200),
('Mocha', 32000.00, 250),
('Americano', 18000.00, 120),
('Macchiato', 27000.00, 190),
('Affogato', 35000.00, 300),
('Cold Brew', 30000.00, 220),
('Iced Latte', 28000.00, 200),
('Iced Tea', 15000.00, 100);

-- Dummy Data untuk tabel discount
INSERT INTO discount (name, percentage, range_days, created_at, updated_at, applied_at) VALUES
('Promo Hari Senin', 10, 7, '2024-09-26 02:43:42', NULL, NULL),
('Diskon Akhir Tahun', 15, 30, '2024-10-31 02:43:42', NULL, NULL),
('Promo Spesial', 20, 14, '2024-10-20 02:43:42', '2024-11-03 02:43:42', '2024-11-04 02:43:42'),
('Diskon Loyalitas', 5, 10, '2024-10-31 02:43:42', NULL, NULL),
('Promo Musim Panas', 25, 21, '2024-10-29 02:43:42', NULL, NULL);

-- Dummy Data untuk tabel orders dengan diskon yang dipakai
INSERT INTO orders (customer_id, discount_id, order_date, total_amount, cashier) VALUES
(1, 1, '2024-10-17 14:30:00', 165000.00, 3), -- Menggunakan Promo Hari Senin
(2, 2, '2024-10-09 12:15:00', 127000.00, 4), -- Menggunakan Diskon Akhir Tahun
(3, NULL, '2024-10-09 12:30:00', 153000.00, 4), -- Menggunakan Diskon Akhir Tahun
(4, NULL, '2024-10-30 10:45:00', 105000.00, 3), -- Tanpa Diskon
(5, 3, '2024-11-02 18:00:00', 87500.00, 4), -- Menggunakan Promo Spesial
(6, NULL, '2024-10-16 16:10:00', 126500.00, 3), -- Tanpa Diskon
(7, 4, '2024-10-22 11:20:00', 142000.00, 4), -- Menggunakan Diskon Loyalitas
(8, NULL, '2024-10-15 09:50:00', 119000.00, 3), -- Tanpa Diskon
(9, 5, '2024-11-01 15:30:00', 103000.00, 4), -- Menggunakan Promo Musim Panas
(10, NULL, '2024-10-27 17:40:00', 89000.00, 3); -- Tanpa Diskon

-- Dummy Data untuk tabel order_items
INSERT INTO order_items (order_id, menu_item_id, quantity, price) VALUES
(1, 1, 2, 40000.00),
(1, 3, 1, 30000.00),
(1, 5, 3, 54000.00),
(1, 7, 1, 35000.00),
(2, 2, 2, 50000.00),
(2, 4, 1, 32000.00),
(2, 6, 2, 54000.00),
(3, 5, 3, 54000.00),
(3, 8, 1, 30000.00),
(3, 9, 2, 56000.00),
(4, 1, 1, 20000.00),
(4, 3, 2, 60000.00),
(5, 2, 3, 75000.00),
(5, 4, 1, 32000.00),
(5, 10, 2, 30000.00),
(6, 3, 2, 60000.00),
(6, 7, 2, 70000.00),
(7, 1, 1, 20000.00),
(7, 8, 1, 30000.00),
(7, 10, 2, 30000.00),
(8, 2, 2, 50000.00),
(8, 5, 1, 18000.00),
(8, 9, 1, 28000.00),
(9, 3, 1, 30000.00),
(9, 6, 1, 27000.00),
(10, 4, 2, 64000.00),
(10, 5, 2, 36000.00),
(10, 8, 1, 30000.00);
