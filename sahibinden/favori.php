<?php
include "ayar.php";
include "menu.php";

if (!isset($_SESSION['kullanici_adi'])) {
    echo "Giriş yapılmamış.";
    exit;
}

$kullanici_id = $_SESSION['kullanici_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ilan_id'])) {
    $ilan_id = $_POST['ilan_id'];
    
    // Favori kaydını tamamen sil
    $sql = "DELETE FROM favori WHERE ilan_id = $ilan_id AND kullanici_id = $kullanici_id";
    
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>İlan favorilerden çıkarıldı.</div>";
    } else {
        echo "<div class='alert alert-danger'>İlan favorilerden çıkarılamadı: " . mysqli_error($conn) . "</div>";
    }
}

// Kullanıcının favori ilanlarını çekme
$sql = "
    SELECT 
        ilan.ilan_id,
        ilan.ilan_adi,
        ilan.fiyat,
        ilan.yil,
        ilan.km,
        ilan.tarih,
        ilan.paket_id,
        ilan.seri_id,
        ilan.renk_id,
        ilan_resim.resim,
        marka.marka_adi,
        seri.seri_adi,
        paket.paket_adi,
        renk.renk_adi
    FROM favori
    LEFT JOIN ilan ON favori.ilan_id = ilan.ilan_id
    LEFT JOIN ilan_resim ON ilan.ilan_id = ilan_resim.ilan_id AND ilan_resim.resim_sira = 1
    LEFT JOIN marka ON ilan.marka_id = marka.marka_id
    LEFT JOIN seri ON ilan.seri_id = seri.seri_id
    LEFT JOIN paket ON ilan.paket_id = paket.paket_id
    LEFT JOIN renk ON ilan.renk_id = renk.renk_id
    WHERE favori.kullanici_id = $kullanici_id
";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favori İlanlarım</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-responsive {
            margin-top: 20px;
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
                <h3 class="text-center">Favori İlanlarım</h3>
                <?php if (mysqli_num_rows($result) > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Resim</th>
                                <th>Seri</th>
                                <th>Model</th>
                                <th>İlan Başlığı</th>
                                <th>Yıl</th>
                                <th>KM</th>
                                <th>Renk</th>
                                <th>Fiyat</th>
                                <th>İlan Tarihi</th>
                                <th>Favoriden Çıkar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($row['resim'])) { ?>
                                            <img src="<?php echo htmlspecialchars($row['resim']); ?>" alt="İlan Resmi" style="width:100px; height:auto;">
                                        <?php } else { ?>
                                            <img src="default.jpg" alt="Varsayılan Resim" style="width:100px; height:auto;">
                                        <?php } ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['seri_adi']); ?></td>
                                    <td><?php echo htmlspecialchars($row['paket_adi']); ?></td>
                                    <td>
                                        <a href="ilandetay.php?ilan_id=<?php echo $row['ilan_id']; ?>">
                                            <?php echo htmlspecialchars($row['ilan_adi']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['yil']); ?></td>
                                    <td><?php echo htmlspecialchars($row['km']); ?></td>
                                    <td><?php echo htmlspecialchars($row['renk_adi']); ?></td>
                                    <td>₺<?php echo htmlspecialchars($row['fiyat']); ?></td>
                                    <td><?php echo htmlspecialchars($row['tarih']); ?></td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="ilan_id" value="<?php echo $row['ilan_id']; ?>">
                                            <button type="submit" class="btn btn-danger">Favoriden Çıkar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } else { ?>
                    <div class="alert alert-info mt-3">Henüz favori ilanınız yok.</div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>
