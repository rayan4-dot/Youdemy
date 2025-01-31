<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Authentication/Auth.php';

use App\Config\Database;

$db = new Database();
$conn = $db->getConnection();
$auth = new Auth($conn);

$sqlPending = "SELECT courses.course_id, courses.title, users.username AS teacher
               FROM courses
               JOIN users ON courses.teacher_id = users.user_id
               WHERE courses.status = 'pending'";
               
$stmtPending = $conn->prepare($sqlPending);
$stmtPending->execute();
$pendingCourses = $stmtPending->fetchAll(PDO::FETCH_ASSOC);

$sqlActive = "SELECT courses.course_id, courses.title, users.username AS teacher
              FROM courses
              JOIN users ON courses.teacher_id = users.user_id
              WHERE courses.status = 'active'";

$stmtActive = $conn->prepare($sqlActive);
$stmtActive->execute();
$approvedCourses = $stmtActive->fetchAll(PDO::FETCH_ASSOC);

$sqlTotalCourses = "SELECT COUNT(*) AS total_courses FROM courses";
$stmtTotalCourses = $conn->prepare($sqlTotalCourses);
$stmtTotalCourses->execute();
$totalCourses = $stmtTotalCourses->fetch(PDO::FETCH_ASSOC)['total_courses'];

$sqlTopTeachers = "SELECT users.username, COUNT(courses.course_id) AS course_count
                   FROM courses
                   JOIN users ON courses.teacher_id = users.user_id
                   GROUP BY users.user_id
                   ORDER BY course_count DESC LIMIT 3";

$stmtTopTeachers = $conn->prepare($sqlTopTeachers);
$stmtTopTeachers->execute();
$topTeachers = $stmtTopTeachers->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        /* Card styles */
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 16px;
            background-color: white;
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 270px;
            height: 100%;
            background-color: #38b2ac;
            color: white;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .main-content {
            margin-left: 270px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 640px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* Light Mode */
        .light-mode {
            background-color: #fafafa;
            color: #2d3748;
        }

        .light-mode .sidebar {
            background-color: rgb(188, 31, 113);
        }

        .light-mode .card {
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Dark Mode */
        .dark-mode {
            background-color: #1a202c;
            color: #edf2f7;
        }

        .dark-mode .sidebar {
            background-color: #6b46c1;
        }

        .dark-mode .card {
            background-color: #2d3748;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        /* Sidebar links */
        .sidebar a {
            text-decoration: none;
            color: #cbd5e0;
            font-size: 18px;
            display: block;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 17px;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #4a5568;
            color: white;
        }

        .sidebar .active {
            background-color: #38b2ac;
            color: white;
        }

        /* Table Styles */
        table {
            width: 100%; /* Full width */
            max-width: 95%; /* Restrict table from being too wide */
            margin: 0 auto; /* Center table */
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #edf2f7;
        }

        th {
            background-color: #f7fafc;
            color: #2d3748;
        }

        td {
            background-color: #ffffff;
        }

        tr:hover {
            background-color: #f1f5f9;
        }

        /* Table container for scrolling */
        .table-container {
            overflow-x: auto;
            margin-top: 2rem;
        }

        /* Button styles */
        .btn {
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }
        #togglePendingCourses {
            margin-left: 42%;
        }
    </style>
</head>

<body class="light-mode">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2 class="text-white text-3xl font-bold text-center mb-12">Admin Dashboard</h2>
        <a href="dashboard.php" >Home</a>
        <a href="teacherManagement.php">Teacher Management</a>
        <a href="studentManagement.php">Student Management</a>
        <a href="courseManagement.php" class="active">Course Management</a>
        <a href="categoryManagement.php">Categories</a>
        <a href="tagManagement.php">Tags</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Courses Management</h1>
            <button id="togglePendingCourses" class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 rounded-md">
             Pending Courses
        </button>
            <a href="../Authentication/Auth.php?action=logout">
                <button class="bg-red-500 hover:bg-red-400 px-4 py-2 rounded-md text-lg font-semibold">Logout</button>
            </a>

                        <!-- Dark Mode Toggle -->
                        <button 
    id="dark-mode-toggle" 
    class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700" 
    aria-label="Toggle dark mode">
    <i id="mode-icon-moon" class="fas fa-moon" aria-hidden="true"></i>
    <i id="mode-icon-brightness" class="fa-solid fa-sun" style="display: none;" aria-hidden="true"></i>
</button>
        </div>





<!-- Total Courses and Top Teachers -->
<section class="mb-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <!-- Total Courses Card -->
        <div class="card bg-gradient-to-br from-blue-50 to-white">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Total Number of Created Courses</h3>
            <div class="flex items-center space-x-3">
                <span class="text-4xl font-bold text-blue-600"><?php echo $totalCourses; ?></span>
                <span class="text-lg text-gray-600">courses</span>
            </div>
        </div>

        <!-- Top Teachers Card -->
        <div class="card bg-gradient-to-br from-purple-50 to-white">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Top 3 Teachers</h3>
            <ul class="space-y-3">
                <?php foreach ($topTeachers as $teacher): ?>
                <li class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <span class="text-md text-gray-700 font-medium"><?php echo htmlspecialchars($teacher['username']); ?></span>
                    <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm font-medium">
                        <?php echo $teacher['course_count']; ?> courses
                    </span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<!-- Approved Courses Table -->
<section class="mb-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Approved Courses</h2>
    <?php if ($approvedCourses): ?>
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($approvedCourses as $course): ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($course['title']); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600"><?php echo htmlspecialchars($course['teacher']); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="../Teacher/courseDetail.php?course_id=<?php echo $course['course_id']; ?>" 
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                View Details
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="card text-center py-8">
        <p class="text-lg text-gray-600">No approved courses yet.</p>
    </div>
    <?php endif; ?>
</section>
   <!-- Pending Courses Table -->


   

<!-- Modal for Pending Courses -->
<div id="pendingCoursesModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 md:w-3/4 lg:w-1/2">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Pending Courses</h2>
        <?php if ($pendingCourses): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="pendingCoursesBody" class="bg-white divide-y divide-gray-200">
                    <?php foreach ($pendingCourses as $course): ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($course['title']); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600"><?php echo htmlspecialchars($course['teacher']); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="../Teacher/courseDetail.php?course_id=<?php echo $course['course_id']; ?>" 
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200">
                                Review Course
                            </a>
                            <!-- Approve Course -->
                            <form method="POST" action="approveCourse.php" style="display:inline;">
                                <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                    Approve
                                </button>
                            </form>
                            <!-- Reject Course -->
                            <form method="POST" action="rejectCourse.php" style="display:inline;">
                                <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                                    Reject
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center py-8">
            <p class="text-lg text-gray-600">No pending courses at the moment.</p>
        </div>
        <?php endif; ?>
        <button id="closeModal" class="mt-4 bg-red-500 hover:bg-red-400 px-4 py-2 rounded-md text-lg font-semibold">Close</button>
    </div>
</div>

    </div>

    <script>
 // Dark mode toggle functionality
const toggleButton = document.getElementById('dark-mode-toggle');
const body = document.getElementById('body');
const modeIconMoon = document.getElementById('mode-icon-moon');
const modeIconBrightness = document.getElementById('mode-icon-brightness');

toggleButton.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    body.classList.toggle('light-mode');

    // Toggle the icon
    if (body.classList.contains('dark-mode')) {
        modeIconMoon.style.display = 'none';
        modeIconBrightness.style.display = 'block';
    } else {
        modeIconMoon.style.display = 'block';
        modeIconBrightness.style.display = 'none';
    }
});

        document.getElementById('togglePendingCourses').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default anchor behavior
    const pendingCoursesModal = document.getElementById('pendingCoursesModal');
    pendingCoursesModal.classList.toggle('hidden'); // Toggle the hidden class
});

// Close the modal when the close button is clicked
document.getElementById('closeModal').addEventListener('click', function() {
    const pendingCoursesModal = document.getElementById('pendingCoursesModal');
    pendingCoursesModal.classList.add('hidden'); // Hide the modal
});
        
    </script>
</body>

</html>
