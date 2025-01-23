<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Course.php';

use App\Config\Database;

session_start();

$db = new Database();
$conn = $db->getConnection();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Authentication/login.php");
    exit;
}

if (isset($_GET['course_id'])) {
    $courseId = $_GET['course_id'];


    $sql = "
        SELECT 
            courses.*, 
            users.username AS teacher_name, 
            categories.name AS category_name
        FROM 
            courses
        JOIN 
            users ON courses.teacher_id = users.user_id
        JOIN 
            categories ON courses.category_id = categories.category_id
        WHERE 
            courses.course_id = :course_id 
            AND courses.status = 'active'
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);
    $stmt->execute();
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$course) {
        die("Course not found or not yet approved.");
    }

    // Format the created_at date as the published date
    $publishedDate = (new DateTime($course['created_at']))->format('F j, Y');
} else {
    die("Invalid course request.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($course['title']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen">
    <div class="max-w-4xl mx-auto p-6">
        <!-- Course Card -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Course Header -->
            <div class="p-6">
                <h1 class="text-4xl font-extrabold mb-4 text-gray-800"><?= htmlspecialchars($course['title']) ?></h1>

                <!-- Course Meta Information -->
                <div class="mb-6 text-sm text-gray-600">
                    <p><strong>Teacher:</strong> <?= htmlspecialchars($course['teacher_name']) ?></p>
                    <p><strong>Category:</strong> <?= htmlspecialchars($course['category_name']) ?></p>
                    <p><strong>Published on:</strong> <?= htmlspecialchars($publishedDate) ?></p>
                </div>

                <!-- Course Description -->
                <div class="mb-6">
                    <p class="text-gray-700 leading-relaxed">
                        <?= nl2br(htmlspecialchars($course['description'])) ?>
                    </p>
                </div>

                <!-- Display Course Content -->
                <?php if ($course['contenu'] === 'video' && $course['video_url']): ?>
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md mb-6">
                        <h3 class="text-xl font-semibold mb-2">Course Video</h3>
                        <iframe width="100%" height="300" src="https://www.youtube.com/embed/<?= htmlspecialchars($course['video_url']) ?>" frameborder="0" allowfullscreen class="rounded-md"></iframe>
                    </div>
                <?php elseif ($course['contenu'] === 'document' && $course['featured_image']): ?>
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md mb-6">
                        <h3 class="text-xl font-semibold mb-2">Course Document</h3>
                        <img src="../uploads/<?= htmlspecialchars($course['featured_image']) ?>" alt="Course Document" class="max-w-md mx-auto h-auto rounded-lg">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
