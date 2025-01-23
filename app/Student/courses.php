<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once __DIR__ . '/../config/database.php';

use App\Config\Database;

$db = new Database();
$conn = $db->getConnection();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['user_id'];


$searchQuery = '';
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];
    $searchQuery = preg_replace("#[^0-9a-zA-Z ]#i", "", $searchQuery); 

    $sql = "SELECT c.*, cat.name AS category_name, u.username AS teacher_name 
            FROM courses c
            JOIN categories cat ON c.category_id = cat.category_id
            JOIN users u ON c.teacher_id = u.user_id
            WHERE c.status = 'active' 
            AND (c.title LIKE :searchQuery OR cat.name LIKE :searchQuery)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':searchQuery', '%' . $searchQuery . '%', PDO::PARAM_STR);
} else {

    $sql = "SELECT c.*, cat.name AS category_name, u.username AS teacher_name 
            FROM courses c
            JOIN categories cat ON c.category_id = cat.category_id
            JOIN users u ON c.teacher_id = u.user_id
            WHERE c.status = 'active'";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sqlCategories = "SELECT DISTINCT c.category_id, cat.name AS category_name 
                  FROM courses c
                  JOIN categories cat ON c.category_id = cat.category_id";
$stmtCategories = $conn->prepare($sqlCategories);
$stmtCategories->execute();
$categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);


$sqlEnrolled = "SELECT course_id FROM enrollments WHERE student_id = :student_id";
$stmtEnrolled = $conn->prepare($sqlEnrolled);
$stmtEnrolled->bindParam(':student_id', $student_id, PDO::PARAM_INT);
$stmtEnrolled->execute();
$enrolledCourseIds = $stmtEnrolled->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Browse Courses</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .iframe-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
        border-radius: 0.5rem;
    }
    .iframe-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
  </style>
</head>
<body class="bg-gray-50">
  <div class="max-w-screen-xl mx-auto p-8">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Browse Courses</h1>

    <!-- Search and Filter Section -->
    <div class="mb-8 flex flex-wrap justify-center gap-4">
      <form method="POST" action="">
        <input type="text" name="search" class="p-3 border border-gray-300 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search by course title or category..." value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-400">Search</button>
      </form>
    </div>

    <!-- Courses List -->
    <div id="coursesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php foreach ($courses as $course): ?>
        <div class="course-item bg-white shadow-lg rounded-xl overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out">
             
             <?php if (!empty($course['video_url'])): ?>

               <div class="iframe-container w-full h-48 mb-4">
                 <iframe src="<?php echo htmlspecialchars($course['video_url']); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="w-full h-full rounded-lg"></iframe>
               </div>
             <?php else: ?>

               <img src="<?php echo !empty($course['featured_image']) ? htmlspecialchars('../uploads/' . $course['featured_image']) : 'https://via.placeholder.com/300x200'; ?>" 
                    alt="Course Image" 
                    class="w-full h-48 object-cover mb-4">
             <?php endif; ?>

             <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2"><?php echo htmlspecialchars($course['title']); ?></h2>
                <p class="text-gray-600 text-base mb-4"><?php echo htmlspecialchars($course['description']); ?></p>
                <p class="text-sm text-gray-500 mb-2">Category: <span class="font-semibold"><?php echo htmlspecialchars($course['category_name']); ?></span></p>
                <p class="text-sm text-gray-500 mb-6">Instructor: <span class="font-semibold"><?php echo htmlspecialchars($course['teacher_name']); ?></span></p>

                <?php if (in_array($course['course_id'], $enrolledCourseIds)): ?>
              <div class="flex gap-4">
                <button class="bg-gray-500 text-white px-4 py-2 rounded-lg cursor-not-allowed">Already Enrolled</button>
                <a href="../Teacher/courseDetail.php?course_id=<?= $course['course_id']; ?>"class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-400">View Details</a>
              </div>
            <?php else: ?>
              <form action="enroll.php" method="POST">
                <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-400">Enroll</button>
              </form>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>
