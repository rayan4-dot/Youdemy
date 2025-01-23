<?php
namespace App\Models;
use App\Config\Database;
use PDO;
use PDOException;

require_once __DIR__ . '/../../vendor/autoload.php';



class Dashboard {

    public function getTotalCourse($db) {
        $query = "SELECT COUNT(*) AS total_courses FROM Courses";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['total_courses'] : 0;
    }

    public function getTotalTeacher($db) {
        $query = "SELECT COUNT(*) AS total_teachers FROM users WHERE role = 'teacher'";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['total_teachers'] : 0;
    }

    public function getTotalStudent($db) {
        $query = "SELECT COUNT(*) AS total_students FROM users WHERE role = 'student'";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['total_students'] : 0;
    }
}
