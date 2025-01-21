<?php
session_start();
require_once __DIR__ . '/../config/database.php';

use App\Config\Database;

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'];
    $student_id = $_SESSION['user_id'];


    $sqlCheck = "SELECT * FROM enrollments WHERE student_id = :student_id AND course_id = :course_id";
    $stmt = $conn->prepare($sqlCheck);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':course_id', $course_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(["status" => "error", "message" => "Already enrolled."]);
        exit;
    }


    $sqlEnroll = "INSERT INTO enrollments (student_id, course_id, progress) VALUES (:student_id, :course_id, 'not_started')";
    $stmt = $conn->prepare($sqlEnroll);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':course_id', $course_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Enrolled successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Enrollment failed."]);
    }
}
?>
