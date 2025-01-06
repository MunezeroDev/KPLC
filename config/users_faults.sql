CREATE TABLE `faults` (
    `seq_id` INT NOT NULL AUTO_INCREMENT,
    `fault_id` varchar(20) NOT NULL, 
    `user_id` varchar(20) NOT NULL,
    `nature_of_fault` varchar(255) NOT NULL,
    `description_of_issue` text NOT NULL,
    `severity_level` enum('Low','Medium','High','Critical') NOT NULL,
    `preferred_contact` varchar(50) DEFAULT NULL,
    `location` varchar(255) NOT NULL,  
    `fault_status` enum('assigned','unassigned') NOT NULL DEFAULT 'unassigned',
    `fault_progress` enum('Pending','In Progress','Investigation','Resolved','Closed') 
        NOT NULL DEFAULT 'Pending',
    -- Timestamp fields
    `submission_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    
    -- Table constraints
    PRIMARY KEY (`seq_id`),
    UNIQUE KEY (`fault_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DELIMITER $$
CREATE TRIGGER `generate_fault_id` 
BEFORE INSERT ON `faults`
FOR EACH ROW
BEGIN
    SET NEW.fault_id = CONCAT('flt', 
        LPAD(
            COALESCE(
                (SELECT AUTO_INCREMENT 
                 FROM information_schema.tables 
                 WHERE table_name = 'faults' 
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