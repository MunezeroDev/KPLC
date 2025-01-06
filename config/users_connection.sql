-- First, let's create the connections table with all necessary fields and constraints
CREATE TABLE `connections` (
    -- Primary identifier that auto-increments
    `seq_id` INT NOT NULL AUTO_INCREMENT,
    
    -- Unique connection identifier that will follow the format 'connXXXXXXXX'
    `connection_id` varchar(20) NOT NULL,
    
    -- User reference and connection details
    `user_id` varchar(20) NOT NULL,
    `connection_type` varchar(20) NOT NULL,
    `premises_type` varchar(20) NOT NULL,
    `property_ownership` varchar(20) NOT NULL,
    `phase_type` varchar(20) NOT NULL,
    `location` varchar(255) NOT NULL,
    
    -- Status tracking fields
    `connection_status` enum('assigned','unassigned') NOT NULL DEFAULT 'unassigned',
    `application_progress` enum('Pending','Under Review','Inspection Scheduled','Approved','Rejected') 
        NOT NULL DEFAULT 'Pending',
    
    -- Timestamp fields for tracking record history
    `submission_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    
    -- Table constraints
    PRIMARY KEY (`seq_id`),
    UNIQUE KEY (`connection_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Now, let's create the trigger for automatic connection_id generation
DELIMITER $$

CREATE TRIGGER `generate_connection_id` 
BEFORE INSERT ON `connections`
FOR EACH ROW
BEGIN
    -- This trigger runs before each insert and generates a unique connection_id
    -- The strategy used here is to:
    -- 1. Get the next AUTO_INCREMENT value from information_schema
    -- 2. If no value exists (empty table), default to 1
    -- 3. Format the number with leading zeros to 8 digits
    -- 4. Prepend 'conn' to create the final connection_id
    SET NEW.connection_id = CONCAT('conn', 
        LPAD(
            COALESCE(
                (SELECT AUTO_INCREMENT 
                 FROM information_schema.tables 
                 WHERE table_name = 'connections' 
                 AND table_schema = DATABASE()
                ), 
                1
            ), 
            8, 
            '0'
        )
    );
END$$

DELIMITER ;

-- If you need to reset the auto-increment value (useful during testing or after table cleanup)
-- ALTER TABLE connections AUTO_INCREMENT = 1;