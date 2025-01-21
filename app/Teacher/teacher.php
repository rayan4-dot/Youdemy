<?php
session_start(); 

if ($_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}

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

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$teacher = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$teacher) {
    session_destroy();
    header("Location: login.php");
    exit();
}

if ($teacher['status'] === 'banned') {
    session_destroy();
    header("Location: banned.php"); 
    exit();
}

$profile_picture_url = $teacher['profile_picture_url'] ?? '';

// fetch courses with categories
$sql_courses = "SELECT courses.*, categories.name AS category_name
                FROM courses
                INNER JOIN categories ON courses.category_id = categories.category_id
                WHERE courses.teacher_id = :teacher_id
                AND courses.status = 'active'";
$stmt_courses = $conn->prepare($sql_courses);
$stmt_courses->bindParam(':teacher_id', $user_id);
$stmt_courses->execute();
$courses = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);

// total courses & total student enrollments
$sql_course_count = "SELECT COUNT(*) AS course_count FROM courses WHERE teacher_id = :user_id";
$stmt_course_count = $conn->prepare($sql_course_count);
$stmt_course_count->bindParam(':user_id', $user_id);
$stmt_course_count->execute();
$course_data = $stmt_course_count->fetch(PDO::FETCH_ASSOC);
$course_count = $course_data['course_count'];

$sql_enrollments = "
    SELECT COUNT(DISTINCT e.student_id) AS student_count
    FROM enrollments e
    JOIN courses c ON e.course_id = c.course_id
    WHERE c.teacher_id = :user_id
";
$stmt_enrollments = $conn->prepare($sql_enrollments);
$stmt_enrollments->bindParam(':user_id', $user_id);
$stmt_enrollments->execute();
$enrollment_data = $stmt_enrollments->fetch(PDO::FETCH_ASSOC);
$student_count = $enrollment_data['student_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    /* General Styles */
    body {
      background-color: #f7fafc;
    }

    /* Navbar */
    .navbar {
      background-color: #4f46e5;
      padding: 1rem 2rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .navbar h1 {
      color: white;
      font-size: 1.8rem;
      font-weight: 700;
    }

    .navbar .nav-links {
      display: flex;
      gap: 1rem;
    }

    .navbar .nav-links a {
      color: white;
      font-weight: 500;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .navbar .nav-links a:hover {
      color: #6366f1;
    }

    /* Profile Section */
    .profile-card {
      background-color: #ffffff;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      margin-bottom: 2rem;
    }

    .profile-header h2 {
      font-size: 2rem;
      color: #333333;
    }

    .profile-header p {
      font-size: 1.2rem;
      color: #666666;
    }

    .profile-picture {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #4f46e5;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    /* Courses Section */
    .course-card {
      transition: all 0.3s ease;
      border-radius: 0.5rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      background-color: #ffffff;
      padding: 1.5rem;
      text-align: center;
    }

    .course-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .course-title {
      font-size: 1.2rem;
      font-weight: 600;
      color: #333333;
    }

    .course-category {
      background-color: #4f46e5;
      color: white;
      border-radius: 1rem;
      padding: 0.25rem 0.75rem;
      margin-top: 1rem;
    }

    .course-action-links {
      margin-top: 1rem;
    }

    .course-action-links a {
      text-decoration: none;
      color: #4f46e5;
      font-weight: 500;
      margin: 0 0.5rem;
    }

    .course-action-links a:hover {
      color: #6366f1;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .profile-picture {
        width: 100px;
        height: 100px;
      }
      .profile-card {
        padding: 1.5rem;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="flex justify-between items-center">
      <h1>Youdemy</h1>
      <div class="nav-links">
        <a href="addCourse.php" class="hover:bg-indigo-500 px-3 py-2 rounded">Add Course</a>
        <a href="../Authentication/logout.php?action=logout" class="bg-red-500 hover:bg-red-400 px-3 py-2 rounded">Logout</a>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="container mx-auto px-4 py-8">

    <!-- Teacher Profile -->
    <div class="profile-card max-w-4xl mx-auto">
      <div class="text-center">
        <img src="../uploads/<?php echo htmlspecialchars($profile_picture_url); ?>" alt="Profile Picture" class="profile-picture mx-auto">
        <div class="profile-header mt-4">
          <h2>Welcome, <?php echo htmlspecialchars($teacher['username']); ?>!</h2>
        </div>
        <div class="mt-6">
          <p>Courses Added: <?php echo $course_count; ?></p>
          <p>Students Enrolled: <?php echo $student_count; ?></p>
        </div>
      </div>
    </div>

    <!-- Courses List -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php if ($courses): ?>
        <?php foreach ($courses as $course): ?>
            <div class="course-card p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:scale-105">
                <h3 class="course-title text-xl font-semibold mb-2">
                    <a href="courseDetail.php?course_id=<?php echo $course['course_id']; ?>" class="hover:text-indigo-600"><?= htmlspecialchars($course['title']); ?></a>
                </h3>
                <span class="course-category bg-indigo-500 text-white py-1 px-4 rounded-full"><?= htmlspecialchars($course['category_name']); ?></span>


                <?php if ($course['contenu'] === 'video'): ?>
                    <div class="iframe-container mt-4">
                        <iframe src="<?= htmlspecialchars($course['video_url']); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="w-full h-56 rounded-lg shadow-md"></iframe>
                    </div>
                <?php elseif ($course['contenu'] === 'document' && $course['featured_image']): ?>

                    <img src="../uploads/<?= htmlspecialchars($course['featured_image']); ?>" alt="Featured Image" class="w-full h-48 object-cover rounded-lg shadow-lg mt-4">
                <?php endif; ?>

                <div class="course-action-links mt-4 flex justify-between">
                    <a href="../updates/updateCourse.php?course_id=<?php echo $course['course_id']; ?>" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                    <a href="deleteCourse.php?course_id=<?php echo $course['course_id']; ?>" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center text-gray-500 w-full">You have not added any courses yet.</p>
    <?php endif; ?>
</div>


  </main>

</body>
</html>
