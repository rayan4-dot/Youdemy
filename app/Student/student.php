<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}



$user_id = $_SESSION['user_id'];


require_once __DIR__ . '/../config/database.php';

use App\Config\Database;


$db = new Database();
$conn = $db->getConnection();


$sqlStudent = "SELECT username FROM users WHERE user_id = :user_id";
$stmtStudent = $conn->prepare($sqlStudent);
$stmtStudent->bindParam(':user_id', $user_id);
$stmtStudent->execute();
$student = $stmtStudent->fetch(PDO::FETCH_ASSOC);


$sqlEnrolledCourses = "SELECT courses.title, courses.course_id, courses.description, enrollments.progress
                       FROM enrollments
                       JOIN courses ON enrollments.course_id = courses.course_id
                       WHERE enrollments.student_id = :student_id";
$stmtEnrolledCourses = $conn->prepare($sqlEnrolledCourses);
$stmtEnrolledCourses->bindParam(':student_id', $user_id);
$stmtEnrolledCourses->execute();
$enrolledCourses = $stmtEnrolledCourses->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
<div class="flex">
    <!-- Sidebar -->
    <div class="bg-green-600 text-white w-64 min-h-screen">
        <h2 class="text-center text-3xl font-bold py-6">Student Dashboard</h2>
        <nav>
            <a href="#enrolled-courses" class="block py-3 px-4 hover:bg-green-500">Enrolled Courses</a>
            <a href="#certifications" class="block py-3 px-4 hover:bg-green-500">Certifications</a>
            <a href="courses.php" class="block py-3 px-4 hover:bg-green-500">Browse Courses</a>
        </nav>
    </div>


    <div class="flex-1">
        <!-- Header -->
        <header class="bg-white shadow-md py-4 px-6 flex justify-between items-center">
            <h1 class="text-xl font-bold">Welcome <?php echo htmlspecialchars($student['username']); ?>!</h1>
            <a href="../Authentication/logout.php?action=logout" class="bg-red-500 text-white py-2 px-4 rounded-lg">Logout</a>
        </header>


        <main class="p-6 space-y-12">
        <section id="enrolled-courses" class="py-8 bg-gray-100">
    <div class="container mx-auto">
        <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Enrolled Courses</h2>
        
        <?php if ($enrolledCourses): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($enrolledCourses as $course): 
                    $progress = isset($course['progress']) ? $course['progress'] : 'not_started';
                ?>
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105">
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">
                                <a href="../Teacher/courseDetail.php?course_id=<?= htmlspecialchars($course['course_id']); ?>" class="text-blue-600 hover:underline">
                                    <?php echo htmlspecialchars($course['title']); ?>
                                </a>
                            </h3>
                            <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($course['description']); ?></p>
                            
                            <!-- Progress Section -->
                            <div class="mb-4">
                                <p class="font-semibold">Progress: 
                                    <span class="<?php echo $progress === 'completed' ? 'text-green-500' : ($progress === 'in_progress' ? 'text-yellow-500' : 'text-red-500'); ?>">
                                        <?php echo ucfirst($progress); ?>
                                    </span>
                                </p>
                                <div class="w-full bg-gray-200 rounded-full h-4 mt-2">
                                    <div class="bg-green-500 h-4 rounded-full"
                                         style="width: <?php echo $progress === 'completed' ? '100%' : ($progress === 'in_progress' ? '50%' : '0%'); ?>;"></div>
                                </div>
                            </div>
                            
                            <!-- Update Progress Form -->
                            <form action="updateProgress.php" method="POST" class="mt-4">
    <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">
    <div class="flex items-center justify-between">
        <select name="progress" class="border rounded-md px-3 py-2 mr-2 flex-grow">
            <option value="not_started" <?php echo $progress === 'not_started' ? 'selected' : ''; ?>>Not Started</option>
            <option value="in_progress" <?php echo $progress === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
            <option value="completed" <?php echo $progress === 'completed' ? 'selected' : ''; ?>>Completed</option>
        </select>

        <div class="flex items-center space-x-2">
            <?php if ($progress === 'completed'): ?>
                <a href="generate_certificate.php?course_id=<?= $course['course_id']; ?>" id="get" class="bg-green-500 text-white rounded-lg hover:bg-green-400 px-4 py-2 transition duration-200">Certificate</a>
            <?php endif; ?>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 transition duration-200">Update</button>
        </div>
    </div>
</form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600 mt-4 text-center">You are not enrolled in any courses yet.</p>
        <?php endif; ?>
    </div>
</section>


        </main>
    </div>
</div>
</body>
</html>