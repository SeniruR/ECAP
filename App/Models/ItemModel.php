<?php

namespace App\Models;

use App\Database\Database;

class ItemModel {
    private $conn; 

    public function getItemsData($type,Database $database) {
        $conn = $database->getConnection();
    
        if(!empty($type)) {
            $sql = "SELECT items.*,itemimages.image FROM items left join itemimages on items.no = itemimages.itemno WHERE type = ? and items.inactive_status=0 group by items.no";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $type);
        } else {
            $sql = "SELECT items.*,itemimages.image FROM items left join itemimages on items.no = itemimages.itemno Where items.inactive_status=0 group by items.no";
            $stmt = $conn->prepare($sql);
        }
        $stmt->execute();
        $result = $stmt->get_result();
    
        $rows = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        $conn->close();
        return $rows;
    }

    public function getItemsTypeData($type,Database $database) {
        $conn = $database->getConnection();
    
        if(!empty($type)) {
            $sql = "SELECT * FROM itemtypes WHERE no = ? and inactive_status=0";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $type);
        } else {
            $sql = "SELECT * FROM itemtypes where inactive_status=0";
            $stmt = $conn->prepare($sql);
        }
        $stmt->execute();
        $result = $stmt->get_result();
    
        $rows = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        $conn->close();
        return $rows;
    }

    public function getItemData($no,Database $database) {
        $conn = $database->getConnection();
    
        if(!empty($no)) {
            $sql = "SELECT items.*,it.no as itno FROM items join itemtypes as it on it.no=items.type WHERE items.no = ? and it.inactive_status=0";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $no);
        } else {
            return null;
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        $conn->close();
        return $result;
    }

    public function getItemImages($no,Database $database) {
        $conn = $database->getConnection();
    
        if(!empty($no)) {
            $sql = "SELECT * FROM itemimages WHERE itemno = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $no);
        } else {
            return null;
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $conn->close();
        return $result;
    }
}
?>
