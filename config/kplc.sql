-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2025 at 06:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kplc`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `nextval` (OUT `next_val` BIGINT)   BEGIN
    UPDATE `fault_seq`
    SET `next_not_cached_value` = `next_not_cached_value` + `increment`
    WHERE `next_not_cached_value` < `maximum_value`;

    SELECT `next_not_cached_value` INTO next_val FROM `fault_seq`;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `connections`
--

CREATE TABLE `connections` (
  `connection_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `connection_type` varchar(20) NOT NULL,
  `premises_type` varchar(20) NOT NULL,
  `property_ownership` varchar(20) NOT NULL,
  `phase_type` varchar(20) NOT NULL,
  `county` varchar(100) NOT NULL,
  `town` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL,
  `application_status` enum('Pending','Under Review','Inspection Scheduled','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `submission_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ;

--
-- Dumping data for table `connections`
--

INSERT INTO `connections` (`connection_id`, `user_id`, `connection_type`, `premises_type`, `property_ownership`, `phase_type`, `county`, `town`, `location`, `application_status`, `submission_timestamp`, `created_at`, `updated_at`) VALUES
('con0001002', 'usr00001005', 'Residential', 'House', 'Owned', 'Single-phase', 'Kericho', 'Kericho Town', 'Kericho', 'Pending', '2025-01-05 10:59:25', '2025-01-05 10:59:25', '2025-01-05 10:59:25');

--
-- Triggers `connections`
--
DELIMITER $$
CREATE TRIGGER `before_connection_insert` BEFORE INSERT ON `connections` FOR EACH ROW BEGIN
    IF NEW.connection_id IS NULL OR NEW.connection_id = '' THEN
        SET NEW.connection_id = CONCAT(
            'con',
            LPAD(NEXTVAL(connection_seq), 7, '0')
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `connection_seq`
--

CREATE TABLE `connection_seq` (
  `next_not_cached_value` bigint(21) NOT NULL,
  `minimum_value` bigint(21) NOT NULL,
  `maximum_value` bigint(21) NOT NULL,
  `start_value` bigint(21) NOT NULL COMMENT 'start value when sequences is created or value if RESTART is used',
  `increment` bigint(21) NOT NULL COMMENT 'increment value',
  `cache_size` bigint(21) UNSIGNED NOT NULL,
  `cycle_option` tinyint(1) UNSIGNED NOT NULL COMMENT '0 if no cycles are allowed, 1 if the sequence should begin a new cycle when maximum_value is passed',
  `cycle_count` bigint(21) NOT NULL COMMENT 'How many cycles have been done'
) ENGINE=InnoDB;

--
-- Dumping data for table `connection_seq`
--

INSERT INTO `connection_seq` (`next_not_cached_value`, `minimum_value`, `maximum_value`, `start_value`, `increment`, `cache_size`, `cycle_option`, `cycle_count`) VALUES
(2001, 1, 9223372036854775806, 1, 1, 1000, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `faults`
--

CREATE TABLE `faults` (
  `fault_id` varchar(10) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `nature_of_fault` varchar(255) NOT NULL,
  `description_of_issue` text NOT NULL,
  `severity_level` enum('Low','Medium','High','Critical') NOT NULL,
  `preferred_contact` varchar(50) DEFAULT NULL,
  `county` varchar(100) DEFAULT NULL,
  `town` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `submission_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fault_status` enum('assigned','unassigned') NOT NULL DEFAULT 'unassigned',
  `fault_progress` enum('pending','inprogress','completed') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faults`
--

INSERT INTO `faults` (`fault_id`, `user_id`, `nature_of_fault`, `description_of_issue`, `severity_level`, `preferred_contact`, `county`, `town`, `location`, `submission_timestamp`, `created_at`, `updated_at`, `fault_status`, `fault_progress`) VALUES
('flt000001', 'usr00001005', 'Damaged Transformer', 'Transformer is oozing smoke and it\\\'s might explode', 'Critical', 'email', 'Kiambu', 'Thika', 'Thika Town', '2025-01-02 17:40:41', '2025-01-02 17:40:41', '2025-01-02 17:40:41', 'unassigned', 'pending'),
('flt000002', 'usr00001005', 'Sparking pole', 'Pole issue in Thika is scary', 'High', 'phone', 'Kiambu', 'Thika', 'Thika Town', '2025-01-05 17:05:51', '2025-01-05 17:05:51', '2025-01-05 17:05:51', 'unassigned', 'pending'),
('flt000003', 'usr00001005', 'Sparking pole', 'aaaaaaaaaaaaaa', 'Critical', 'email', 'Kilifi', 'Kilifi Town', 'Thika Town', '2025-01-05 17:21:08', '2025-01-05 17:21:08', '2025-01-05 17:21:08', 'unassigned', 'pending');

--
-- Triggers `faults`
--
DELIMITER $$
CREATE TRIGGER `before_insert_faults` BEFORE INSERT ON `faults` FOR EACH ROW BEGIN
    SET NEW.fault_id = CONCAT('flt', LPAD(COALESCE((SELECT MAX(CAST(SUBSTRING(fault_id, 4) AS UNSIGNED)) + 1 FROM faults), 1), 6, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `fraud`
--

CREATE TABLE `fraud` (
  `fraud_id` varchar(20) NOT NULL DEFAULT concat('fr',lpad(nextval(`kplc_db`.`fraud_seq`),8,'0')),
  `user_id` varchar(20) NOT NULL,

  `date_of_observation` date NOT NULL,

  `detailed_description` text NOT NULL,
  `preferred_contact_method` varchar(50) DEFAULT NULL,

  `submission_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `feedback_response` text DEFAULT NULL,

  `status_of_report` varchar(50) DEFAULT 'Pending',

  `priority_level` enum('Low','Medium','High') DEFAULT 'Low',

  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
 
  `county` varchar(50) NOT NULL,
  `town` varchar(50) NOT NULL,
  `fraud_type` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fraud_seq`
--

CREATE TABLE `fraud_seq` (
  `next_not_cached_value` bigint(21) NOT NULL,
  `minimum_value` bigint(21) NOT NULL,
  `maximum_value` bigint(21) NOT NULL,
  `start_value` bigint(21) NOT NULL COMMENT 'start value when sequences is created or value if RESTART is used',
  `increment` bigint(21) NOT NULL COMMENT 'increment value',
  `cache_size` bigint(21) UNSIGNED NOT NULL,
  `cycle_option` tinyint(1) UNSIGNED NOT NULL COMMENT '0 if no cycles are allowed, 1 if the sequence should begin a new cycle when maximum_value is passed',
  `cycle_count` bigint(21) NOT NULL COMMENT 'How many cycles have been done'
) ENGINE=InnoDB;

--
-- Dumping data for table `fraud_seq`
--

INSERT INTO `fraud_seq` (`next_not_cached_value`, `minimum_value`, `maximum_value`, `start_value`, `increment`, `cache_size`, `cycle_option`, `cycle_count`) VALUES
(1001, 1, 9223372036854775806, 1, 1, 1000, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `outage`
--

CREATE TABLE `outage` (
  `outage_id` varchar(20) NOT NULL DEFAULT concat('out',lpad(nextval(`kplc_db`.`outage_seq`),8,'0')),
  `user_id` varchar(20) NOT NULL,
  `type_of_outage` varchar(255) NOT NULL,
  `duration_minutes` int(11) DEFAULT NULL,

  `preferred_contact` varchar(50) DEFAULT NULL,
  `submission_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),

  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `town` varchar(255) NOT NULL,
  `county` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,

  `outage_start_time` datetime NOT NULL,

  `suspected_reason` text DEFAULT NULL COMMENT '\r\n',
  `priority_level` enum('High','Medium','Low') NOT NULL,
  
  `remarks` text DEFAULT NULL,
  `report_status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `outage_seq`
--

CREATE TABLE `outage_seq` (
  `next_not_cached_value` bigint(21) NOT NULL,
  `minimum_value` bigint(21) NOT NULL,
  `maximum_value` bigint(21) NOT NULL,
  `start_value` bigint(21) NOT NULL COMMENT 'start value when sequences is created or value if RESTART is used',
  `increment` bigint(21) NOT NULL COMMENT 'increment value',
  `cache_size` bigint(21) UNSIGNED NOT NULL,
  `cycle_option` tinyint(1) UNSIGNED NOT NULL COMMENT '0 if no cycles are allowed, 1 if the sequence should begin a new cycle when maximum_value is passed',
  `cycle_count` bigint(21) NOT NULL COMMENT 'How many cycles have been done'
) ENGINE=InnoDB;

--
-- Dumping data for table `outage_seq`
--

INSERT INTO `outage_seq` (`next_not_cached_value`, `minimum_value`, `maximum_value`, `start_value`, `increment`, `cache_size`, `cycle_option`, `cycle_count`) VALUES
(1001, 1, 9223372036854775806, 1, 1, 1000, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(20) NOT NULL DEFAULT concat('usr',lpad(nextval(`kplc_db`.`user_seq`),8,'0')),
  
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,

  `email` varchar(100) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,

  `national_id` varchar(20) NOT NULL,
  `county` varchar(50) NOT NULL,
  `town` varchar(50) NOT NULL,

  `connection_type` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,

  `role` enum('CLIENT','ADMIN','STAFF') NOT NULL DEFAULT 'CLIENT',
  
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `availability` enum('available','unavailable') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `date_of_birth`, `gender`, `email`, `mobile_number`, `national_id`, `county`, `town`, `connection_type`, `password_hash`, `role`, `created_at`, `updated_at`, `availability`) VALUES
('usr00000001', 'System', 'Admin', '2000-08-24', 'Male', 'admin@gmail.com', '0794949130', 'pc794949130', 'Kiambu', 'Thika', 'Residential', '6c0babd55d2c4da19a8e7ea36169e7ba012b02ca', 'ADMIN', '2025-01-02 14:32:55', '2025-01-02 14:32:55', 'available'),
('usr00001005', 'Karun', 'Nyambura', '2007-01-01', 'Male', 'karun1@gmail.com', '0784849130', 'azx1234567', 'Kilifi', 'Watamu', 'Residential', '9fccbad51fc9317b334fc23fade99f5d2bdf59dd', 'CLIENT', '2025-01-02 14:37:21', '2025-01-02 14:37:21', 'available'),
('usr00001006', 'Marcus', 'Garvey ', '2025-01-08', 'Male', 'marcus@gmail.com', '0794949130', '8989898978', 'Kisii', 'Kisii Town', 'Commercial', '33c8a0513d2be78426a301eb6e94d8550d0eb5f4', 'STAFF', '2025-01-02 14:46:41', '2025-01-02 22:03:08', 'unavailable'),
('usr00001007', 'Lumumba', 'PLO', '2025-01-20', 'Male', 'lumumba@gmail.com', '0794949130', 'lum123456', 'Busia', 'Busia Town', 'Residential', 'd9acdeb79ecf82de154de272fc1cc16d92e42d89', 'STAFF', '2025-01-02 14:47:47', '2025-01-02 22:04:47', 'unavailable');

-- --------------------------------------------------------

--
-- Table structure for table `user_seq`
--

CREATE TABLE `user_seq` (
  `next_not_cached_value` bigint(21) NOT NULL,
  `minimum_value` bigint(21) NOT NULL,
  `maximum_value` bigint(21) NOT NULL,
  `start_value` bigint(21) NOT NULL COMMENT 'start value when sequences is created or value if RESTART is used',
  `increment` bigint(21) NOT NULL COMMENT 'increment value',
  `cache_size` bigint(21) UNSIGNED NOT NULL,
  `cycle_option` tinyint(1) UNSIGNED NOT NULL COMMENT '0 if no cycles are allowed, 1 if the sequence should begin a new cycle when maximum_value is passed',
  `cycle_count` bigint(21) NOT NULL COMMENT 'How many cycles have been done'
) ENGINE=InnoDB;

--
-- Dumping data for table `user_seq`
--

INSERT INTO `user_seq` (`next_not_cached_value`, `minimum_value`, `maximum_value`, `start_value`, `increment`, `cache_size`, `cycle_option`, `cycle_count`) VALUES
(2001, 1, 9223372036854775806, 1, 1, 1000, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `connections`
--
ALTER TABLE `connections`
  ADD PRIMARY KEY (`connection_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `faults`
--
ALTER TABLE `faults`
  ADD PRIMARY KEY (`fault_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `fraud`
--
ALTER TABLE `fraud`
  ADD PRIMARY KEY (`fraud_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `outage`
--
ALTER TABLE `outage`
  ADD PRIMARY KEY (`outage_id`),
  ADD KEY `fk_outage_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `national_id` (`national_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `connections`
--
ALTER TABLE `connections`
  ADD CONSTRAINT `connections_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `faults`
--
ALTER TABLE `faults`
  ADD CONSTRAINT `faults_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `fraud`
--
ALTER TABLE `fraud`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `outage`
--
ALTER TABLE `outage`
  ADD CONSTRAINT `fk_outage_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
