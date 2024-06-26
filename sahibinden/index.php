<?php
include "ayar.php";
include 'menu.php';



// Form gönderildiğinde ilanları getir
$ilanlar = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Filtre değerlerini al
    $selected_marka = $_POST['selected_marka'] ?? null;
    $selected_seri = $_POST['selected_seri'] ?? null;
    $selected_paket = $_POST['selected_paket'] ?? null;
    $selected_ils = $_POST['il_id'] ?? [];
    $selected_ilces = $_POST['ilce_id'] ?? [];
    $yakit_turu_id = $_POST['yakit_turu_id'] ?? [];
    $vites_turu_id = $_POST['vites_turu_id'] ?? [];
    $renk_id = $_POST['renk_id'] ?? [];
    $motor_gucu = $_POST['motor_gucu'] ?? [];
    $motor_hacmi = $_POST['motor_hacmi'] ?? [];
    $plaka_id = $_POST['plaka_id'] ?? [];
    $kasa_tipi_id = $_POST['kasa_tipi_id'] ?? [];
    $cekis_id = $_POST['cekis_id'] ?? [];

    $min_fiyat = $_POST['min_fiyat'] ?? null;
    $max_fiyat = $_POST['max_fiyat'] ?? null;
    $min_yil = $_POST['min_yil'] ?? null;
    $max_yil = $_POST['max_yil'] ?? null;
    $min_km = $_POST['min_km'] ?? null;
    $max_km = $_POST['max_km'] ?? null;
    $garanti = $_POST['garanti'] ?? [];
    $hasar_kaydi = $_POST['hasar_kaydi'] ?? [];
    $kimden = $_POST['kimden'] ?? null;
    $takas = $_POST['takas'] ?? null;
    $arac_durum = $_POST['arac_durum'] ?? null;

    // SQL temel sorgusu
    $sql = "
    SELECT 
        ilan.*, 
        marka.marka_adi, 
        seri.seri_adi, 
        paket.paket_adi, 
        yakit_turu.tur_adi AS yakit_turu, 
        vites_turu.tur_adi AS vites_turu, 
        renk.renk_adi, 
        il.il_adi, 
        ilce.ilce_adi, 
        ilan_resim.resim
    FROM ilan
    LEFT JOIN marka ON ilan.marka_id = marka.marka_id
    LEFT JOIN seri ON ilan.seri_id = seri.seri_id
    LEFT JOIN paket ON ilan.paket_id = paket.paket_id
    LEFT JOIN yakit_turu ON ilan.yakit_turu_id = yakit_turu.yakit_turu_id
    LEFT JOIN vites_turu ON ilan.vites_turu_id = vites_turu.vites_turu_id
    LEFT JOIN renk ON ilan.renk_id = renk.renk_id
    LEFT JOIN il ON ilan.il_id = il.il_id
    LEFT JOIN ilce ON ilan.ilce_id = ilce.ilce_id
    LEFT JOIN ilan_resim ON ilan.ilan_id = ilan_resim.ilan_id AND ilan_resim.resim_sira = 1
    WHERE 1=1";

    // Filtreleme
    if (!empty($selected_marka)) {
        $sql .= " AND ilan.marka_id = '$selected_marka'";
    }
    if (!empty($selected_seri)) {
        $sql .= " AND ilan.seri_id = '$selected_seri'";
    }
    if (!empty($selected_paket)) {
        $sql .= " AND ilan.paket_id = '$selected_paket'";
    }

    if (!empty($selected_ils)) {
        $il_conditions = [];
        foreach ($selected_ils as $il) {
            $il_conditions[] = "ilan.il_id = '$il'";
        }
        $sql .= " AND (" . implode(' OR ', $il_conditions) . ")";
    }
    
    if (!empty($selected_ilces)) {
        $ilce_conditions = [];
        foreach ($selected_ilces as $ilce) {
            $ilce_conditions[] = "ilan.ilce_id = '$ilce'";
        }
        $sql .= " AND (" . implode(' OR ', $ilce_conditions) . ")";
    }

    if (!empty($min_fiyat)) {
        $sql .= " AND ilan.fiyat >= '$min_fiyat'";
    }
    if (!empty($max_fiyat)) {
        $sql .= " AND ilan.fiyat <= '$max_fiyat'";
    }
    if (!empty($min_yil)) {
        $sql .= " AND ilan.yil >= '$min_yil'";
    }
    if (!empty($max_yil)) {
        $sql .= " AND ilan.yil <= '$max_yil'";
    }
    if (!empty($min_km)) {
        $sql .= " AND ilan.km >= '$min_km'";
    }
    if (!empty($max_km)) {
        $sql .= " AND ilan.km <= '$max_km'";
    }


if (!empty($kasa_tipi_id)) {
    $kasa_conditions = [];
    foreach ($kasa_tipi_id as $kasa) {
        $kasa_conditions[] = "ilan.kasa_tipi_id = '$kasa'";
    }
    $sql .= " AND (" . implode(' OR ', $kasa_conditions) . ")";
}
if (!empty($cekis_id)) {
    $cekis_conditions = [];
    foreach ($cekis_id as $cekis) {
        $cekis_conditions[] = "ilan.cekis_id = '$cekis'";
    }
    $sql .= " AND (" . implode(' OR ', $cekis_conditions) . ")";
}


    if (!empty($garanti)) {
        foreach ($garanti as $gar) {
            $sql .= " AND ilan.garanti = '$gar'";
        }
    }
    if (!empty($hasar_kaydi)) {
        foreach ($hasar_kaydi as $hasar) {
            $sql .= " AND ilan.hasar_kaydi = '$hasar'";
        }
    }
    if ($kimden !== null) {
        $sql .= " AND ilan.kimden = '$kimden'";
    }
    if ($takas !== null) {
        $sql .= " AND ilan.takas = '$takas'";
    }
    if ($arac_durum !== null) {
        $sql .= " AND ilan.arac_durum = '$arac_durum'";
    }
    if (!empty($motor_gucu)) {
        $motor_gucu_conditions = [];
        foreach ($motor_gucu as $guc) {
            [$min, $max] = explode('-', $guc);
            $motor_gucu_conditions[] = "(ilan.motor_gucu_id >= '$min' AND ilan.motor_gucu_id <= '$max')";
        }
        $sql .= " AND (" . implode(' OR ', $motor_gucu_conditions) . ")";
    }
    if (!empty($motor_hacmi)) {
        $motor_hacmi_conditions = [];
        foreach ($motor_hacmi as $hacim) {
            [$min, $max] = explode('-', $hacim);
            $motor_hacmi_conditions[] = "(ilan.motor_hacmi_id >= '$min' AND ilan.motor_hacmi_id <= '$max')";
        }
        $sql .= " AND (" . implode(' OR ', $motor_hacmi_conditions) . ")";
    }
    if (!empty($yakit_turu_id)) {
        $yakit_conditions = [];
        foreach ($yakit_turu_id as $yakit) {
            $yakit_conditions[] = "ilan.yakit_turu_id = '$yakit'";
        }
        $sql .= " AND (" . implode(' OR ', $yakit_conditions) . ")";
    }
    if (!empty($vites_turu_id)) {
        $vites_conditions = [];
        foreach ($vites_turu_id as $vites) {
            $vites_conditions[] = "ilan.vites_turu_id = '$vites'";
        }
        $sql .= " AND (" . implode(' OR ', $vites_conditions) . ")";
    }
    if (!empty($renk_id)) {
        $renk_conditions = [];
        foreach ($renk_id as $renk) {
            $renk_conditions[] = "ilan.renk_id = '$renk'";
        }
        $sql .= " AND (" . implode(' OR ', $renk_conditions) . ")";
    }
    if (!empty($plaka_id)) {
        $plaka_conditions = [];
        foreach ($plaka_id as $plaka) {
            $plaka_conditions[] = "ilan.plaka_id = '$plaka'";
        }
        $sql .= " AND (" . implode(' OR ', $plaka_conditions) . ")";
    }

    // Sorguyu çalıştırma
    $result = mysqli_query($conn, $sql);

    // Sonuçları işleme
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $ilanlar[] = $row;
        }
    } else {
        echo "<p>Eşleşen ilan bulunamadı.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AracBul</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <?php include "filtre.php";
            ?>
        </div>
        <div class="col-md-10">
            <?php if ($_SERVER['REQUEST_METHOD'] !== 'POST') { ?>
                <?php include "vitrinilanlar.php"; ?>
            <?php } else { ?>
                <div id="ilanlar">
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
                                    <th>İl / İlçe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ilanlar as $ilan): ?>
                                    <tr>
                                        <td>
                                            <?php if (!empty($ilan['resim'])): ?>
                                                <img src="<?php echo htmlspecialchars($ilan['resim']); ?>" alt="İlan Resmi" style="width:100px; height:auto;">
                                            <?php else: ?>
                                                <img src="default.jpg" alt="Varsayılan Resim" style="width:100px; height:auto;">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($ilan['seri_adi']); ?></td>
                                        <td><?php echo htmlspecialchars($ilan['paket_adi']); ?></td>
                                        <td>
                                            <a href="ilandetay.php?ilan_id=<?php echo $ilan['ilan_id']; ?>">
                                                <?php echo htmlspecialchars($ilan['ilan_adi']); ?>
                                            </a>
                                        </td>
                                        <td><?php echo htmlspecialchars($ilan['yil']); ?></td>
                                        <td><?php echo htmlspecialchars($ilan['km']); ?></td>
                                        <td><?php echo htmlspecialchars($ilan['renk_adi']); ?></td>
                                        <td>₺<?php echo htmlspecialchars($ilan['fiyat']); ?></td>
                                        <td><?php echo htmlspecialchars($ilan['tarih']); ?></td>
                                        <td><?php echo htmlspecialchars($ilan['il_adi']) . " / " . htmlspecialchars($ilan['ilce_adi']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php 
include "footer.php";
?>
</body>
</html>
