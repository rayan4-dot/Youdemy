<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require realpath(__DIR__ . '/../../vendor/autoload.php');
require_once '../Models/Tag.php';
use App\Config\Database;
use App\Models\Tag;

$tagModel = new Tag();
$tags = $tagModel->display();

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nameTag'])) {
    $tagModel->name = $_POST['nameTag'];

    if ($tagModel->insertTag(['name' => $tagModel->name])) {
        header("Location: tagManagement.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
  $tagModel->id = $_POST['id'];

  if ($tagModel->deleteTag($tagModel->id)) {
      header("Location: tagManagement.php");
      exit();
  }
}




// var_dump($tags)

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Udemy Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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

    /* Table styling */
    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f7fafc;
    }
  </style>
</head>

<body class="light-mode">

  <!-- Sidebar -->
  <div class="sidebar">
    <h2 class="text-white text-3xl font-bold text-center mb-12">Admin Dashboard</h2>
    <a href="dashboard.php">Home</a>
    <a href="teacherManagement.php">Teacher Management</a>
    <a href="#">Student Management</a>
    <a href="courseManagement.php">Course Management</a>
    <a href="categoryManagement.php">Categories</a>
    <a href="tagManagement.php" class="active">Tags</a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">Tag Management</h1>
      <button class="bg-blue-500 text-white py-2 px-6 rounded-lg">Logout</button>
    </div>

    <!-- Add Tag Form -->
    <div class="mb-6">
      <form action="tagManagement.php" method="POST">
        <input type="text" name="nameTag" placeholder="Enter tag name" class="px-4 py-2 rounded-md border" required>
        <button type="submit" class="button">Add Tag</button>
      </form>
    </div>

    <!-- Tag Table -->
    <div class="table-container mb-6">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Tag Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!empty($tags)): ?>
    <?php foreach ($tags as $tag): ?>
        <tr>
            <td><?php echo htmlspecialchars($tag['tag_id']); ?></td>
            <td><?php echo htmlspecialchars($tag['name']); ?></td>
            <td>
                <form action="updateTag.php" method="POST" style="display:inline;">
                    <input type="hidden" name="tagId" value="<?php echo htmlspecialchars($tag['tag_id']); ?>">
                    <input type="hidden" name="tagName" value="<?php echo htmlspecialchars($tag['name']); ?>">
                    <button type="submit" class="button button-edit">Edit</button>
                </form>
                <form action="tagManagement.php" method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($tag['tag_id']); ?>"> 
              
                <button type="submit" class="button button-action" onclick="return confirm('Are you sure you want to delete this tag?');">Delete</button>
</form>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>

        </tbody>
      </table>
    </div>
  </div>

</body>

</html>
