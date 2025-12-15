<? php
class WebsiteController {
    // Formulaire ajout
    public function create($batchId) {
        $batchModel = new Batch();
        $batch = $batchModel->getById($batchId);
        
        if (!$batch) {
            $_SESSION['error'] = "Batch introuvable";
            header('Location: /batches');
            exit;
        }
        
        $isEdit = false;
        $website = null;
        
        require_once __DIR__ . '/../views/websites/form.php';
    }
    
    // Enregistrer un nouveau site
    public function store($batchId) {
        $url = $_POST['url'] ?? '';
        
        if (!empty($url)) {
            $website = new Website();
            $website->create($batchId, $url);
            $_SESSION['success'] = "Site ajouté avec succès";
        } else {
            $_SESSION['error'] = "L'URL est obligatoire";
        }
        
        header('Location: /batches/' . $batchId);
        exit;
    }
    
    // Formulaire modification
    public function edit($id) {
        $websiteModel = new Website();
        $website = $websiteModel->getById($id);
        
        if (!$website) {
            $_SESSION['error'] = "Site introuvable";
            header('Location: /batches');
            exit;
        }
        
        $batchModel = new Batch();
        $batch = $batchModel->getById($website['batch_id']);
        
        $isEdit = true;
        
        require_once __DIR__ .  '/../views/websites/form. php';
    }
    
    // Mettre à jour un site
    public function update($id) {
        $url = $_POST['url'] ?? '';
        
        $websiteModel = new Website();
        $website = $websiteModel->getById($id);
        
        if (!$website) {
            $_SESSION['error'] = "Site introuvable";
            header('Location: /batches');
            exit;
        }
        
        if (!empty($url)) {
            $websiteModel->update($id, $url);
            $_SESSION['success'] = "Site modifié avec succès";
        } else {
            $_SESSION['error'] = "L'URL est obligatoire";
        }
        
        header('Location: /batches/' . $website['batch_id']);
        exit;
    }
    
    // Supprimer un site
    public function delete($id) {
        $websiteModel = new Website();
        $website = $websiteModel->getById($id);
        
        if ($website) {
            $batchId = $website['batch_id'];
            $websiteModel->delete($id);
            $_SESSION['success'] = "Site supprimé avec succès";
            header('Location: /batches/' . $batchId);
        } else {
            $_SESSION['error'] = "Site introuvable";
            header('Location: /batches');
        }
        exit;
    }
    
    // Vérifier un site
    public function checkOne($id) {
        $websiteModel = new Website();
        $website = $websiteModel->getById($id);
        
        if ($website) {
            $websiteModel->checkStatus($id);
            $_SESSION['success'] = "Vérification effectuée";
            header('Location: /batches/' . $website['batch_id']);
        } else {
            $_SESSION['error'] = "Site introuvable";
            header('Location: /batches');
        }
        exit;
    }
    
    // Vérifier tous les sites d'un batch
    public function checkAll($batchId) {
        $websiteModel = new Website();
        $websiteModel->checkAllByBatch($batchId);
        $_SESSION['success'] = "Tous les sites ont été vérifiés";
        
        header('Location: /batches/' . $batchId);
        exit;
    }
}