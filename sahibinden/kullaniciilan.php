    <?php
    include "ayar.php";
    include "menu.php";

    if (!isset($_SESSION['kullanici_adi'])) {
        echo "Giriş yapılmamış.";
        exit;
    }

    $kullanici_id = $_SESSION['kullanici_id'];

    // Kullanıcıya ait ilanları ve ilan resimlerini çekme
    $sql = "
        SELECT 
            ilan.*, 
            seri.seri_adi, 
            paket.paket_adi, 
            renk.renk_adi, 
            ilan_resim.resim
        FROM ilan
        LEFT JOIN seri ON ilan.seri_id = seri.seri_id
        LEFT JOIN paket ON ilan.paket_id = paket.paket_id
        LEFT JOIN renk ON ilan.renk_id = renk.renk_id
        LEFT JOIN ilan_resim ON ilan.ilan_id = ilan_resim.ilan_id AND ilan_resim.resim_sira = 1
        WHERE ilan.kullanici_id = $kullanici_id
    ";
    $result = mysqli_query($conn, $sql);

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
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class=" col-md-3">
                <?php include "panel.php"; ?>
            </div>
            <div class="col-md-9">
                <h3 class="text-center">İlanlarım</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Resim</th>
                                <th>Seri</th>
                                <th>Model</th>
                                <th>İlan Başlığı</th>
                              
                                <th>Renk</th>
                          
                                <th>İlan Tarihi</th>
                                <th>İlanı Düzenle</th>
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
                              
                                    <td><?php echo htmlspecialchars($row['renk_adi']); ?></td>
                                    <td>₺<?php echo htmlspecialchars($row['fiyat']); ?></td>
                            
                                    <td>
                                        <a href="ilanduzenle.php?ilan_id=<?php echo $row['ilan_id']; ?>" class="btn btn-primary">İlanı Düzenle</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php if (mysqli_num_rows($result) == 0) { ?>
                    <p class="text-center">Henüz bir ilanınız yok.</p>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>
