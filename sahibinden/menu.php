<?php
session_start(); // Oturumu başlat

include "ayar.php";
if (isset($_SESSION['kullanici_adi'])) {
    // Kullanıcı oturum açmışsa yapılacak işlemler
} else {
    // Kullanıcı oturum açmamışsa yapılacak işlemler
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .nav-link {
            font-size: 1.1rem;
        }
        .dropdown-menu {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .nav-link.bg-primary {
            color: #fff !important;
            border-radius: 5px;
        }
        .form-control {
            border-radius: 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="img/aracbul.jpeg" width="120px" height="auto" alt="Logo">
            </a>

            <!-- Arama Formu -->
            <form class="d-flex me-auto" method="GET" action="arama_sonuclari.php">
                <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php if (!isset($_SESSION['kullanici_adi'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="giris.php">Giriş Yap</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="kayit.php">Kayıt Ol</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Hoşgeldin, <?php echo $_SESSION['kullanici_adi']; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="kullaniciilan.php">İlanlarım</a></li>
                                <li><a class="dropdown-item" href="favori.php">Favorilerim</a></li>
                                <li><a class="dropdown-item" href="hesap.php">Hesabım</a></li>
                                <li><a class="dropdown-item" href="mesajliste.php">Mesajlar</a></li>
                                <li><a class="dropdown-item" href="cikis.php">Çıkış Yap</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['kullanici_adi'])) { ?>
                            <a class="nav-link bg-primary text-dark" href="ilanekle.php">Ücretsiz İlan Ver</a>
                        <?php } else { ?>
                            <a class="nav-link bg-primary text-dark" href="giris.php">Ücretsiz İlan Ver</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
 
</body>
</html>
