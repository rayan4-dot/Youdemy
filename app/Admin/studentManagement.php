<?php
session_start();
require_once __DIR__ . '/../Authentication/Auth.php';
require_once __DIR__ . '/../config/database.php';

use App\Config\Database;

$db = new Database();
$conn = $db->getConnection();
$auth = new Auth($conn);


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


if ($_SESSION['role'] === 'student') {
    $sql = "SELECT status FROM users WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

}

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
            $sql = "UPDATE users SET status = :status WHERE user_id = :user_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
        } elseif ($action === 'suspend') {
            $status = 'suspended';
            $sql = "UPDATE users SET status = :status WHERE user_id = :user_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
        } elseif ($action === 'delete') {
            $sql = "DELETE FROM users WHERE user_id = :user_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
        } else {
            throw new Exception("Invalid action");
        }


        header("Location: studentManagement.php");
        exit;
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            color: #2c3e50;
            font-size: 32px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: white;
            font-size: 16px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td button {
            padding: 8px 12px;
            margin: 5px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        td button.activate {
            background-color: #27ae60;
            color: white;
        }

        td button.suspend {
            background-color: #f39c12;
            color: white;
        }

        td button.delete {
            background-color: #e74c3c;
            color: white;
        }

        td button:hover {
            opacity: 0.8;
        }

        td input[type="hidden"] {
            display: none;
        }

    </style>
</head>
<body>
    <h2>Manage Students</h2>
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
                        <button type="submit" name="action" value="delete" class="delete" onclick="return confirm('Are you sure ?')">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
