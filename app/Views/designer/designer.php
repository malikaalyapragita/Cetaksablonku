<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $this->renderSection('title') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">DESIGN STUDIO</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="/designer/dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/designer/desain_masuk">Antrian Kerja</a></li>
                    <li class="nav-item"><a class="nav-link" href="/designer/riwayat">Arsip Desain</a></li>
                </ul>
                <a href="/logout" class="btn btn-sm btn-light">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mt-4"><?= $this->renderSection('content') ?></div>
</body>
</html>