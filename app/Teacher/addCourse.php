<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Models/Tag.php';

use App\Models\Category\Category;
use App\Models\Tag;
use App\Models\Course;



$categoryModel = new Category();
$tagModel = new Tag();

$categories = $categoryModel->getAllCategories();
$tags = $tagModel->display();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
    <!-- Navbar -->
    <nav class="bg-blue-600 text-white px-6 py-4 shadow-md flex justify-between items-center">
      <h1 class="text-2xl font-bold">Course Management</h1>
      <div class="flex space-x-4">
        <a href="#view-courses" class="hover:bg-blue-500 px-3 py-2 rounded transition duration-300">View Courses</a>
        <a href="#add-course" class="hover:bg-blue-500 px-3 py-2 rounded transition duration-300">Add Course</a>
        <button class="bg-red-500 hover:bg-red-400 px-3 py-2 rounded transition duration-300">Logout</button>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <!-- Add Course Form -->
      <div class="bg-white shadow-lg rounded-xl p-8 max-w-3xl mx-auto">
        <h2 class="text-3xl font-bold text-blue-600 mb-6 text-center">Add Course</h2>
        <form action="process_add_course.php" method="POST" class="space-y-6">
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
        <input type="checkbox" name="tags[]" 
               class="mr-2">
        <label for="tag-<?= htmlspecialchars($tag['id'] ?? ''); ?>" 
               class="text-gray-700"><?= htmlspecialchars($tag['name'] ); ?></label>
    </div>
<?php endforeach; ?>



            </div>
          </div>
          <div>
            <label for="content_type" class="block text-lg font-semibold text-gray-700 mb-1">Content Type:</label>
            <select id="content_type" name="contenu" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 shadow-sm" onchange="toggleContentType()" required>
              <option value="video">Video</option>
              <option value="document">Document</option>
            </select>
          </div>
          <div id="video_url_field" style="display: block;">
            <label for="video_url" class="block text-lg font-semibold text-gray-700 mb-1">Video URL:</label>
            <input type="url" id="video_url" name="video_url" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="Enter video URL">
          </div>
          <div id="document_field" style="display: none;">
            <label for="document_text" class="block text-lg font-semibold text-gray-700 mb-1">Document Content:</label>
            <textarea id="document_text" name="document_text" rows="6" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="Enter document content"></textarea>
          </div>
          <input type="hidden" name="teacher_id" value="<?= htmlspecialchars($teacher_id); ?>">
          <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-500 transition duration-300 font-semibold">Add Course</button>
        </form>
      </div>
    </main>
  </div>
</body>
</html>
