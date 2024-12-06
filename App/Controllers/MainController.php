<?php
namespace App\Controllers;

use App\Models\ItemModel;
use App\Database\Database;

class MainController{
    public function index(){
        $database = new Database();
        $ItemModel = new ItemModel($database);
        $ItemData = $ItemModel->getItemsData($database);
        $counter = 0;
        include __DIR__ . '/../Views/index.php';
        exit();
    }
}