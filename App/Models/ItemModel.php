<?php

namespace App\Models;

use App\Database\Database;

class ItemModel {
    private $conn; 

    public function getItemsData(Database $database) {
        $conn = $database->getConnection();
    
        $sql = "SELECT * FROM items";
        $stmt = $conn->prepare($sql);
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
}
?>
