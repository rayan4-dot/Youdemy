<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Required files
require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Models/Tag.php';
require_once __DIR__ . '/../Models/Course.php';
require_once __DIR__ . '/../Models/CourseVideo.php';
require_once __DIR__ . '/../Models/CourseDoc.php';
require_once __DIR__ . '/../Config/Database.php'; 

use App\Models\Category\Category;
use App\Models\Tag;
use App\Models\Course\CourseVideo;
use App\Models\Course\CourseDoc;
use App\Config\Database;

session_start();

$database = new Database();
$conn = $database->getConnection();
$teacher_id = $_SESSION['user_id'];

$categoryModel = new Category();
$tagModel = new Tag();
$categories = $categoryModel->getAllCategories();
$tags = $tagModel->display();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = 'pending'; 

    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $contenu = $_POST['contenu'] ?? '';
    $tags = $_POST['tags'] ?? [];
    $scheduled_date = $_POST['scheduled_date'] ?? null;
    $featuredImage = null;
    if ($contenu === 'document') {

        if (isset($_FILES['featured_image']['name']) && !empty($_FILES['featured_image']['name'])) {
            $uploadDir = __DIR__ . '/../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }
            $uploadPath = $uploadDir . basename($_FILES['featured_image']['name']);
            move_uploaded_file($_FILES['featured_image']['tmp_name'], $uploadPath);
            $featuredImage = basename($_FILES['featured_image']['name']);
        }
    }

    if ($contenu === 'video') {

        $videoUrl = $_POST['video_url'] ?? '';

        if (!empty($videoUrl) && filter_var($videoUrl, FILTER_VALIDATE_URL)) {

            $videoEmbedUrl = str_replace("watch?v=", "embed/", $videoUrl);  
            $course = new CourseVideo($title, $description, $teacher_id, $category_id, $videoEmbedUrl, $status, $featuredImage, $scheduled_date);
        }
    } else {    
        $documentContent = $_POST['document_text'] ?? '';
        $course = new CourseDoc($title, $description, $teacher_id, $category_id, $documentContent, $status, $featuredImage, $scheduled_date);
    }

    try {
        $conn->beginTransaction();

        $courseId = $course->save();

        if (!empty($tags)) {
            foreach ($tags as $tagId) {
                $stmt = $conn->prepare("INSERT INTO course_tags (course_id, tag_id) VALUES (:course_id, :tag_id)");
                $stmt->bindParam(':course_id', $courseId);
                $stmt->bindParam(':tag_id', $tagId);
                $stmt->execute();
            }
        }

        $conn->commit();
        echo "Course successfully added!";
    } catch (Exception $e) {
        $conn->rollBack();
        echo "Error adding course: " . $e->getMessage();
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Add Course</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #4f46e5;
        }
    </style>
    <script>
        function toggleContentType() {
            const contentType = document.getElementById("content_type").value;
            const videoUrlField = document.getElementById("video_url_field");
            const documentField = document.getElementById("document_field");

            if (contentType === "video") {
                videoUrlField.style.display = "block";
                documentField.style.display = "none";
            } else {
                videoUrlField.style.display = "none";
                documentField.style.display = "block";
            }
        }
    </script>
</head>
<body class="bg-gray-100">
<div class="min-h-screen flex flex-col">
    <nav class="navbar text-white px-6 py-4 shadow-md flex justify-between items-center">
        <h1 class="text-2xl font-bold">Course Management</h1>
        <div class="flex space-x-4">
            <a href="teacher.php" class="hover:bg-blue-500 px-3 py-2 rounded transition duration-300">Profile</a>
        </div>
    </nav>

    <main class="flex-1 p-6">
        <div class="bg-white shadow-lg rounded-xl p-8 max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-blue-600 mb-6 text-center">Add Course</h2>
            <form action="addCourse.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label for="course-title" class="block text-lg font-semibold text-gray-700 mb-1">Course Title:</label>
                    <input type="text" id="course-title" name="title" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="Enter course title" required>
                </div>

                <div>
                    <label for="description" class="block text-lg font-semibold text-gray-700 mb-1">Course Description:</label>
                    <textarea id="description" name="description" rows="4" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="Enter course description" required></textarea>
                </div>

                <div>
                    <label for="category_id" class="block text-lg font-semibold text-gray-700 mb-1">Category:</label>
                    <select name="category_id" id="category_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category['category_id']); ?>">
                                <?= htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="tags" class="block text-lg font-semibold text-gray-700 mb-1">Tags:</label>
                    <div id="tags" class="flex flex-wrap gap-4">
                        <?php foreach ($tags as $tag): ?>
                            <div class="flex items-center">
                                <input type="checkbox" name="tags[]" value="<?= $tag['tag_id']; ?>" class="mr-2">
                                <label for="tag-<?= htmlspecialchars($tag['tag_id']); ?>" class="text-gray-700"><?= htmlspecialchars($tag['name']); ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <label for="content_type" class="block text-lg font-semibold text-gray-700 mb-1">Content Type:</label>
                    <select id="content_type" name="contenu" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 shadow-sm" onchange="toggleContentType()" required>
                        <option value="document">Document</option>
                        <option value="video">Video</option>
                    </select>
                </div>

                <!-- Video URL Field -->
                <div id="video_url_field" style="display: none;">
                    <label for="video_url" class="block text-lg font-semibold text-gray-700 mb-1">Video URL (YouTube):</label>
                    <input type="text" id="video_url" name="video_url" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="Enter YouTube video URL">
                </div>

                <!-- Document Upload Field -->
                <div id="document_field">
                    <label for="document_text" class="block text-lg font-semibold text-gray-700 mb-1">Document Content:</label>
                    <textarea id="document_text" name="document_text" rows="4" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="Enter document content"></textarea>

                    <label for="featured_image" class="block text-lg font-semibold text-gray-700 mb-1 mt-4">Featured Image:</label>
                    <input type="file" id="featured_image" name="featured_image" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 shadow-sm" />
                </div>

                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg text-lg">Submit Course</button>
            </form>
        </div>
    </main>
</div>
</body>
</html>
