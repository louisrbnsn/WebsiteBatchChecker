<?php
class BatchController {
    // Liste des batches
    public function index() {
        $batch = new Batch();
        $batches = $batch->getAll();
        
        require_once __DIR__ . '/../views/batches/index.php';
    }
    
    // Formulaire création
    public function create() {
        require_once __DIR__ .  '/../views/batches/create.php';
    }
    
    // Enregistrer un nouveau batch
    public function store() {
        $name = $_POST['name'] ?? '';
        $type = $_POST['type'] ?? '';
        
        if (! empty($name) && !empty($type)) {
            $batch = new Batch();
            $batch->create($name, $type);
            $_SESSION['success'] = "Batch créé avec succès";
        } else {
            $_SESSION['error'] = "Tous les champs sont obligatoires";
        }
        
        header('Location: /batches');
        exit;
    }
    
    // Afficher un batch et ses sites
    public function show($id) {
        $batchModel = new Batch();
        $batch = $batchModel->getById($id);
        
        if (!$batch) {
            $_SESSION['error'] = "Batch introuvable";
            header('Location: /batches');
            exit;
        }
        
        $websites = $batchModel->getWebsites($id);
        
        require_once __DIR__ . '/../views/websites/show.php';
    }
    
    // Supprimer un batch
    public function delete($id) {
        $batch = new Batch();
        $batch->delete($id);
        $_SESSION['success'] = "Batch supprimé avec succès";
        
        header('Location: /batches');
        exit;
    }
}