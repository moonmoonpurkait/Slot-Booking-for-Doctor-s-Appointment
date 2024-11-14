SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `teledoc`
-- CREATE DATABASE IF NOT EXISTS `if0_37668483_teledoc`;
USE `if0_37668483_teledoc`; 

-- --------------------------------------------------------
-- Table structure for table `doctor`
-- --------------------------------------------------------
CREATE TABLE `doctor` (
  `IndexNumber` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Degree` varchar(50) DEFAULT NULL,
  `Speciality` varchar(100) DEFAULT NULL,
  `Division` varchar(50) DEFAULT NULL,
  `ChamberNumber` varchar(20) DEFAULT NULL,
  `Hospital` varchar(255) DEFAULT NULL,
  `ChamberLocation` varchar(255) DEFAULT NULL,
  `TimeStart` time DEFAULT NULL,
  `TimeEnd` time DEFAULT NULL,
  `VisitCharge` int(11) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IndexNumber`),
  UNIQUE (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `doctor` (`IndexNumber`, `Name`, `Email`, `Password`, `Degree`, `Speciality`, `Division`, `ChamberNumber`, `Hospital`, `ChamberLocation`, `TimeStart`, `TimeEnd`, `VisitCharge`, `Image`) 
VALUES 
(1, 'Dr. Ananya Gupta', 'ananya.gupta@example.com', 'securepassword123', 'MBBS, MD', 'Cardiologist', 'North Kolkata', 'C101', 'Apollo Gleneagles Hospital', '58 Canal Circular Road, Kolkata', '09:00:00', '13:00:00', 1200, 'img/team-3.jpg'),
(2, 'Dr. Rajiv Sen', 'rajiv.sen@example.com', 'securepassword456', 'BDS, MDS', 'Dentist', 'South Kolkata', 'D202', 'Fortis Hospital', '730 Anandapur, Kolkata', '10:00:00', '14:00:00', 800, 'img/team-2.jpg'),
(3, 'Dr. Priya Das', 'priya.das@example.com', 'securepassword789', 'MBBS, MS', 'Orthopedic Surgeon', 'Central Kolkata', 'O303', 'AMRI Hospital', 'JC 16 & 17, Salt Lake, Kolkata', '15:00:00', '18:00:00', 1500, 'img/team-3.jpg'),
(4, 'Dr. Arjun Roy', 'arjun.roy@example.com', 'securepassword101', 'MBBS, DNB', 'Pediatrician', 'East Kolkata', 'P404', 'Columbia Asia Hospital', 'IB-193, Sector-III, Salt Lake, Kolkata', '11:00:00', '13:30:00', 900, 'img/team-1.jpg'),
(5, 'Dr. Meera Chakraborty', 'meera.chakraborty@example.com', 'securepassword102', 'MBBS, DM', 'Neurologist', 'West Kolkata', 'N505', 'Narayana Multispeciality Hospital', '124 Jessore Road, Kolkata', '16:00:00', '20:00:00', 2000, 'img/team-3.jpg');

-- --------------------------------------------------------
-- Table structure for table `info`
-- --------------------------------------------------------

CREATE TABLE `info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(99) NOT NULL,
  `name` varchar(99) DEFAULT NULL,
  `pass` varchar(99) DEFAULT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `user_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Sample data for table `info`
INSERT INTO `info` (`id`, `email`, `name`, `pass`,`otp`, `user_type`) VALUES
(1, 'admin', 'admin', 'admin', null, 0),
(3, 'milisen@gmail.com', 'Mili Sen', 'Mili@1', null, 2),
(2, 'rimisen@gmail.com', 'Rimi Sen', 'Rimi@1', null, 2),
(4, 'bm051998@gmail.com', 'B M', 'Bm@1234', null, 2),
(5, 'bm161998@gmail.com', 'B M', 'Bm@1234', null, 2);

-- --------------------------------------------------------
-- Table structure for table `doctor_availablity`
-- --------------------------------------------------------

CREATE TABLE `doctor_availablity` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `cost` double DEFAULT NULL,
  PRIMARY KEY (`app_id`),
  KEY `doc_id` (`doc_id`),
  KEY `fk_user_id` (`user_id`),
  FOREIGN KEY (`doc_id`) REFERENCES `doctor` (`IndexNumber`),
  FOREIGN KEY (`user_id`) REFERENCES `info` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Sample data for table `doctor_availablity`
INSERT INTO `doctor_availablity` (`app_id`, `doc_id`, `user_id`, `appointment_time`, `date`, `cost`) VALUES
(7, 1, 3, '08:00:00', '2024-04-16', 1200),  -- Corrected user_id
(8, 2, 2, '16:00:00', '2024-04-16', 800);  -- Corrected user_id

-- Auto-increment values for tables
ALTER TABLE `doctor` MODIFY `IndexNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `doctor_availablity` MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
ALTER TABLE `info` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

COMMIT;


-- --------------------------------------------------------
-- Table structure for table `otp`
-- --------------------------------------------------------

CREATE TABLE `otp` (
  `email` varchar(99) NOT NULL,
  `pass` varchar(99) DEFAULT NULL,
  `otp` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Sample data for table `info`
-- INSERT INTO `info` (`id`, `email`, `name`, `pass`, `user_type`) VALUES
-- (1, 'admin', 'admin', 'admin', 0),

CREATE TABLE contact_us (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);