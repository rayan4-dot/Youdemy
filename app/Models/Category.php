<?php
namespace App\Models\Category;


require realpath(__DIR__ . '/../../vendor/autoload.php') ;


use App\Models\Crud;

class Category extends Crud
{
    private $table = "Categories";

    public $id;
    public $name;

    public function insertCategory(array $data)
    {
        return $this->insertRecord($this->table, $data);
    }

    public function deleteCategory(int $category_id) 
    {
        return $this->deleteRecord($this->table, $category_id, 'category_id'); 
    }

    public function updateCategory(array $data, int $category_id) 
    {
        return $this->updateRecord($this->table, $data, $category_id); 
    }

    public function getAllCategories()
    {
        return $this->selectRecords($this->table);
    }
}
