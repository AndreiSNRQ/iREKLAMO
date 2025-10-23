-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Oct 05, 2025 at 12:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barangay`
--

-- --------------------------------------------------------

--
-- Table structure for table `barangay_officials`
--

CREATE TABLE `barangay_officials` (
  `id` int(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay_officials`
--

INSERT INTO `barangay_officials` (`id`, `position`, `name`, `updated_at`) VALUES
(16, 'Captain', 'Trishia Mae Camposano', '2025-10-03 05:07:10'),
(17, 'Secretary', 'Sherilyn Joyce Aligaga', '2025-10-03 05:07:10'),
(18, 'Kagawad', 'Andrei San Roque', '2025-10-03 05:07:10'),
(19, 'President', 'Harold Vince Abdurahman', '2025-10-03 05:07:10'),
(20, 'Vice President', 'Andrea Delfin', '2025-10-03 05:07:10');

-- --------------------------------------------------------

--
-- Table structure for table `blotter`
--

CREATE TABLE `blotter` (
  `id` int(255) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `c_contact` varchar(255) NOT NULL,
  `c_address` varchar(255) NOT NULL,
  `r_name` varchar(255) NOT NULL,
  `r_contact` varchar(255) NOT NULL,
  `r_address` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `date_time` datetime NOT NULL,
  `status` enum('pending','summon','1st trial','2nd trial','3rd trial','cfa','withdraw','resolved') NOT NULL DEFAULT 'pending',
  `created_by` int(11) DEFAULT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blotter`
--

INSERT INTO `blotter` (`id`, `c_name`, `c_contact`, `c_address`, `r_name`, `r_contact`, `r_address`, `type`, `details`, `location`, `date_time`, `status`, `created_by`, `updated_at`) VALUES
(12, 'renz', '092423', '213 mabanho bagbaqg', 'arlyn', '084243', 'sifhu i dff', 'Assault', 'fduignhui  jm', 'frfhrujn', '2025-09-27 05:51:00', 'resolved', 1, '2025-10-02'),
(13, 'renz', '092423', '213 mabanho bagbaqg', 'arlyn', '084243', 'sifhu i dff', 'Assault', 'fduignhui  jm', 'frfhrujn', '2025-09-27 05:51:00', 'resolved', 1, '2025-10-02'),
(14, 'renz', '092423', '213 mabanho bagbaqg', 'arlyn', '084243', 'sifhu i dff', 'Assault', 'fduignhui  jm', 'frfhrujn', '2025-09-27 05:51:00', 'resolved', 1, '2025-10-02'),
(15, 'Juan Dela Cruz', '09123456789', 'Barangay 1', 'Pedro Santos', '09987654321', 'Barangay 2', 'Physical Injury', 'Complaint details...', 'Barangay Hall', '2025-01-05 10:00:00', 'cfa', 1, '0000-00-00'),
(16, 'Maria Reyes', '09112223333', 'Barangay 3', 'Jose Cruz', '09998887777', 'Barangay 4', 'Verbal Abuse', 'Complaint details...', 'Barangay Hall', '2025-01-07 14:00:00', 'cfa', 1, '0000-00-00'),
(17, 'John Doe', '09133334444', 'Barangay 5', 'Mark Smith', '09997776666', 'Barangay 6', 'Theft', 'Complaint details...', 'Barangay Hall', '2025-01-10 09:00:00', 'cfa', 1, '0000-00-00'),
(18, 'Alice Tan', '09144445555', 'Barangay 7', 'Robert Lee', '09996665555', 'Barangay 8', 'Trespassing', 'Complaint details...', 'Barangay Hall', '2025-01-12 13:30:00', 'withdraw', 1, '2025-02-04'),
(19, 'Carlos Santos', '09155556666', 'Barangay 9', 'Miguel Torres', '09995554444', 'Barangay 10', 'Physical Injury', 'Complaint details...', 'Barangay Hall', '2025-01-15 11:00:00', 'withdraw', 1, '2025-10-02'),
(20, 'Ana Cruz', '09166667777', 'Barangay 11', 'Lito Ramos', '09994443333', 'Barangay 12', 'Harassment', 'Complaint details...', 'Barangay Hall', '2025-01-18 16:00:00', 'resolved', 1, '2025-10-02'),
(21, 'Pedro Lopez', '09177778888', 'Barangay 13', 'Diego Reyes', '09993332222', 'Barangay 14', 'Vandalism', 'Complaint details...', 'Barangay Hall', '2025-01-20 08:30:00', 'cfa', 1, '0000-00-00'),
(22, 'Maria Lopez', '09188889999', 'Barangay 15', 'Cesar Aquino', '09992221111', 'Barangay 16', 'Fraud', 'Complaint details...', 'Barangay Hall', '2025-01-22 15:00:00', 'summon', 1, '2025-10-03'),
(23, 'Jose Torres', '09199990000', 'Barangay 17', 'Juan Ramos', '09991110000', 'Barangay 18', 'Threat', 'Complaint details...', 'Barangay Hall', '2025-01-25 10:30:00', 'summon', 1, '2025-10-03'),
(24, 'Lucia Gomez', '09100001111', 'Barangay 19', 'Paulo Santos', '09990009999', 'Barangay 20', 'Other', 'Complaint details...', 'Barangay Hall', '2025-01-28 14:30:00', 'summon', 1, '2025-10-03'),
(25, 'Juan Dela Cruz', '09123456789', 'Barangay 1', 'Pedro Santos', '09987654321', 'Barangay 2', 'Physical Injury', 'Complaint details...', 'Barangay Hall', '2025-01-06 10:00:00', 'resolved', 1, '2025-10-02'),
(26, 'Maria Reyes', '09112223333', 'Barangay 3', 'Jose Cruz', '09998887777', 'Barangay 4', 'Verbal Abuse', 'Complaint details...', 'Barangay Hall', '2025-01-08 14:00:00', 'resolved', 1, '2025-10-02'),
(27, 'John Doe', '09133334444', 'Barangay 5', 'Mark Smith', '09997776666', 'Barangay 6', 'Theft', 'Complaint details...', 'Barangay Hall', '2025-01-11 09:00:00', 'resolved', 1, '2025-10-02'),
(28, 'Alice Tan', '09144445555', 'Barangay 7', 'Robert Lee', '09996665555', 'Barangay 8', 'Trespassing', 'Complaint details...', 'Barangay Hall', '2025-01-13 13:30:00', 'resolved', 1, '2025-10-02'),
(29, 'Carlos Santos', '09155556666', 'Barangay 9', 'Miguel Torres', '09995554444', 'Barangay 10', 'Physical Injury', 'Complaint details...', 'Barangay Hall', '2025-01-16 11:00:00', 'resolved', 1, '2025-10-02'),
(30, 'Ana Cruz', '09166667777', 'Barangay 11', 'Lito Ramos', '09994443333', 'Barangay 12', 'Harassment', 'Complaint details...', 'Barangay Hall', '2025-01-19 16:00:00', 'resolved', 1, '2025-10-02'),
(31, 'Pedro Lopez', '09177778888', 'Barangay 13', 'Diego Reyes', '09993332222', 'Barangay 14', 'Vandalism', 'Complaint details...', 'Barangay Hall', '2025-01-21 08:30:00', 'resolved', 1, '2025-07-16'),
(32, 'Maria Lopez', '09188889999', 'Barangay 15', 'Cesar Aquino', '09992221111', 'Barangay 16', 'Fraud', 'Complaint details...', 'Barangay Hall', '2025-01-23 15:00:00', 'resolved', 1, '2025-07-13'),
(33, 'Jose Torres', '09199990000', 'Barangay 17', 'Juan Ramos', '09991110000', 'Barangay 18', 'Threat', 'Complaint details...', 'Barangay Hall', '2025-01-26 10:30:00', 'resolved', 1, '2025-05-06'),
(35, 'Juan Dela Cruz', '09123456789', 'Barangay 1', 'Pedro Santos', '09987654321', 'Barangay 2', 'Physical Injury', 'Complaint details...', 'Barangay Hall', '2025-01-06 10:00:00', 'resolved', 1, '2025-08-04'),
(36, 'Maria Reyes', '09112223333', 'Barangay 3', 'Jose Cruz', '09998887777', 'Barangay 4', 'Verbal Abuse', 'Complaint details...', 'Barangay Hall', '2025-01-08 14:00:00', 'resolved', 1, '2025-06-24'),
(37, 'John Doe', '09133334444', 'Barangay 5', 'Mark Smith', '09997776666', 'Barangay 6', 'Theft', 'Complaint details...', 'Barangay Hall', '2025-01-11 09:00:00', 'resolved', 1, '2025-04-16'),
(38, 'Alice Tan', '09144445555', 'Barangay 7', 'Robert Lee', '09996665555', 'Barangay 8', 'Trespassing', 'Complaint details...', 'Barangay Hall', '2025-01-13 13:30:00', 'resolved', 1, '2025-01-09'),
(39, 'Carlos Santos', '09155556666', 'Barangay 9', 'Miguel Torres', '09995554444', 'Barangay 10', 'Physical Injury', 'Complaint details...', 'Barangay Hall', '2025-01-16 11:00:00', 'resolved', 1, '2025-10-02'),
(40, 'Ana Cruz', '09166667777', 'Barangay 11', 'Lito Ramos', '09994443333', 'Barangay 12', 'Harassment', 'Complaint details...', 'Barangay Hall', '2025-01-19 16:00:00', 'resolved', 1, '2025-10-02'),
(41, 'Pedro Lopez', '09177778888', 'Barangay 13', 'Diego Reyes', '09993332222', 'Barangay 14', 'Vandalism', 'Complaint details...', 'Barangay Hall', '2025-01-21 08:30:00', 'resolved', 1, '2025-09-09'),
(42, 'Maria Lopez', '09188889999', 'Barangay 15', 'Cesar Aquino', '09992221111', 'Barangay 16', 'Fraud', 'Complaint details...', 'Barangay Hall', '2025-01-23 15:00:00', 'resolved', 1, '2025-09-01'),
(43, 'Jose Torres', '09199990000', 'Barangay 17', 'Juan Ramos', '09991110000', 'Barangay 18', 'Threat', 'Complaint details...', 'Barangay Hall', '2025-01-26 10:30:00', 'resolved', 1, '2025-09-22'),
(44, 'Lucia Gomez', '09100001111', 'Barangay 19', 'Paulo Santos', '09990009999', 'Barangay 20', 'Other', 'Complaint details...', 'Barangay Hall', '2025-01-29 14:30:00', 'resolved', 1, '2025-10-01'),
(45, 'andrei', '091323', '212 evcefvfev valenzuela', 'ako sya', '09324472', '324 dkv ndfjkvn fjv', 'Assault', 'csdcsdvkdfjmdflknmf', 'valenzuela', '2025-09-27 03:21:00', 'withdraw', 1, '2025-10-02'),
(48, 'Maria Reyes', '09112223333', 'Barangay 3', 'Jose Cruz', '09998887777', 'Barangay 4', 'Verbal Abuse', 'Complaint details...', 'Barangay Hall', '2025-01-07 14:00:00', 'cfa', 1, '0000-00-00'),
(49, 'andrei san roque', '09123456789', '2025 Bestlink College of the Philippines', 'san roque andrei', '09876543210', '2025 Bestlink College of the Philippines', 'Domestic Dispute', 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibend', 'bahay lang', '2025-10-01 01:02:00', 'withdraw', 1, '0000-00-00'),
(50, 'andrei', '09123456789', '212 evcefvfev valenzuela', 'ako sya', '09876543211', '324 dkv ndfjkvn fjv', 'Theft', 'ccdswdecd', 'csdcds', '2025-10-03 00:00:00', 'pending', NULL, '2025-10-03'),
(51, 'andrie', '10234512891', 'dqweq', 'andrieee', '10234567891', 'sadas', 'Noise Complaint', '1332131', 'valenzuela', '2025-10-03 14:47:00', 'cfa', 1, '2025-10-03'),
(52, 'andrei', '09123456789', 'CSDDS', 'fvdc cf', '09876543211', 'SVSDFVFD', 'Theft', 'VSDVDSV', 'VVSDFVFDSVFD', '2025-10-03 00:00:00', 'pending', NULL, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

CREATE TABLE `complaint` (
  `id` int(255) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `c_contact` varchar(255) NOT NULL,
  `c_address` varchar(255) NOT NULL,
  `r_name` varchar(255) NOT NULL,
  `r_contact` varchar(255) NOT NULL,
  `r_address` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `date_time` datetime NOT NULL,
  `status` enum('active','archived','transfer') NOT NULL DEFAULT 'active',
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint`
--

INSERT INTO `complaint` (`id`, `c_name`, `c_contact`, `c_address`, `r_name`, `r_contact`, `r_address`, `type`, `details`, `location`, `date_time`, `status`, `created_by`) VALUES
(6, 'andrei', '091323', '212 evcefvfev valenzuela', 'ako sya', '09324472', '324 dkv ndfjkvn fjv', 'Assault', 'csdcsdvkdfjmdflknmf', 'valenzuela', '2025-09-27 03:21:00', 'transfer', 1),
(8, 'david', '0942342', '2cnznc dksj', 'trishia', '0834343', 'cscsdnvjv', 'Noise Complaint', 'apaka ingay ng bibig', 'csvfvfsv', '2025-09-27 03:31:00', 'active', 1),
(9, 'joyce', '2234345', 'cnsjkcnsdjk', 'lj', '938455', 'vskjvnfjdvnfsj', 'Others', 'vnvodfnvjundj', 'knmdndj', '2025-09-27 04:19:00', 'transfer', 1),
(10, 'david', '091323', '212 evcefvfev valenzuela', 'joyce', '09324472', '324 dkv ndfjkvn fjv', 'Vandalism', 'cscsdvfdvf', 'dcscs', '2025-09-27 05:23:00', 'active', 1),
(11, 'renz', '092423', '213 mabanho bagbaqg', 'arlyn', '084243', 'sifhu i dff', 'Assault', 'fduignhui  jm', 'frfhrujn', '2025-09-27 05:51:00', 'transfer', 1),
(22, 'Juan Dela Cruz', '09123456789', 'Barangay 1', 'Pedro Santos', '09987654321', 'Barangay 2', 'Physical Injury', 'Complaint details...', 'Barangay Hall', '2025-01-05 10:00:00', 'active', 1),
(23, 'Maria Reyes', '09112223333', 'Barangay 3', 'Jose Cruz', '09998887777', 'Barangay 4', 'Verbal Abuse', 'Complaint details...', 'Barangay Hall', '2025-01-07 14:00:00', 'transfer', 1),
(24, 'John Doe', '09133334444', 'Barangay 5', 'Mark Smith', '09997776666', 'Barangay 6', 'Theft', 'Complaint details...', 'Barangay Hall', '2025-01-10 09:00:00', 'active', 1),
(25, 'Alice Tan', '09144445555', 'Barangay 7', 'Robert Lee', '09996665555', 'Barangay 8', 'Trespassing', 'Complaint details...', 'Barangay Hall', '2025-01-12 13:30:00', 'archived', 1),
(26, 'Carlos Santos', '09155556666', 'Barangay 9', 'Miguel Torres', '09995554444', 'Barangay 10', 'Physical Injury', 'Complaint details...', 'Barangay Hall', '2025-01-15 11:00:00', 'archived', 1),
(27, 'Ana Cruz', '09166667777', 'Barangay 11', 'Lito Ramos', '09994443333', 'Barangay 12', 'Harassment', 'Complaint details...', 'Barangay Hall', '2025-01-18 16:00:00', 'archived', 1),
(28, 'Pedro Lopez', '09177778888', 'Barangay 13', 'Diego Reyes', '09993332222', 'Barangay 14', 'Vandalism', 'Complaint details...', 'Barangay Hall', '2025-01-20 08:30:00', 'archived', 1),
(29, 'Maria Lopez', '09188889999', 'Barangay 15', 'Cesar Aquino', '09992221111', 'Barangay 16', 'Fraud', 'Complaint details...', 'Barangay Hall', '2025-01-22 15:00:00', 'archived', 1),
(30, 'Jose Torres', '09199990000', 'Barangay 17', 'Juan Ramos', '09991110000', 'Barangay 18', 'Threat', 'Complaint details...', 'Barangay Hall', '2025-01-25 10:30:00', 'archived', 1),
(31, 'Lucia Gomez', '09100001111', 'Barangay 19', 'Paulo Santos', '09990009999', 'Barangay 20', 'Other', 'Complaint details...', 'Barangay Hall', '2025-01-28 14:30:00', 'archived', 1),
(32, 'andrei', '09123456789', '2123 Mauricio st. Bagbaguin, Valenzuela City', 'Loysa', '09876543211', 'La forteza Camarin Caloocan', 'Theft', 'ninakaw ang poso', 'CellPhone?', '2025-09-28 02:12:00', 'archived', 1),
(33, 'andrei', '09123456789', '2123 Mauricio st. Bagbaguin, Valenzuela City', 'Loysa', '09876543211', 'La forteza Camarin Caloocan', 'Theft', 'ninakaw ang poso', 'CellPhone?', '2025-09-28 02:12:00', 'archived', 1),
(34, 'andrei', '09123456789', '2123 Mauricio st. Bagbaguin, Valenzuela City', 'Loysa', '09876543211', 'La forteza Camarin Caloocan', 'Theft', 'ninakaw ang poso', 'CellPhone?', '2025-09-28 02:14:00', 'archived', 1),
(39, 'andrei', '091323', '212 evcefvfev valenzuela', 'ako sya', '09324472', '324 dkv ndfjkvn fjv', 'Theft', 'cscdsvfd', 'csvkfmf', '2025-09-28 18:04:00', 'active', 1),
(40, 'andrei san roque', '09123456789', '2025 Bestlink College of the Philippines', 'san roque andrei', '09876543210', '2025 Bestlink College of the Philippines', 'Domestic Dispute', 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibend', 'bahay lang', '2025-10-01 01:02:00', 'transfer', 1),
(68, 'dccd', 'v df vdf', 'O NDI DFCJ', 'NH IDKUFH', 'UNFIDVN DFI', 'NIKDFUNV FDI', 'Theft', 'UNDFIUDF', 'DFVDFV', '2025-10-03 12:08:00', 'active', 1),
(69, 'complainant name', 'complainant contact', 'complainant contact complainant address', 'complainant contact complainant address', 'complainant contact complainant address', 'complainant contact complainant address', '', 'complainant contact complainant address incident location date and time of incident details have', 'complainant contact complainant address incident location', '0000-00-00 00:00:00', 'archived', 1),
(70, 'andrei san roque', '091323', '212 evcefvfev valenzuela', 'ako sya', '09324472', '324 dkv ndfjkvn fjv', 'Theft', 'fvdfvfd', 'valenzuela', '2025-10-03 12:10:00', 'active', 1),
(74, 'andrie', '10234512891', 'dqweq', 'andrieee', '10234567891', 'sadas', 'Noise Complaint', '1332131', 'valenzuela', '2025-10-03 14:47:00', 'transfer', 1),
(75, 'andrei', '091323', '212 evcefvfev valenzuela', 'ako sya', '09324472', '324 dkv ndfjkvn fjv', 'Assault', 'CSCDSC', 'CSDCSDC', '2025-10-03 15:26:00', 'archived', 1);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `document_type` enum('complaint','both','blotter') NOT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `generated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `generated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_requests`
--

CREATE TABLE `report_requests` (
  `id` int(11) NOT NULL,
  `statuses` text DEFAULT NULL,
  `check_all` tinyint(1) DEFAULT 0,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status` varchar(32) DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `reviewed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('Admin','DeskStaff') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `email`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', '2025-08-30 14:11:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangay_officials`
--
ALTER TABLE `barangay_officials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blotter`
--
ALTER TABLE `blotter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_blotter_user` (`created_by`);

--
-- Indexes for table `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_complaint_user` (`created_by`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blotter_id` (`case_id`),
  ADD KEY `generated_by` (`generated_by`);

--
-- Indexes for table `report_requests`
--
ALTER TABLE `report_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangay_officials`
--
ALTER TABLE `barangay_officials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `blotter`
--
ALTER TABLE `blotter`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `complaint`
--
ALTER TABLE `complaint`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `report_requests`
--
ALTER TABLE `report_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blotter`
--
ALTER TABLE `blotter`
  ADD CONSTRAINT `fk_blotter_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `complaint`
--
ALTER TABLE `complaint`
  ADD CONSTRAINT `fk_complaint_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `blotter` (`id`),
  ADD CONSTRAINT `documents_ibfk_2` FOREIGN KEY (`generated_by`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
