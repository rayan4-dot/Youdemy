<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/Auth.php';

use App\Config\Database;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];  

    $profile_picture_url = '';  

    if (isset($_FILES['profile_picture'])) {
        $profile_picture = $_FILES['profile_picture'];
        $target_dir = "../uploads/"; 
        $target_file = $target_dir . basename($profile_picture['name']);


        if (move_uploaded_file($profile_picture['tmp_name'], $target_file)) {

$profile_picture_url = basename($profile_picture['name']);  

        }
    }

    try {
        $db = new Database();
        $conn = $db->getConnection();
        $auth = new Auth($conn);


        $registerStatus = $auth->register($username, $email, $password, $role, $profile_picture_url);

        if ($registerStatus) {
            $success_message = "Account created successfully. Please log in.";
        } else {
            $error_message = "Registration failed. Please try again.";
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Register</h2>
        
        <?php if (isset($error_message)): ?>
            <div class="text-red-600 text-center mb-4"><?php echo $error_message; ?></div>
        <?php elseif (isset($success_message)): ?>
            <div class="text-green-600 text-center mb-4"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php" class="space-y-6" enctype="multipart/form-data">
            <!-- Username Field -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" required class="mt-1 px-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required class="mt-1 px-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required class="mt-1 px-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Role Dropdown -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select id="role" name="role" required class="mt-1 px-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                </select>
            </div>

            <!-- Profile Picture Upload -->
            <div>
                <label for="profile_picture" class="block text-sm font-medium text-gray-700">Profile Picture</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="mt-1 px-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Register</button>
        </form>

        <p class="text-center mt-4 text-sm">
            Already have an account? <a href="login.php" class="text-blue-600 hover:text-blue-700">Login</a>
        </p>
    </div>

</body>
</html>
