

CREATE TABLE `Categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
)  


CREATE TABLE `Courses` (
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `teacher_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('published','draft') NOT NULL DEFAULT 'draft',
  `isCompleted` enum('notCompleted','completed') DEFAULT 'notCompleted',
  `featured_image` varchar(255) DEFAULT NULL,
  `scheduled_date` datetime DEFAULT NULL,
  `contenu` enum('video','document') DEFAULT NULL
)  

CREATE TABLE `course_tags` (
  `course_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
)  

CREATE TABLE `Enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `progress` enum('not_started','in_progress','completed') DEFAULT 'not_started'
)  



CREATE TABLE `Tags` (
  `tag_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
)  


CREATE TABLE `Users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('student','teacher','admin') NOT NULL,
  `status` enum('active','suspended','pending') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_picture_url` varchar(255) DEFAULT NULL
)  
