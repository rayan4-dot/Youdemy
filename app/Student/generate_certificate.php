<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../../vendor/autoload.php'; 

use App\Config\Database;
use TCPDF; 

$db = new Database();
$conn = $db->getConnection();


$course_id = $_GET['course_id']; 


if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to access this page.";
    exit;
}

$user_id = $_SESSION['user_id']; 


$sql = "SELECT c.title, u.username, e.completed_at, t.username AS teacher_name 
        FROM courses c 
        JOIN enrollments e ON c.course_id = e.course_id 
        JOIN users u ON e.student_id = u.user_id 
        JOIN users t ON c.teacher_id = t.user_id 
        WHERE c.course_id = :course_id AND e.student_id = :user_id AND e.progress = 'completed'";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if ($course) {

    $pdf = new TCPDF('L', 'mm', array(280, 210), true, 'UTF-8', false); 
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Youdemy');
    $pdf->SetTitle('Certificate of Completion');
    $pdf->SetSubject('Course Completion Certificate');
    $pdf->SetKeywords('TCPDF, PDF, certificate, completion');


    $pdf->SetMargins(15, 40, 15);
    $pdf->AddPage();


    $pdf->SetFillColor(255, 245, 230); 
    $pdf->Rect(10, 10, 260, 190, 'F'); 


    $pdf->Image('logo.png', 15, 15, 40, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);


    $pdf->SetFont('helvetica', 'B', 30);
    $pdf->SetTextColor(0, 102, 204); // Set title color to blue
    $pdf->Cell(0, 10, 'Certificate of Completion', 0, 1, 'C');


    $pdf->Ln(10);


    $pdf->SetFont('helvetica', 'B', 24);
    $pdf->SetTextColor(0, 0, 0); 
    $pdf->Cell(0, 10, htmlspecialchars($course['username']), 0, 1, 'C');


    $pdf->SetFont('helvetica', '', 20);
    $pdf->Cell(0, 10, 'has completed the course:', 0, 1, 'C');
    $pdf->SetFont('helvetica', 'B', 24);
    $pdf->Cell(0, 10, htmlspecialchars($course['title']), 0, 1, 'C');


    $pdf->Ln(10);


    $completionDate = date('F j, Y', strtotime($course['completed_at']));

    $pdf->SetFont('helvetica', '', 16);
    $pdf->Cell(0, 10, 'Date of Completion: ' . $completionDate, 0, 1, 'C');


    $pdf->Ln(10);


    $pdf->SetDrawColor(0, 102, 204); 

        $pdf->SetDrawColor(0, 102, 204); 
        $pdf->Line(15, $pdf->GetY(), 265, $pdf->GetY()); 
    

        $pdf->Ln(4); 
    

        $pdf->SetFont('helvetica', 'I', 16);
        $pdf->Cell(0, 10, 'Instructor: ' . htmlspecialchars($course['teacher_name']), 0, 1, 'C');
    

        $pdf->Ln(8);
    

        $pdf->SetFont('GreatVibes', '', 24); 
        $signatureText = "   ______________\n  /              \\\n /   Code. Create. Innovate     \\\n \\________________/";
        $pdf->MultiCell(0, 10, $signatureText, 0, 'C'); 
    

        $pdf->Output('Certaficate.pdf', 'D'); 
    } else {
        echo "You have not completed this course.";
    }
    ?>