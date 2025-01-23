<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Config\Database;
use App\Models\Category\Category;


$database = new Database();
$db = $database->getConnection();
$category = new Category($db);




if (isset($_POST['update-category']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_GET['categoryId'];
    $name = $_POST['categoryName'];


    $category->updateCategory(["name" => $name], $id);
    

    header("Location: categoryManagement.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            background-color: rgb(188, 31, 113); /* Light Green Sidebar */
        }

        /* Dark Mode */
        .dark-mode {
            background-color: #1a202c;
            color: #edf2f7;
        }

        .dark-mode .sidebar {
            background-color: #6b46c1; /* Dark Purple Sidebar */
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

        /* Button styles */
        .button {
            background-color: #38b2ac;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
        }

        .button:hover {
            background-color: #319795;
        }

        .button-action {
            background-color: #e53e3e;
        }

        .button-action:hover {
            background-color: #c53030;
        }

        .button-edit {
            background-color: #ed8936;
        }

        .button-edit:hover {
            background-color: #dd6b20;
        }
    </style>
</head>
<body class="bg-gray-100 h-screen">

    <div class="flex h-full">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2 class="text-white text-3xl font-bold text-center mb-12">Admin Dashboard</h2>
            <a href="dashboard.php">Home</a>
            <a href="validate.php">Account Validation</a>
            <a href="teacherManagement.php">Teacher Management</a>
            <a href="userManagement.php">User Management</a>
            <a href="#">Student Management</a>
            <a href="courseManagement.php">Course Management</a>
            <a href="categoryManagement.php" class="active">Categories</a>
            <a href="tagManagement.php">Tags</a>
        </div>

        <!-- Main Content -->
        <main class="flex-1 p-6 main-content">
            <div class="bg-white shadow-md rounded-lg p-4">
                <h1 class="text-2xl font-semibold mb-4">Edit Category</h1>

                <form action="updateCategory.php" method="POST">
                    <div class="mb-4">
                        <label for="categoryName" class="block text-gray-700">Category Name</label>
                        <input
                            type="text"
                            name="categoryName"
                            id="categoryName"
                            class="border border-gray-300 rounded px-4 py-2"
                            value="<?php echo htmlspecialchars($currentCategory['name']); ?>"
                            required
                        />
                    </div>
                    <input type="hidden" name="categoryId" value="<?php echo $currentCategory['category_id']; ?>">
                    <button name="update-category" type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Category</button>
                    <a href="categoryManagement.php"><button type="button" class="button bg-gray-500 hover:bg-gray-600 mt-4">Back</button></a>
                </form>
            </div>
        </main>
    </div>

</body>
</html>
