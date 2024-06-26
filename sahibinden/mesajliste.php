<?php
include "ayar.php";
include "menu.php";

if (!isset($_SESSION['kullanici_adi'])) {
    echo '<div class="alert alert-warning text-center mt-3" role="alert">Giriş yapılmamış.</div>';
    exit;
}

$current_user_id = $_SESSION['kullanici_id'] ?? null;

$sql = "SELECT i.ilan_id, i.ilan_adi, k.k_adi, MAX(m.tarih) as son_mesaj_tarihi
        FROM mesaj m
        JOIN ilan i ON m.ilan_id = i.ilan_id
        JOIN kullanici k ON i.kullanici_id = k.kullanici_id
        WHERE m.alicikullanici_id = $current_user_id OR m.ilansahibikullanici_id = $current_user_id
        GROUP BY i.ilan_id, i.ilan_adi, k.k_adi
        ORDER BY son_mesaj_tarihi DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesajlarım</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .chat-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            transition: background-color 0.3s;
        }
        .chat-item:hover {
            background-color: #f1f1f1;
        }
        .chat-item .info {
            flex: 1;
        }
        .chat-item .info h5 {
            margin: 0;
            font-size: 1.1rem;
        }
        .chat-item .info p {
            margin: 0;
            color: #666;
        }
        .chat-item .time {
            font-size: 0.875rem;
            color: #999;
            white-space: nowrap;
            margin-left: auto;
        }
        .chat-item .delete-btn {
            margin-left: 15px;
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
                <div class="mt-4">
                    <h3 class="mb-3">Mesajlar</h3>
                    <ul class="chat-list list-group">
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <li class="chat-item list-group-item">
                                    <a href="mesaj.php?ilan_id=<?php echo $row['ilan_id']; ?>" class="d-flex align-items-center text-decoration-none text-dark w-100">
                                        <div class="info">
                                            <h5 class="mb-1"><?php echo htmlspecialchars($row['ilan_adi']); ?></h5>
                                            <p class="mb-0 text-muted"><?php echo htmlspecialchars($row['k_adi']); ?></p>
                                        </div>
                                        <div class="time text-end">
                                            <?php echo date('d M Y H:i', strtotime($row['son_mesaj_tarihi'])); ?>
                                        </div>
                                        <a href="sohbet_sil.php?ilan_id=<?php echo $row['ilan_id']; ?>" class="btn btn-danger btn-sm delete-btn" onclick="return confirm('Bu sohbeti silmek istediğinizden emin misiniz?');">Sohbeti Sil</a>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <li class="list-group-item text-center">Mesaj bulunmamaktadır.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
 
</body>
</html>
