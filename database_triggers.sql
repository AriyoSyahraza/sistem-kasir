DELIMITER $$

-- Trigger untuk mencatat INSERT ke log_customers
CREATE TRIGGER after_insert_customers
AFTER INSERT ON customers
FOR EACH ROW
BEGIN
    INSERT INTO log_customers (customer_id, operation, new_data, timestamp, performed_by)
    VALUES (NEW.customer_id, 'INSERT', CONCAT('Name: ', NEW.name, ', Phone: ', NEW.phone_number, ', Points: ', NEW.points, ', Status: ', NEW.status), NOW(), CURRENT_USER());
END $$

-- Trigger untuk mencegah penghapusan langsung pada tabel customers
CREATE TRIGGER before_delete_customers
BEFORE DELETE ON customers
FOR EACH ROW
BEGIN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Cannot delete customer. Set status to inactive instead.';
END $$

-- Trigger untuk mengubah status customer menjadi inactive alih-alih menghapus
CREATE TRIGGER before_update_customers_status
BEFORE UPDATE ON customers
FOR EACH ROW
BEGIN
    IF OLD.status = 'active' AND NEW.status = 'inactive' THEN
        INSERT INTO log_customers (customer_id, operation, old_data, new_data, timestamp, performed_by)
        VALUES (OLD.customer_id, 'UPDATE', CONCAT('Name: ', OLD.name, ', Phone: ', OLD.phone_number, ', Points: ', OLD.points, ', Status: active'),
                CONCAT('Name: ', OLD.name, ', Phone: ', OLD.phone_number, ', Points: ', OLD.points, ', Status: inactive'), NOW(), CURRENT_USER());

        -- Menyeting kunci asing terkait menjadi NULL jika status customer berubah ke inactive
        UPDATE orders SET customer_id = NULL WHERE customer_id = OLD.customer_id;
    END IF;
END $$

-- Trigger untuk mencatat INSERT ke log_orders
CREATE TRIGGER after_insert_orders
AFTER INSERT ON orders
FOR EACH ROW
BEGIN
    INSERT INTO log_orders (order_id, operation, new_data, timestamp, performed_by)
    VALUES (NEW.order_id, 'INSERT', CONCAT('Customer ID: ', NEW.customer_id, ', Total Amount: ', NEW.total_amount, ', Cashier: ', NEW.cashier, ', Discount ID: ', NEW.discount_id), NOW(), CURRENT_USER());
END $$

-- Trigger untuk mencatat UPDATE pada log_orders
CREATE TRIGGER after_update_orders
AFTER UPDATE ON orders
FOR EACH ROW
BEGIN
    INSERT INTO log_orders (order_id, operation, old_data, new_data, timestamp, performed_by)
    VALUES (OLD.order_id, 'UPDATE', 
            CONCAT('Customer ID: ', OLD.customer_id, ', Total Amount: ', OLD.total_amount, ', Cashier: ', OLD.cashier, ', Discount ID: ', OLD.discount_id),
            CONCAT('Customer ID: ', NEW.customer_id, ', Total Amount: ', NEW.total_amount, ', Cashier: ', NEW.cashier, ', Discount ID: ', NEW.discount_id), NOW(), CURRENT_USER());
END $$

-- Trigger untuk mencegah penghapusan langsung di log_orders (khusus untuk admin)
CREATE TRIGGER before_delete_orders
BEFORE DELETE ON orders
FOR EACH ROW
BEGIN
    DECLARE user_level ENUM('cashier', 'admin');
    SET user_level = (SELECT level FROM user WHERE username = CURRENT_USER());
    IF user_level <> 'admin' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Only admin can delete orders data.';
    END IF;
END $$

-- Trigger untuk mencatat UPDATE pada log_order_items
CREATE TRIGGER after_update_order_items
AFTER UPDATE ON order_items
FOR EACH ROW
BEGIN
    INSERT INTO log_order_items (order_item_id, order_id, operation, old_data, new_data, timestamp, performed_by)
    VALUES (OLD.order_item_id, OLD.order_id, 'UPDATE', 
            CONCAT('Menu Item ID: ', OLD.menu_item_id, ', Quantity: ', OLD.quantity, ', Price: ', OLD.price),
            CONCAT('Menu Item ID: ', NEW.menu_item_id, ', Quantity: ', NEW.quantity, ', Price: ', NEW.price), NOW(), 'System');
END $$

-- Trigger untuk mencegah penghapusan langsung di log_order_items (khusus untuk admin)
CREATE TRIGGER before_delete_order_items
BEFORE DELETE ON order_items
FOR EACH ROW
BEGIN
    DECLARE user_level ENUM('cashier', 'admin');
    SET user_level = (SELECT level FROM user WHERE username = CURRENT_USER());
    IF user_level <> 'admin' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Only admin can delete order items data.';
    END IF;
END $$


-- Trigger untuk mencatat INSERT ke log_discount
CREATE TRIGGER after_insert_discount
AFTER INSERT ON discount
FOR EACH ROW
BEGIN
    INSERT INTO log_discount (discount_id, operation, new_data, timestamp, performed_by)
    VALUES (NEW.discount_id, 'CREATE',
            CONCAT('Name: ', NEW.name, ', Percentage: ', NEW.percentage, ', Range Days: ', NEW.range_days), NOW(), 'System');
END $$

-- Trigger untuk mencatat UPDATE pada log_discount
CREATE TRIGGER after_update_discount
AFTER UPDATE ON discount
FOR EACH ROW
BEGIN
    INSERT INTO log_discount (discount_id, operation, old_data, new_data, timestamp, performed_by)
    VALUES (OLD.discount_id, 'UPDATE',
            CONCAT('Name: ', OLD.name, ', Percentage: ', OLD.percentage, ', Range Days: ', OLD.range_days),
            CONCAT('Name: ', NEW.name, ', Percentage: ', NEW.percentage, ', Range Days: ', NEW.range_days), NOW(), 'System');
END $$

-- Trigger untuk mencatat DELETE pada log_discount
CREATE TRIGGER after_delete_discount
AFTER DELETE ON discount
FOR EACH ROW
BEGIN
    INSERT INTO log_discount (discount_id, operation, old_data, timestamp, performed_by)
    VALUES (OLD.discount_id, 'DELETE',
            CONCAT('Name: ', OLD.name, ', Percentage: ', OLD.percentage, ', Range Days: ', OLD.range_days), NOW(), 'System');
END $$

-- Trigger untuk mencatat INSERT ke log_user
CREATE TRIGGER after_insert_user
AFTER INSERT ON user
FOR EACH ROW
BEGIN
    INSERT INTO log_user (user_id, operation, new_data, timestamp, performed_by)
    VALUES (NEW.user_id, 'CREATE', CONCAT('Username: ', NEW.username, ', Status: ', NEW.status, ', Level: ', NEW.level), NOW(), CURRENT_USER());
END $$

-- Trigger untuk mencatat UPDATE pada log_user (hanya admin yang boleh mengubah status cashier)
CREATE TRIGGER before_update_user
BEFORE UPDATE ON user
FOR EACH ROW
BEGIN
    DECLARE user_level ENUM('cashier', 'admin');
    SET user_level = (SELECT level FROM user WHERE username = CURRENT_USER());
    IF OLD.level = 'cashier' AND user_level <> 'admin' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Only admin can update cashier status.';
    ELSE
        INSERT INTO log_user (user_id, operation, old_data, new_data, timestamp, performed_by)
        VALUES (OLD.user_id, 'UPDATE', 
                CONCAT('Username: ', OLD.username, ', Status: ', OLD.status, ', Level: ', OLD.level),
                CONCAT('Username: ', NEW.username, ', Status: ', NEW.status, ', Level: ', NEW.level), NOW(), CURRENT_USER());
    END IF;
END $$

-- Trigger untuk mencatat DELETE pada log_user (hanya admin yang boleh menghapus cashier)
CREATE TRIGGER before_delete_user
BEFORE DELETE ON user
FOR EACH ROW
BEGIN
    DECLARE user_level ENUM('cashier', 'admin');
    SET user_level = (SELECT level FROM user WHERE username = CURRENT_USER());
    IF OLD.level = 'cashier' AND user_level <> 'admin' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Only admin can delete cashier.';
    ELSE
        INSERT INTO log_user (user_id, operation, old_data, timestamp, performed_by)
        VALUES (OLD.user_id, 'DELETE', CONCAT('Username: ', OLD.username, ', Status: ', OLD.status, ', Level: ', OLD.level), NOW(), CURRENT_USER());
    END IF;
END $$

DELIMITER ;
