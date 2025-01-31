<?php
session_start();
require_once __DIR__ . '/../Authentication/Auth.php';
require_once __DIR__ . '/../config/database.php';

use App\Config\Database;

$db = new Database();
$conn = $db->getConnection();
$auth = new Auth($conn);

// // Ensure user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit;
// }


$sql = "SELECT * FROM users WHERE role = 'student'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $action = $_POST['action'];

    try {
        error_log("Action: $action, User ID: $user_id");

        if ($action === 'activate') {
            $status = 'active';
        } elseif ($action === 'suspend') {
            $status = 'suspended';
        } elseif ($action === 'ban') {
            $status = 'banned';
        } else {
            throw new Exception("Invalid action");
        }

        $sql = "UPDATE users SET status = :status WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        header("Location: studentManagement.php");
        exit;
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        /* Shared styles */
        .card {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 16px;
            background-color: white;
            transition: all 0.3s ease-in-out;
        }

        .table-container {
            overflow-x: auto;
            margin-top: 2rem;
        }

        table {
            width: 100%;
            max-width: 95%;
            margin: 0 auto;
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

        button {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button.activate {
            background-color: #38a169;
        }

        button.activate:hover {
            background-color: #2f855a;
        }

        button.suspend {
            background-color: #dd6b20;
        }

        button.suspend:hover {
            background-color: #c05621;
        }

        button.ban {
            background-color: #e53e3e;
        }

        button.ban:hover {
            background-color: #c53030;
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 270px;
            height: 100%;
            background-color: rgb(178, 56, 70);
            color: white;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            transition: all 0.3s ease;
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

        .main-content {
            margin-left: 270px;
            padding: 30px;
            transition: all 0.3s ease;
        }

        /* Light Mode */
        .light-mode {
            background-color: #fafafa;
            color: #2d3748;
        }

        .light-mode .sidebar {
            background-color: rgb(188, 31, 113);
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .dark-mode button.activate {
            background-color: #48bb78;
        }

        .dark-mode button.suspend {
            background-color: #f6ad55;
        }

        .dark-mode button.ban {
            background-color: #e53e3e;
        }

        .dark-mode button:hover {
            opacity: 0.9;
        }

        .dark-mode .sidebar a:hover {
            background-color: #4a5568;
        }

        .dark-mode .sidebar .active {
            background-color: #38b2ac;
        }

        /* Dark mode table fixes */
        .dark-mode table {
            background-color: #2d3748;
        }

        .dark-mode th {
            background-color: #4a5568;
            color: #edf2f7;
        }

        .dark-mode td {
            background-color: #3d3d3d;
            color: #edf2f7;
        }

        .dark-mode tr:hover {
            background-color: #4a5568;
        }
        #logout{
            margin-left: 420%;

        }
    </style>
</head>

<body class="light-mode" id="body">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2 class="text-white text-3xl font-bold text-center mb-12">Admin Dashboard</h2>
        <a href="dashboard.php">Home</a>
        <a href="teacherManagement.php">Teacher Management</a>
        <a href="studentManagement.php" class="active">Student Management</a>
        <a href="courseManagement.php">Course Management</a>
        <a href="categoryManagement.php">Categories</a>
        <a href="tagManagement.php">Tags</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Student Management</h1>
            <a href="../Authentication/Auth.php?action=logout">
                <button id="logout" class="bg-red-500 hover:bg-red-400 px-4 py-2 rounded-md text-lg font-semibold">Logout</button>
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

        <section class="mb-8">
            <div class="table-container card">
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['username']); ?></td>
                            <td><?php echo htmlspecialchars($student['email']); ?></td>
                            <td><?php echo ucfirst($student['status']); ?></td>
                            <td>
                                <form method="POST" action="studentManagement.php">
                                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($student['user_id']); ?>">
                                    <button type="submit" name="action" value="activate" class="activate">Activate</button>
                                    <button type="submit" name="action" value="suspend" class="suspend">Suspend</button>
                                    <button type="submit" name="action" value="ban" class="ban" onclick="return confirm('Are you sure you want to ban this student?')">Ban</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
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
    </script>

</body>

</html>
