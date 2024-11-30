// classes/Student.php
<?php
class Student {
    private $conn;
    private $table_name = "student";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllStudents() {
        $query = "SELECT s.*, c.name as class_name 
                 FROM " . $this->table_name . " s 
                 LEFT JOIN classes c ON s.class_id = c.class_id 
                 ORDER BY s.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function getStudent($id) {
        $query = "SELECT s.*, c.name as class_name 
                 FROM " . $this->table_name . " s 
                 LEFT JOIN classes c ON s.class_id = c.class_id 
                 WHERE s.id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    public function createStudent($name, $email, $address, $class_id, $image = null) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (name, email, address, class_id, image) 
                 VALUES (:name, :email, :address, :class_id, :image)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":class_id", $class_id);
        $stmt->bindParam(":image", $image);
        
        return $stmt->execute();
    }

    public function updateStudent($id, $name, $email, $address, $class_id, $image = null) {
        $query = "UPDATE " . $this->table_name . " 
                 SET name = :name, 
                     email = :email, 
                     address = :address, 
                     class_id = :class_id" .
                 ($image ? ", image = :image" : "") .
                 " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":class_id", $class_id);
        
        if ($image) {
            $stmt->bindParam(":image", $image);
        }
        
        return $stmt->execute();
    }

    public function deleteStudent($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
