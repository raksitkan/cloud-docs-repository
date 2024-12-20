-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2022 at 07:49 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smp_db_fms`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_user_log`
--

CREATE TABLE `add_user_log` (
  `log_id` int(11) NOT NULL,
  `m_username` varchar(50) NOT NULL,
  `m_password` varchar(50) NOT NULL,
  `m_action` varchar(50) NOT NULL,
  `action_by` varchar(50) NOT NULL,
  `host` text NOT NULL,
  `ip` varchar(20) NOT NULL,
  `time_add` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active | 0=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `file_log`
--

CREATE TABLE `file_log` (
  `log_id` int(11) NOT NULL,
  `file_name` text CHARACTER SET utf8 NOT NULL,
  `name_random` text CHARACTER SET utf8 NOT NULL,
  `subjects` varchar(50) CHARACTER SET utf8 NOT NULL,
  `action` varchar(50) CHARACTER SET utf8 NOT NULL,
  `create_by` varchar(20) CHARACTER SET utf8 NOT NULL,
  `host` text CHARACTER SET utf8 NOT NULL,
  `ip` varchar(20) CHARACTER SET utf8 NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `file_log`
--

INSERT INTO `file_log` (`log_id`, `file_name`, `name_random`, `subjects`, `action`, `create_by`, `host`, `ip`, `create_time`) VALUES
(177, 'script.zip', 'script.zip', 'เอกสาร1', 'Upload file successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:03:29'),
(178, 'ch3.rar', 'ch3.rar', 'เอกสาร2', 'Upload file successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:06:38'),
(179, 'ch3.rar', '2221647194921124.rar', 'เอกสาร3', 'Upload file successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:08:41'),
(180, '', 'script.zip', '', 'Deleted Successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:10:18'),
(181, '', 'ch3.rar', '', 'Deleted Successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:10:20'),
(182, '', '2221647194921124.rar', '', 'Deleted Successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:10:22'),
(183, '', '2221647194921124.rar', '', 'Deleted Successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:10:31'),
(184, 'ch3.rar', '2221647195068768.rar', 'เอกสาร1', 'Upload file successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:11:08'),
(185, '', '2221647195068768.rar', '', 'Deleted Successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:11:13'),
(186, '', '2221647195068768.rar', '', 'Deleted Successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:12:08'),
(187, '', '2221647195068768.rar', '', 'Deleted Successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:12:11'),
(188, '', '2221647195068768.rar', '', 'Deleted Successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:12:13'),
(189, '', '2221647195068768.rar', '', 'Deleted Successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:12:35'),
(190, 'ch3.rar', '2221647195176159.rar', '555', 'Upload file successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:12:56'),
(191, '', '2221647195176159.rar', '', 'Deleted Successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:12:57'),
(192, 'ch3.rar', '2221647195234303.rar', 'ไฟล์01 ', 'Upload file successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:13:54'),
(193, 'ch3.rar', '2221647195269991.rar', 'ไฟล์02', 'Upload file successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:14:29'),
(194, 'ch3.rar', '2221647195383642.rar', 'ฟฟฟ', 'Upload file successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:16:23'),
(195, '', '2221647195383642.rar', '', 'Deleted Successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:17:25'),
(196, 'empform3.zip', '2221647195473605.zip', '', 'Update file successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:17:53'),
(197, '', '2221647195269991.rar', '', 'Deleted Successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:18:00'),
(198, '', '2221647195234303.rar', '', 'Deleted Successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:18:03'),
(199, 'empform2.zip', '2221647195492862.zip', 'ไฟล์02', 'Upload file successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:18:12'),
(200, '', '2221647195492862.zip', '', 'Deleted Successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:18:19'),
(201, 'empform3.zip', '2221647195510384.zip', 'ไฟล์02', 'Upload file successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:18:30'),
(202, '', '2221647195510384.zip', '', 'Deleted Successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:18:39'),
(203, 'ch3.rar', '2221647195659176.rar', 'ไฟล์02', 'Upload file successfully', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:20:59'),
(204, '', '', '', 'File Already Exists', '222', 'FakeNews', '127.0.0.1', '2022-03-13 18:29:20'),
(205, '', '2221647195659176.rar', '', 'Deleted Successfully', '444', 'FakeNews', '127.0.0.1', '2022-03-13 18:29:37');

-- --------------------------------------------------------

--
-- Table structure for table `file_tbl`
--

CREATE TABLE `file_tbl` (
  `id` int(4) UNSIGNED ZEROFILL NOT NULL,
  `fname` varchar(100) CHARACTER SET utf8 NOT NULL,
  `file_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `file_name_random` text CHARACTER SET utf8 NOT NULL,
  `file_type` varchar(10) NOT NULL,
  `m_username` varchar(10) CHARACTER SET utf8 NOT NULL,
  `timestemp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(50) CHARACTER SET utf8 NOT NULL,
  `host` varchar(100) CHARACTER SET utf8 NOT NULL,
  `ip` varchar(15) CHARACTER SET utf8 NOT NULL,
  `DOWNLOAD` varchar(3) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `history_log`
--

CREATE TABLE `history_log` (
  `log_id` int(11) NOT NULL,
  `m_username` varchar(10) NOT NULL,
  `m_level` varchar(5) NOT NULL,
  `m_action` varchar(40) NOT NULL,
  `login_time` datetime NOT NULL,
  `m_actions` varchar(40) NOT NULL,
  `logout_time` datetime NOT NULL,
  `ip` varchar(20) NOT NULL,
  `host` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `history_log`
--

INSERT INTO `history_log` (`log_id`, `m_username`, `m_level`, `m_action`, `login_time`, `m_actions`, `logout_time`, `ip`, `host`) VALUES
(1, '444', 'admin', 'Has LoggedIn the system at', '2022-03-14 01:45:42', 'Has Logout the system at!', '2022-03-14 01:47:49', '127.0.0.1', 'FakeNews'),
(2, '444', 'admin', 'Has LoggedIn the system at', '2022-03-14 01:47:53', '', '0000-00-00 00:00:00', '127.0.0.1', 'FakeNews');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp`
--

CREATE TABLE `tbl_emp` (
  `m_id` int(11) NOT NULL,
  `m_username` varchar(50) NOT NULL,
  `m_password` varchar(50) NOT NULL,
  `m_level` varchar(10) NOT NULL,
  `host` text NOT NULL,
  `ip` varchar(20) NOT NULL,
  `m_datesave` timestamp NOT NULL DEFAULT current_timestamp(),
  `create_by` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_emp`
--

INSERT INTO `tbl_emp` (`m_id`, `m_username`, `m_password`, `m_level`, `host`, `ip`, `m_datesave`, `create_by`) VALUES
(1, '111 ', '111', 'staff', 'FakeNews', '127.0.0.1', '2020-03-24 04:00:33', '444'),
(2, '222', '222', 'staff', '', '', '2020-03-24 04:00:33', ''),
(3, '333 ', '333', 'admin', 'FakeNews', '127.0.0.1', '2020-03-24 04:00:33', '444'),
(4, '444', '444', 'admin', 'FakeNews', '127.0.0.1', '2020-03-24 04:00:33', '444'),
(36, 'Socia12345', ' 555', 'admin', 'DESKTOP-KG3MJRD', '127.0.0.1', '2022-03-04 08:27:43', '444');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_user_log`
--
ALTER TABLE `add_user_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `file_log`
--
ALTER TABLE `file_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `file_tbl`
--
ALTER TABLE `file_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_log`
--
ALTER TABLE `history_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tbl_emp`
--
ALTER TABLE `tbl_emp`
  ADD PRIMARY KEY (`m_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_user_log`
--
ALTER TABLE `add_user_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `file_log`
--
ALTER TABLE `file_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `file_tbl`
--
ALTER TABLE `file_tbl`
  MODIFY `id` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `history_log`
--
ALTER TABLE `history_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_emp`
--
ALTER TABLE `tbl_emp`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
