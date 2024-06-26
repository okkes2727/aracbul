<?php
include "ayar.php"; // Veritabanı bağlantısı
include "menu.php";

// Giriş yapılmamışsa işlemi sonlandır
if (!isset($_SESSION['kullanici_adi'])) {
    echo "Giriş yapılmamış.";
    exit;
}

// Giriş yapan kullanıcının ID'sini al
$current_user_id = $_SESSION['kullanici_id'] ?? null;

// İlan ID'sini $_GET üzerinden al
$ilan_id = $_GET['ilan_id'] ?? null;

// Eğer ilan ID bulunamazsa hata mesajı ver ve işlemi sonlandır
if (!$ilan_id) {
    echo "İlan ID bulunamadı.";
    exit;
}

// İlgili ilanın bilgilerini al
$sql = "SELECT kullanici_id FROM ilan WHERE ilan_id = $ilan_id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $ilan = mysqli_fetch_assoc($result);
    $ilan_sahibi_id = $ilan['kullanici_id'];

    // Mesaj gönderme işlemi
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $mesaj = mysqli_real_escape_string($conn, $_POST['mesaj']);
        $sql = "INSERT INTO mesaj (ilansahibikullanici_id, alicikullanici_id, ilan_id, mesaj) 
                VALUES ($ilan_sahibi_id, $current_user_id, $ilan_id, '$mesaj')";
        mysqli_query($conn, $sql);
    }

    // İlgili ilana ait mesajları getir
    $sql = "SELECT m.mesaj, m.tarih, k.k_adi 
            FROM mesaj m 
            JOIN kullanici k ON m.alicikullanici_id = k.kullanici_id 
            WHERE m.ilan_id = $ilan_id 
            ORDER BY m.tarih ASC";
    $mesajlar = mysqli_query($conn, $sql);
} else {
    echo "İlan bulunamadı.";
    exit;
}
?>



<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İlanlarım</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-responsive {
            margin-top: 20px;
        }
        .message-box {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 15px;
        }
        .message {
            padding: 5px;
            margin-bottom: 5px;
        }
        .message.incoming {
            background-color: #f1f1f1;
            border-radius: 5px 5px 5px 0;
        }

        .message.outgoing {
            background-color: #d1e7dd;
            border-radius: 5px 5px 0 5px;
        }

        .alert-incoming {
            background-color: #d1e7dd;
            border-color: #bee5eb;
        }

        .alert-outgoing {
            background-color: #f1f1f1;
            border-color: #d6d8d9;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <?php include "panel.php"; ?>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-warning">
                                <strong>İlan:</strong> <a href="ilandetay.php?ilan_id=<?php echo $ilan_id; ?>"><?php echo $ilan_id; ?></a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="message-box">
                                <?php while ($row = mysqli_fetch_assoc($mesajlar)): ?>
                                    <div class="message <?php echo $row['k_adi'] == 'ilan_sahibi' ? 'incoming' : 'outgoing'; ?>">
                                        <strong><?php echo htmlspecialchars($row['k_adi']); ?>:</strong>
                                        <p><?php echo htmlspecialchars($row['mesaj']); ?></p>
                                        <small><?php echo $row['tarih']; ?></small>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <form action="mesaj.php?ilan_id=<?php echo $ilan_id; ?>" method="POST">
                                <div class="mb-3">
                                    <textarea name="mesaj" class="form-control" rows="3" placeholder="Mesajınızı buraya yazın" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Gönder</button>
                            </form>
                            <a href="mesajliste.php"><button>Geri</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>

