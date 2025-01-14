<?php



namespace App\Class\Tags;
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Class\Crud\Crud;


class Tag extends Crud {
    private $table = "tags"; 

    public $id;
    public $name;

    public function insertTag($data) {
        return $this->insertRecord($this->table, $data);
    }

    public function deleteTag($id) {
        return $this->deleteRecord($this->table, $id);
    }


    public function update($data, $id) {
       return $this->updateRecord($this->table, $data, $id);
    }


    public function display() {
        return $this->selectRecords($this->table);
    }

}

?>