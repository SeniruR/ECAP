<?php

namespace App\Models;

use App\Database\Database;

class UserModel {
    private $conn; 

    public function getUserDatabyEmail($email,Database $database) {
        $conn = $database->getConnection();
    
        $sql = "SELECT pass FROM users WHERE no = ?";
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
}
?>
