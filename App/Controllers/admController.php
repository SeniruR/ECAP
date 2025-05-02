<?php
namespace App\Controllers;

use App\Models\adm_m;
use App\Models\ItemModel;
use App\Database\Database;

class admController {

    private $adm_m;
    private $database;
    private $itemModel;

    public function __construct() {
        $this->database = new Database();
        $this->adm_m = new adm_m($this->database);
        $this->itemModel = new ItemModel($this->database);
    }

    public function check(Database $database) {
        if (!isset($_SESSION['admin_logged_in'])) {
            header("Location: index.php?url=Login");
            exit();
        }
    }

    public function adm_da(){
        $this->check($this->database);
        include __DIR__ . '/../Views/adm/index.php';
    }
    public function adm_list(){
        $this->check($this->database);
        $admitemData = $this->adm_m->getAllitemData($this->database);
        $itemtypes = $this->itemModel->getItemsTypeData(null,$this->database);
        include __DIR__ . '/../Views/adm/list.php';
    }

    public function adm_types_list(){
        $this->check($this->database);
        $itemtypes = $this->itemModel->getItemsTypeData(null,$this->database);
        include __DIR__ . '/../Views/adm/listtypes.php';
    }

    public function adm_add($success_message){
        $this->check($this->database);
        $success_message = $success_message ?? null;
        $type = $_GET['type'] ?? null;
        if(isset($_GET['no'])){
            $itemData = $this->itemModel->getItemData($_GET['no'],$this->database);
            $itemImages = $this->itemModel->getItemImages($_GET['no'],$this->database);
            $itemData['images'] = $itemImages;
            $update=true;
        }else{
            $itemData = null;
            $itemImages = null;
            $itemData['images'] = 0;
            $update=false;
        }
        
        $typeList = $this->itemModel->getItemsTypeData($type,$this->database);
        include __DIR__ . '/../Views/adm/add_item.php';
    }

    public function process_add_item(){
        $this->check($this->database);
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $item_name = $_POST['item_name'] ?? null;
            $item_short_description = nl2br(htmlspecialchars($_POST['item_short_description'] ?? '', ENT_QUOTES, 'UTF-8'));
            $item_long_description = nl2br(htmlspecialchars($_POST['item_long_description'] ?? '', ENT_QUOTES, 'UTF-8'));
            $item_type = $_POST['item_type'] ?? null;
            $item_contents = nl2br(htmlspecialchars($_POST['item_contents'] ?? '', ENT_QUOTES, 'UTF-8'));
            $item_benefits = nl2br(htmlspecialchars($_POST['item_benefits'] ?? '', ENT_QUOTES, 'UTF-8'));
            $item_trademark = $_POST['item_trademark'] ?? null;
            $item_price = $_POST['item_price'] ?? null;
            $item_image = $_FILES['item_image'] ?? null;

            if ($item_name && $item_short_description && $item_long_description && $item_type && $item_contents && $item_benefits && $item_price && $item_image) {
                $upload_dir = __DIR__ . '/../../Public/images/products/';
                $uploaded_files = [];
                foreach ($item_image['tmp_name'] as $key => $tmp_name) {
                    $file_name = basename($item_image['name'][$key]);
                    $file_path = $upload_dir . $file_name;
                    if (move_uploaded_file($tmp_name, $file_path)) {
                        $uploaded_files[] = $file_name;
                    }
                }

                $this->adm_m->addItem(
                    $item_name,
                    $item_short_description,
                    $item_long_description,
                    $item_type,
                    $item_contents,
                    $item_benefits,
                    $item_trademark,
                    $item_price,
                    $uploaded_files,$this->database
                );

                $success_message = "Item added successfully!";
                $this->adm_add($success_message);
                exit();
            }
        } elseif($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
            $item_name = $_POST['item_name'] ?? null;
            $item_short_description = nl2br(htmlspecialchars($_POST['item_short_description'] ?? '', ENT_QUOTES, 'UTF-8'));
            $item_long_description = nl2br(htmlspecialchars($_POST['item_long_description'] ?? '', ENT_QUOTES, 'UTF-8'));
            $item_type = $_POST['item_type'] ?? null;
            $item_contents = nl2br(htmlspecialchars($_POST['item_contents'] ?? '', ENT_QUOTES, 'UTF-8'));
            $item_benefits = nl2br(htmlspecialchars($_POST['item_benefits'] ?? '', ENT_QUOTES, 'UTF-8'));
            $item_trademark = $_POST['item_trademark'] ?? null;
            $item_price = $_POST['item_price'] ?? null;
            $no = $_POST['no'] ?? null;
            $item_image = $_FILES['item_image'] ?? null;

            $upload_dir = __DIR__ . '/../../Public/images/products/';
            $uploaded_files = [];
            if (!empty($item_image['tmp_name'][0])) {
                foreach ($item_image['tmp_name'] as $key => $tmp_name) {
                    $file_name = basename($item_image['name'][$key]);
                    $file_path = $upload_dir . $file_name;
                    if (move_uploaded_file($tmp_name, $file_path)) {
                        $uploaded_files[] = $file_name;
                    }
                }
            }

            $this->adm_m->updateItemWithImages(
                $no,
                $item_name,
                $item_short_description,
                $item_long_description,
                $item_type,
                $item_contents,
                $item_benefits,
                $item_trademark,
                $item_price,
                $uploaded_files,
                $this->database
            );
            
            $success_message = "Item updated successfully!";
            $this->adm_add($success_message);
            exit();
        } else {
            echo "Invalid request.";
         
        }
    }

    public function adm_types($success_message) {
        $this->check($this->database);
        $success_message = $success_message ?? null;
        $update = false;

        if (isset($_GET['no'])) {
            $categoryData = $this->adm_m->getCategoryData($_GET['no'], $this->database);
            $update = true;
        } else {
            $categoryData = null;
        }

        include __DIR__ . '/../Views/adm/add_types.php';
    }

    public function process_add_item_type() {
        $this->check($this->database);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $type_name = $_POST['name'] ?? null;
            $type_short_description = nl2br(htmlspecialchars($_POST['short_description'] ?? '', ENT_QUOTES, 'UTF-8'));
            $type_long_description = nl2br(htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES, 'UTF-8'));

            if ($type_name && $type_short_description && $type_long_description) {
                $this->adm_m->addItemType($type_name, $type_short_description, $type_long_description, $this->database);
                $success_message = "Category added successfully!";
                $this->adm_types($success_message);
                exit();
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $no = $_POST['no'] ?? null;
            $type_name = $_POST['name'] ?? null;
            $type_short_description = nl2br(htmlspecialchars($_POST['short_description'] ?? '', ENT_QUOTES, 'UTF-8'));
            $type_long_description = nl2br(htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES, 'UTF-8'));

            if ($no && $type_name && $type_short_description && $type_long_description) {
                $this->adm_m->updateItemType($no, $type_name, $type_short_description, $type_long_description, $this->database);
                $success_message = "Category updated successfully!";
                $this->adm_types($success_message);
                exit();
            }
        } else {
            echo "Invalid request.";
        }
    }
}
