<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require realpath(__DIR__ . '/../../vendor/autoload.php');

require_once '../Models/Dashboard.php';
use App\Config\Database;
use App\Models\Dashboard;

$database = new Database();
$db = $database->getConnection(); // Use $db for the connection
$dashboard = new Dashboard();
$totalCourses = $dashboard->getTotalCourse($db);
$totalTeachers = $dashboard->getTotalTeacher($db);
$totalStudents = $dashboard->getTotalStudent($db);

// Fetching Courses by Category
$sqlCategoryCounts = "
    SELECT c.name AS category_name, COUNT(co.course_id) AS course_count
    FROM categories c
    LEFT JOIN courses co ON c.category_id = co.category_id
    GROUP BY c.category_id
";

$stmtCategoryCounts = $db->prepare($sqlCategoryCounts); // Use $db here
$stmtCategoryCounts->execute();
$categoryCounts = $stmtCategoryCounts->fetchAll(PDO::FETCH_ASSOC);

// Fetching Top 3 Teachers
$sqlTopTeachers = "
    SELECT users.username, COUNT(courses.course_id) AS course_count
    FROM courses
    JOIN users ON courses.teacher_id = users.user_id
    GROUP BY users.user_id
    ORDER BY course_count DESC LIMIT 3
";

$stmtTopTeachers = $db->prepare($sqlTopTeachers); // Use $db here
$stmtTopTeachers->execute();
$topTeachers = $stmtTopTeachers->fetchAll(PDO::FETCH_ASSOC);

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Authentication/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Udemy Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Custom styles for Dark and Light mode */
        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Sidebar styling */
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
            transition: background-color 0.3s ease;
        }

        .main-content {
            margin-left: 270px;
            padding: 30px;
            transition: margin-left 0.3s ease, background-color 0.3s ease, color 0.3s ease;
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

        /* Stat cards */
        .stat-card {
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 600;
        }

        .stat-card p {
            font-size: 1.125rem;
            color: #4a5568;
        }

        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }

        /* Toggle button icon styles */
        .toggle-btn {
            cursor: pointer;
        }

        #out {
            margin-left: 390%;
        }
    </style>
</head>

<body class="light-mode" id="body">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2 class="text-white text-3xl font-bold text-center mb-12">Admin Dashboard</h2>
        <a href="#home" class="active">Home</a>
        <a href="teacherManagement.php">Teacher Management</a>
        <a href="studentManagement.php">Student Management</a>
        <a href="courseManagement.php">Course Management</a>
        <a href="categoryManagement.php">Categories</a>
        <a href="tagManagement.php">Tags</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Welcome Back, Admin</h1>
            <a href="../Authentication/logout.php">
                <button id="out" class="bg-red-500 text-white py-2 px-6 rounded-lg">Logout</button>
            </a>
            <button id="dark-mode-toggle" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700" aria-label="Toggle dark mode">
                <i id="mode-icon-moon" class="fas fa-moon" aria-hidden="true"></i>
                <i id="mode-icon-brightness" class="fa-solid fa-sun" style="display: none;" aria-hidden="true"></i>
            </button>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-12">
            <div class="stat-card">
                <h3>Total Courses</h3>
                <p><?php echo $totalCourses ?></p>
            </div>
            <div class="stat-card">
                <h3>Teachers</h3>
                <p><?php echo $totalTeachers ?></p>
            </div>
            <div class="stat-card">
                <h3>Students</h3>
                <p><?php echo $totalStudents ?></p>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Courses by Category Chart -->
            <div class="card">
                <div class="card-header">Distribution of Courses by Category</div>
                <div class="chart-container">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>

            <!-- Top 3 Teachers Chart -->
            <div class="card">
                <div class="card-header">Top 3 Teachers</div>
                <div class="chart-container">
                    <canvas id="teachersChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
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

        // Fetching data for the category chart
        const categoryData = <?php echo json_encode($categoryCounts); ?>;
        const categoryLabels = categoryData.map(item => item.category_name);
        const categoryCounts = categoryData.map(item => item.course_count);

// Courses by Category Chart
const ctxCategory = document.getElementById('categoryChart').getContext('2d');
const categoryChart = new Chart(ctxCategory, {
    type: 'pie',
    data: {
        labels: categoryLabels,
        datasets: [{
            label: 'Courses by Category',
            data: categoryCounts,
            backgroundColor: [
                '#38b2ac', // Teal
                '#48bb78', // Green
                '#ed64a6', // Pink
                '#ed8936', // Orange
                '#f6e05e', // Yellow
                '#63b3ed'  // Light Blue
            ],
            borderColor: '#ffffff', // White border for better contrast
            borderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // Allow the chart to fill its container
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    font: {
                        size: 14, // Increase font size for legend
                    },
                    padding: 20, // Add padding between legend items
                },
            },
            tooltip: {
                backgroundColor: '#333', // Dark background for tooltips
                titleColor: '#fff', // White title color
                bodyColor: '#fff', // White body color
                borderColor: '#fff', // White border for tooltips
                borderWidth: 1,
            },
        },
    },
});

        // Fetching data for the top 3 teachers chart
        const teachersData = <?php echo json_encode($topTeachers); ?>;
        const teachersLabels = teachersData.map(item => item.username);
        const teachersCounts = teachersData.map(item => item.course_count);

// Top 3 Teachers Chart
const ctxTeachers = document.getElementById('teachersChart').getContext('2d');

// Create a gradient for the bar colors
const gradient = ctxTeachers.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, '#63b3ed'); // Light Blue
gradient.addColorStop(1, '#2b6cb0'); // Darker Blue

const teachersChart = new Chart(ctxTeachers, {
    type: 'bar',
    data: {
        labels: teachersLabels,
        datasets: [{
            label: 'Top 3 Teachers (Students)',
            data: teachersCounts,
            backgroundColor: gradient, // Use the gradient
            borderColor: '#2b6cb0', // Darker Blue for border
            borderWidth: 2,
            hoverBackgroundColor: '#2c5282', // Darker blue on hover
            hoverBorderColor: '#2c5282', // Even darker blue on hover
            barPercentage: 0.6, // Adjust bar width
            categoryPercentage: 0.5, // Adjust spacing between bars
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animations: {
            tension: {
                duration: 1000,
                easing: 'easeInOutQuad',
                from: 1,
                to: 0,
                loop: true
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 2000,
                    font: {
                        size: 14, // Increase font size for y-axis
                    },
                },
                grid: {
                    color: '#e2e8f0', // Light gray grid lines
                    lineWidth: 1, // Thicker grid lines
                },
            },
            x: {
                grid: {
                    display: false, // Hide grid lines for x-axis
                },
                ticks: {
                    font: {
                        size: 14, // Increase font size for x-axis
                    },
                },
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    font: {
                        size: 14, // Increase font size for legend
                    },
                },
            },
            tooltip: {
                backgroundColor: '#333',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#fff',
                borderWidth: 1,
                padding: 10, // Add padding to tooltip
                titleFont: {
                    size: 16, // Increase title font size
                },
                bodyFont: {
                    size: 14, // Increase body font size
                },
            },
        },
    },
});
    </script>
</body>

</html>