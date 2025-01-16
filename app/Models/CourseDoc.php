<?php

use App\Models\Course\Course;

use App\Config\Database;


require realpath(__DIR__ . '/../../vendor/autoload.php') ;


class CourseDoc extends Course{
    private $document;

    public function __construct($title, $description, $teacher_id, $category_id, $document, $status = 'draft', $isCompleted = 'notCompleted', $featuredImage = null, $scheduled_date = null){
        parent::__construct($title, $description, $teacher_id, $category_id, $status, $isCompleted, $featuredImage, $scheduled_date);

            $this->contenu = 'document';
            $this->document = $document;
    }
    public function save(){
        $sql = "INSERT INTO Courses (title, description, teacher_id, category_id, status, isCompleted, featured_image, scheduled_date, contenu, document_content, created_at, updated_at)
                VALUES (:title, :description, :teacher_id, :category_id, :status, :isCompleted, :featured_image, :scheduled_date, :contenu, :document_content, NOW(), NOW())";

                $stmt = $this->db->prepare($sql);

                $stmt->bindParam(':title', $this->title);
                $stmt->bindParam(':description', $this->description);
                $stmt->bindParam(':teacher_id', $this->teacher_id);
                $stmt->bindParam(':category_id', $this->category_id);
                $stmt->bindParam(':status', $this->status);
                $stmt->bindParam(':isCompleted', $this->isCompleted);
                $stmt->bindParam(':featured_image', $this->featuredImage);
                $stmt->bindParam(':scheduled_date', $this->scheduled_date);
                $stmt->bindParam(':contenu', $this->contenu);
                $stmt->bindParam(':document_content', $this->document);

                return $stmt->execute();
    }

}