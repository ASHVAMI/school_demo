// classes/Student.php
<?php
class Student {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAllStudents() {
        $stmt = $this->pdo->query("
            SELECT s.*, c.name as class_name 
            FROM student s 
            LEFT JOIN classes c ON s.class_id = c.class_id 
            ORDER BY s.created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getStudent($id) {
        $stmt = $this->pdo->prepare("
            SELECT s.*, c.name as class_name 
            FROM student s 
            LEFT JOIN classes c ON s.class_id = c.class_id 
            WHERE s.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function createStudent($name, $email, $address, $class_id, $image) {
        $stmt = $this->pdo->prepare("
            INSERT INTO student (name, email, address, class_id, image, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        return $stmt->execute([$name, $email, $address, $class_id, $image]);
    }
    
    public function updateStudent($id, $name, $email, $address, $class_id, $image = null) {
        if ($image) {
            $stmt = $this->pdo->prepare("
                UPDATE student 
                SET name = ?, email = ?, address = ?, class_id = ?, image = ? 
                WHERE id = ?
            ");
            return $stmt->execute([$name, $email, $address, $class_id, $image, $id]);
        } else {
            $stmt = $this->pdo->prepare("
                UPDATE student 
                SET name = ?, email = ?, address = ?, class_id = ? 
                WHERE id = ?
            ");
            return $stmt->execute([$name, $email, $address, $class_id, $id]);
        }
    }
    
    public function deleteStudent($id) {
        $stmt = $this->pdo->prepare("DELETE FROM student WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
