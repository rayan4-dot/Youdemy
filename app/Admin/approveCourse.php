<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';

use App\Config\Database;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_id'])) {
    $courseId = $_POST['course_id'];

    $db = new Database();
    $conn = $db->getConnection();

    try {
        $stmt = $conn->prepare("UPDATE courses SET status = 'active' WHERE course_id = :course_id");
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();

        header("Location: courseManagement.php");
        exit();
    } catch (PDOException $e) {
        echo "Error approving course: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}
?>
