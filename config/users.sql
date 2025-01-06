-- Create the main users table
CREATE TABLE `users` (
    -- Separate auto-incrementing ID column
    `seq_id` INT NOT NULL AUTO_INCREMENT,
    -- User ID column (populated using a trigger)
    `user_id` varchar(20) NOT NULL,
    
    -- Personal information fields
    `first_name` varchar(50) NOT NULL,
    `last_name` varchar(50) NOT NULL,
    `date_of_birth` date NOT NULL,
    `gender` enum('Male', 'Female', 'Other') NOT NULL,
    
    -- Contact information fields
    `email` varchar(100) NOT NULL,
    `mobile_number` varchar(15) NOT NULL,
    
    -- Identification and location fields
    `national_id` varchar(20) NOT NULL,
    `county` varchar(50) NOT NULL,
    `town` varchar(50) NOT NULL,
    
    -- Service-related fields
    `connection_type` varchar(50) NOT NULL,
    `password_hash` varchar(255) NOT NULL,
    
    -- Role and access control
    `role` enum('CLIENT', 'ADMIN', 'STAFF') NOT NULL DEFAULT 'CLIENT',
    
    -- Audit fields for tracking record creation and updates
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    
    -- Primary key on the auto-incrementing seq_id
    PRIMARY KEY (`seq_id`),
    -- Unique constraint on the user_id
    UNIQUE KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create the trigger to generate user_id based on role and seq_id
DELIMITER $$

CREATE TRIGGER `generate_user_id` 
BEFORE INSERT ON `users`
FOR EACH ROW
BEGIN
    IF NEW.role = 'CLIENT' THEN
        SET NEW.user_id = CONCAT('usr', LPAD(NEW.seq_id + 1, 8, '0'));
    ELSEIF NEW.role = 'STAFF' THEN
        SET NEW.user_id = CONCAT('stf', LPAD(NEW.seq_id + 1, 8, '0'));
    ELSEIF NEW.role = 'ADMIN' THEN
        SET NEW.user_id = CONCAT('adm', LPAD(NEW.seq_id + 1, 8, '0'));
    END IF;
END$$

DELIMITER ;

-- Create the staff details table
CREATE TABLE `staff_details` (
    `staff_id` varchar(20) NOT NULL,
    `availability` enum('available', 'unavailable') DEFAULT 'available',
    PRIMARY KEY (`staff_id`),
    FOREIGN KEY (`staff_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create the admin details table
CREATE TABLE `admin_details` (
    `admin_id` varchar(20) NOT NULL,
    PRIMARY KEY (`admin_id`),
    FOREIGN KEY (`admin_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


