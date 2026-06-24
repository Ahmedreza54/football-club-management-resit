<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($title ?? 'Football Management System'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        :root {
            --app-primary: #0d6efd;
            --app-dark: #12263f;
        }
        body {
            background: #f4f7fb !important;
        }
        .navbar {
            background: linear-gradient(90deg, var(--app-dark) 0%, #1a3d66 100%) !important;
            box-shadow: 0 8px 24px rgba(18, 38, 63, 0.24);
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.2px;
        }
        .navbar .nav-link {
            color: rgba(255, 255, 255, 0.88) !important;
        }
        .navbar .nav-link:hover {
            color: #fff !important;
        }
        .app-content {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
        .app-panel {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e9edf5;
            box-shadow: 0 10px 24px rgba(11, 30, 58, 0.06);
        }
        .table {
            --bs-table-border-color: #e9edf5;
        }
        .table thead.table-light th {
            background: #f7f9fc;
            color: #253858;
        }
        .btn-primary {
            box-shadow: 0 8px 18px rgba(13, 110, 253, 0.25);
        }
        .alert {
            border-radius: 12px;
        }
    </style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="./index.php?r=home">Football</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <?php require __DIR__ . '/partials/navbar.php'; ?>
        </div>
    </div>
</nav>

<main class="container app-content">
    <?php if ($msg = Flash::pull('success')): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($msg); ?>
        </div>
    <?php endif; ?>
    <?php if ($msg = Flash::pull('error')): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($msg); ?>
        </div>
    <?php endif; ?>
    <?php echo $content; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

