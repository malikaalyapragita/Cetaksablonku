<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $this->renderSection('title') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow-sm">
        <div class="container">
            <a class="navbar-brand text-dark fw-bold" href="#">PRODUCTION FLOOR</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link text-dark" href="/production/dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="/production/antrian">1. Cetak</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="/production/qc">2. QC</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="/production/packing">3. Packing</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="/production/selesai">4. Selesai</a></li>
                </ul>
                <a href="/logout" class="btn btn-sm btn-dark">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mt-4"><?= $this->renderSection('content') ?></div>
</body>
</html>