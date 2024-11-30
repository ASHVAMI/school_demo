// classes/ClassRoom.php
<?php
class ClassRoom {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAllClasses() {
        $stmt = $this->pdo->query("SELECT * FROM classes ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getClass($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM classes WHERE class_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function createClass($name) {
        $stmt = $this->pdo->prepare("
            INSERT INTO classes (name, created_at) 
            VALUES (?, NOW())
        ");
        return $stmt->execute([$name]);
    }
    
    public function updateClass($id, $name) {
        $stmt = $this->pdo->prepare("UPDATE classes SET name = ? WHERE class_id = ?");
        return $stmt->execute([$name, $id]);
    }
    
    public function deleteClass($id) {
        $stmt = $this->pdo->prepare("DELETE FROM classes WHERE class_id = ?");
        return $stmt->execute([$id]);
    }
}
?>
