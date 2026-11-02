<?php
// Load helper cURL
require_once "config/config.php";

// API Key NewsAPI
$api_key = "a4876d9a09c247a3b7d4b71a4b3d8888";

// Endpoint Top Headlines Indonesia
$url = "https://newsapi.org/v2/everything?q=indonesia&sortBy=publishedAt&apiKey=" . $api_key;

// Request data via cURL
$response = http_request_get($url);

// Konversi JSON ke array
$hasil = json_decode($response, true);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REST Client - Portal Berita Indonesia</title>
    <!-- Bootstrap 4 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        .card-img-top {
            object-fit: cover;
            height: 190px;
        }
        .card {
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-info fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="#">NewsClient API</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Headline</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Container -->
<div class="container" style="margin-top: 85px; margin-bottom: 50px;">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="border-bottom pb-2">Berita Terkini Indonesia</h3>
        </div>
    </div>

    <div class="row">
        <?php 
        // Validasi response dari API
        if (isset($hasil['status']) && $hasil['status'] === 'ok' && !empty($hasil['articles'])) {
            foreach ($hasil['articles'] as $row) { 
                $gambar = !empty($row['urlToImage']) ? $row['urlToImage'] : 'https://placehold.co/600x400/png?text=No+Image';
                $penulis = !empty($row['author']) ? htmlspecialchars($row['author']) : 'Redaksi';
                $judul = htmlspecialchars($row['title']);
                $urlArtikel = $row['url'];
        ?>
            <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                <div class="card shadow-sm w-100">
                    <img src="<?= $gambar; ?>" class="card-img-top" alt="Thumbnail Berita" onerror="this.onerror=null;this.src='https://placehold.co/600x400/png?text=Image+Error';">
                    <div class="card-body d-flex flex-column">
                        <small class="text-muted mb-2">Penulis: <?= $penulis; ?></small>
                        <h6 class="card-title font-weight-bold"><?= $judul; ?></h6>
                        <div class="mt-auto text-right">
                            <a href="<?= $urlArtikel; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-info">Baca Selengkapnya &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
            } 
        } else { 
            $pesanError = isset($hasil['message']) ? $hasil['message'] : 'Gagal memuat berita atau data kosong.';
        ?>
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    <strong>Peringatan:</strong> <?= htmlspecialchars($pesanError); ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- JS Bootstrap via CDN -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>