<?php



namespace App\Models;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\Crud;


class Tag extends Crud {
    private $table = "Tags"; 

    public $id;
    public $name;

    public function insertTag($data) {
        return $this->insertRecord($this->table, $data);
    }

    public function deleteTag($id) {
        return $this->deleteRecord($this->table, $id, 'tag_id'); 
    }
    


    public function update($data, $id) {
        return $this->updateRecord($this->table, $data, $id);
    }
    


    public function display() {
        return $this->selectRecords($this->table);
    }


    public function getTagById($id) {
        $result = $this->selectRecords($this->table, '*', "tag_id = $id");
        return !empty($result) ? $result[0] : null;  // Return the first record or null if not found
    }

}

?>