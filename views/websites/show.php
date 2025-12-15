<?php
$title = 'Batch:  ' . htmlspecialchars($batch['name']);
ob_start();
?>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="card-title">Batch:  <?php echo htmlspecialchars($batch['name']); ?></h2>
            <div>
                <a href="/WebsiteBatchChecker/batches" class="btn btn-secondary">← Retour</a>
                <a href="/WebsiteBatchChecker/batches/checkall/<?php echo $batch['id']; ?>" class="btn btn-info">Vérifier tous</a>
                <a href="/WebsiteBatchChecker/websites/create/<?php echo $batch['id']; ?>" class="btn btn-primary">+ Ajouter un site</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>URL</th>
                        <th>Statut</th>
                        <th>Dernier check</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($websites)): ?>
                        <tr>
                            <td colspan="5" class="text-center">Aucun site dans ce batch</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($websites as $website): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($website['id']); ?></td>
                                <td><?php echo htmlspecialchars($website['url']); ?></td>
                                <td>
                                    <?php if ($website['status']): ?>
                                        <span class="badge <?php echo WebsiteStatus::getBadgeClass($website['status']); ?>">
                                            <?php echo htmlspecialchars($website['status']); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Non vérifié</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo $website['last_checked'] ? date('Y-m-d H:i', strtotime($website['last_checked'])) : '-'; ?>
                                </td>
                                <td>
                                    <a href="/WebsiteBatchChecker/websites/check/<?php echo $website['id']; ?>" 
                                       class="btn btn-sm btn-info">Vérifier</a>
                                    <a href="/WebsiteBatchChecker/websites/edit/<?php echo $website['id']; ?>" 
                                       class="btn btn-sm btn-warning">Modif</a>
                                    <a href="/WebsiteBatchChecker/websites/delete/<?php echo $website['id']; ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Supprimer ce site ? ')">Suppr</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>