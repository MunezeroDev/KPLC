CREATE TABLE `outages` (
    `seq_id` INT NOT NULL AUTO_INCREMENT,
    `outage_id` varchar(20) NOT NULL, 
    `user_id` varchar(20) NOT NULL,

    `type_of_outage` varchar(255) NOT NULL,
    `outage_start_time` datetime NOT NULL,
    `duration_minutes` int(11) DEFAULT NULL,    
    `priority_level` enum('High','Medium','Low') NOT NULL,

    `location` varchar(255) NOT NULL,  
    `preferred_contact` varchar(50) DEFAULT NULL,
    `suspected_reason` text DEFAULT NULL COMMENT '\r\n',

    `report_progress` enum('Pending','Resolving','Resolved') 
    NOT NULL DEFAULT 'Pending',
   
    `outage_status` enum('assigned','unassigned') NOT NULL DEFAULT 'unassigned',
    -- Timestamp fields
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    
    -- Table constraints
    PRIMARY KEY (`seq_id`),
    UNIQUE KEY (`outage_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DELIMITER $$
CREATE TRIGGER `generate_outage_id` 
BEFORE INSERT ON `outages`
FOR EACH ROW
BEGIN
    SET NEW.outage_id = CONCAT('out', 
        LPAD(
            COALESCE(
                (SELECT AUTO_INCREMENT 
                 FROM information_schema.tables 
                 WHERE table_name = 'outages' 
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