<?php
include "ayar.php";
include "menu.php";

if (!isset($_SESSION['kullanici_adi'])) {
    echo "Giriş yapılmamış.";
    exit;
}

$ilan_id = $_GET['ilan_id'];
$kullanici_id = $_SESSION['kullanici_id'];

// İlan bilgilerini çek
$sql = "SELECT * FROM ilan WHERE ilan_id = $ilan_id AND kullanici_id = $kullanici_id";
$result = mysqli_query($conn, $sql);
$ilan = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['guncelle'])) {
        $ilan_adi = $_POST['ilan_adi'];
        $fiyat = $_POST['fiyat'];
        $yil = $_POST['yil'];
        $km = $_POST['km'];
        $renk_id = $_POST['renk_id'];
        $vites_turu_id = $_POST['vites_turu_id'];
        $yakit_turu_id = $_POST['yakit_turu_id'];
        $arac_durum = $_POST['arac_durum'];
        $garanti = $_POST['garanti'];
        $hasar_kaydi = $_POST['hasar_kaydi'];
        $takas = $_POST['takas'];
        $aciklama = $_POST['aciklama'];

        // HTML etiketlerini kaldırmak için strip_tags kullanın
        $plainText = strip_tags($aciklama);

        // İlanı güncelle
        $sql = "UPDATE ilan SET
                    ilan_adi = '$ilan_adi',
                    fiyat = '$fiyat',
                    yil = '$yil',
                    km = '$km',
                    renk_id = '$renk_id',
                    vites_turu_id = '$vites_turu_id',
                    yakit_turu_id = '$yakit_turu_id',
                    arac_durum = '$arac_durum',
                    garanti = '$garanti',
                    hasar_kaydi = '$hasar_kaydi',
                    takas = '$takas',
                    ilan_aciklama = '$plainText'
                WHERE ilan_id = $ilan_id AND kullanici_id = $kullanici_id";
        
        if (mysqli_query($conn, $sql)) {
            echo "<div class='alert alert-success'>İlan başarıyla güncellendi.</div>";
        } else {
            echo "<div class='alert alert-danger'>İlan güncellenemedi: " . mysqli_error($conn) . "</div>";
        }
    } elseif (isset($_POST['sil'])) {
        // İlanı sil
        $sql = "DELETE FROM ilan WHERE ilan_id = $ilan_id AND kullanici_id = $kullanici_id";
        
        if (mysqli_query($conn, $sql)) {
            echo "<div class='alert alert-success'>İlan başarıyla silindi.</div>";
            header("Location: ilanlarim.php");
            exit;
        } else {
            echo "<div class='alert alert-danger'>İlan silinemedi: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İlanı Düzenle</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CKEditor CDN -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">İlanı Düzenle</h2>
        <form method="POST" action="ilanduzenle.php?ilan_id=<?php echo $ilan_id; ?>">
            <div class="mb-3">
                <label for="ilan_adi" class="form-label">İlan Başlığı</label>
                <input type="text" class="form-control" id="ilan_adi" name="ilan_adi" value="<?php echo htmlspecialchars($ilan['ilan_adi']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="fiyat" class="form-label">Fiyat</label>
                <input type="text" class="form-control" id="fiyat" name="fiyat" value="<?php echo htmlspecialchars($ilan['fiyat']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="yil" class="form-label">Yıl</label>
                <input type="text" class="form-control" id="yil" name="yil" value="<?php echo htmlspecialchars($ilan['yil']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="km" class="form-label">Kilometre</label>
                <input type="text" class="form-control" id="km" name="km" value="<?php echo htmlspecialchars($ilan['km']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="renk_id" class="form-label">Renk</label>
                <select class="form-select" id="renk_id" name="renk_id" required>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM renk");
                    while ($row = mysqli_fetch_assoc($result)) {
                        $selected = $ilan['renk_id'] == $row['renk_id'] ? 'selected' : '';
                        echo "<option value='{$row['renk_id']}' $selected>{$row['renk_adi']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="vites_turu_id" class="form-label">Vites Türü</label>
                <select class="form-select" id="vites_turu_id" name="vites_turu_id" required>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM vites_turu");
                    while ($row = mysqli_fetch_assoc($result)) {
                        $selected = $ilan['vites_turu_id'] == $row['vites_turu_id'] ? 'selected' : '';
                        echo "<option value='{$row['vites_turu_id']}' $selected>{$row['tur_adi']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="yakit_turu_id" class="form-label">Yakıt Türü</label>
                <select class="form-select" id="yakit_turu_id" name="yakit_turu_id" required>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM yakit_turu");
                    while ($row = mysqli_fetch_assoc($result)) {
                        $selected = $ilan['yakit_turu_id'] == $row['yakit_turu_id'] ? 'selected' : '';
                        echo "<option value='{$row['yakit_turu_id']}' $selected>{$row['tur_adi']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="arac_durum" class="form-label">Araç Durumu</label>
                <select class="form-select" id="arac_durum" name="arac_durum" required>
                    <option value="1" <?php if ($ilan['arac_durum'] == 1) echo 'selected'; ?>>Sıfır</option>
                    <option value="0" <?php if ($ilan['arac_durum'] == 0) echo 'selected'; ?>>İkinci El</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="garanti" class="form-label">Garanti</label>
                <select class="form-select" id="garanti" name="garanti" required>
                    <option value="1" <?php if ($ilan['garanti'] == 1) echo 'selected'; ?>>Evet</option>
                    <option value="0" <?php if ($ilan['garanti'] == 0) echo 'selected'; ?>>Hayır</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="hasar_kaydi" class="form-label">Hasar Kaydı</label>
                <select class="form-select" id="hasar_kaydi" name="hasar_kaydi" required>
                    <option value="1" <?php if ($ilan['hasar_kaydi'] == 1) echo 'selected'; ?>>Evet</option>
                    <option value="0" <?php if ($ilan['hasar_kaydi'] == 0) echo 'selected'; ?>>Hayır</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="takas" class="form-label">Takas</label>
                <select class="form-select" id="takas" name="takas" required>
                    <option value="1" <?php if ($ilan['takas'] == 1) echo 'selected'; ?>>Evet</option>
                    <option value="0" <?php if ($ilan['takas'] == 0) echo 'selected'; ?>>Hayır</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="aciklama" class="form-label">Açıklama</label>
                <textarea class="form-control" id="aciklama" name="aciklama" rows="4" required><?php echo htmlspecialchars($ilan['ilan_aciklama']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="guncelle">Güncelle</button>
            <button type="submit" class="btn btn-danger" name="sil" onclick="return confirm('İlanı silmek istediğinize emin misiniz?')">Sil</button>
        </form>
    </div>

    <!-- CKEditor'u açıklama alanına uygulamak için JavaScript kodu -->
    <script>
        CKEDITOR.replace('aciklama');
    </script>

    <?php include "footer.php"; ?>
</body>
</html>
