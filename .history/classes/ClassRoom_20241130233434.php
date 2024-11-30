// classes/ClassRoom.php
<?php
class ClassRoom {
    private $conn;
    private $table_name = "classes";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllClasses() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getClass($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE class_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function createClass($name) {
        $query = "INSERT INTO " . $this->table_name . " (name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        return $stmt->execute();
    }

    public function updateClass($id, $name) {
        $query = "UPDATE " . $this->table_name . " SET name = :name WHERE class_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function deleteClass($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE class_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
