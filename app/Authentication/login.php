<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/Auth.php';

use App\Config\Database;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy(); 
        session_unset(); 
    }
    session_start();
    

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        $db = new Database();
        $conn = $db->getConnection();
        $auth = new Auth($conn);
        $auth->login($email, $password); 
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
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Login</h2>

        <?php if (isset($error_message)): ?>
            <div class="text-red-600 text-center mb-4"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php" class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required class="mt-1 px-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required class="mt-1 px-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Login</button>
        </form>

        <p class="text-center mt-4 text-sm">
            Don't have an account? <a href="register.php" class="text-blue-600 hover:text-blue-700">Create one</a>
        </p>
    </div>
</body>
</html>
