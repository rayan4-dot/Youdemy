-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 31, 2025 at 06:14 PM
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Categories`
--

INSERT INTO `Categories` (`category_id`, `name`, `created_at`) VALUES
(1, 'Web Devlopement', '2025-01-15 09:51:48'),
(3, 'Artificial Intelligence', '2025-01-15 10:01:46'),
(4, 'Networking', '2025-01-15 10:09:57'),
(13, 'Object Oriented Programming', '2025-01-19 00:27:49'),
(14, 'Digital Marketing', '2025-01-19 10:27:25'),
(16, 'Entrepreneurship', '2025-01-19 13:17:45');

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
(127, 'Web Development Basics: HTML, CSS & JavaScript for Beginners', 'Unlock the power of web development by mastering the three core technologies that power the web: HTML, CSS, and JavaScript. Whether you’re a complete beginner or looking to refine your skills, this hands-on course will take you through building your very own website, from scratch, using these essential web technologies.', 13, 1, '2025-01-22 15:42:44', '2025-01-31 16:42:02', NULL, NULL, 'video', 'https://www.youtube.com/embed/4FsbTgftmCk', 'enjoy this stuf', 'active'),
(129, 'Data science', 'Dive into the world of data science with this comprehensive course, designed to take you from beginner to expert in one of today’s most in-demand fields. Data science combines programming, statistics, and domain knowledge to extract valuable insights from data. Whether you want to analyze customer data, build predictive models, or automate decision-making, this course covers everything you need to know.', 26, 3, '2025-01-23 09:17:25', '2025-01-31 16:41:35', NULL, NULL, 'video', 'https://www.youtube.com/embed/4FsbTgftmCk', '', 'active'),
(130, 'Digital marketing', 'Unlock the power of digital marketing with this comprehensive, step-by-step video course. Whether you\'re a beginner looking to build foundational knowledge or an experienced marketer aiming to refine your skills, this course covers everything you need to succeed in the digital space.', 26, 14, '2025-01-23 09:23:22', '2025-01-31 16:45:15', NULL, NULL, 'video', 'https://www.youtube.com/embed/wRZ3qWHYWZg', '', 'active'),
(134, 'UI Design Mastery: From Beginner to Pro', 'Learn how to create stunning, user-friendly interfaces that delight users and drive business success. This comprehensive course will take you step by step through the world of User Interface (UI) Design, covering essential design principles, tools, and techniques needed to design visually appealing, intuitive, and functional digital products. Whether you\'re aiming to become a UI designer or enhance your skills for a career in UX or product design, this course has you covered', 30, 3, '2025-01-30 19:09:21', '2025-01-31 16:42:49', NULL, NULL, 'video', 'https://www.youtube.com/embed/xiWUL3M9D8c', '', 'active'),
(135, 'Generative Ai', 'Generative AI is revolutionizing the way we create, innovate, and interact with technology. At its core, generative AI refers to a type of artificial intelligence that can produce new, original content based on patterns learned from existing data. Unlike traditional AI models, which focus on classifying or predicting data, generative AI is designed to generate new content—whether it’s text, images, music, or even video—by mimicking the style, structure, and characteristics of the data it’s trained on.\n\nFrom creating realistic images and videos to writing compelling text and composing music, generative AI is opening up new possibilities in creativity, automation, and design', 30, 3, '2025-01-30 19:10:37', '2025-01-31 16:42:55', NULL, NULL, 'video', 'https://www.youtube.com/embed/G0jO8kUrg-I&list=PLjwm_8O3suyOgDS_Z8AWbbq3zpCmR-WE9&index=2&pp=iAQB', '', 'active'),
(136, 'Startup: From Idea to Execution', 'Ready to turn your entrepreneurial dreams into reality? This course will guide you through every stage of building a successful startup, from developing your initial idea to scaling your business. Learn the key principles and practical steps needed to validate your concept, build a product, attract customers, and raise funding.', 30, 4, '2025-01-30 19:11:20', '2025-01-31 16:43:15', NULL, NULL, 'video', 'https://www.youtube.com/embed/_uQrJ0TkZlc&pp=ygUGcHl0aG9u', '', 'active'),
(137, 'CS50\'s Introduction to Artificial Intelligence with Python', 'This is CS50, Harvard University\'s introduction to the intellectual enterprises of computer science and the art of programming.\r\n\r\n', 30, 3, '2025-01-30 22:58:29', '2025-01-30 23:01:07', NULL, NULL, 'video', 'https://www.youtube.com/embed/gR8QvFmNuLE?si=FtG9mptP9SovChEC', '', 'active'),
(138, 'The Foundations of Entrepreneurship - Full Course', 'This entrepreneurship course will teach you the important lessons that they don\'t teach you in business school. You will learn about topics such as how to network, how to find customers, and how to get a job.', 13, 16, '2025-01-31 16:33:28', '2025-01-31 16:33:58', NULL, NULL, 'video', 'https://www.youtube.com/embed/UEngvxZ11sw?si=2NFcDjlMO7qGJDj9', '', 'active'),
(139, 'The MVC architecture', 'MVC is the most popular architecture for building complex web servers. It is used by many frameworks, and implemented into nearly every modern web application. In this video I will cover what MVC is, how it works, and why you should use it.\r\n\r\nMVC stands for Model, View, Controller. It is used to define how these three different entities can interact with each other.\r\n\r\nThe Controller handles user requests and delegates information between the Model and the View. It only deals with requests, and never handles data or presentation.\r\n\r\nThe Model handles data validation, logic, and persistence. It interacts directly with the database to handle the data. The Controller will get all of its data information by asking the Model about the data.\r\n\r\nThe View handles presenting the information. It will usually render dynamic HTML pages based on the data the model fetches. The Controller is responsible for passing that data between the Model and View, so that the Model and View never have to interact with each other.', 13, 1, '2025-01-31 16:35:49', '2025-01-31 16:35:58', NULL, NULL, 'video', 'https://www.youtube.com/embed/DUg2SWWK18I?si=W75MF5_FgNEVlo-C', '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `course_tags`
--

CREATE TABLE `course_tags` (
  `course_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_tags`
--

INSERT INTO `course_tags` (`course_id`, `tag_id`) VALUES
(127, 1),
(127, 2),
(129, 5),
(129, 7),
(130, 2),
(130, 5),
(134, 5),
(134, 10),
(135, 5),
(136, 8),
(137, 5),
(137, 10),
(138, 8),
(139, 6),
(139, 7);

-- --------------------------------------------------------

--
-- Table structure for table `Enrollments`
--

CREATE TABLE `Enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `progress` enum('not_started','in_progress','completed') DEFAULT 'not_started',
  `completed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Enrollments`
--

INSERT INTO `Enrollments` (`enrollment_id`, `student_id`, `course_id`, `enrolled_at`, `progress`, `completed_at`) VALUES
(22, 24, 127, '2025-01-23 09:19:00', 'completed', '2025-01-30 21:30:03'),
(23, 24, 135, '2025-01-30 19:17:31', 'in_progress', '2025-01-30 21:30:03'),
(24, 24, 134, '2025-01-30 20:21:12', 'not_started', '2025-01-30 21:44:41'),
(25, 24, 136, '2025-01-30 20:35:08', 'in_progress', '2025-01-30 21:37:56'),
(26, 24, 137, '2025-01-30 23:00:23', 'completed', '2025-01-31 00:16:20'),
(27, 35, 138, '2025-01-31 16:37:41', 'not_started', NULL),
(28, 24, 139, '2025-01-31 16:56:54', 'not_started', NULL),
(29, 24, 129, '2025-01-31 16:57:28', 'not_started', NULL),
(30, 24, 130, '2025-01-31 16:57:35', 'not_started', NULL),
(31, 24, 138, '2025-01-31 16:57:41', 'not_started', NULL);

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
(10, 'Azure Ai', '2025-01-20 14:16:31');

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
(1, 'Rayan', 'rayan@gmail.com', '$2y$10$YDN8tf2BaenvIFzuee0rF.Nbdgyio/tV17U48YaREQoIEbObt6x1q', 'admin', 'active', '2025-01-16 15:06:02', '2025-01-23 02:35:46', NULL),
(7, 'Rayan', 'ayman@gmail.com', '$2y$10$RpX5ZOuBS3fZJO.bV4NDtu1I12aj8MDVN3jGi.ynsoHwsboUhF.OK', 'admin', 'active', '2025-01-16 17:42:07', '2025-01-31 16:24:44', NULL),
(13, 'Rayan Elguerdaoui', 'kudo@gmail.com', '$2y$10$2NVs58IpNu2e9KcE5lo2WeRqHgKM3LW8Ws.DENVQKtyrJ0S4pRq/K', 'teacher', 'active', '2025-01-17 10:22:49', '2025-01-30 18:06:40', '../uploads/kudo.JPG'),
(22, 'ahmad', 'ahmad@gmail.com', '$2y$10$ttuGpORCZWKiliwgNJiP4O0cBC9Iy1ZjkfWlJUCAXJ4XHi/erPTkm', 'teacher', 'active', '2025-01-19 00:25:06', '2025-01-23 08:14:11', 'udemy.png'),
(24, 'Student', 'student@gmail.com', '$2y$10$7T4rEdrfEDERCCVxh6pSKOhQsyOwqfpqcjZAA3Ebqqp.0RuE6A39e', 'student', 'active', '2025-01-20 07:47:42', '2025-01-31 16:54:16', 'unknown3.jpg'),
(26, 'Ait Hssaine', 'mhamed@gmail.com', '$2y$10$q5aYChcn7ozimFVlHsHQfeqG6YvA/rx7LRnrMecyrhiJVwhlZwO9S', 'teacher', 'active', '2025-01-21 13:19:48', '2025-01-31 16:45:44', 'mhammed.jpeg'),
(30, 'David J. Malan', 'formateur@gmail.com', '$2y$10$dZNzGwQZiAtgA8K5BYknwO2ILTmuch7vdlMyMWpz1LnF9yym72BmC', 'teacher', 'active', '2025-01-23 02:22:10', '2025-01-30 22:55:56', 'notifications table.png'),
(33, 'Prof Rayan', 'rayan123@gmail.com', '$2y$10$L.EJlWChDdAjFYOtcqcqLeOxT6lsyffgzG2GklqIQRPtDKWbhGLxW', 'teacher', 'active', '2025-01-31 16:23:44', '2025-01-31 16:25:39', 'kudo.webp'),
(34, 'imane', 'imane@gmail.com', '$2y$10$4X9qJtJg.hkFDeR0U3pAf.xQ0Jkm1fUytNhDObfvZysJUxh.Qpo5m', 'student', 'active', '2025-01-31 16:36:49', '2025-01-31 16:36:49', 'pdf-icon.png'),
(35, 'yahya', 'yahya@gmail.com', '$2y$10$0lsHgAlVWYENYfKOXxGp2uTKxw/Bj0xWulggc03Ytz4IDzyKJIirm', 'student', 'active', '2025-01-31 16:37:16', '2025-01-31 16:37:16', 'apple-logo.png'),
(36, 'aymane', 'Aymane@gmail.com', '$2y$10$ijpZEOmp3R5QueMZ1Z4W4OFdYjyvlwrOOfcxAxSsXQWcNQHXcIHKy', 'student', 'suspended', '2025-01-31 16:48:21', '2025-01-31 16:51:46', 'bitnami-xampp.png'),
(37, 'khalid', 'khalid@gmail.com', '$2y$10$KTJFgfMU6parnvdPkTwJ6.mRkk/UbOL9VjloE4JNBzBVlwKRo2Kb2', 'student', 'active', '2025-01-31 16:49:03', '2025-01-31 16:49:03', 'favicon.png'),
(38, 'Mouad', 'MouadH@gmail.com', '$2y$10$PB08qk3ZnRR77rSomDvs/efTRio8A8UQvxzbNwIJiwbVzG0IuB8R2', 'student', 'active', '2025-01-31 16:49:34', '2025-01-31 16:49:34', 'linux-logo.png'),
(39, 'Khadija', 'khadija1200@gmail.com', '$2y$10$Ca4NWCC9eqjmvhOGinTRfes9EUqIpngXFvGTwKG2KiGLuDomyXbwS', 'student', 'active', '2025-01-31 16:49:49', '2025-01-31 16:49:49', 'appleVM-logo.png'),
(40, 'othman', 'othmanel@gmail.com', '$2y$10$2Nc35thSMeEfNDpBY5rEMesCrQ/J46ivUfnpVV/Pkuy7KgUddN9fq', 'student', 'suspended', '2025-01-31 16:50:19', '2025-01-31 16:54:01', 'image3.png'),
(41, 'farouq', 'farouq@gmail.com', '$2y$10$NagEkUt4ekcn8Sx0bXz.nevQ9.RMkIqYpeIvnGg8cNDiuWmeBJCO2', 'student', 'active', '2025-01-31 16:51:00', '2025-01-31 16:51:00', 'fastly-logo@2x.png'),
(42, 'Ali', 'ta7cha@gmail.com', '$2y$10$noYeop7vGVLSY3qUvxGLO.mVWkz76uh5xuWVyP58BDCcMIr3letji', 'student', 'active', '2025-01-31 16:51:24', '2025-01-31 16:51:24', 'apple-logo.png'),
(43, 'Hamza', 'hamza@gmail.com', '$2y$10$YsbNBw.4SsXXrvR3utiZ/.t.sgikxsRKOaKLNvNAo0tMceXmu59Uq', 'student', 'active', '2025-01-31 16:51:41', '2025-01-31 16:51:41', 'appleVM-logo.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`category_id`);

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
  ADD PRIMARY KEY (`enrollment_id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`course_id`),
  ADD KEY `enrollments_ibfk_2` (`course_id`);

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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `Enrollments`
--
ALTER TABLE `Enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `Tags`
--
ALTER TABLE `Tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Constraints for dumped tables
--

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
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
