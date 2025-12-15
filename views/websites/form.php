<?php
$title = $isEdit ? 'Modifier site' : 'Ajouter un site';
ob_start();
?>

<div class="card">
    <div class="card-body">
        <h2 class="card-title mb-4"><?= $isEdit ? 'Modifier' : 'Ajouter un' ?> site</h2>

        <form method="POST" action="<?= $isEdit ? '/websites/edit/' .  $website['id'] : '/websites/create/' . $batch['id'] ?>">
            <div class="mb-3">
                <label for="url" class="form-label">URL</label>
                <input type="url" class="form-control" id="url" name="url" 
                       value="<?= $isEdit ? htmlspecialchars($website['url']) : '' ?>" 
                       placeholder="https://example.com" required>
            </div>

            <div class="d-flex gap-2">
                <a href="/batches/<?= $batch['id'] ? >" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>