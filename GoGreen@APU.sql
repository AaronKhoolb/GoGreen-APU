-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 15, 2026 at 01:59 PM
-- Server version: 5.7.44-log
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rwdd`
--
CREATE DATABASE IF NOT EXISTS `rwdd` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `rwdd`;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `message` text,
  `image_path` varchar(250) DEFAULT NULL,
  `target_event_id` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `message`, `image_path`, `target_event_id`, `created_by`, `created_at`) VALUES
(4, 'minecraft', 'hahhaha Minecraft lol', '9_1769583957.png', 9, 2, '2026-01-28 15:05:57'),
(7, 'Beach Clean Up', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', NULL, 1, 1, '2026-01-28 21:14:08'),
(8, 'ZERO-WASTE WORKSHOP', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', NULL, 5, 1, '2026-01-28 21:20:34'),
(9, 'Beach Clean Up', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', NULL, 1, 1, '2026-01-30 02:53:27'),
(10, 'CAMPUS THRIFT MARKET', 'Campus Thrift Market is a student-led marketplace where pre-loved clothes, books and accessories are bought and sold at affordable prices. It promotes sustainability, encourages reuse and brings the campus community together through eco-friendly shopping.\r\n', NULL, 4, 1, '2026-01-30 02:53:32');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_codes`
--

CREATE TABLE `attendance_codes` (
  `id` bigint(20) NOT NULL,
  `event_id` bigint(20) NOT NULL,
  `code` int(3) DEFAULT NULL,
  `generated_by` int(11) DEFAULT NULL,
  `generated_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance_codes`
--

INSERT INTO `attendance_codes` (`id`, `event_id`, `code`, `generated_by`, `generated_at`, `expires_at`) VALUES
(1, 9, 846, 1, '2026-01-29 21:02:40', '2026-01-29 21:04:40'),
(2, 20, 687, 1, '2026-01-28 03:23:28', '2026-01-28 03:25:28'),
(3, 1, 472, 56, '2026-01-30 01:40:44', '2026-01-30 01:42:44'),
(4, 9, 481, NULL, '2026-01-30 04:17:30', '2026-01-30 04:19:30'),
(5, 9, 602, NULL, '2026-01-30 04:40:31', '2026-01-30 04:42:31'),
(6, 9, 934, NULL, '2026-01-30 04:54:05', '2026-01-30 04:56:05'),
(7, 20, 598, NULL, '2026-01-30 13:22:57', '2026-01-30 13:24:57'),
(8, 20, 662, NULL, '2026-01-30 13:23:11', '2026-01-30 13:25:11'),
(9, 20, 344, NULL, '2026-01-30 13:24:59', '2026-01-30 13:26:59'),
(10, 20, 838, NULL, '2026-01-30 13:27:01', '2026-01-30 13:29:01'),
(11, 20, 392, NULL, '2026-01-30 13:29:02', '2026-01-30 13:31:02'),
(12, 20, 779, NULL, '2026-01-30 13:31:04', '2026-01-30 13:33:04'),
(13, 20, 623, NULL, '2026-01-30 13:31:55', '2026-01-30 13:33:55'),
(14, 20, 686, NULL, '2026-01-30 13:32:00', '2026-01-30 13:34:00'),
(15, 20, 782, NULL, '2026-01-30 13:32:04', '2026-01-30 13:34:04'),
(16, 20, 564, NULL, '2026-01-30 13:34:08', '2026-01-30 13:36:08'),
(17, 20, 168, NULL, '2026-01-30 13:36:13', '2026-01-30 13:38:13'),
(18, 20, 301, NULL, '2026-01-30 13:38:18', '2026-01-30 13:40:18'),
(19, 20, 789, NULL, '2026-01-30 13:40:19', '2026-01-30 13:42:19'),
(20, 20, 414, NULL, '2026-01-30 13:42:23', '2026-01-30 13:44:23'),
(21, 9, 496, NULL, '2026-01-30 14:01:30', '2026-01-30 14:03:30'),
(22, 9, 498, NULL, '2026-01-30 14:01:31', '2026-01-30 14:03:31'),
(23, 9, 217, NULL, '2026-01-30 14:04:31', '2026-01-30 14:06:31'),
(24, 9, 363, NULL, '2026-01-30 14:10:05', '2026-01-30 14:12:05'),
(25, 9, 847, NULL, '2026-01-30 14:16:15', '2026-01-30 14:18:15'),
(26, 9, 710, NULL, '2026-01-30 14:19:31', '2026-01-30 14:21:31'),
(27, 9, 346, NULL, '2026-01-30 14:23:16', '2026-01-30 14:25:16'),
(28, 9, 874, NULL, '2026-01-30 14:23:46', '2026-01-30 14:25:46'),
(29, 9, 656, NULL, '2026-01-30 14:44:56', '2026-01-30 14:46:56'),
(30, 9, 809, NULL, '2026-01-30 14:51:21', '2026-01-30 14:53:21'),
(31, 9, 104, NULL, '2026-01-30 15:02:44', '2026-01-30 15:04:44'),
(32, 9, 566, NULL, '2026-01-30 15:04:46', '2026-01-30 15:06:46'),
(33, 9, 775, NULL, '2026-01-30 15:05:04', '2026-01-30 15:07:04'),
(34, 9, 775, NULL, '2026-01-30 15:05:07', '2026-01-30 15:07:07'),
(35, 20, 350, NULL, '2026-01-30 15:05:21', '2026-01-30 15:07:21'),
(36, 20, 955, NULL, '2026-01-30 15:05:29', '2026-01-30 15:07:29'),
(37, 20, 160, NULL, '2026-01-30 15:07:30', '2026-01-30 15:09:30'),
(38, 20, 267, NULL, '2026-01-30 15:07:36', '2026-01-30 15:09:36'),
(39, 20, 621, NULL, '2026-01-30 15:07:38', '2026-01-30 15:09:38'),
(40, 9, 967, NULL, '2026-01-30 15:07:40', '2026-01-30 15:09:40'),
(41, 9, 906, NULL, '2026-01-30 15:07:47', '2026-01-30 15:09:47'),
(42, 9, 888, NULL, '2026-01-30 15:07:51', '2026-01-30 15:09:51'),
(43, 9, 679, NULL, '2026-01-30 15:10:07', '2026-01-30 15:12:07'),
(44, 9, 573, NULL, '2026-01-30 15:10:46', '2026-01-30 15:12:46'),
(45, 9, 643, NULL, '2026-01-30 15:14:41', '2026-01-30 15:16:41'),
(46, 9, 733, NULL, '2026-01-30 15:35:14', '2026-01-30 15:37:14'),
(47, 9, 992, NULL, '2026-01-30 15:35:15', '2026-01-30 15:37:15'),
(48, 9, 194, NULL, '2026-01-30 15:40:41', '2026-01-30 15:42:41'),
(49, 9, 163, NULL, '2026-01-30 15:40:42', '2026-01-30 15:42:42');

-- --------------------------------------------------------

--
-- Table structure for table `certificate`
--

CREATE TABLE `certificate` (
  `event_id` bigint(20) NOT NULL,
  `signature_path` varchar(250) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `certificate`
--

INSERT INTO `certificate` (`event_id`, `signature_path`, `updated_at`, `updated_by`) VALUES
(1, '1.png', '2026-01-22 18:23:57', 2),
(5, '5.png', '2026-01-23 19:03:34', 2),
(9, '9.png', '2026-01-22 23:55:06', 2),
(17, '17.png', '2026-01-30 03:18:56', 2),
(18, '18.png', '2026-01-23 22:30:56', 1),
(20, '20.png', '2026-01-26 12:38:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `clubs`
--

CREATE TABLE `clubs` (
  `id` bigint(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `logo_path` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `website_link` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clubs`
--

INSERT INTO `clubs` (`id`, `name`, `description`, `logo_path`, `email`, `website_link`) VALUES
(1, 'Sustainable Future Fusion', 'A sustainable, future-oriented club with fusion aesthetics, prioritizing eco-friendly practices and innovative, forward-thinking design.', '1.png', 'isuc.apu@mail.dkly.top', 'https://apusff.com/'),
(2, 'APU Tech Club', 'A student club for technology enthusiasts focused on coding, innovation, and exploring tech solutions, including eco-friendly and sustainable projects.', '2.png', 'aputechclub@apu.edu.my', 'https://techclub.apu.edu.my'),
(3, 'Society of Petroleum Engineers Student Chapter', 'A student organization focused on advancing knowledge in petroleum engineering, promoting professional development and engaging in environmental and community initiatives.', '3.png', 'spe.apu@university.edu.my', 'https://spe.apu.edu.my'),
(4, 'APU Mental Wellness', 'A campus club dedicated to promoting mental health, wellbeing, and supportive initiatives for students through activities and awareness programs.', '4.png', 'mewe@apu.edu.my', 'https://mewe.apu.edu.my');

-- --------------------------------------------------------

--
-- Table structure for table `collaborators`
--

CREATE TABLE `collaborators` (
  `user_id` bigint(20) NOT NULL,
  `event_id` bigint(20) NOT NULL,
  `type` enum('internal','external') NOT NULL,
  `positions` varchar(50) DEFAULT NULL,
  `ngo_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `collaborators`
--

INSERT INTO `collaborators` (`user_id`, `event_id`, `type`, `positions`, `ngo_name`) VALUES
(56, 1, 'internal', 'Vice President', NULL),
(76, 1, 'internal', 'sleep', NULL),
(77, 1, 'external', 'Harrassment', 'ABC'),
(82, 13, 'internal', 'dawg', NULL),
(85, 6, 'internal', NULL, NULL),
(88, 1, 'internal', 'Volunteer', NULL),
(94, 9, 'internal', 'Volunteer Lead', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) NOT NULL,
  `event_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `comment` text NOT NULL,
  `coins_awarded` int(11) NOT NULL DEFAULT '5',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `event_id`, `user_id`, `comment`, `coins_awarded`, `created_at`) VALUES
(17, 13, 3, 'lollll sixxxx sevennn', 5, '2026-01-28 14:41:12'),
(18, 1, 3, 'Nice event, had fun and meaningful 💚', 5, '2026-01-29 15:52:01'),
(19, 1, 3, 'Tired but worth it, good experience!', 5, '2026-01-29 15:52:13'),
(20, 1, 3, 'Great teamwork, beach looks much cleaner now 👏', 5, '2026-01-29 15:52:46'),
(21, 1, 3, 'Happy to be part of this clean-up 💪', 5, '2026-01-29 15:52:56'),
(22, 1, 3, 'Fun + meaningful, hope to join again next time 🌊', 5, '2026-01-29 15:53:12'),
(23, 1, 3, 'Nice experience, good memories ✨', 5, '2026-01-30 02:48:18');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `image_path` varchar(250) NOT NULL,
  `club_id` bigint(20) NOT NULL,
  `short_description` text NOT NULL,
  `like_count` int(11) NOT NULL DEFAULT '0',
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `location` varchar(250) NOT NULL,
  `embed_map` text,
  `transportation` tinyint(1) NOT NULL,
  `transport_details` text,
  `coins_earned` int(11) NOT NULL,
  `max_participants` int(11) NOT NULL,
  `registration_deadline` datetime NOT NULL,
  `is_paid` tinyint(1) NOT NULL,
  `price` double(8,2) DEFAULT NULL,
  `sdg1` tinyint(1) NOT NULL,
  `sdg2` tinyint(1) NOT NULL,
  `sdg3` tinyint(1) NOT NULL,
  `sdg4` tinyint(1) NOT NULL,
  `sdg5` tinyint(1) NOT NULL,
  `sdg6` tinyint(1) NOT NULL,
  `sdg7` tinyint(1) NOT NULL,
  `sdg8` tinyint(1) NOT NULL,
  `sdg9` tinyint(1) NOT NULL,
  `sdg10` tinyint(1) NOT NULL,
  `sdg11` tinyint(1) NOT NULL,
  `sdg12` tinyint(1) NOT NULL,
  `sdg13` tinyint(1) NOT NULL,
  `sdg14` tinyint(1) NOT NULL,
  `sdg15` tinyint(1) NOT NULL,
  `sdg16` tinyint(1) NOT NULL,
  `sdg17` tinyint(1) NOT NULL,
  `details` text NOT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `whatsapp` varchar(250) DEFAULT NULL,
  `facebook` varchar(250) DEFAULT NULL,
  `instagram` varchar(250) DEFAULT NULL,
  `discord` varchar(250) DEFAULT NULL,
  `teams` varchar(250) DEFAULT NULL,
  `pinned` tinyint(4) NOT NULL DEFAULT '0',
  `is_approved` tinyint(1) DEFAULT NULL,
  `approved_by` bigint(20) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `attendance_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `image_path`, `club_id`, `short_description`, `like_count`, `start_date`, `end_date`, `start_time`, `end_time`, `location`, `embed_map`, `transportation`, `transport_details`, `coins_earned`, `max_participants`, `registration_deadline`, `is_paid`, `price`, `sdg1`, `sdg2`, `sdg3`, `sdg4`, `sdg5`, `sdg6`, `sdg7`, `sdg8`, `sdg9`, `sdg10`, `sdg11`, `sdg12`, `sdg13`, `sdg14`, `sdg15`, `sdg16`, `sdg17`, `details`, `phone_no`, `whatsapp`, `facebook`, `instagram`, `discord`, `teams`, `pinned`, `is_approved`, `approved_by`, `approved_at`, `created_by`, `created_at`, `updated_by`, `updated_at`, `attendance_code`) VALUES
(1, 'Beach Clean Up', '1.png', 1, 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 80, '2026-05-20', '2026-05-20', '07:30:00', '12:00:00', 'Pantai Kelang', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1992.5453523638569!2d101.41102529999999!3d2.7894915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cda147f6d746ef%3A0x6edaf265e15536a1!2sPantai%20Kelanang!5e0!3m2!1sen!2smy!4v1767705817089!5m2!1sen!2smy\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 1, '<h2>Transport Details</h2>\r\n<p>\r\n  To minimize our carbon footprint, we encourage all volunteers to use the organized group transport or carpool to the beach location.\r\n</p>\r\n\r\n<h3>Meeting Point & Time</h3>\r\n<ul>\r\n  <li><strong>Location:</strong> Main Entrance / Bus Stop Area (Campus Ground)</li>\r\n  <li><strong>Meeting Time:</strong> 7:30 AM (Bus departs strictly at 7:50 AM)</li>\r\n  <li><strong>Expected Return:</strong> 12:00 PM</li>\r\n</ul>\r\n\r\n<h3>Transportation Options</h3>\r\n<ul>\r\n  <li><strong>Shuttle Bus (Recommended):</strong> Free shuttle service provided by the club for the first 40 registered participants.</li>\r\n  <li><strong>Public Transport:</strong> Take Bus Route 50 to the \"Coastal Park\" stop; our team will meet you at the station.</li>\r\n  <li><strong>Carpooling:</strong> If you are driving, please contact the coordinator to offer empty seats to other volunteers.</li>\r\n</ul>\r\n\r\n<h3>Important Notes</h3>\r\n<ul>\r\n  <li>Please arrive 15 minutes early for attendance marking.</li>\r\n  <li>Ensure you have your student ID card for transport verification.</li>\r\n  <li>In case of heavy rain, transport schedules may be adjusted; check the club\'s Instagram for live updates.</li>\r\n</ul>', 25, 50, '2026-04-08 23:59:00', 0, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, '<h2>Activity Overview</h2>\r\n<p>\r\nA volunteer-based beach clean-up focused on removing plastic waste and debris to keep the coastline clean and safe.\r\n</p>\r\n\r\n<h2>What Volunteers Will Do</h2>\r\n<ul>\r\n  <li>Collect plastic waste and debris along the beach</li>\r\n  <li>Sort collected waste into designated bags</li>\r\n  <li>Work in small groups under organizer guidance</li>\r\n</ul>\r\n\r\n<h2>Equipment Provided (Free)</h2>\r\n<p>The following items will be provided to all participants:</p>\r\n<ul>\r\n  <li>Gloves</li>\r\n  <li>Trash bags</li>\r\n  <li>Waste pickers / tongs</li>\r\n  <li>Hats</li>\r\n  <li>Handkerchiefs / towels</li>\r\n</ul>\r\n\r\n<h2>Event Flow</h2>\r\n<ul>\r\n  <li>Short safety and task briefing</li>\r\n  <li>Beach clean-up activity</li>\r\n  <li>Waste collection and proper disposal</li>\r\n</ul>\r\n\r\n<h2>Why It Matters</h2>\r\n<ul>\r\n  <li>Protects marine life</li>\r\n  <li>Promotes environmental awareness</li>\r\n  <li>Encourages youth participation in sustainability efforts</li>\r\n</ul>\r\n', '', '', '', 'https://www.instagram.com/sff.apu/', '', '', 1, 1, 1, '2026-01-21 11:26:51', 2, '2026-01-06 21:51:11', 2, '2026-01-30 03:06:24', '172'),
(4, 'CAMPUS THRIFT MARKET', '5.jpeg', 1, 'Campus Thrift Market is a student-led marketplace where pre-loved clothes, books and accessories are bought and sold at affordable prices. It promotes sustainability, encourages reuse and brings the campus community together through eco-friendly shopping.\r\n', 164, '2026-03-10', '2026-04-15', '10:00:00', '17:00:00', 'CAMPUS Level 3', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3983.8517928545234!2d101.6799179!3d3.1338343!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc49c0707981fb%3A0x4a8ca9b691cf345b!2sGoogle%20Malaysia!5e0!3m2!1sen!2smy!4v1768113610388!5m2!1sen!2smy\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, NULL, 300, 30, '2026-04-17 00:00:00', 1, 10.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, '<h2>Activity Overview</h2>\r\n<p>\r\n  A volunteer-based beach clean-up focused on removing plastic waste and debris to keep the coastline clean and safe.\r\n</p>\r\n\r\n<h2>What Volunteers Will Do</h2>\r\n<ul>\r\n  <li>Collect plastic waste and debris along the beach</li>\r\n  <li>Sort collected waste into designated bags</li>\r\n  <li>Work in small groups under organizer guidance</li>\r\n</ul>\r\n\r\n<h2>Equipment Provided (Free)</h2>\r\n<p>The following items will be provided to all participants:</p>\r\n<ul>\r\n  <li>Gloves</li>\r\n  <li>Trash bags</li>\r\n  <li>Waste pickers / tongs</li>\r\n  <li>Hats</li>\r\n  <li>Handkerchiefs / towels</li>\r\n</ul>\r\n\r\n<h2>Event Flow</h2>\r\n<ul>\r\n  <li>Short safety and task briefing</li>\r\n  <li>Beach clean-up activity</li>\r\n  <li>Waste collection and proper disposal</li>\r\n</ul>\r\n\r\n<h2>Why It Matters</h2>\r\n<ul>\r\n  <li>Protects marine life</li>\r\n  <li>Promotes environmental awareness</li>\r\n  <li>Encourages youth participation in sustainability efforts</li>\r\n</ul>\r\n', '', '', 'https://www.facebook.com/isuc.csi\r\n', 'https://www.instagram.com/sff.apu/', '', '', 1, 1, 1, '2026-01-06 21:51:11', 2, '2026-01-06 21:51:11', 2, '2026-01-08 05:19:13', NULL),
(5, 'ZERO-WASTE WORKSHOP', '6.jpeg', 1, 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 0, '2026-01-13', '2026-02-10', '10:00:00', '16:00:00', 'Campus B-06-02-Eco-Innovation-Lab', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.1466974226473!2d101.6979851115252!3d3.0553868469075516!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4abb795025d9%3A0x1c37182a714ba968!2sAsia%20Pacific%20University%20of%20Technology%20%26%20Innovation%20(APU)!5e0!3m2!1sen!2smy!4v1768994441951!5m2!1sen!2smy\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, NULL, 10, 30, '2026-02-10 00:00:00', 0, 0.00, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0, '<h2>Activity Overview</h2>\n<p>\n  A hands-on workshop dedicated to the \"Zero Waste\" philosophy, where participants learn to reduce daily trash and transform discarded materials into functional household items.\n</p>\n\n<h2>What Participants Will Do</h2>\n<ul>\n  <li>Learn practical DIY skills to create eco-friendly alternatives (e.g., beeswax wraps or upcycled decor)</li>\n  <li>Engage in a \"Waste Audit\" to identify and minimize personal carbon footprints</li>\n  <li>Brainstorm innovative ways to integrate sustainability into campus life</li>\n</ul>\n\n<h2>Equipment Provided (Free)</h2>\n<p>All materials needed for the workshop will be provided to all participants:</p>\n<ul>\n  <li>Upcycling starter kits</li>\n  <li>Reusable crafting tools</li>\n  <li>Recycled raw materials</li>\n  <li>Informational \"Zero Waste\" guidebooks</li>\n  <li>Sustainable snacks and refreshments</li>\n</ul>\n\n<h2>Event Flow</h2>\n<ul>\n  <li>Interactive talk on Zero Waste principles and the \"5 Rs\"</li>\n  <li>Hands-on DIY upcycling session</li>\n  <li>Group showcase and \"Small Action, Big Impact\" pledge</li>\n</ul>\n\n<h2>Why It Matters</h2>\n<ul>\n  <li>Reduces the amount of waste sent to local landfills</li>\n  <li>Empowers students with tangible skills for sustainable living</li>\n  <li>Fosters a community of eco-conscious leaders at APU</li>\n</ul>', NULL, NULL, '', 'https://www.instagram.com/APU.FFP/', NULL, NULL, 1, 1, 1, NULL, 2, '2026-02-05 23:59:59', NULL, NULL, NULL),
(6, 'E-Waste Collection Drive', '7.png', 1, 'Don’t let your old electronics gather dust or end up in a landfill! We are hosting an E-Waste Collection Drive to help our community recycle responsibly. Whether it’s an old laptop, a tangled web of chargers, or a retired smartphone, bring them over and ensure they are processed safely for the environment.', 12, '2026-02-21', '2026-02-21', '10:00:00', '14:00:00', 'APU campus', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.1466974226473!2d101.69798511152518!3d3.0553868469075667!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4abb795025d9%3A0x1c37182a714ba968!2sAsia%20Pacific%20University%20of%20Technology%20%26%20Innovation%20(APU)!5e0!3m2!1sen!2smy!4v1768993203073!5m2!1sen!2smy\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, 'use walk', 10, 20, '2026-01-31 13:30:26', 1, 5.50, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 'hbcjhdsbcbd', '011-1738 2732', 'cascacs', 'asasa', 'cas', 'csac', 'sad', 1, 1, 1, NULL, 2, '2026-02-01 13:30:00', NULL, NULL, NULL),
(9, 'World Environment Day: Paws & Plants', '2.png', 1, 'An outdoor festival featuring hands-on Terrarium and Aquascape workshops alongside a lively Pet Fair. Enjoy a family-friendly atmosphere where you can learn about nature, shop for your pets and connect with fellow animal and plant lovers.', 6, '2026-06-05', '2026-06-05', '09:00:00', '15:00:00', 'Central Park Eco Forest', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8246.831001778502!2d101.89122564982964!3d2.928226109226651!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cdd1ec29abac31%3A0x6b33b5864a900be0!2sCentral%20Park%20Eco%20Forest!5e0!3m2!1sen!2smy!4v1768993930985!5m2!1sen!2smy\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 1, NULL, 20, 50, '2026-05-20 23:59:59', 0, 0.00, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 0, '', '011-1738 2732', '', '', '', '', '', 0, 1, 1, NULL, 2, '2026-03-18 21:15:23', 2, '2026-03-18 21:15:23', '625'),
(13, 'River Cleanup', '8.png\r\n', 2, 'Help us restore the beauty of our local waterways! Our Community River Cleanup is a hands-on event dedicated to removing litter and protecting the health of our river\'s ecosystem.', 0, '2026-04-20', NULL, '09:00:00', '12:00:00', 'Riverside Park', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7962.625985764886!2d103.32122891810292!3d3.741827570814092!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31c8b1007e8ecad5%3A0x460b72d4b9339eca!2sRiverside%20Park!5e0!3m2!1sen!2smy!4v1768997560487!5m2!1sen!2smy\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 1, 'The university is committed to supporting our sustainability efforts by providing free transportation for participants.\r\n\r\nBus Capacity: A 40-person shuttle bus has been reserved specifically for this event.\r\n\r\nPick-up Location: The bus will depart from the Main Campus Bus Terminal.\r\n\r\nDeparture Time: The bus will leave promptly at 8:30 AM to ensure we arrive at Riverside Park for the 9:00 AM start.\r\n\r\nReturn Trip: The bus will depart from the Riverside Park entrance at 12:15 PM to bring volunteers back to campus.\r\n\r\nHow to Secure a Seat\r\nSince the bus is limited to 40 passengers, seats will be allocated on a first-come, first-served basis.', 10, 40, '2026-01-25 18:36:00', 0, NULL, 0, 0, 0, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 'Time,Activity,Description\r\n09:00 AM,Registration & Welcome,\"Arrive at the Grand Avenue Entrance. Sign in, meet the team, and get settled.\"\r\n09:15 AM,Safety Briefing & Kit Distribution,Receive your gloves and collection bags. We will cover safety tips for working near the water.\r\n09:30 AM,Cleanup Kick-off,Teams head to their assigned zones along the riverbank to begin collecting litter and debris.\r\n10:45 AM,Mid-Way Refuel,A short break for light refreshments and water. A great time to swap stories with other volunteers!\r\n11:00 AM,Sorting & Final Sweep,Continue the cleanup and begin sorting collected waste into recyclables and non-recyclables.\r\n11:45 AM,Waste Weigh-in & Group Photo,We\'ll weigh the total trash collected to see our impact and take a commemorative group photo.\r\n12:00 PM,Event Wrap-up,\"Final thank you, return of reusable gear, and official close of the event.\"', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, NULL, 2, '2026-02-02 12:00:00', 2, '2026-02-20 18:36:54', NULL),
(17, 'Green Careers Talk', '10.png', 1, 'Are you passionate about the environment and looking to turn that passion into a profession? Join us for an inspiring Green Careers Talk! This event is designed for students and professionals eager to explore the rapidly growing sectors of sustainability.\r\n', 2, '2026-03-27', NULL, '18:00:00', '20:00:00', 'APU level-3 Auditorium 4 ', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.1466974226473!2d101.6979851115252!3d3.0553868469075516!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4abb795025d9%3A0x1c37182a714ba968!2sAsia%20Pacific%20University%20of%20Technology%20%26%20Innovation%20(APU)!5e0!3m2!1sen!2smy!4v1768998156935!5m2!1sen!2smy\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, '', 20, 35, '2026-03-21 20:00:00', 1, 10.00, 0, 0, 0, 1, 0, 0, 1, 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 'Core Discussion Topics\r\n1. The State of the Green Job Market\r\nIndustry Trends: Insights into why green jobs are growing at double the rate of traditional roles.\r\n\r\nEconomic Outlook: How SDG 8 (Decent Work) is driving global investments in sustainable businesses.\r\n\r\n2. Specialized Career Pathways\r\nRenewable Energy & Tech: Beyond engineering—discussing roles in project management, solar logistics, and AI for energy optimization.\r\n\r\nEnvironmental Science: Career options in water quality, soil health, and wildlife conservation (SDG 14 & 15).\r\n\r\nSustainable Urban Planning: How to design \"15-minute cities\" and green infrastructure to combat urban heat.\r\n\r\nCorporate Sustainability: The rise of the ESG (Environmental, Social, and Governance) Manager in the finance and retail sectors.\r\n\r\n3. The \"Green Skills\" Toolkit\r\nTechnical Skills: The importance of GIS (Mapping), carbon footprint accounting, and environmental law.\r\n\r\nSoft Skills: Why \"systems thinking,\" stakeholder negotiation, and complex problem-solving are vital for climate action.', '011-1738 2732', 'a', 'b', 'c', 'd', 'e', 1, 1, 1, '2026-01-24 07:13:09', 2, '2026-01-27 10:00:00', 1, '2026-02-04 03:56:25', NULL),
(18, 'Pet Care Program', '3.png', 1, 'Our Pet Care Program offers a range of free services and educational talks to help you provide the best possible care for your pets.', 7, '2026-01-22', NULL, '10:00:00', '14:00:00', 'APU level-3', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.1466974226473!2d101.69798511152518!3d3.0553868469075667!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4abb795025d9%3A0x1c37182a714ba968!2sAsia%20Pacific%20University%20of%20Technology%20%26%20Innovation%20(APU)!5e0!3m2!1sen!2smy!4v1768999285506!5m2!1sen!2smy\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, NULL, 15, 40, '2026-01-21 23:59:59', 0, NULL, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, 'Time, Activity, Description\r\n10:00 AM - 2:00 PM, Free Vet Checks, \"Bring your pet for a complimentary health check-up by our team of qualified veterinarians. (First-come, first-served basis)\"\r\n10:00 AM - 2:00 PM, Grooming Stations, \"Professional groomers will be available for basic grooming services like nail trimming, ear cleaning, and brushing.\"\r\n11:00 AM - 11:45 AM, Care Talk: Nutrition & Diet, Learn about the best nutritional practices for your pets at the stage area.\r\n12:30 PM - 1:15 PM, Care Talk: Pet First Aid, \"Essential first-aid tips for common pet emergencies, presented by a vet.\"\r\n1:30 PM - 2:00 PM,Q&A Session, An open session to ask our experts any questions you have about pet care.', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '2025-12-24 20:09:59', 2, '2025-12-10 14:09:59', NULL, NULL, NULL),
(19, 'Neighborhood Repair Café', '9.png', 1, 'Let\'s together in a bustling, friendly atmosphere, trading the \"throwaway\" mindset for a culture of care and reuse.', 0, '2026-01-21', NULL, '10:00:00', '17:00:00', 'APU Campus\r\nS8-3', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15936.473864074014!2d101.69541173178835!3d3.062983551207112!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4abb795025d9%3A0x1c37182a714ba968!2sAsia%20Pacific%20University%20of%20Technology%20%26%20Innovation%20(APU)!5e0!3m2!1sen!2smy!4v1769072038427!5m2!1sen!2smy\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, NULL, 10, 38, '2026-01-20 23:59:59', 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, '10:00 AM: The event begins with Doors Open & Registration, where guests can check in their broken items and get assigned to a specific repair station.\r\n\r\n10:30 AM: We will hold a Welcome Note to provide a brief introduction to the Repair Café movement and our goals.\r\n\r\n11:00 AM: The first Repair Session starts, focusing primarily on fixing small electronics, toys, and mechanical gadgets.\r\n\r\n12:30 PM: Everyone is invited to the Community Lunch Break for complimentary coffee and snacks while meeting fellow neighbors.\r\n\r\n1:30 PM: The second Repair Session begins, shifting the focus to textiles, clothing repairs, and patching.\r\n\r\n3:00 PM: Join our \"Fix-it\" Workshop for a live demonstration on how to perform basic tool maintenance.\r\n\r\n3:45 PM: The day concludes with a Wrap-up & Photo session to celebrate our fixed items and the waste we successfully diverted from landfills.', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 2, '2026-01-01 20:11:15', NULL, NULL, NULL),
(20, 'SDG Hackathon', '11.png', 2, '24-hour competitions where teams develop technical or social solutions for campus sustainability challenges.', 0, '2026-10-26', '2026-10-27', '10:00:00', '17:00:00', 'APU Campus Level 3 Canteen', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15936.674389229473!2d101.68247740522982!3d3.0494808506155655!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4abb795025d9%3A0x1c37182a714ba968!2sAsia%20Pacific%20University%20of%20Technology%20%26%20Innovation%20(APU)!5e0!3m2!1sen!2smy!4v1769078109908!5m2!1sen!2smy\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, '', 20, 25, '2026-01-21 20:12:00', 0, 0.00, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, '🚀 The Hackathon Breakdown\r\nThis is a 24-hour sprint where diverse teams—from engineers and designers to social activists—collaborate to build a \"Minimum Viable Product\" (MVP).\r\n\r\nThe Challenge: Identify a sustainability gap on campus (e.g., food waste in dining halls, inefficient lighting, or lack of inclusive spaces).\r\n\r\nTechnical Track: Building apps, sensors, or dashboards. (Think: An AI-powered bin that sorts recycling automatically).\r\n\r\nSocial Track: Designing policy changes, awareness campaigns, or community programs. (Think: A campus-wide \"Circular Economy\" clothing swap system).\r\n\r\nThe Pitch: At the end of 24 hours, teams present to a panel of judges for prizes, mentorship, or funding to actually implement the idea.', '', '', '', '', '', '', 0, 1, 1, '2026-02-06 11:04:39', 2, '2026-02-03 20:12:15', 1, '2026-02-12 18:48:32', '836'),
(21, 'Forest Cleanup Audits', '12.png', 2, 'Go beyond just cleaning; have participants categorize waste to identify the most frequent local pollutants for policy advocacy.', 0, '2026-01-22', NULL, '07:00:00', '12:00:00', 'Friends of Taman Tugu', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127493.39549433894!2d101.61018304794524!3d3.0494776408019812!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc49bc7461220b%3A0x5cb79f195aa30822!2sTaman%20Tugu!5e0!3m2!1sen!2smy!4v1769081043943!5m2!1sen!2smy\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 1, 'The APU shuttle bus will depart from the Main Campus Lobby at 7:15 AM to transport all participants directly to the forest cleanup site.', 11, 40, '2026-01-21 23:59:59', 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 1, 'Phase 1: Arrival & Briefing (8:00 AM – 8:30 AM)Once the APU bus drops you off at the meeting point (e.g., Taman Tugu Nursery), the session begins with coordination.Team Formation: Divide into groups of 4 or 5.Role Assignment: * 2 Collectors: The \"boots\" who go into the trails to find waste.1 Sorter: Stays at the base station to organize incoming bags.1 Recorder: The \"scientist\" who logs every item into the Audit Sheet.Safety Gear: Put on heavy-duty gloves and ensure everyone has tongs.Phase 2: The Search & Rescue (8:30 AM – 10:00 AM)Teams head into assigned zones of the forest.The \"Sweep\": Don\'t just look for big bottles; look for \"micro-litter\" like cigarette butts and plastic fragments, as these often do the most damage to soil.Collection Strategy: Fill bags but do not mix wet organic waste (like food scraps) with dry recyclables if possible.Phase 3: The Audit & Categorization (10:00 AM – 11:30 AM)This is the most critical part of the event. Instead of throwing everything into one big bin, you will empty your bags onto sorting tables.CategoryWhat to look forPolicy Advocacy GoalPET PlasticsWater/soda bottles.Push for a national Deposit Return Scheme (DRS).Soft PlasticsPlastic bags, snack wrappers, \"Maggi\" packets.Advocate for bans on non-recyclable multi-layer packaging.Aluminum/MetalCans, scrap metal.Support localized recycling bin placement.HazardousBatteries, e-waste, masks.Demand specialized toxic waste collection points.Brand AuditIdentifying which brands are most frequent.Hold corporations accountable via Extended Producer Responsibility (EPR).Phase 4: Data Entry & Photo Evidence (11:30 AM – 12:00 PM)Weight Check: Use a luggage scale to weigh each category.The \"Money Shot\": Lay out the most frequent pollutants (e.g., 200 plastic bottles) and take a high-impact photo. This \"visual data\" is what goes viral and catches the eye of policymakers.Digital Submission: Upload the totals to a shared Google Sheet or a citizen science app like Clean Swell.Phase 5: Clean Up & Departure (12:00 PM – 12:30 PM)Final Disposal: Ensure the audited waste is moved to the designated collection point for Alam Flora or the park’s waste management team.De-Gearing: Clean your tools and board the APU bus for the ride back to campus.Participant ChecklistAttire: Long pants (to avoid leeches/mosquitoes), APU club t-shirt, and closed-toe shoes.Essentials: Reusable water bottle, sunblock, and a power bank for data logging.Digital: Download the audit template (PDF/Google Sheet) before reaching the forest.', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 2, '2026-01-05 23:59:59', NULL, NULL, NULL),
(22, 'Bio-Blitz Diversity Counts', '13.png', 3, 'Using apps to document every local plant and insect species in a city park to support biodiversity.', 0, '2026-01-14', NULL, '06:00:00', '13:00:00', 'Forest Research Institute Malaysia', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.461009137246!2d101.62726466152583!3d3.2348599967266396!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc47da1a1466e7%3A0x7b6238e89ecebbf7!2sForest%20Research%20Institute%20Malaysia%20(FRIM)!5e0!3m2!1sen!2smy!4v1769122261957!5m2!1sen!2smy\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, NULL, 15, 40, '2026-01-13 23:59:59', 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, '1. Mastering the \"Digital Tools\"\r\nYou\'ll learn how to use apps like naturalist and Seek to contribute to global science.\r\n\r\nThe Perfect Snap: How to take \"Research Grade\" photos—getting the right angles, focus, and lighting so scientists (or AI) can actually identify the species.\r\n\r\nData Tagging: Recording precise locations and timestamps to help track how species move through the city over time.\r\n\r\nIdentify on the Fly: Using the \"Seek\" AR camera to get instant identifications of plants and bugs just by pointing your phone.\r\n\r\n2. Species Identification (The \"Nature\" Side)\r\nLocal experts usually lead walks to teach you how to spot things you normally walk past:\r\n\r\nThe \"Big 5\" Insects: Learning to tell the difference between major groups like Coleoptera (beetles), Hymenoptera (bees/ants), and Lepidoptera (butterflies/moths).\r\n\r\nNative vs. Invasive: How to tell if a plant belongs in your local park or if it\'s an \"invader\" that\'s outcompeting local species.\r\n\r\nMicro-Habitats: Learning where insects hide—under logs, inside seed pods, or on the undersides of leaves.', NULL, 'https://wa.link/jr70p4', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 2, '2025-12-30 20:14:35', NULL, NULL, NULL),
(23, 'The \"Eco-Code\" Hackathon', '23.png', 1, 'Instead of a traditional clean-up, challenge students to build digital solutions for environmental problems.', 0, '2026-01-11', NULL, '17:00:00', '20:30:00', 'APU Campus S8-3', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.1466974226473!2d101.6979851115252!3d3.0553868469075516!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4abb795025d9%3A0x1c37182a714ba968!2sAsia%20Pacific%20University%20of%20Technology%20%26%20Innovation%20(APU)!5e0!3m2!1sen!2smy!4v1769123161872!5m2!1sen!2smy\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, NULL, 20, 45, '2026-01-10 23:59:59', 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 'The Goal: Develop a prototype (app, website, or IoT device) that solves a local campus issue, like tracking food waste in the cafeteria or optimizing energy use in the labs.\r\n\r\nWhy it works for APU: It uses the technical skills of students in Computer Science and Engineering to create real-world impact.\r\n\r\nPartner: Collaborate with the APU Google Developer Student Club or AI Club.', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 2, '2026-01-05 20:16:04', 2, '2026-01-25 22:42:31', NULL),
(24, 'Urban Farm-to-Table Workshop', '15.png', 1, 'A hands-on morning of permaculture farming followed by a fresh, organic community lunch.', 0, '2026-02-01', NULL, '08:00:00', '13:00:00', 'Urban Hijau', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127480.45964222202!2d101.46674729726563!3d3.1567170000000027!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc49007d673be5%3A0xa009061ffe145d1e!2sUrban%20Hijau!5e0!3m2!1sen!2smy!4v1769123811005!5m2!1sen!2smy\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 1, '📍 Pickup & Drop-off Point\r\nLocation: APU Main Campus Shuttle Bus Waiting Area (Ground Floor, near the main entrance).\r\n\r\nAssembly Time: 07:45 AM (Please arrive early for attendance taking).\r\n\r\nDeparture Time: 08:00 AM SHARP. The bus will not wait for latecomers to ensure we reach the farm by the 08:30 AM start time.\r\n\r\n⚠️ Important \"Must-Knows\"\r\nFirst Come, First Served: We have one standard 40-seater bus. Once the seats are filled, registration for the bus will close.\r\n\r\nStudent ID Required: You must present your physical or digital APU Student ID to the bus marshal before boarding.\r\n\r\nLimited Space: If the bus is full, you may still join the event by arranging your own transportation (Grab/Carpool) to Urban Hijau, Kg. Sungai Penchala.', 30, 50, '2026-01-31 23:59:59', 1, 40.00, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 'Students get their hands dirty learning about vermicomposting, seed saving, and polyculture planting. The \"Twist\": You\'ll harvest the ingredients for the lunch you eat at the end of the session, making the connection between soil health and food security.', '011-1738 4043', 'https://wa.link/vzb4is', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 2, '2026-01-23 20:09:59', NULL, NULL, NULL),
(25, 'Zoo Keeperku Experience', '4.png', 1, 'A day in the life of a wildlife conservator helping to maintain animal welfare and habitats.', 0, '2026-01-30', NULL, '08:00:00', '16:00:00', 'Zoo Negara Malaysia', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.5569603380386!2d101.75623851152567!3d3.2103487967513447!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc39b60a831fe1%3A0xf2c800c702db7b2f!2sZoo%20Negara%20Malaysia!5e0!3m2!1sen!2smy!4v1769125792607!5m2!1sen!2smy\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 1, NULL, 50, 50, '2026-01-29 23:59:59', 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 'In collaboration with the Zoo Negara Education Department, students assist keepers with enclosure enrichment, food preparation for endangered species, and cleaning. It’s a deep dive into the logistics of SDG 15 (Life on Land).', '011-1738 4043', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 2, '2026-01-10 20:09:59', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_participants`
--

CREATE TABLE `event_participants` (
  `id` bigint(20) NOT NULL,
  `event_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `status` enum('attended','absent') DEFAULT NULL,
  `receipt_path` varchar(100) DEFAULT NULL,
  `approval_status` tinyint(1) DEFAULT NULL,
  `approved_by` bigint(20) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `coins_earned` int(11) NOT NULL DEFAULT '0',
  `registered_at` datetime NOT NULL,
  `marked_by` bigint(20) DEFAULT NULL,
  `check_in_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event_participants`
--

INSERT INTO `event_participants` (`id`, `event_id`, `user_id`, `status`, `receipt_path`, `approval_status`, `approved_by`, `approved_at`, `coins_earned`, `registered_at`, `marked_by`, `check_in_time`) VALUES
(15, 4, 3, 'attended', '4_3.pdf', 0, 2, '2026-01-30 03:07:53', 0, '2026-01-22 14:40:36', NULL, NULL),
(17, 5, 3, 'absent', NULL, 1, 2, '2026-01-23 00:07:36', 0, '2026-01-23 00:06:26', NULL, NULL),
(18, 13, 3, NULL, NULL, NULL, NULL, NULL, 0, '2026-01-24 14:45:37', NULL, NULL),
(20, 1, 3, 'attended', NULL, NULL, NULL, NULL, 25, '2026-01-28 14:21:16', 2, '2026-01-31 01:27:16'),
(22, 1, 86, NULL, NULL, NULL, NULL, NULL, 0, '2026-01-30 01:26:11', NULL, NULL),
(23, 1, 89, 'attended', NULL, NULL, NULL, NULL, 25, '2026-01-30 01:28:11', 2, '2026-01-31 00:49:53'),
(27, 9, 3, 'attended', NULL, 1, 1, '2026-01-30 16:21:19', 20, '2026-01-30 16:01:48', 1, '2026-02-06 11:00:44');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` bigint(20) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `category` enum('general','events','account','rewards') NOT NULL DEFAULT 'general',
  `category_id` bigint(20) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`, `category`, `category_id`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'What is GoGreen@APU?', '<p>GoGreen@APU is the official sustainability platform for Asia Pacific University. It connects students with eco-friendly events, clubs, and initiatives while rewarding participation with AP Coins that can be redeemed for exciting rewards.</p>', 'general', 1, '2026-01-20 05:25:07', 1, '2026-01-20 13:25:07', 1),
(2, 'How do I get started?', '<p>Getting started is easy! Simply register with your APU student credentials, complete your profile, and start exploring events.</p>', 'general', 1, '2026-01-20 05:25:07', 1, '2026-01-20 13:25:07', 1),
(3, 'How do I register for an event?', '<p>To register for an event, navigate to the event page and click the \"Register\" button. Check the confirmation box and submit.</p>', 'events', 1, '2026-01-20 05:25:07', 1, '2026-01-20 13:25:07', 1),
(4, 'How do I earn AP Coins?', '<p>You can earn AP Coins through various activities: attending events, leaving comments, and completing your profile.</p>', 'rewards', 1, '2026-01-20 05:25:07', 1, '2026-01-20 13:25:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `role` enum('admin','organizer','collaborator','student') NOT NULL,
  `action` varchar(50) NOT NULL,
  `details` text NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `role`, `action`, `details`, `date_time`) VALUES
(1, 2, 'organizer', 'Event', 'Event id 1 created', '2026-01-06 22:01:19'),
(2, 2, 'organizer', 'Event', 'Event id 1 poster updated', '2026-01-08 05:13:37'),
(3, 2, 'organizer', 'Event', 'Event id 1 poster updated', '2026-01-08 05:16:44'),
(4, 2, 'organizer', 'Event', 'Event id 1 information updated', '2026-01-08 05:18:27'),
(5, 2, 'organizer', 'Event', 'Event id 1 information updated', '2026-01-08 05:19:13'),
(6, 2, 'organizer', 'Event', 'Event id 2 deleted', '2026-01-09 10:14:57'),
(7, 2, 'organizer', 'Event', 'Event id 3 deleted', '2026-01-09 10:18:07'),
(9, 3, 'student', 'Comment', 'Commented on event id 4', '2026-01-11 13:18:25'),
(10, 3, 'student', 'Comment', 'Commented on event id 4', '2026-01-11 13:21:25'),
(11, 3, 'student', 'Event', 'Registered for event id 4', '2026-01-11 13:37:18'),
(12, 3, 'student', 'Event', 'Cancelled registration for event id 4', '2026-01-11 14:23:02'),
(13, 3, 'student', 'Event', 'Registered for event id 4', '2026-01-11 14:31:34'),
(14, 3, 'student', 'Comment', 'Commented on event id 4', '2026-01-11 15:53:41'),
(15, 3, 'student', 'Event', 'Cancelled registration for event id 1', '2026-01-12 10:23:46'),
(16, 3, 'student', 'Event', 'Registered for event id 1', '2026-01-12 10:23:56'),
(17, 3, 'student', 'Comment', 'Commented on event id 4', '2026-01-13 05:33:42'),
(18, 3, 'student', 'Comment', 'Commented on event id 4', '2026-01-16 09:45:16'),
(19, 1, 'admin', 'Event', 'Event id 5 approved by admin id 1', '2026-01-18 13:02:42'),
(20, 1, 'admin', 'Event', 'Event id 5 approved by admin id 1', '2026-01-18 13:02:46'),
(21, 1, 'admin', 'Event', 'Event id 5 rejected by admin id 1', '2026-01-18 13:03:09'),
(22, 1, 'admin', 'Event', 'Event id 5 rejected by admin id 1', '2026-01-18 13:03:12'),
(23, 1, 'admin', 'Event', 'Event id 5 approved by admin id 1', '2026-01-18 13:03:14'),
(24, 1, 'admin', 'Event', 'Event id 5 rejected by admin id 1', '2026-01-18 13:04:16'),
(25, 1, 'admin', 'Event', 'Event id 5 rejected by admin id 1', '2026-01-18 13:04:20'),
(26, 1, 'admin', 'Event', 'Event id 5 approved by admin id 1', '2026-01-18 13:12:28'),
(27, 1, 'admin', 'Event', 'Event id 5 rejected by admin id 1', '2026-01-18 13:12:31'),
(28, 1, 'admin', 'Event', 'Event id 1 rejected by admin id 1', '2026-01-18 13:28:36'),
(29, 1, 'admin', 'Event', 'Event id 1 approved by admin id 1', '2026-01-18 13:28:38'),
(30, 3, 'student', 'Comment', 'Commented on event id 4', '2026-01-18 15:19:54'),
(31, 3, 'student', 'Comment', 'Commented on event id 1', '2026-01-19 10:51:21'),
(32, 3, 'student', 'Comment', 'Commented on event id 1', '2026-01-19 10:51:28'),
(33, 2, 'organizer', 'Event', 'Event id 7 created: Test', '2026-01-19 20:31:06'),
(34, 2, 'organizer', 'Event', 'Event id 8 created: Test', '2026-01-19 21:12:53'),
(35, 2, 'organizer', 'Event', 'Event id 9 created: Test', '2026-01-19 21:15:23'),
(36, 1, 'admin', 'Event', 'Event id 10 created: Test', '2026-01-20 01:58:22'),
(37, 1, 'admin', 'Event', 'Event id 11 created: I want Sleep', '2026-01-20 02:11:56'),
(38, 1, 'admin', 'Event', 'Event id 12 created: Test', '2026-01-20 02:16:22'),
(39, 3, 'student', 'Comment', 'Commented on event id 1', '2026-01-20 20:42:50'),
(40, 3, 'student', 'Event', 'Cancelled registration for event id 4', '2026-01-21 02:21:25'),
(41, 3, 'student', 'Event', 'Registered for event id 4', '2026-01-21 02:23:11'),
(42, 2, 'organizer', 'Event', 'Event id 5 poster updated', '2026-01-21 03:09:46'),
(43, 2, 'organizer', 'Event', 'Event id 5 poster updated', '2026-01-21 03:12:28'),
(44, 2, 'organizer', 'Event', 'Event id 5 poster updated', '2026-01-21 03:12:35'),
(45, 1, 'admin', 'Event', 'Event id 1 rejected by admin id 1', '2026-01-21 11:26:41'),
(46, 1, 'admin', 'Event', 'Event id 1 approved by admin id 1', '2026-01-21 11:26:43'),
(47, 1, 'admin', 'Event', 'Event id 1 rejected by admin id 1', '2026-01-21 11:26:49'),
(48, 1, 'admin', 'Event', 'Event id 1 approved by admin id 1', '2026-01-21 11:26:51'),
(49, 2, 'organizer', 'Event', 'Event id 11 deleted', '2026-01-21 18:17:35'),
(50, 1, 'admin', 'Event', 'Event id 13 created', '2026-01-21 18:36:54'),
(51, 1, 'admin', 'Event', 'Event id 14 created', '2026-01-21 18:41:35'),
(52, 1, 'admin', 'Event', 'Event id 26 created', '2026-01-21 21:49:06'),
(53, 1, 'admin', 'Event', 'Event id 26 approved by admin id 1', '2026-01-21 21:49:17'),
(54, 2, 'organizer', 'Event', 'Event id 27 created', '2026-01-21 21:53:39'),
(55, 2, 'organizer', 'Event', 'Event id 27 deleted', '2026-01-21 21:53:44'),
(56, 1, 'organizer', 'Event', 'Event id 26 deleted', '2026-01-21 21:55:41'),
(57, 1, 'admin', 'Event', 'Event id 28 created', '2026-01-21 22:00:00'),
(58, 1, 'organizer', 'Event', 'Event id 28 deleted', '2026-01-21 22:00:18'),
(59, 1, 'admin', 'Event', 'Event id 29 created', '2026-01-21 22:07:25'),
(60, 1, 'organizer', 'Event', 'Event id 29 deleted', '2026-01-21 22:08:50'),
(61, 1, 'admin', 'Participant', 'Approved participant id 13 for event id 1', '2026-01-22 03:28:09'),
(62, 1, 'admin', 'Participant', 'Rejected participant id 13 for event id 1', '2026-01-22 03:28:13'),
(63, 1, 'admin', 'Participant', 'Deleted participant id 13 from event id 1', '2026-01-22 04:32:49'),
(64, 3, 'student', 'Event', 'Cancelled registration for event id 4', '2026-01-22 14:40:17'),
(65, 3, 'student', 'Event', 'Registered for event id 4', '2026-01-22 14:40:36'),
(66, 3, 'student', 'Comment', 'Commented on event id 4', '2026-01-22 14:40:43'),
(67, 1, 'admin', 'Event', 'Event id 20 approved by admin id 1', '2026-01-22 14:41:50'),
(68, 1, 'admin', 'Participant', 'Approved participant id 15 for event id 4', '2026-01-22 14:42:37'),
(69, 1, 'admin', 'Event', 'Event id 17 rejected by admin id 1', '2026-01-22 18:28:14'),
(70, 1, 'admin', 'Event', 'Event id 17 approved by admin id 1', '2026-01-22 18:28:17'),
(71, 3, 'student', 'Event', 'Registered for event id 9', '2026-01-23 00:06:26'),
(72, 2, 'organizer', 'Participant', 'Approved participant id 16 for event id 9', '2026-01-23 00:07:36'),
(73, 1, 'admin', 'Pinned Post', 'Pinned event id 1', '2026-01-23 02:34:03'),
(74, 1, 'admin', 'Event', 'Event id 26 created', '2026-01-23 02:57:54'),
(75, 1, 'admin', 'Pinned Post', 'Unpinned event id 1', '2026-01-23 02:59:04'),
(76, 1, 'admin', 'Pinned Post', 'Pinned event id 17', '2026-01-23 03:07:38'),
(77, 1, 'admin', 'Pinned Post', 'Pinned event id 17', '2026-01-23 03:07:43'),
(78, 1, 'admin', 'Pinned Post', 'Pinned event id 17', '2026-01-23 03:07:43'),
(79, 1, 'admin', 'Pinned Post', 'Pinned event id 17', '2026-01-23 03:07:44'),
(80, 1, 'admin', 'Pinned Post', 'Pinned event id 17', '2026-01-23 03:07:44'),
(81, 1, 'admin', 'Pinned Post', 'Unpinned event id 17', '2026-01-23 03:10:03'),
(82, 1, 'admin', 'Pinned Post', 'Pinned event id 17', '2026-01-23 03:10:05'),
(83, 1, 'admin', 'Pinned Post', 'Unpinned event id 17', '2026-01-23 03:10:15'),
(84, 1, 'admin', 'Pinned Post', 'Pinned event id 17', '2026-01-23 03:10:16'),
(85, 1, 'admin', 'Pinned Post', 'Pinned event id 9', '2026-01-23 03:12:06'),
(86, 1, 'admin', 'Pinned Post', 'Pinned event id 1', '2026-01-23 03:12:11'),
(87, 1, 'admin', 'Pinned Post', 'Pinned event id 1', '2026-01-23 03:12:11'),
(88, 1, 'admin', 'Pinned Post', 'Pinned event id 9', '2026-01-23 03:12:11'),
(89, 1, 'admin', 'Pinned Post', 'Pinned event id 9', '2026-01-23 03:12:11'),
(90, 1, 'admin', 'Pinned Post', 'Unpinned event id 1', '2026-01-23 03:12:14'),
(91, 1, 'admin', 'Pinned Post', 'Pinned event id 1', '2026-01-23 03:23:36'),
(92, 1, 'admin', 'Pinned Post', 'Pinned event id 13', '2026-01-23 03:23:38'),
(93, 1, 'admin', 'Pinned Post', 'Pinned event id 4', '2026-01-23 03:23:41'),
(94, 1, 'admin', 'Pinned Post', 'Pinned event id 18', '2026-01-23 03:23:44'),
(95, 1, 'admin', 'Pinned Post', 'Pinned event id 6', '2026-01-23 03:23:46'),
(96, 1, 'admin', 'Pinned Post', 'Pinned event id 5', '2026-01-23 03:23:55'),
(97, 1, 'admin', 'Pinned Post', 'Unpinned event id 5', '2026-01-23 03:45:18'),
(98, 1, 'admin', 'Pinned Post', 'Pinned event id 5', '2026-01-23 03:45:20'),
(99, 1, 'admin', 'Pinned Post', 'Unpinned event id 5', '2026-01-23 04:01:51'),
(100, 1, 'admin', 'Pinned Post', 'Pinned event id 5', '2026-01-23 04:01:53'),
(101, 2, 'organizer', 'Event', 'Event id 1 information updated', '2026-01-24 01:27:39'),
(102, 2, 'organizer', 'Event', 'Event id 1 information updated', '2026-01-24 01:40:10'),
(103, 2, 'organizer', 'Event', 'Event id 1 information updated', '2026-01-24 01:47:04'),
(104, 2, 'organizer', 'Event', 'Event id 1 information updated', '2026-01-24 01:48:28'),
(105, 2, 'organizer', 'Event', 'Event id 1 information updated', '2026-01-24 01:48:47'),
(106, 2, 'organizer', 'Event', 'Event id 1 information updated', '2026-01-24 01:50:10'),
(107, 2, 'organizer', 'Event', 'Event id 1 information updated', '2026-01-24 01:51:02'),
(108, 2, 'organizer', 'Event', 'Event id 1 information updated', '2026-01-24 01:51:05'),
(109, 2, 'organizer', 'Event', 'Event id 1 information updated', '2026-01-24 01:51:32'),
(110, 2, 'organizer', 'Event', 'Event id 1 information updated', '2026-01-24 01:52:49'),
(111, 2, 'organizer', 'Event', 'Event id 1 information updated', '2026-01-24 01:56:42'),
(112, 2, 'organizer', 'Event', 'Event id 1 information updated', '2026-01-24 02:02:58'),
(113, 2, 'organizer', 'Event', 'Event id 27 created', '2026-01-24 02:22:35'),
(114, 2, 'organizer', 'Event', 'Event id 17 information updated', '2026-01-24 03:33:20'),
(115, 1, 'admin', 'Event', 'Event id 17 information updated', '2026-01-24 03:34:17'),
(116, 1, 'admin', 'Event', 'Event id 17 information updated', '2026-01-24 03:34:55'),
(117, 1, 'admin', 'Event', 'Event id 17 information updated', '2026-01-24 03:39:26'),
(118, 1, 'admin', 'Event', 'Event id 17 information updated', '2026-01-24 03:40:38'),
(119, 1, 'admin', 'Event', 'Event id 17 information updated', '2026-01-24 03:41:17'),
(120, 1, 'admin', 'Event', 'Event id 17 information updated', '2026-01-24 03:45:01'),
(121, 1, 'admin', 'Event', 'Event id 17 information updated', '2026-01-24 03:45:04'),
(122, 1, 'admin', 'Event', 'Event id 1 information updated', '2026-01-24 03:49:19'),
(123, 1, 'admin', 'Event', 'Event id 1 information updated', '2026-01-24 03:49:55'),
(124, 1, 'admin', 'Event', 'Event id 1 information updated', '2026-01-24 03:50:07'),
(125, 1, 'admin', 'Event', 'Event id 1 information updated', '2026-01-24 03:52:36'),
(126, 1, 'admin', 'Event', 'Event id 1 information updated', '2026-01-24 03:54:52'),
(127, 1, 'admin', 'Event', 'Event id 17 rejected by admin id 1', '2026-01-24 07:13:08'),
(128, 1, 'admin', 'Event', 'Event id 17 approved by admin id 1', '2026-01-24 07:13:10'),
(129, 1, 'admin', 'Event', 'Event id 1 information updated', '2026-01-24 11:37:35'),
(130, 2, 'organizer', 'Event', 'Event id 1 information updated', '2026-01-24 11:38:18'),
(131, 2, 'organizer', 'Event', 'Event id 17 information updated', '2026-01-24 11:42:54'),
(132, 2, 'organizer', 'Event', 'Event id 17 information updated', '2026-01-24 11:42:58'),
(133, 2, 'organizer', 'Event', 'Event id 27 deleted', '2026-01-24 11:44:27'),
(134, 3, 'student', 'Event', 'Registered for event id 13', '2026-01-24 14:45:37'),
(135, 2, 'organizer', 'Event', 'Event id 17 information updated', '2026-01-24 15:03:20'),
(136, 1, 'admin', 'Event', 'Event id 17 information updated', '2026-01-24 23:34:55'),
(137, 56, 'collaborator', 'Event', 'Event id 1 information updated', '2026-01-24 23:56:32'),
(138, 56, 'collaborator', 'Event', 'Event id 1 information updated', '2026-01-24 23:57:30'),
(139, 56, 'collaborator', 'Event', 'Event id 1 information updated', '2026-01-25 00:05:14'),
(140, 56, 'collaborator', 'Event', 'Event id 1 information updated', '2026-01-25 00:14:46'),
(141, 56, 'collaborator', 'Event', 'Event id 1 information updated', '2026-01-25 00:24:01'),
(142, 56, 'collaborator', 'Event', 'Event id 1 information updated', '2026-01-25 00:27:00'),
(143, 56, 'collaborator', 'Event', 'Event id 1 information updated', '2026-01-25 00:27:20'),
(144, 56, 'collaborator', 'Event', 'Event id 1 information updated', '2026-01-25 00:28:30'),
(145, 56, 'collaborator', 'Event', 'Event id 1 information updated', '2026-01-25 00:28:37'),
(146, 3, 'student', 'Comment', 'Commented on event id 4', '2026-01-25 09:38:55'),
(147, 3, 'student', 'Comment', 'Commented on event id 4', '2026-01-25 09:39:07'),
(148, 3, 'student', 'Comment', 'Commented on event id 6', '2026-01-25 16:25:12'),
(149, 2, 'organizer', 'Event', 'Event id 23 poster updated', '2026-01-25 22:42:16'),
(150, 2, 'organizer', 'Event', 'Event id 23 poster updated', '2026-01-25 22:42:31'),
(151, 2, 'organizer', 'Participant', 'Rejected participant id 15 for event id 4', '2026-01-26 00:04:29'),
(152, 2, 'organizer', 'Participant', 'Approved participant id 15 for event id 4', '2026-01-26 00:04:31'),
(153, 2, 'organizer', 'Participant', 'Rejected participant id 15 for event id 4', '2026-01-26 01:15:05'),
(154, 2, 'organizer', 'Participant', 'Approved participant id 15 for event id 4', '2026-01-26 01:15:08'),
(155, 3, 'student', 'Comment', 'Commented on event id 6', '2026-01-26 16:15:37'),
(156, 3, 'student', 'Comment', 'Commented on event id 17', '2026-01-26 16:15:51'),
(157, 2, 'organizer', 'Participant', 'Rejected participant id 16 for event id 9', '2026-01-26 23:43:15'),
(158, 2, 'organizer', 'Participant', 'Approved participant id 16 for event id 9', '2026-01-26 23:43:23'),
(159, 2, 'organizer', 'Participant', 'Approved participant id 16 for event id 9', '2026-01-26 23:43:23'),
(160, 2, 'organizer', 'Participant', 'Approved participant id 16 for event id 9', '2026-01-26 23:43:23'),
(161, 2, 'organizer', 'Participant', 'Rejected participant id 16 for event id 9', '2026-01-26 23:43:31'),
(162, 2, 'organizer', 'Participant', 'Approved participant id 16 for event id 9', '2026-01-26 23:43:38'),
(163, 3, 'student', 'Event', 'Registered for event id 9', '2026-01-28 11:25:57'),
(164, 3, 'student', 'Event', 'Registered for event id 1', '2026-01-28 14:21:16'),
(165, 2, 'organizer', 'Participant', 'Approved participant id 19 for event id 9', '2026-01-28 14:39:33'),
(166, 2, 'organizer', 'Participant', 'Rejected participant id 19 for event id 9', '2026-01-28 14:39:47'),
(167, 3, 'student', 'Comment', 'Commented on event id 13', '2026-01-28 14:40:50'),
(168, 3, 'student', 'Comment', 'Commented on event id 13', '2026-01-28 14:41:12'),
(169, 2, 'organizer', 'Participant', 'Approved participant id 19 for event id 9', '2026-01-28 14:54:55'),
(170, 1, 'admin', 'Pinned Post', 'Unpinned event id 9', '2026-01-28 20:13:10'),
(171, 1, 'admin', 'Pinned Post', 'Unpinned event id 1', '2026-01-28 20:13:16'),
(172, 1, 'admin', 'Pinned Post', 'Unpinned event id 5', '2026-01-28 20:13:21'),
(173, 1, 'admin', 'Pinned Post', 'Unpinned event id 18', '2026-01-28 20:13:25'),
(174, 1, 'admin', 'Pinned Post', 'Pinned event id 5', '2026-01-28 20:13:29'),
(175, 1, 'admin', 'Pinned Post', 'Pinned event id 18', '2026-01-28 20:21:46'),
(176, 1, 'admin', 'Pinned Post', 'Pinned event id 1', '2026-01-28 21:14:08'),
(177, 1, 'admin', 'Pinned Post', 'Unpinned event id 5', '2026-01-28 21:20:28'),
(178, 1, 'admin', 'Pinned Post', 'Unpinned event id 13', '2026-01-28 21:20:30'),
(179, 1, 'admin', 'Pinned Post', 'Pinned event id 5', '2026-01-28 21:20:34'),
(180, 3, 'student', 'Comment', 'Commented on event id 1', '2026-01-29 15:52:01'),
(181, 3, 'student', 'Comment', 'Commented on event id 1', '2026-01-29 15:52:13'),
(182, 3, 'student', 'Comment', 'Commented on event id 1', '2026-01-29 15:52:46'),
(183, 3, 'student', 'Comment', 'Commented on event id 1', '2026-01-29 15:52:56'),
(184, 3, 'student', 'Comment', 'Commented on event id 1', '2026-01-29 15:53:12'),
(185, 3, 'student', 'Event', 'Registered for event id 17', '2026-01-29 15:56:41'),
(186, 86, 'student', 'Event', 'Registered for event id 1', '2026-01-30 01:26:11'),
(187, 89, 'student', 'Event', 'Registered for event id 1', '2026-01-30 01:28:12'),
(188, 1, 'admin', 'Event', 'Event id 17 information updated', '2026-01-30 02:07:54'),
(189, 3, 'student', 'Event', 'Cancelled registration for event id 17', '2026-01-30 02:08:06'),
(190, 3, 'student', 'Event', 'Registered for event id 17', '2026-01-30 02:08:56'),
(191, 3, 'student', 'Event', 'Cancelled registration for event id 17', '2026-01-30 02:09:03'),
(192, 3, 'student', 'Event', 'Registered for event id 17', '2026-01-30 02:23:03'),
(193, 3, 'student', 'Event', 'Cancelled registration for event id 17', '2026-01-30 02:26:17'),
(194, 3, 'student', 'Comment', 'Commented on event id 1', '2026-01-30 02:48:18'),
(195, 1, 'admin', 'Pinned Post', 'Unpinned event id 4', '2026-01-30 02:52:28'),
(196, 1, 'admin', 'Pinned Post', 'Unpinned event id 1', '2026-01-30 02:52:33'),
(197, 1, 'admin', 'Pinned Post', 'Pinned event id 1', '2026-01-30 02:53:27'),
(198, 1, 'admin', 'Pinned Post', 'Pinned event id 4', '2026-01-30 02:53:32'),
(199, 2, 'organizer', 'Event', 'Event id 1 information updated', '2026-01-30 03:06:15'),
(200, 2, 'organizer', 'Event', 'Event id 1 information updated', '2026-01-30 03:06:24'),
(201, 2, 'organizer', 'Participant', 'Rejected participant id 15 for event id 4', '2026-01-30 03:07:53'),
(202, 3, 'student', 'Event', 'Registered for event id 17', '2026-01-30 03:10:12'),
(203, 2, 'organizer', 'Participant', 'Approved participant id 26 for event id 17', '2026-01-30 03:11:37'),
(204, 3, 'student', 'Event', 'Registered for event id 9', '2026-01-30 16:01:48'),
(205, 1, 'admin', 'Participant', 'Approved participant id 27 for event id 9', '2026-01-30 16:21:19'),
(206, 1, 'admin', 'Club', 'Club id 5 created: testclub ', '2026-01-30 17:31:54'),
(207, 1, 'admin', 'Club', 'Club id 6 created: testing 2', '2026-01-30 17:42:32'),
(208, 1, 'admin', 'Club', 'Club id 7 created: testtest123', '2026-01-31 14:50:51'),
(209, 3, 'student', 'Event', 'Cancelled registration for event id 17', '2026-02-04 03:23:08'),
(210, 1, 'admin', 'Event', 'Event id 17 information updated', '2026-02-04 03:55:55'),
(211, 1, 'admin', 'Event', 'Event id 17 information updated', '2026-02-04 03:56:25'),
(212, 1, 'admin', 'Event', 'Event id 20 approved by admin id 1', '2026-02-06 11:04:39'),
(213, 1, 'admin', 'Event', 'Event id 20 information updated', '2026-02-12 18:48:32');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `type` enum('system','general','event','reward') NOT NULL,
  `title` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `link_event_id` bigint(20) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `link_event_id`, `is_read`, `created_at`) VALUES
(1, 3, 'event', 'Registration Submitted', 'You have requested to register for Testing. Waiting for approval.', 4, 1, '2026-01-11 12:48:44'),
(2, 3, 'event', 'Registration Cancelled', 'You have cancelled your registration for Testing.', 4, 1, '2026-01-11 12:52:16'),
(3, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting on an event!', 4, 1, '2026-01-11 13:18:25'),
(4, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting on an event!', 4, 1, '2026-01-11 13:21:25'),
(5, 3, 'event', 'Registration Submitted', 'You have requested to register for Testing. Waiting for approval.', 4, 1, '2026-01-11 13:37:18'),
(6, 3, 'event', 'Registration Cancelled', 'You have cancelled your registration for Testing.', 4, 1, '2026-01-11 14:23:02'),
(7, 3, 'event', 'Registration Submitted', 'You have requested to register for Testing. Waiting for approval.', 4, 1, '2026-01-11 14:31:34'),
(8, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting on an event!', 4, 1, '2026-01-11 15:53:41'),
(9, 3, 'event', 'Registration Cancelled', 'You have cancelled your registration for Beach Clean Up.', 1, 1, '2026-01-12 10:23:46'),
(10, 3, 'event', 'Registration Submitted', 'You have requested to register for Beach Clean Up. Waiting for approval.', 1, 1, '2026-01-12 10:23:56'),
(11, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting on an event!', 4, 1, '2026-01-13 05:33:42'),
(12, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting on an event!', 4, 1, '2026-01-16 09:45:16'),
(13, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting on an event!', 4, 1, '2026-01-18 15:19:54'),
(14, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting on an event!', 1, 1, '2026-01-19 10:51:21'),
(15, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting on an event!', 1, 1, '2026-01-19 10:51:28'),
(16, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting on an event!', 1, 1, '2026-01-20 20:42:50'),
(17, 3, 'event', 'Registration Cancelled', 'You have cancelled your registration for CAMPUS THRIFT MARKET.', 4, 1, '2026-01-21 02:21:25'),
(18, 3, 'event', 'Registration Submitted', 'You have requested to register for CAMPUS THRIFT MARKET. Waiting for approval.', 4, 1, '2026-01-21 02:23:11'),
(19, 3, 'event', 'Registration Approved', 'Your registration for Beach Clean Up has been approved!', 1, 1, '2026-01-22 03:28:09'),
(20, 3, 'event', 'Registration Rejected', 'Your registration for Beach Clean Up has been rejected.', 1, 1, '2026-01-22 03:28:13'),
(21, 3, 'event', 'Registration Removed', 'Your registration for Beach Clean Up has been removed.', 1, 1, '2026-01-22 04:32:49'),
(22, 3, 'event', 'Registration Cancelled', 'You have cancelled your registration for CAMPUS THRIFT MARKET.', 4, 1, '2026-01-22 14:40:17'),
(23, 3, 'event', 'Registration Submitted', 'You have requested to register for CAMPUS THRIFT MARKET. Waiting for approval.', 4, 1, '2026-01-22 14:40:36'),
(24, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting!', 4, 1, '2026-01-22 14:40:43'),
(25, 3, 'event', 'Registration Approved', 'Your registration for CAMPUS THRIFT MARKET has been approved!', 4, 1, '2026-01-22 14:42:37'),
(26, 3, 'event', 'Registration Submitted', 'You have requested to register for World Environment Day: Paws & Plants. Waiting for approval.', 9, 1, '2026-01-23 00:06:26'),
(27, 3, 'event', 'Registration Approved', 'Your registration for World Environment Day: Paws & Plants has been approved!', 9, 1, '2026-01-23 00:07:36'),
(28, 3, 'event', 'Registration Submitted', 'You have requested to register for River Cleanup. Waiting for approval.', 13, 1, '2026-01-24 14:45:37'),
(29, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting!', 4, 1, '2026-01-25 09:38:55'),
(30, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting!', 4, 1, '2026-01-25 09:39:07'),
(31, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting!', 6, 1, '2026-01-25 16:25:12'),
(32, 3, 'event', 'Registration Rejected', 'Your registration for CAMPUS THRIFT MARKET has been rejected.', 4, 1, '2026-01-26 00:04:29'),
(33, 3, 'event', 'Registration Approved', 'Your registration for CAMPUS THRIFT MARKET has been approved!', 4, 1, '2026-01-26 00:04:31'),
(34, 3, 'event', 'Registration Rejected', 'Your registration for CAMPUS THRIFT MARKET has been rejected.', 4, 1, '2026-01-26 01:15:05'),
(35, 3, 'event', 'Registration Approved', 'Your registration for CAMPUS THRIFT MARKET has been approved!', 4, 1, '2026-01-26 01:15:08'),
(36, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting!', 6, 1, '2026-01-26 16:15:37'),
(37, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting!', 17, 1, '2026-01-26 16:15:51'),
(38, 3, 'event', 'Registration Rejected', 'Your registration for World Environment Day: Paws & Plants has been rejected.', 9, 1, '2026-01-26 23:43:15'),
(39, 3, 'event', 'Registration Approved', 'Your registration for World Environment Day: Paws & Plants has been approved!', 9, 1, '2026-01-26 23:43:23'),
(40, 3, 'event', 'Registration Approved', 'Your registration for World Environment Day: Paws & Plants has been approved!', 9, 1, '2026-01-26 23:43:23'),
(41, 3, 'event', 'Registration Approved', 'Your registration for World Environment Day: Paws & Plants has been approved!', 9, 1, '2026-01-26 23:43:23'),
(42, 3, 'event', 'Registration Rejected', 'Your registration for World Environment Day: Paws & Plants has been rejected.', 9, 1, '2026-01-26 23:43:31'),
(43, 3, 'event', 'Registration Approved', 'Your registration for World Environment Day: Paws & Plants has been approved!', 9, 1, '2026-01-26 23:43:38'),
(44, 3, 'event', 'Registration Submitted', 'You have requested to register for World Environment Day: Paws & Plants. Waiting for approval.', 9, 1, '2026-01-28 11:25:57'),
(45, 3, 'event', 'Registration Submitted', 'You have requested to register for Beach Clean Up. Waiting for approval.', 1, 1, '2026-01-28 14:21:16'),
(46, 3, 'event', 'Registration Approved', 'Your registration for World Environment Day: Paws & Plants has been approved!', 9, 1, '2026-01-28 14:39:33'),
(47, 3, 'event', 'Registration Rejected', 'Your registration for World Environment Day: Paws & Plants has been rejected.', 9, 1, '2026-01-28 14:39:47'),
(48, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting!', 13, 1, '2026-01-28 14:40:50'),
(49, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting!', 13, 1, '2026-01-28 14:41:12'),
(50, 3, 'event', 'Registration Approved', 'Your registration for World Environment Day: Paws & Plants has been approved!', 9, 1, '2026-01-28 14:54:55'),
(51, 3, 'event', 'Announcement: test', 'lol', 9, 1, '2026-01-28 14:56:06'),
(52, 3, 'event', 'Announcement: minecraft', 'hahhaha Minecraft lol', 9, 1, '2026-01-28 15:05:57'),
(53, 3, 'event', 'Announcement: Pet Care Program', 'Our Pet Care Program offers a range of free services and educational talks to help you provide the best possible care for your pets.', 18, 1, '2026-01-28 20:21:46'),
(54, 4, 'event', 'Announcement: Pet Care Program', 'Our Pet Care Program offers a range of free services and educational talks to help you provide the best possible care for your pets.', 18, 0, '2026-01-28 20:21:46'),
(58, 3, 'event', 'Announcement: Beach Clean Up', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 1, 1, '2026-01-28 21:14:08'),
(59, 4, 'event', 'Announcement: Beach Clean Up', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 1, 0, '2026-01-28 21:14:08'),
(61, 58, 'event', 'Announcement: Beach Clean Up', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 1, 0, '2026-01-28 21:14:08'),
(62, 68, 'event', 'Announcement: Beach Clean Up', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 1, 0, '2026-01-28 21:14:08'),
(63, 69, 'event', 'Announcement: Beach Clean Up', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 1, 0, '2026-01-28 21:14:08'),
(64, 70, 'event', 'Announcement: Beach Clean Up', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 1, 0, '2026-01-28 21:14:08'),
(65, 71, 'event', 'Announcement: Beach Clean Up', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 1, 0, '2026-01-28 21:14:08'),
(66, 72, 'event', 'Announcement: Beach Clean Up', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 1, 0, '2026-01-28 21:14:08'),
(67, 73, 'event', 'Announcement: Beach Clean Up', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 1, 0, '2026-01-28 21:14:08'),
(73, 3, 'event', 'Announcement: ZERO-WASTE WORKSHOP', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 5, 1, '2026-01-28 21:20:34'),
(74, 4, 'event', 'Announcement: ZERO-WASTE WORKSHOP', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 5, 0, '2026-01-28 21:20:34'),
(76, 58, 'event', 'Announcement: ZERO-WASTE WORKSHOP', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 5, 0, '2026-01-28 21:20:34'),
(77, 68, 'event', 'Announcement: ZERO-WASTE WORKSHOP', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 5, 0, '2026-01-28 21:20:34'),
(78, 69, 'event', 'Announcement: ZERO-WASTE WORKSHOP', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 5, 0, '2026-01-28 21:20:34'),
(79, 70, 'event', 'Announcement: ZERO-WASTE WORKSHOP', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 5, 0, '2026-01-28 21:20:34'),
(80, 71, 'event', 'Announcement: ZERO-WASTE WORKSHOP', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 5, 0, '2026-01-28 21:20:34'),
(81, 72, 'event', 'Announcement: ZERO-WASTE WORKSHOP', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 5, 0, '2026-01-28 21:20:34'),
(82, 73, 'event', 'Announcement: ZERO-WASTE WORKSHOP', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 5, 0, '2026-01-28 21:20:34'),
(85, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting!', 1, 1, '2026-01-29 15:52:01'),
(86, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting!', 1, 1, '2026-01-29 15:52:13'),
(87, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting!', 1, 1, '2026-01-29 15:52:46'),
(88, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting!', 1, 1, '2026-01-29 15:52:56'),
(89, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting!', 1, 1, '2026-01-29 15:53:12'),
(90, 3, 'event', 'Registration Submitted', 'You have requested to register for Green Careers Talk. Waiting for approval.', 17, 1, '2026-01-29 15:56:41'),
(91, 86, 'event', 'Registration Submitted', 'You have requested to register for Beach Clean Up. Waiting for approval.', 1, 0, '2026-01-30 01:26:11'),
(92, 89, 'event', 'Registration Submitted', 'You have requested to register for Beach Clean Up. Waiting for approval.', 1, 0, '2026-01-30 01:28:11'),
(93, 3, 'event', 'Registration Cancelled', 'You have cancelled your registration for Green Careers Talk.', 17, 1, '2026-01-30 02:08:06'),
(94, 3, 'event', 'Registration Submitted', 'You have requested to register for Green Careers Talk. Waiting for approval.', 17, 1, '2026-01-30 02:08:56'),
(95, 3, 'event', 'Registration Cancelled', 'You have cancelled your registration for Green Careers Talk.', 17, 1, '2026-01-30 02:09:03'),
(96, 3, 'event', 'Registration Submitted', 'You have requested to register for Green Careers Talk. Waiting for approval.', 17, 1, '2026-01-30 02:23:03'),
(97, 3, 'event', 'Registration Cancelled', 'You have cancelled your registration for Green Careers Talk.', 17, 1, '2026-01-30 02:26:17'),
(98, 3, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting!', 1, 1, '2026-01-30 02:48:18'),
(99, 3, 'event', 'Announcement: Beach Clean Up', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 1, 1, '2026-01-30 02:53:27'),
(100, 4, 'event', 'Announcement: Beach Clean Up', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 1, 0, '2026-01-30 02:53:27'),
(101, 57, 'event', 'Announcement: Beach Clean Up', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 1, 0, '2026-01-30 02:53:27'),
(113, 89, 'event', 'Announcement: Beach Clean Up', 'Zero waste, infinite possibilities. Learn to minimize your footprint and lead the fusion of sustainability and daily life.', 1, 0, '2026-01-30 02:53:27'),
(114, 3, 'event', 'Announcement: CAMPUS THRIFT MARKET', 'Campus Thrift Market is a student-led marketplace where pre-loved clothes, books and accessories are bought and sold at affordable prices. It promotes sustainability, encourages reuse and brings the campus community together through eco-friendly shopping.\r\n', 4, 1, '2026-01-30 02:53:32'),
(115, 4, 'event', 'Announcement: CAMPUS THRIFT MARKET', 'Campus Thrift Market is a student-led marketplace where pre-loved clothes, books and accessories are bought and sold at affordable prices. It promotes sustainability, encourages reuse and brings the campus community together through eco-friendly shopping.\r\n', 4, 0, '2026-01-30 02:53:32'),
(116, 57, 'event', 'Announcement: CAMPUS THRIFT MARKET', 'Campus Thrift Market is a student-led marketplace where pre-loved clothes, books and accessories are bought and sold at affordable prices. It promotes sustainability, encourages reuse and brings the campus community together through eco-friendly shopping.\r\n', 4, 0, '2026-01-30 02:53:32'),
(117, 58, 'event', 'Announcement: CAMPUS THRIFT MARKET', 'Campus Thrift Market is a student-led marketplace where pre-loved clothes, books and accessories are bought and sold at affordable prices. It promotes sustainability, encourages reuse and brings the campus community together through eco-friendly shopping.\r\n', 4, 0, '2026-01-30 02:53:32'),
(118, 68, 'event', 'Announcement: CAMPUS THRIFT MARKET', 'Campus Thrift Market is a student-led marketplace where pre-loved clothes, books and accessories are bought and sold at affordable prices. It promotes sustainability, encourages reuse and brings the campus community together through eco-friendly shopping.\r\n', 4, 0, '2026-01-30 02:53:32'),
(119, 69, 'event', 'Announcement: CAMPUS THRIFT MARKET', 'Campus Thrift Market is a student-led marketplace where pre-loved clothes, books and accessories are bought and sold at affordable prices. It promotes sustainability, encourages reuse and brings the campus community together through eco-friendly shopping.\r\n', 4, 0, '2026-01-30 02:53:32'),
(120, 70, 'event', 'Announcement: CAMPUS THRIFT MARKET', 'Campus Thrift Market is a student-led marketplace where pre-loved clothes, books and accessories are bought and sold at affordable prices. It promotes sustainability, encourages reuse and brings the campus community together through eco-friendly shopping.\r\n', 4, 0, '2026-01-30 02:53:32'),
(121, 71, 'event', 'Announcement: CAMPUS THRIFT MARKET', 'Campus Thrift Market is a student-led marketplace where pre-loved clothes, books and accessories are bought and sold at affordable prices. It promotes sustainability, encourages reuse and brings the campus community together through eco-friendly shopping.\r\n', 4, 0, '2026-01-30 02:53:32'),
(122, 72, 'event', 'Announcement: CAMPUS THRIFT MARKET', 'Campus Thrift Market is a student-led marketplace where pre-loved clothes, books and accessories are bought and sold at affordable prices. It promotes sustainability, encourages reuse and brings the campus community together through eco-friendly shopping.\r\n', 4, 0, '2026-01-30 02:53:32'),
(123, 73, 'event', 'Announcement: CAMPUS THRIFT MARKET', 'Campus Thrift Market is a student-led marketplace where pre-loved clothes, books and accessories are bought and sold at affordable prices. It promotes sustainability, encourages reuse and brings the campus community together through eco-friendly shopping.\r\n', 4, 0, '2026-01-30 02:53:32'),
(124, 79, 'event', 'Announcement: CAMPUS THRIFT MARKET', 'Campus Thrift Market is a student-led marketplace where pre-loved clothes, books and accessories are bought and sold at affordable prices. It promotes sustainability, encourages reuse and brings the campus community together through eco-friendly shopping.\r\n', 4, 0, '2026-01-30 02:53:32'),
(125, 80, 'event', 'Announcement: CAMPUS THRIFT MARKET', 'Campus Thrift Market is a student-led marketplace where pre-loved clothes, books and accessories are bought and sold at affordable prices. It promotes sustainability, encourages reuse and brings the campus community together through eco-friendly shopping.\r\n', 4, 0, '2026-01-30 02:53:32'),
(126, 83, 'event', 'Announcement: CAMPUS THRIFT MARKET', 'Campus Thrift Market is a student-led marketplace where pre-loved clothes, books and accessories are bought and sold at affordable prices. It promotes sustainability, encourages reuse and brings the campus community together through eco-friendly shopping.\r\n', 4, 0, '2026-01-30 02:53:32'),
(127, 86, 'event', 'Announcement: CAMPUS THRIFT MARKET', 'Campus Thrift Market is a student-led marketplace where pre-loved clothes, books and accessories are bought and sold at affordable prices. It promotes sustainability, encourages reuse and brings the campus community together through eco-friendly shopping.\r\n', 4, 0, '2026-01-30 02:53:32'),
(128, 89, 'event', 'Announcement: CAMPUS THRIFT MARKET', 'Campus Thrift Market is a student-led marketplace where pre-loved clothes, books and accessories are bought and sold at affordable prices. It promotes sustainability, encourages reuse and brings the campus community together through eco-friendly shopping.\r\n', 4, 0, '2026-01-30 02:53:32'),
(129, 3, 'event', 'Registration Rejected', 'Your registration for CAMPUS THRIFT MARKET has been rejected.', 4, 1, '2026-01-30 03:07:53'),
(130, 3, 'event', 'Registration Submitted', 'You have requested to register for Green Careers Talk. Waiting for approval.', 17, 1, '2026-01-30 03:10:12'),
(131, 3, 'event', 'Registration Approved', 'Your registration for Green Careers Talk has been approved!', 17, 1, '2026-01-30 03:11:37'),
(132, 3, 'event', 'Registration Submitted', 'You have requested to register for World Environment Day: Paws & Plants. Waiting for approval.', 9, 1, '2026-01-30 16:01:48'),
(133, 3, 'event', 'Registration Approved', 'Your registration for World Environment Day: Paws & Plants has been approved!', 9, 1, '2026-01-30 16:21:19'),
(134, 3, 'event', 'Announcement: Test 123', 'test test 123', 9, 1, '2026-01-31 14:35:37'),
(135, 3, 'event', 'Registration Cancelled', 'You have cancelled your registration for Green Careers Talk.', 17, 1, '2026-02-04 03:23:08');

-- --------------------------------------------------------

--
-- Table structure for table `organizers`
--

CREATE TABLE `organizers` (
  `user_id` bigint(20) NOT NULL,
  `club_id` bigint(20) NOT NULL,
  `positions` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organizers`
--

INSERT INTO `organizers` (`user_id`, `club_id`, `positions`) VALUES
(2, 1, 'President'),
(81, 2, 'Technology Kia'),
(87, 1, 'Club Leader');

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` bigint(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `image_path` varchar(100) NOT NULL,
  `cost` int(10) NOT NULL,
  `description` text NOT NULL,
  `quantity` int(10) NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_by` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id`, `title`, `image_path`, `cost`, `description`, `quantity`, `is_active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Limited Edition 2026 APU Hoodie', '1.png', 2500, '100% organic cotton with our signature logo. Available in sizes S, M and L.', 18, 1, 1, '2026-01-23 08:13:57', NULL, NULL),
(2, '1-Month Campus Parking Permit', '2.png', 3000, 'Free parking in any student-designated zone for 30 days.', 19, 1, 1, '2026-01-24 09:48:21', NULL, NULL),
(3, 'RM10 APCard Reload', '3.png', 1000, 'Instant RM10 reload for your APCard.', 49, 1, 1, '2026-01-24 11:08:03', NULL, '2026-01-24 11:05:25'),
(4, 'Eco-Friendly Canvas Tote Bag', '4.png', 500, 'Ditch single-use plastic bags for good! This durable, 100% natural cotton canvas tote is perfect for carrying your laptop, textbooks and groceries. Promote SDG 12 (Responsible Consumption) while looking stylish on campus.', 94, 1, 1, '2026-01-24 13:13:13', NULL, '2026-01-24 13:09:14');

-- --------------------------------------------------------

--
-- Table structure for table `reward_redemptions`
--

CREATE TABLE `reward_redemptions` (
  `id` bigint(20) NOT NULL,
  `reward_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `ap_coins_spent` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `notes` text,
  `redeemed_at` datetime NOT NULL,
  `fulfilled_by` bigint(20) DEFAULT NULL,
  `fulfilled_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reward_redemptions`
--

INSERT INTO `reward_redemptions` (`id`, `reward_id`, `user_id`, `ap_coins_spent`, `status`, `notes`, `redeemed_at`, `fulfilled_by`, `fulfilled_at`) VALUES
(1, 1, 3, 2500, 'redeemed', NULL, '2026-01-24 14:42:59', NULL, NULL),
(2, 3, 3, 1000, 'redeemed', NULL, '2026-01-25 10:39:25', NULL, NULL),
(3, 4, 3, 500, 'redeemed', NULL, '2026-01-25 10:39:29', NULL, NULL),
(9, 4, 3, 500, 'redeemed', NULL, '2026-01-27 18:03:48', NULL, NULL),
(10, 4, 3, 500, 'pending', NULL, '2026-01-27 18:03:54', NULL, NULL),
(11, 4, 3, 500, 'pending', NULL, '2026-01-30 22:22:06', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `user_id` bigint(20) NOT NULL,
  `course` varchar(100) NOT NULL,
  `graduation` year(4) NOT NULL,
  `ap_coins` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`user_id`, `course`, `graduation`, `ap_coins`) VALUES
(3, 'ICT(SE)', 2026, 8165),
(4, '321', 2026, 0),
(86, 'Software Engineering', 2028, 0),
(89, 'Cyber Security', 2030, 25),
(90, 'Computer Science', 2027, 0),
(93, 'Cs', 2027, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `apkey` varchar(15) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `avatar_path` varchar(250) DEFAULT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `security_quest1` varchar(100) NOT NULL,
  `security_quest2` varchar(100) NOT NULL,
  `security_quest3` varchar(100) NOT NULL,
  `security_ans1` varchar(100) NOT NULL,
  `security_ans2` varchar(100) NOT NULL,
  `security_ans3` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `apkey`, `password`, `role`, `first_name`, `last_name`, `avatar_path`, `dob`, `gender`, `phone_no`, `security_quest1`, `security_quest2`, `security_quest3`, `security_ans1`, `security_ans2`, `security_ans3`, `created_at`, `updated_at`, `last_login`) VALUES
(1, 'TP000001', '$2y$10$j0LvBe4oKXx2DPPw7ELSWu5D2QaP8KjKWfHINEZOQekDMnzNgDi3q', 'admin', 'Admin', 'Admin', '1.png', '2026-01-02', 'Male', '011-17382732', 'What is your mother\'s maiden name?', 'What is your favorite colour?', 'What is your first pet\'s name?', 'Lew', 'Purple', 'John', '2026-01-06 11:19:58', NULL, '2026-02-15 05:56:10'),
(2, 'TP123456', '$2y$10$1LqB10mitAfxSjHYJFN4S./5PnDHKFdCo2v3/Rewp8kmg7Gwn1vPu', 'organizer', 'Organizer', 'Organizer', '2.png', '2006-06-01', 'Male', '012-3456789', 'What is your mother\'s maiden name?', 'What is your favorite colour?', 'What is your first pet\'s name?', 'default', 'blue', 'cat', '2026-01-06 05:27:40', NULL, '2026-02-15 04:45:57'),
(3, 'TP083872', '$2y$10$8/cfdXi1YXyIlDdNy30cNuc9j2z0NFj/cY7PI.v3hXL9XAVorYGmy', 'student', 'Lay Bin', 'Khoo', '3.png', '2006-08-11', 'Male', '011-17382732', '', '', '', 'Lew', 'Purple', 'John', '2026-01-06 05:20:51', NULL, '2026-02-15 09:26:09'),
(4, 'TP083321', '$2y$10$BusqNkUStW6doha28bhuveL0XS23k/d2mynk4LpUXNVd554twWx02', 'student', 'Ray Han', 'Chong', '4.png', '2026-01-17', 'Male', '3213', 'Where did you fly for your first airplane trip?', 'What is your first pet\'s name?', 'What is your favorite colour?', 'das', 'dsa', 'dsa', '2026-01-07 15:58:48', NULL, NULL),
(56, 'TP000003', '$2y$10$SvW5cadVRI8.IUafD.DF9O4HG9I4ud8FuEZ05SiV.QQW8GSOhyvC2', 'collaborator', 'Collaborator', 'Collaborator', '56.jpg', '2022-06-08', 'Male', '012-3456789', 'What is your favorite color?', 'What is your pet\'s name?', 'What city were you born in?', 'Orange', 'BaoBao', 'Ocean', '2026-01-09 04:15:26', NULL, '2026-02-15 08:06:55'),
(86, 'TP083711', '$2y$10$Ctdahwkap/Jn5d9nnYJy7uAqoSgiO5HnMDQ0HDjA82hgATMvYkd9y', 'student', 'Chong', 'Jun Yoong', '86.jpeg', '2006-12-30', 'Male', '011-1234561', 'What is your mother\'s maiden name?', 'What is your favorite colour?', 'Who was your childhood hero?', 'alice', 'black', 'superman', '2026-01-29 16:29:28', NULL, '2026-01-30 01:24:08'),
(87, 'TP083901', '$2y$10$x8iqzmqMPj3.xL7TsBJwHeUfxX7YuO/dOWkBJjUxXQAt3tcpftbjK', 'organizer', 'Kiew', 'Kin Kin', '87.png', '2006-07-28', 'Male', '011-31231266', 'What is your favorite colour?', 'Who was your childhood hero?', 'Where did you fly for your first airplane trip?', 'white', 'batman', 'China', '2026-01-29 17:14:48', NULL, NULL),
(88, 'TP0319021', '$2y$10$X/IJgqKhsL9u0HN5FhQBIu38zOEYmjm4ZZjrDbYoN8iU/dhiK01zy', 'collaborator', 'Hong Jun', 'Chen', '88.png', '2006-05-25', 'Male', '013-80123145', 'What is your Hometown\'s name?', 'What was the model of your first car?', 'What is your first pet\'s name?', 'KL', 'Honda', 'boyboy', '2026-01-29 17:17:10', NULL, NULL),
(89, 'TP083781', '$2y$10$DFGqr5dH/TalxuyIGN1XR.HyPmBJTmiDai9psie0SKnIQG6iL5CNO', 'student', 'Jing Xiang', 'Lim', '89.jpeg', '2026-01-21', 'Male', '012-849123123', 'What is your first pet\'s name?', 'Where did you fly for your first airplane trip?', 'Who was your childhood hero?', 'Meow', 'Taiwan', 'Iron man', '2026-01-29 17:20:16', NULL, '2026-01-30 01:27:54'),
(90, 'TP087874', '$2y$10$oVVlNA5Db.CWracPFJcm7.wL9FWjNcnfZVsAzFdzVOMfOKHH5TljS', 'student', 'Xiao Ming', 'Chong ', '90.png', '2026-01-22', 'Male', '011294444', 'Where did you fly for your first airplane trip?', 'Who was your childhood hero?', 'What is your mother\'s maiden name?', 'dsad', 'dsa', 'dsa', '2026-01-31 12:48:31', NULL, NULL),
(93, 'TP875595', '$2y$10$U9E80y.el3fNfAFuI9nowenI0qpWEHljJWBTPRyyCvcCxRxtiYFgq', 'student', 'Miku', 'Chong', '93.jpg', '2026-12-31', 'Female', '01157902833', 'What is your mother\'s maiden name?', 'What is your favorite colour?', 'What was the model of your first car?', '1', '2', '3', '2026-01-31 13:30:46', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `target_event_id` (`target_event_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `attendance_codes`
--
ALTER TABLE `attendance_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `generated_by` (`generated_by`);

--
-- Indexes for table `certificate`
--
ALTER TABLE `certificate`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collaborators`
--
ALTER TABLE `collaborators`
  ADD PRIMARY KEY (`user_id`,`event_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `event_participants`
--
ALTER TABLE `event_participants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_event_user` (`event_id`,`user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `marked_by` (`marked_by`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `link_event_id` (`link_event_id`);

--
-- Indexes for table `organizers`
--
ALTER TABLE `organizers`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `club_id` (`club_id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `reward_redemptions`
--
ALTER TABLE `reward_redemptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reward_id` (`reward_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fulfilled_by` (`fulfilled_by`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `attendance_codes`
--
ALTER TABLE `attendance_codes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `event_participants`
--
ALTER TABLE `event_participants`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reward_redemptions`
--
ALTER TABLE `reward_redemptions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `certificate`
--
ALTER TABLE `certificate`
  ADD CONSTRAINT `certificate_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
