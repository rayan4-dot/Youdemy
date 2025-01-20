<?php
session_start();
require_once __DIR__ . '/../config/database.php';


use App\Config\Database;
use App\Models\Certification;

$db = new Database();
$conn = $db->getConnection();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'];
    $progress = $_POST['progress'];
    $student_id = $_SESSION['user_id'];


    $allowedProgress = ['not_started', 'in_progress', 'completed'];
    if (!in_array($progress, $allowedProgress)) {
        die('Invalid progress value.');
    }


    $sqlUpdate = "UPDATE enrollments SET progress = :progress WHERE student_id = :student_id AND course_id = :course_id";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':progress', $progress);
    $stmtUpdate->bindParam(':student_id', $student_id);
    $stmtUpdate->bindParam(':course_id', $course_id);

    if ($stmtUpdate->execute()) {
        header('Location: student.php');
        exit();
    } else {
        echo "Failed to update progress.";
        error_log("Failed to update progress for student_id: $student_id, course_id: $course_id");
    }
}
?>
