<?php

use App\Models\Course\Course;

use App\Config\Database;


require realpath(__DIR__ . '/../../vendor/autoload.php') ;


class CourseVideo extends Course{
    private $videoUrl;

    public function __construct($title, $description, $teacher_id, $category_id, $videoUrl, $status = 'draft', $isCompleted = 'notCompleted', $featuredImage = null, $scheduled_date = null) {
        parent::__construct($title, $description, $teacher_id, $category_id, $status, $isCompleted, $featuredImage, $scheduled_date); 
        $this->contenu = 'video';
            $this->videoUrl = $videoUrl;
        }

        public function save(){
        $sql = "INSERT INTO Courses (title, description, teacher_id, category_id, status, isCompleted, featured_image, scheduled_date, contenu, video_url, created_at, updated_at)
        VALUES (:title, :description, :teacher_id, :category_id, :status, :isCompleted, :featured_image, :scheduled_date, :contenu, :video_url, NOW(), NOW())";

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
        $stmt->bindParam(':video_url', $this->videoUrl);


        return $stmt->execute();
        }
    }

    