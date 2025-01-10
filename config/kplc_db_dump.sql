-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2025 at 05:42 AM
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
-- Database: `kplc_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_details`
--

CREATE TABLE `admin_details` (
  `admin_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_details`
--

INSERT INTO `admin_details` (`admin_id`) VALUES
('adm00000004');

-- --------------------------------------------------------

--
-- Table structure for table `connections`
--

CREATE TABLE `connections` (
  `seq_id` int(11) NOT NULL,
  `connection_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `connection_type` varchar(20) NOT NULL,
  `premises_type` varchar(20) NOT NULL,
  `property_ownership` varchar(20) NOT NULL,
  `phase_type` varchar(20) NOT NULL,
  `location` varchar(255) NOT NULL,
  `connection_status` enum('assigned','unassigned') NOT NULL DEFAULT 'unassigned',
  `application_progress` enum('Pending','Under Review','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `submission_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `connections`
--

INSERT INTO `connections` (`seq_id`, `connection_id`, `user_id`, `connection_type`, `premises_type`, `property_ownership`, `phase_type`, `location`, `connection_status`, `application_progress`, `submission_timestamp`, `created_at`, `updated_at`) VALUES
(1, 'conn00000001', 'usr00000005', 'Residential', 'House', 'Owned', 'Single-phase', 'Thika Town', 'assigned', 'Under Review', '2025-01-07 18:14:57', '2025-01-07 18:14:57', '2025-01-09 19:54:07'),
(2, 'conn00000002', 'usr00000003', 'Commercial', 'Shop/Office', 'Rented', 'Three-phase', 'Kericho', 'unassigned', 'Pending', '2025-01-09 05:01:15', '2025-01-09 05:01:15', '2025-01-09 05:01:15'),
(3, 'conn00000003', 'usr00000003', 'Residential', 'House', 'Owned', 'Single-phase', 'Thika Town', 'unassigned', 'Pending', '2025-01-09 15:12:16', '2025-01-09 15:12:16', '2025-01-09 15:12:16');

--
-- Triggers `connections`
--
DELIMITER $$
CREATE TRIGGER `generate_connection_id` BEFORE INSERT ON `connections` FOR EACH ROW BEGIN
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
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `faults`
--

CREATE TABLE `faults` (
  `seq_id` int(11) NOT NULL,
  `fault_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `nature_of_fault` varchar(255) NOT NULL,
  `description_of_issue` text NOT NULL,
  `severity_level` enum('Low','Medium','High','Critical') NOT NULL,
  `preferred_contact` varchar(50) DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `fault_status` enum('assigned','unassigned') NOT NULL DEFAULT 'unassigned',
  `fault_progress` enum('Pending','In Progress','Investigation','Resolved','Closed') NOT NULL DEFAULT 'Pending',
  `submission_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faults`
--

INSERT INTO `faults` (`seq_id`, `fault_id`, `user_id`, `nature_of_fault`, `description_of_issue`, `severity_level`, `preferred_contact`, `location`, `fault_status`, `fault_progress`, `submission_timestamp`, `created_at`, `updated_at`) VALUES
(1, 'flt00000001', 'usr00000005', 'Flickering or Dimming Lights', 'Lights Issues', 'High', 'phone', 'Thika Town', 'unassigned', 'Pending', '2025-01-07 18:19:09', '2025-01-07 18:19:09', '2025-01-07 18:19:09');

--
-- Triggers `faults`
--
DELIMITER $$
CREATE TRIGGER `generate_fault_id` BEFORE INSERT ON `faults` FOR EACH ROW BEGIN
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
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `frauds`
--

CREATE TABLE `frauds` (
  `seq_id` int(11) NOT NULL,
  `fraud_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `fraud_type` varchar(50) NOT NULL,
  `date_of_observation` date NOT NULL,
  `preferred_contact` varchar(50) DEFAULT NULL,
  `detailed_description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `fraud_status` enum('assigned','unassigned') NOT NULL DEFAULT 'unassigned',
  `fraud_progress` enum('Pending','Investigation','Under Review','Resolved','Closed') NOT NULL DEFAULT 'Pending',
  `submission_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `frauds`
--

INSERT INTO `frauds` (`seq_id`, `fraud_id`, `user_id`, `fraud_type`, `date_of_observation`, `preferred_contact`, `detailed_description`, `location`, `fraud_status`, `fraud_progress`, `submission_timestamp`, `created_at`, `updated_at`) VALUES
(1, 'frd00000001', 'usr00000005', 'Meter Tampering', '2025-01-22', 'Phone Contact', 'Issue Meter Tampering ', 'Thika Town', 'unassigned', 'Pending', '2025-01-07 18:22:22', '2025-01-07 18:22:22', '2025-01-07 18:22:22');

--
-- Triggers `frauds`
--
DELIMITER $$
CREATE TRIGGER `generate_fraud_id` BEFORE INSERT ON `frauds` FOR EACH ROW BEGIN
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
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `outages`
--

CREATE TABLE `outages` (
  `seq_id` int(11) NOT NULL,
  `outage_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `type_of_outage` varchar(255) NOT NULL,
  `outage_start_time` datetime NOT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `priority_level` enum('High','Medium','Low') NOT NULL,
  `location` varchar(255) NOT NULL,
  `preferred_contact` varchar(50) DEFAULT NULL,
  `suspected_reason` text DEFAULT NULL COMMENT '\r\n',
  `report_progress` enum('Pending','Resolving','Resolved') NOT NULL DEFAULT 'Pending',
  `outage_status` enum('assigned','unassigned') NOT NULL DEFAULT 'unassigned',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `outages`
--

INSERT INTO `outages` (`seq_id`, `outage_id`, `user_id`, `type_of_outage`, `outage_start_time`, `duration_minutes`, `priority_level`, `location`, `preferred_contact`, `suspected_reason`, `report_progress`, `outage_status`, `created_at`, `updated_at`) VALUES
(1, 'out00000001', 'usr00000005', 'Complete Power Loss', '2025-01-01 21:21:00', 50, 'Medium', 'Thika Town', 'phone', 'vehicle', 'Pending', 'unassigned', '2025-01-07 18:21:24', '2025-01-07 18:21:24');

--
-- Triggers `outages`
--
DELIMITER $$
CREATE TRIGGER `generate_outage_id` BEFORE INSERT ON `outages` FOR EACH ROW BEGIN
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
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `staff_details`
--

CREATE TABLE `staff_details` (
  `staff_id` varchar(20) NOT NULL,
  `availability` enum('available','unavailable') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_details`
--

INSERT INTO `staff_details` (`staff_id`, `availability`) VALUES
('stf00000012', 'unavailable'),
('stf00000013', 'unavailable'),
('stf00000014', 'unavailable'),
('stf00000015', 'unavailable'),
('stf00000016', 'unavailable'),
('stf00000017', 'unavailable'),
('stf00000018', 'unavailable');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `seq_id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`seq_id`, `user_id`, `first_name`, `last_name`, `date_of_birth`, `gender`, `email`, `mobile_number`, `national_id`, `county`, `town`, `connection_type`, `password_hash`, `role`, `created_at`, `updated_at`) VALUES
(2, 'usr00000002', 'Farida', 'MaryAnne', '2007-01-03', 'Female', 'farida@gmail.com', '0794949130', '123243ftyrt56', 'Nairobi', 'Westlands', 'Residential', '93b2b8315af3447574f50e3e9996317099d63bc8', 'CLIENT', '2025-01-06 18:35:07', '2025-01-06 18:35:07'),
(3, 'usr00000003', 'William ', 'Munezero', '2007-01-02', 'Female', 'williammunezero1@gmail.com', '+254794949130', '4567898uhb', 'Kiambu', 'Thika', 'Residential', '7a9e00aa0ca568b676fe559ed7b9a23093996a96', 'CLIENT', '2025-01-06 18:37:21', '2025-01-06 18:37:21'),
(4, 'adm00000004', 'System', 'Admin', '1990-01-01', 'Other', 'admin@gmail.com', '+254700000000', 'ADM123456', 'Nairobi', 'Nairobi', 'Direct', '6c0babd55d2c4da19a8e7ea36169e7ba012b02ca', 'ADMIN', '2025-01-06 18:48:14', '2025-01-06 18:48:14'),
(5, 'usr00000005', 'Karun', 'Nyambura ', '2004-02-17', 'Female', 'karun@gmail.com', '0794949130', '7h897765', 'Kiambu', 'Gatundu', 'Residential', '283aca75cbbb18805bdc0da43b78b54ecdbd257e', 'CLIENT', '2025-01-07 18:02:15', '2025-01-07 18:02:15'),
(12, 'stf00000012', 'Ismael ', 'Makanga', '2007-01-02', 'Male', 'ismael@gmail.com', '0794949130', '0101010101017', 'Kiambu', 'Thika', 'Residential', '329c31e858ca78c78a3592ce1cad7cfb11321ae8', 'STAFF', '2025-01-08 06:02:35', '2025-01-08 06:02:35'),
(13, 'stf00000013', 'Martin', 'Luther King', '2007-01-03', 'Male', 'Luther@gmail.com', '0794949130', '12wse45675', 'Kiambu', 'Thika', 'Residential', '9c747e9c688d34e982a886788a9fa6e4972550da', 'STAFF', '2025-01-08 06:10:20', '2025-01-08 06:10:20'),
(14, 'stf00000014', 'Mahtma ', 'Gandhi', '2004-06-22', 'Female', 'mahtma@gmail.com', '0794949130', '333333333367', 'Bungoma', 'Bungoma Town', 'Residential', '0ca71057138ec5d08db5a80012866d919300cda8', 'STAFF', '2025-01-08 15:21:47', '2025-01-08 15:21:47'),
(15, 'stf00000015', 'Salman', 'Khan', '2007-01-03', 'Male', 'salman@gmail.com', '0794949130', 's3454645', 'Garissa', 'Garissa Town', 'Residential', '4fabdafd5a4cc07d6e9ea2a84b9fde580b675c27', 'STAFF', '2025-01-08 15:28:20', '2025-01-08 15:28:20'),
(16, 'stf00000016', 'Marcus', 'Garvey ', '2007-01-03', 'Male', 'garvey@gmail.com', '0794949130', 'ga32342', 'Kilifi', 'Kilifi Town', 'Residential', '7e5b84771c580edc946f60ab7dbae0ecf0866cc2', 'STAFF', '2025-01-08 15:34:26', '2025-01-08 15:34:26'),
(17, 'stf00000017', 'Muamar', 'Gaddaffi', '2007-01-02', 'Male', 'muamar@gmail.com', '0794949130', '8989898978', 'Embu', 'Embu Town', 'Residential', 'c02e24b59292ba5b2deb3640aed5afabaa4fe4c5', 'STAFF', '2025-01-08 17:18:54', '2025-01-08 17:18:54'),
(18, 'stf00000018', 'Dedan ', 'Kimathi', '2003-01-08', 'Male', 'kimathi@gmail.com', '0794949130', '0101010101015', 'Kiambu', 'Gatundu', 'Residential', '0f53712240a72b6e683726f13fc50dac27ad2b08', 'STAFF', '2025-01-08 22:36:18', '2025-01-08 22:36:18');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `generate_user_id` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    DECLARE next_seq_id INT;

    -- Fetch the next AUTO_INCREMENT value
    SELECT AUTO_INCREMENT INTO next_seq_id
    FROM information_schema.TABLES
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users';

    -- Generate the user_id based on the role
    IF NEW.role = 'CLIENT' THEN
        SET NEW.user_id = CONCAT('usr', LPAD(next_seq_id, 8, '0'));
    ELSEIF NEW.role = 'STAFF' THEN
        SET NEW.user_id = CONCAT('stf', LPAD(next_seq_id, 8, '0'));
    ELSEIF NEW.role = 'ADMIN' THEN
        SET NEW.user_id = CONCAT('adm', LPAD(next_seq_id, 8, '0'));
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_details`
--
ALTER TABLE `admin_details`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `connections`
--
ALTER TABLE `connections`
  ADD PRIMARY KEY (`seq_id`),
  ADD UNIQUE KEY `connection_id` (`connection_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `faults`
--
ALTER TABLE `faults`
  ADD PRIMARY KEY (`seq_id`),
  ADD UNIQUE KEY `fault_id` (`fault_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `frauds`
--
ALTER TABLE `frauds`
  ADD PRIMARY KEY (`seq_id`),
  ADD UNIQUE KEY `fraud_id` (`fraud_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `outages`
--
ALTER TABLE `outages`
  ADD PRIMARY KEY (`seq_id`),
  ADD UNIQUE KEY `outage_id` (`outage_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `staff_details`
--
ALTER TABLE `staff_details`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`seq_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `connections`
--
ALTER TABLE `connections`
  MODIFY `seq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `faults`
--
ALTER TABLE `faults`
  MODIFY `seq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `frauds`
--
ALTER TABLE `frauds`
  MODIFY `seq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `outages`
--
ALTER TABLE `outages`
  MODIFY `seq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `seq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_details`
--
ALTER TABLE `admin_details`
  ADD CONSTRAINT `admin_details_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `connections`
--
ALTER TABLE `connections`
  ADD CONSTRAINT `connections_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `faults`
--
ALTER TABLE `faults`
  ADD CONSTRAINT `faults_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `frauds`
--
ALTER TABLE `frauds`
  ADD CONSTRAINT `frauds_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `outages`
--
ALTER TABLE `outages`
  ADD CONSTRAINT `outages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `staff_details`
--
ALTER TABLE `staff_details`
  ADD CONSTRAINT `staff_details_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
