<?php
session_start();
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


if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];


    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM courses WHERE course_id = :course_id AND teacher_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':course_id', $course_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($course) {

        $deleteSql = "DELETE FROM courses WHERE course_id = :course_id";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bindParam(':course_id', $course_id);
        $deleteStmt->execute();


        header("Location: teacher.php");
        exit();
    } else {
        echo "You do not have permission to delete this course.";
    }
} else {
    echo "Course ID is missing.";
}
?>
