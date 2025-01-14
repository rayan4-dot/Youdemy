<?php

namespace App\Class\Category;

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Class\Crud\Crud;

class Category extends Crud {
    private $table = "Categories";

    public $id;
    public $name;


    public function insertCategory($data) {
        return $this->insertRecord($this->table, $data);  
    }

    public function deleteCategory($id) {
        return $this->deleteRecord($this->table, $id);  

    }


    public function update($data, $id) {
        return $this->updateRecord($this->table, $data, $id);  
    }

    public function getAllCat() {
        return $this->selectRecords($this->table);  
    }
}
