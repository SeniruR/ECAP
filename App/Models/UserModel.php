<?php

namespace App\Models;

use App\Database\Database;

class UserModel {
    private $conn; 

    public function getUserData($email, $password, Database $database) {
        $conn = $database->getConnection();
    
        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
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
