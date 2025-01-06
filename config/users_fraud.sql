-- Create the frauds table with consistent structure
CREATE TABLE `frauds` (
    `seq_id` INT NOT NULL AUTO_INCREMENT,
    `fraud_id` varchar(20) NOT NULL,
    
    -- User reference
    `user_id` varchar(20) NOT NULL,
    `fraud_type` varchar(50) NOT NULL,
    
    -- Fraud details
    `date_of_observation` date NOT NULL,
    `preferred_contact` varchar(50) DEFAULT NULL,
    `detailed_description` text NOT NULL,
    
    `location` varchar(255) NOT NULL,
    
    -- Status tracking fields
    `fraud_status` enum('assigned','unassigned') NOT NULL DEFAULT 'unassigned',
    `fraud_progress` enum('Pending','Investigation','Under Review','Resolved','Closed') 
        NOT NULL DEFAULT 'Pending',
    
    -- Timestamp fields
    `submission_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    
    -- Table constraints
    PRIMARY KEY (`seq_id`),
    UNIQUE KEY (`fraud_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create the trigger for automatic fraud_id generation
DELIMITER $$
CREATE TRIGGER `generate_fraud_id` 
BEFORE INSERT ON `frauds`
FOR EACH ROW
BEGIN
    SET NEW.fraud_id = CONCAT('frd', 
        LPAD(
            COALESCE(
                (SELECT AUTO_INCREMENT 
                 FROM information_schema.tables 
                 WHERE table_name = 'frauds' 
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