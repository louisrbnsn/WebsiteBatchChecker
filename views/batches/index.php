<?php
$title = 'Batches';
ob_start();
?>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="card-title">Batches</h2>
            <a href="<?php echo url('/batches/create'); ?>" class="btn btn-primary">+ Nouveau batch</a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Créé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($batches as $batch): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($batch['id']); ?></td>
                            <td><?php echo htmlspecialchars($batch['name']); ?></td>
                            <td><?php echo htmlspecialchars($batch['type']); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($batch['created_at'])); ?></td>
                            <td>
                                <a href="<?php echo url('/batches/' . $batch['id']); ?>" class="btn btn-sm btn-primary">Ouvrir</a>
                                <a href="<?php echo url('/batches/delete/' . $batch['id']); ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Supprimer ce batch ?')">Suppr</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>