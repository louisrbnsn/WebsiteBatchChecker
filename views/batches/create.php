<?php
$title = 'Nouveau batch';
ob_start();
?>

<div class="card">
    <div class="card-body">
        <h2 class="card-title mb-4">Nouveau batch</h2>

        <form method="POST" action="/WebsiteBatchChecker/batches/create">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <input type="text" class="form-control" id="type" name="type" 
                       placeholder="ex: API, Interne, RH..." required>
            </div>

            <div class="d-flex gap-2">
                <a href="/WebsiteBatchChecker/batches" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Créer</button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>