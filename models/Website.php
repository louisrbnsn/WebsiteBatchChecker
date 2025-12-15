<?php
class Website {
    private $conn;
    
    public $id;
    public $batch_id;
    public $url;
    public $status;
    public $last_checked;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    // Récupérer un site par ID
    public function getById($id) {
        $query = "SELECT * FROM websites WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Créer un nouveau site
    public function create($batchId, $url) {
        $query = "INSERT INTO websites (batch_id, url, status, last_checked) 
                  VALUES (:batch_id, : url, NULL, NULL)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(': batch_id', $batchId);
        $stmt->bindParam(':url', $url);
        return $stmt->execute();
    }
    
    // Mettre à jour un site
    public function update($id, $url) {
        $query = "UPDATE websites SET url = :url WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(': url', $url);
        return $stmt->execute();
    }
    
    // Supprimer un site
    public function delete($id) {
        $query = "DELETE FROM websites WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    // Vérifier le statut d'un site avec cURL
    public function checkStatus($id) {
        $website = $this->getById($id);
        if (! $website) {
            return false;
        }
        
        $url = $website['url'];
        $status = WebsiteStatus::DOWN;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_NOBODY, true); // HEAD request
        
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        // Codes 200-399 = UP
        if ($httpCode >= 200 && $httpCode < 400) {
            $status = WebsiteStatus::UP;
        }
        
        // Mettre à jour le statut et last_checked
        $query = "UPDATE websites SET status = :status, last_checked = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    // Vérifier tous les sites d'un batch
    public function checkAllByBatch($batchId) {
        $query = "SELECT id FROM websites WHERE batch_id = :batch_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':batch_id', $batchId);
        $stmt->execute();
        $websites = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($websites as $website) {
            $this->checkStatus($website['id']);
        }
        
        return true;
    }
}