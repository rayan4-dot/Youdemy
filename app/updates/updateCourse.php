<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Authentication/Auth.php';

use App\Config\Database;

$db = new Database();
$conn = $db->getConnection();
$auth = new Auth($conn);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    $user_id = $_SESSION['user_id'];
    
    // Fetch the course details from the database
    $sql = "SELECT * FROM courses WHERE course_id = :course_id AND teacher_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':course_id', $course_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$course) {
        echo "You do not have permission to update this course.";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get POST data
        $title = $_POST['title'];
        $description = $_POST['description'];
        $video_url = $_POST['video_url'];
        $contenu = $_POST['contenu'];
        $category_id = $_POST['category_id'];

        // Update the course in the database
        $updateSql = "UPDATE courses 
                      SET title = :title, description = :description, video_url = :video_url, 
                          contenu = :contenu, category_id = :category_id 
                      WHERE course_id = :course_id";
        
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':title', $title);
        $updateStmt->bindParam(':description', $description);
        $updateStmt->bindParam(':video_url', $video_url);
        $updateStmt->bindParam(':contenu', $contenu);
        $updateStmt->bindParam(':category_id', $category_id);
        $updateStmt->bindParam(':course_id', $course_id);
        $updateStmt->execute();

        // Redirect to the view course page after updating
        header("Location: ../Teacher/teacher.php");
        exit();
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-blue-600 text-white px-6 py-4 shadow-md flex justify-between items-center">
            <h1 class="text-2xl font-bold">Youdemy</h1>
            <div class="flex space-x-4">
                <a href="viewCourse.php" class="hover:bg-blue-500 px-3 py-2 rounded">View Courses</a>
                <a href="addCourse.php" class="hover:bg-blue-500 px-3 py-2 rounded">Add Course</a>
                <a href="../Authentication/Auth.php?action=logout" class="bg-red-500 hover:bg-red-400 px-3 py-2 rounded">Logout</a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="bg-white shadow-md rounded-lg p-6 max-w-3xl mx-auto">
                <h2 class="text-2xl font-bold mb-4">Update Course</h2>

                <form action="" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="text-lg font-semibold" for="title">Course Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($course['title']); ?>" class="border border-gray-300 rounded px-4 py-2">
    </div>
    <div>
        <label class="text-lg font-semibold" for="description">Course Description:</label>
        <textarea id="description" name="description" class="border border-gray-300 rounded px-4 py-2"><?php echo htmlspecialchars($course['description']); ?></textarea>
    </div>
    <div>
        <label class="text-lg font-semibold" for="video_url">Video URL:</label>
        <input type="text" id="video_url" name="video_url" value="<?php echo htmlspecialchars($course['video_url']); ?>" class="border border-gray-300 rounded px-4 py-2">
    </div>
    <div>
        <label class="text-lg font-semibold" for="category_id">Category:</label>
        <select id="category_id" name="category_id" class="border border-gray-300 rounded px-4 py-2">
            <?php
            $categorySql = "SELECT * FROM categories";
            $categoryStmt = $conn->prepare($categorySql);
            $categoryStmt->execute();
            $categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($categories as $category) {
                $selected = ($category['category_id'] == $course['category_id']) ? 'selected' : '';
                echo "<option value='" . $category['category_id'] . "' $selected>" . htmlspecialchars($category['name']) . "</option>";
            }
            ?>
        </select>
    </div>
    <div>
        <label class="text-lg font-semibold" for="contenu">Content Type:</label>
        <select id="contenu" name="contenu" class="border border-gray-300 rounded px-4 py-2">
            <option value="video" <?php echo ($course['contenu'] === 'video') ? 'selected' : ''; ?>>Video</option>
            <option value="document" <?php echo ($course['contenu'] === 'document') ? 'selected' : ''; ?>>Document</option>
        </select>
    </div>
</div>
<div class="mt-4 text-center">
    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-500">Update Course</button>
</div>

                </form>
            </div>
        </main>
    </div>
</body>
</html>
