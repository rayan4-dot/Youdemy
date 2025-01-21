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

            <section id="enrolled-courses">
                <h2 class="text-3xl font-bold mb-6">Enrolled Courses</h2>
                <?php if ($enrolledCourses): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($enrolledCourses as $course): 
                            $progress = isset($course['progress']) ? $course['progress'] : 'not_started';
                        ?>
                            <div class="bg-white shadow-md rounded-lg p-4">
                                <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($course['title']); ?></h3>
                                <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($course['description']); ?></p>
                                <div class="mb-4">
                                    <p class="font-semibold">Progress: <?php echo ucfirst($progress); ?></p>
                                    <div class="w-full bg-gray-200 rounded-full h-4 mt-2">
                                        <div class="bg-green-500 h-4 rounded-full"
                                             style="width: <?php echo $progress === 'completed' ? '100%' : ($progress === 'in_progress' ? '50%' : '0%'); ?>;"></div>
                                    </div>
                                </div>
                                <form action="updateProgress.php" method="POST" class="mt-4">
                                    <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">
                                    <select name="progress" class="border rounded-md px-3 py-2">
                                        <option value="not_started" <?php echo $progress === 'not_started' ? 'selected' : ''; ?>>Not Started</option>
                                        <option value="in_progress" <?php echo $progress === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                        <option value="completed" <?php echo $progress === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                    </select>
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Update</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600 mt-4">You are not enrolled in any courses yet.</p>
                <?php endif; ?>
            </section>


        </main>
    </div>
</div>
</body>
</html>