<?php
class Batch {
    private $conn;
    
    public $id;
    public $name;
    public $type;
    public $created_at;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    // Récupérer tous les batches
    public function getAll() {
        $query = "SELECT * FROM batches ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Récupérer un batch par ID
    public function getById($id) {
        $query = "SELECT * FROM batches WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Créer un nouveau batch
    public function create($name, $type) {
        $query = "INSERT INTO batches (name, type, created_at) VALUES (:name, :type, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        return $stmt->execute();
    }
    
    // Supprimer un batch
    public function delete($id) {
        $query = "DELETE FROM batches WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    // Récupérer les websites d'un batch
    public function getWebsites($batchId) {
        $query = "SELECT * FROM websites WHERE batch_id = :batch_id ORDER BY id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':batch_id', $batchId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}