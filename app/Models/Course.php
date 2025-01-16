<?php

namespace App\Models\Course;

require realpath(__DIR__ . '/../../vendor/autoload.php') ;

use App\Config\Database;

abstract class Course {

    protected $table = "Courses";
    public $title ;
    public $description ;
    public $teacher_id;
    public $category_id;
    public $status;
    public $isCompleted;
    public $featuredImage;
    public $scheduled_date;
    public $contenu;
    public $created_at;
    public $updated_at;
    protected $db;

    public function __construct($title, $description,$teacher_id,$category_id,$status= 'draft', $isCompleted= 'notCompleted',$featuredImage= null, $scheduled_date=null){
        $this->title = $title;
        $this->description = $description;
        $this->teacher_id = $teacher_id;
        $this->category_id = $category_id;
        $this->status = $status;
        $this->isCompleted = $isCompleted;
        $this->featuredImage = $featuredImage;
        $this->scheduled_date = $scheduled_date;
        $this->contenu = null;
        // $this->created_at = date();
        // $this->updated_at = date();
        
        $db = new Database();
        $this->db = $db->getConnection();
    
        
    }

    abstract public function save();

}
    
