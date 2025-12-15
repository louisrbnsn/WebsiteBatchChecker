<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ??  'Website Batch Checker'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a1a;
            color: #ffffff;
        }
        .navbar {
            background-color: #2c3e50 !important;
        }
        .table {
            color: #ffffff;
        }
        .table-dark {
            background-color: #2c3e50;
        }
        .card {
            background-color: #2c3e50;
            border:  none;
        }
        .form-control, .form-select {
            background-color: #34495e;
            color: #ffffff;
            border-color: #4a5f7f;
        }
        .form-control:focus, .form-select:focus {
            background-color: #34495e;
            color: #ffffff;
            border-color: #5a7fa0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo url('/batches'); ?>">
                <strong>Website Batch Checker</strong>
            </a>
        </div>
    </nav>

    <div class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php echo $content; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min. js"></script>
</body>
</html>