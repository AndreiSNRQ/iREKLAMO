-- SQL to create barangay_officials table
CREATE TABLE `barangay_officials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert initial data
INSERT INTO barangay_officials (position, name) VALUES
('Punong Barangay', 'Charles Dj. Manalad'),
('Barangay Secretary', 'Nandy L. San Buenaventura'),
('Barangay Kagawad', 'Ramil T. Borre'),
('President', 'Manuel S. Paguyo'),
('Vice President', 'Sammer D. Hadjimanan');