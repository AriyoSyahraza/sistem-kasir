-- View untuk Melihat Detail Order

CREATE VIEW view_order_details AS
SELECT 
    o.order_id,
    c.name AS customer_name,
    COUNT(oi.menu_item_id) AS total_menu_items,
    GROUP_CONCAT(mi.name) AS menu_items,
    o.total_amount,
    d.name AS discount_name,
    o.order_date,
    u.username AS cashier_name
FROM orders o
JOIN customers c ON o.customer_id = c.customer_id
JOIN order_items oi ON o.order_id = oi.order_id
JOIN menu_items mi ON oi.menu_item_id = mi.menu_item_id
LEFT JOIN discount d ON o.discount_id = d.discount_id
JOIN user u ON o.cashier = u.user_id
GROUP BY o.order_id;


-- Menampilkan Seluruh Pesanan yang Menggunakan Diskon

sql
Copy code
SELECT 
    o.order_id,
    c.name AS customer_name,
    o.total_amount,
    d.name AS discount_name,
    o.order_date
FROM orders o
JOIN customers c ON o.customer_id = c.customer_id
JOIN discount d ON o.discount_id = d.discount_id;

-- Menampilkan Seluruh Order yang Dilakukan Selama 2 Minggu Terakhir

SELECT 
    o.order_id,
    c.name AS customer_name,
    o.total_amount,
    o.order_date,
    u.username AS cashier_name
FROM orders o
JOIN customers c ON o.customer_id = c.customer_id
JOIN user u ON o.cashier = u.user_id
WHERE o.order_date >= DATE_SUB('2024-11-11', INTERVAL 14 DAY);


-- Menampilkan Menu Item dan Jumlah Pesanan Masing-Masing

SELECT 
    mi.name AS menu_item_name,
    COUNT(oi.menu_item_id) AS times_ordered
FROM order_items oi
JOIN menu_items mi ON oi.menu_item_id = mi.menu_item_id
GROUP BY mi.menu_item_id
ORDER BY times_ordered DESC;

-- Menampilkan Nama Pelanggan dengan Transaksi Terbanyak Selama 1 Bulan Terakhir

SELECT 
    c.name AS customer_name,
    COUNT(o.order_id) AS total_transactions,
    SUM(o.total_amount) AS total_amount_transaction
FROM orders o
JOIN customers c ON o.customer_id = c.customer_id
WHERE o.order_date >= DATE_SUB('2024-11-11', INTERVAL 1 MONTH)
GROUP BY c.customer_id
ORDER BY total_transactions DESC, total_amount_transaction DESC
LIMIT 1;


