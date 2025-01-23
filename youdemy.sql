  -- phpMyAdmin SQL Dump
  -- version 5.2.1
  -- https://www.phpmyadmin.net/
  --
  -- Host: localhost
  -- Generation Time: Jan 19, 2025 at 04:12 PM
  -- Server version: 10.4.28-MariaDB
  -- PHP Version: 8.0.28

  SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
  START TRANSACTION;
  SET time_zone = "+00:00";


  /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
  /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
  /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
  /*!40101 SET NAMES utf8mb4 */;

  --
  -- Database: `youdemy`
  --

  -- --------------------------------------------------------

  --
  -- Table structure for table `Categories`
  --

  CREATE TABLE `Categories` (
    `category_id` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `description` text DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Dumping data for table `Categories`
  --

  INSERT INTO `Categories` (`category_id`, `name`, `description`, `created_at`) VALUES
  (1, 'Web Devlopement', NULL, '2025-01-15 09:51:48'),
  (3, 'Artificial Intelligence', NULL, '2025-01-15 10:01:46'),
  (4, 'Networking', NULL, '2025-01-15 10:09:57'),
  (12, 'Backend', NULL, '2025-01-19 00:27:30'),
  (13, 'Object Oriented Programming', NULL, '2025-01-19 00:27:49'),
  (14, 'Digital Marketing', NULL, '2025-01-19 10:27:25'),
  (15, 'Government', NULL, '2025-01-19 10:28:55'),
  (16, 'Entrepreneurship', NULL, '2025-01-19 13:17:45');

  -- --------------------------------------------------------

  --
  -- Table structure for table `certifications`
  --

  CREATE TABLE `certifications` (
    `certification_id` int(11) NOT NULL,
    `student_id` int(11) NOT NULL,
    `course_id` int(11) NOT NULL,
    `completion_date` date DEFAULT curdate()
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Dumping data for table `certifications`
  --

  INSERT INTO `certifications` (`certification_id`, `student_id`, `course_id`, `completion_date`) VALUES
  (1, 1, 105, '2025-01-19');

  -- --------------------------------------------------------

  --
  -- Table structure for table `courses`
  --

  CREATE TABLE `courses` (
    `course_id` int(11) NOT NULL,
    `title` varchar(255) NOT NULL,
    `description` text DEFAULT NULL,
    `teacher_id` int(11) NOT NULL,
    `category_id` int(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `featured_image` varchar(255) DEFAULT NULL,
    `scheduled_date` datetime DEFAULT NULL,
    `contenu` enum('video','document') DEFAULT NULL,
    `video_url` varchar(255) DEFAULT NULL,
    `document_content` text DEFAULT '',
    `status` enum('pending','active') NOT NULL DEFAULT 'pending'
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Dumping data for table `courses`
  --

  INSERT INTO `courses` (`course_id`, `title`, `description`, `teacher_id`, `category_id`, `created_at`, `updated_at`, `featured_image`, `scheduled_date`, `contenu`, `video_url`, `document_content`, `status`) VALUES
  (105, 'Google Digital Marketing & E-commerce ', '\r\nLearn the fundamentals of digital marketing and e-commerce to gain the skills needed to land an entry-level job\r\n\r\nAttract and engage customers through digital marketing channels like search and email\r\n\r\nMeasure marketing performance through analytics and present insights\r\n\r\nBuild e-commerce stores, analyze online performance, and grow customer loyalty\r\n\r\n\r\nPrepare for a new career in the high-growth fields of digital marketing and e-commerce, in under six months, no experience or degree required. Businesses need digital marketing and e-commerce talent more than ever before; \r\n86% of business leaders \r\nreport that digital commerce will be the most important route to growth. There are over 213,000 open jobs in digital marketing and e-commerce with a median entry-level salary of $59,000.¹\r\n\r\nThroughout this program, you will gain in-demand skills that prepare you for an entry-level job and learn how to use tools and platforms like Canva, Constant Contact, Google Ads, Google Analytics, Hootsuite, HubSpot, Mailchimp, Shopify, and Twitter. You will learn from subject-matter experts at Google and have a chance to build your own portfolio with projects like customer personas and social media calendars to show to potential employers.\r\n', 23, 14, '2025-01-19 10:40:54', '2025-01-19 10:41:01', 'digital.jpeg', '2025-01-19 00:00:00', 'video', 'https://www.youtube.com/watch?v=wRZ3qWHYWZg', '', 'active');

  -- --------------------------------------------------------

  --
  -- Table structure for table `course_tags`
  --

  CREATE TABLE `course_tags` (
    `course_id` int(11) NOT NULL,
    `tag_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  -- --------------------------------------------------------

  --
  -- Table structure for table `Enrollments`
  --

  CREATE TABLE `Enrollments` (
    `enrollment_id` int(11) NOT NULL,
    `student_id` int(11) NOT NULL,
    `course_id` int(11) NOT NULL,
    `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `progress` enum('not_started','in_progress','completed') DEFAULT 'not_started'
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Dumping data for table `Enrollments`
  --

  INSERT INTO `Enrollments` (`enrollment_id`, `student_id`, `course_id`, `enrolled_at`, `progress`) VALUES
  (5, 1, 105, '2025-01-19 13:11:48', 'completed');

  -- --------------------------------------------------------

  --
  -- Table structure for table `Tags`
  --

  CREATE TABLE `Tags` (
    `tag_id` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Dumping data for table `Tags`
  --

  INSERT INTO `Tags` (`tag_id`, `name`, `created_at`) VALUES
  (1, 'Html&Css', '2025-01-15 11:33:48'),
  (2, 'Javascript', '2025-01-15 11:39:03'),
  (5, 'Python', '2025-01-16 08:04:20'),
  (6, 'PHP', '2025-01-19 00:27:34'),
  (7, 'OOP', '2025-01-19 00:27:37'),
  (8, 'Social sciences', '2025-01-19 10:29:03'),
  (9, 'starting business', '2025-01-19 13:18:08');

  -- --------------------------------------------------------

  --
  -- Table structure for table `Users`
  --

  CREATE TABLE `Users` (
    `user_id` int(11) NOT NULL,
    `username` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password_hash` varchar(255) NOT NULL,
    `role` enum('student','teacher','admin') NOT NULL,
    `status` enum('active','suspended','pending','banned') DEFAULT 'active',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `profile_picture_url` varchar(255) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Dumping data for table `Users`
  --

  INSERT INTO `Users` (`user_id`, `username`, `email`, `password_hash`, `role`, `status`, `created_at`, `updated_at`, `profile_picture_url`) VALUES
  (1, 'Rayan', 'rayan@gmail.com', '$2y$10$YDN8tf2BaenvIFzuee0rF.Nbdgyio/tV17U48YaREQoIEbObt6x1q', 'student', 'active', '2025-01-16 15:06:02', '2025-01-17 09:48:16', NULL),
  (7, 'ayman', 'ayman@gmail.com', '$2y$10$RpX5ZOuBS3fZJO.bV4NDtu1I12aj8MDVN3jGi.ynsoHwsboUhF.OK', 'student', 'active', '2025-01-16 17:42:07', '2025-01-16 17:54:20', NULL),
  (13, 'Rayan Elguerdaoui', 'kudo@gmail.com', '$2y$10$2NVs58IpNu2e9KcE5lo2WeRqHgKM3LW8Ws.DENVQKtyrJ0S4pRq/K', 'teacher', 'active', '2025-01-17 10:22:49', '2025-01-19 00:30:00', '../uploads/kudo.JPG'),
  (22, 'ahmad', 'ahmad@gmail.com', '$2y$10$ttuGpORCZWKiliwgNJiP4O0cBC9Iy1ZjkfWlJUCAXJ4XHi/erPTkm', 'teacher', 'active', '2025-01-19 00:25:06', '2025-01-19 00:25:32', 'udemy.png'),
  (23, 'Salma Derk', 'salmaderk@gmail.com', '$2y$10$t4B5M1kohszKBq0UYmRzWO8XwB.G/RYnQBEbhLRIndMpi/2P1AlzS', 'teacher', 'active', '2025-01-19 10:39:39', '2025-01-19 10:39:53', 'sd.jpg');

  --
  -- Indexes for dumped tables
  --

  --
  -- Indexes for table `Categories`
  --
  ALTER TABLE `Categories`
    ADD PRIMARY KEY (`category_id`);

  --
  -- Indexes for table `certifications`
  --
  ALTER TABLE `certifications`
    ADD PRIMARY KEY (`certification_id`),
    ADD KEY `student_id` (`student_id`),
    ADD KEY `course_id` (`course_id`);

  --
  -- Indexes for table `courses`
  --
  ALTER TABLE `courses`
    ADD PRIMARY KEY (`course_id`),
    ADD KEY `teacher_id` (`teacher_id`),
    ADD KEY `category_id` (`category_id`);

  --
  -- Indexes for table `course_tags`
  --
  ALTER TABLE `course_tags`
    ADD PRIMARY KEY (`course_id`,`tag_id`),
    ADD KEY `tag_id` (`tag_id`);

  --
  -- Indexes for table `Enrollments`
  --
  ALTER TABLE `Enrollments`
    ADD PRIMARY KEY (`enrollment_id`) ON DELETE CASCADE,
    ADD UNIQUE KEY `student_id` (`student_id`,`course_id`),
    ADD KEY `course_id` (`course_id`);

  --
  -- Indexes for table `Tags`
  --
  ALTER TABLE `Tags`
    ADD PRIMARY KEY (`tag_id`),
    ADD UNIQUE KEY `name` (`name`);

  --
  -- Indexes for table `Users`
  --
  ALTER TABLE `Users`
    ADD PRIMARY KEY (`user_id`),
    ADD UNIQUE KEY `email` (`email`);

  --
  -- AUTO_INCREMENT for dumped tables
  --

  --
  -- AUTO_INCREMENT for table `Categories`
  --
  ALTER TABLE `Categories`
    MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

  --
  -- AUTO_INCREMENT for table `certifications`
  --
  ALTER TABLE `certifications`
    MODIFY `certification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

  --
  -- AUTO_INCREMENT for table `courses`
  --
  ALTER TABLE `courses`
    MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

  --
  -- AUTO_INCREMENT for table `Enrollments`
  --
  ALTER TABLE `Enrollments`
    MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

  --
  -- AUTO_INCREMENT for table `Tags`
  --
  ALTER TABLE `Tags`
    MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

  --
  -- AUTO_INCREMENT for table `Users`
  --
  ALTER TABLE `Users`
    MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

  --
  -- Constraints for dumped tables
  --

  --
  -- Constraints for table `certifications`
  --
  ALTER TABLE `certifications`
    ADD CONSTRAINT `certifications_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
    ADD CONSTRAINT `certifications_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

  --
  -- Constraints for table `courses`
  --
  ALTER TABLE `courses`
    ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `Users` (`user_id`),
    ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `Categories` (`category_id`);

  --
  -- Constraints for table `course_tags`
  --
  ALTER TABLE `course_tags`
    ADD CONSTRAINT `course_tags_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE,
    ADD CONSTRAINT `course_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE;

  --
  -- Constraints for table `Enrollments`
  --
  ALTER TABLE `Enrollments`
    ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `Users` (`user_id`),
    ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `Courses` (`course_id`);
  COMMIT;

  /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
  /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
  /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
