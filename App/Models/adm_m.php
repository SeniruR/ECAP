<?php

namespace App\Models;

use App\Database\Database;

class adm_m{
    private $conn; 

    public function getUserDatabyEmail($email,Database $database) {
        $conn = $database->getConnection();
    
        $sql = "SELECT adm_p FROM adm_u WHERE adm_e = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return null;
        }

        $conn->close();
    }

    public function getAllitemData(Database $database) {
        $conn = $database->getConnection();
    
        $sql = "SELECT items.*,itemimages.image,i.name as typename FROM items left join itemimages on items.no = itemimages.itemno join itemtypes as i on i.no= items.type group by items.no";
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

    public function addItem($item_name, $item_short_description, $item_long_description, $item_type, $item_contents, $item_benefits, $item_trademark, $item_price, $uploaded_files, Database $database) {
        $conn = $database->getConnection();
    
        $sql = "INSERT INTO items (name, short_dis, long_dis, type, content, benefits, trademark, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $item_name, $item_short_description, $item_long_description, $item_type, $item_contents, $item_benefits, $item_trademark, $item_price);
    
        if ($stmt->execute()) {
            $last_id = $conn->insert_id;
    
            foreach ($uploaded_files as $file_name) {
                $image_path = "./images/products/" . $file_name;

                $sql_image = "INSERT INTO itemimages (image, itemno) VALUES (?, ?)";
                $stmt_image = $conn->prepare($sql_image);
                $stmt_image->bind_param("ss", $image_path, $last_id);

                if (!$stmt_image->execute()) {
                    echo "Error: " . $conn->error;
                }
            }
            return true;
        } else {
            echo "Error: " . $conn->error;
            return false;
        }
    }

    public function updateItemWithImages($no, $item_name, $item_short_description, $item_long_description, $item_type, $item_contents, $item_benefits, $item_trademark, $item_price, $uploaded_files, Database $database) {
        $conn = $database->getConnection();

        $sql = "UPDATE items SET name = ?, short_dis = ?, long_dis = ?, type = ?, content = ?, benefits = ?, trademark = ?, price = ? WHERE no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $item_name, $item_short_description, $item_long_description, $item_type, $item_contents, $item_benefits, $item_trademark, $item_price, $no);

        if ($stmt->execute()) {
            $sql_delete_images = "DELETE FROM itemimages WHERE itemno = ?";
            $stmt_delete_images = $conn->prepare($sql_delete_images);
            $stmt_delete_images->bind_param("i", $no);
            $stmt_delete_images->execute();

            foreach ($uploaded_files as $file_name) {
                $image_path = "./images/products/" . $file_name;

                $sql_image = "INSERT INTO itemimages (image, itemno) VALUES (?, ?)";
                $stmt_image = $conn->prepare($sql_image);
                $stmt_image->bind_param("si", $image_path, $no);

                if (!$stmt_image->execute()) {
                    echo "Error: " . $conn->error;
                }
            }
            return true;
        } else {
            echo "Error: " . $conn->error;
            return false;
        }
    }

    public function getTypeData($no,Database $database) {
        $conn = $database->getConnection();
    
        $sql = "SELECT * FROM itemtypes WHERE no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $no);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function addItemType($type_name, $type_short_description, $type_long_description, Database $database) {
        $conn = $database->getConnection();

        $sql = "INSERT INTO itemtypes (name, short_discription, discription) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $type_name, $type_short_description, $type_long_description);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error: " . $conn->error;
            return false;
        }
    }

    public function updateItemType($no, $type_name, $type_short_description, $type_long_description, Database $database) {
        $conn = $database->getConnection();

        $sql = "UPDATE itemtypes SET name = ?, short_discription = ?, discription = ? WHERE no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $type_name, $type_short_description, $type_long_description, $no);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error: " . $conn->error;
            return false;
        }
    }

    public function changeStatus($no, $status, Database $database) {
        $conn = $database->getConnection();

        $sql = "UPDATE items SET inactive_status = ? WHERE no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $status, $no);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error: " . $conn->error;
            return false;
        }
    }

    public function removeItem($no, Database $database) {
        $conn = $database->getConnection();

        $sql = "DELETE FROM items WHERE no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $no);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error: " . $conn->error;
            return false;
        }
    }

    public function changeCategoryStatus($no, $status, Database $database) {
        $conn = $database->getConnection();

        $sql = "UPDATE itemtypes SET inactive_status = ? WHERE no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $status, $no);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error: " . $conn->error;
            return false;
        }
    }

    public function removeCategory($no, Database $database) {
        $conn = $database->getConnection();

        $sql = "DELETE FROM itemtypes WHERE no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $no);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error: " . $conn->error;
            return false;
        }
    }
}
?>
