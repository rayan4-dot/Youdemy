<?php
session_start();
require_once __DIR__ . '/../config/database.php';

use App\Config\Database;

$db = new Database();
$conn = $db->getConnection();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];


    $checkSql = "SELECT * FROM enrollments WHERE student_id = :student_id AND course_id = :course_id";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $checkStmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
    $checkStmt->execute();

    if ($checkStmt->rowCount() === 0) {

        $sql = "INSERT INTO enrollments (student_id, course_id) VALUES (:student_id, :course_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->execute();
    }


    header("Location: courses.php?course_id=$course_id");
    exit;
}
?>
