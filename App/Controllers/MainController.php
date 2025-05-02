<?php
namespace App\Controllers;

use App\Models\ItemModel;
use App\Database\Database;

class MainController{
    public function index(){
        $database = new Database();
        $ItemModel = new ItemModel($database);
        $type = $_GET['type'] ?? null;
        $Itemtypes = $ItemModel->getItemsTypeData($type,$database);
        $ItemData = $ItemModel->getItemsData($type,$database);
        $counter = 0;
        include __DIR__ . '/../Views/index.php';
    }

    public function listall(){
        $database = new Database();
        $ItemModel = new ItemModel($database);
        $type = $_GET['type'] ?? null;
        $typeData = $ItemModel->getItemsTypeData($type,$database);
        $ItemData = $ItemModel->getItemsData($type,$database);
        $counter = 0;
        include __DIR__ . '/../Views/listall.php';
    }

    public function item(){
        $database = new Database();
        $ItemModel = new ItemModel($database);
        $no = $_GET['no'] ?? null;
        $ItemData = $ItemModel->getItemData($no,$database);
        $getItemImages = $ItemModel->getItemImages($no,$database);
        include __DIR__ . '/../Views/item.php';
    }
}