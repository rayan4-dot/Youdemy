<?php

namespace App\Models\Course;

require realpath(__DIR__ . '/../../vendor/autoload.php');

use App\Config\Database;

abstract class Course {
    protected $table = "courses";
    public $title;
    public $description;
    public $teacher_id;
    public $category_id;
    public $status;
    public $featuredImage;
    public $scheduled_date;
    public $contenu;
    public $created_at;
    public $updated_at;
    protected $db;

    public function __construct($title, $description, $teacher_id, $category_id, $status = 'pending', $featuredImage = null, $scheduled_date = null) {
        $this->title = $title;
        $this->description = $description;
        $this->teacher_id = $teacher_id;
        $this->category_id = $category_id;
        $this->status = $status;
        $this->featuredImage = $featuredImage;
        $this->scheduled_date = $scheduled_date;
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');

        $db = new Database();
        $this->db = $db->getConnection();
    }

    abstract public function save();
}
