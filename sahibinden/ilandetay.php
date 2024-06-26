<?php
include "ayar.php";
include "menu.php";
$oturum_var = isset($_SESSION['kullanici_id']); 
if (isset($_GET['ilan_id'])) {
    $ilan_id = mysqli_real_escape_string($conn, $_GET['ilan_id']);
    
    
    
     
    $sql = "
        SELECT ilan.*, marka.marka_adi, seri.seri_adi, paket.paket_adi, il.il_adi, ilce.ilce_adi, renk.renk_adi, kullanici.ad, kullanici.soyad, kullanici.tel, cekis.cekis_adi, plaka.tur, kasa_tipi.kasa_adi, mahalle.mahalle_adi, yakit_turu.tur_adi AS yakit_adi
        FROM ilan
        JOIN marka ON ilan.marka_id = marka.marka_id
        JOIN seri ON ilan.seri_id = seri.seri_id
        JOIN paket ON ilan.paket_id = paket.paket_id
        JOIN il ON ilan.il_id = il.il_id
        JOIN ilce ON ilan.ilce_id = ilce.ilce_id
        JOIN renk ON ilan.renk_id = renk.renk_id
        JOIN kullanici ON ilan.kullanici_id = kullanici.kullanici_id
        JOIN cekis ON ilan.cekis_id = cekis.cekis_id
        JOIN plaka ON ilan.plaka_id = plaka.plaka_id
        JOIN kasa_tipi ON ilan.kasa_tipi_id = kasa_tipi.kasa_tipi_id
        JOIN mahalle ON ilan.mahalle_id = mahalle.mahalle_id
        JOIN yakit_turu ON ilan.yakit_turu_id = yakit_turu.yakit_turu_id
        WHERE ilan.ilan_id = '$ilan_id'
    ";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $ilan = mysqli_fetch_assoc($result);

        // Resimleri çekme
        $sql_resim = "SELECT * FROM ilan_resim WHERE ilan_id = $ilan_id ORDER BY resim_sira ASC";
        $result_resim = mysqli_query($conn, $sql_resim);
        $resimler = mysqli_fetch_all($result_resim, MYSQLI_ASSOC);
    } else {
        die("İlan ID belirtilmemiş.");
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['favori_ekle'])) {
    if (!isset($_SESSION['kullanici_adi'])) {
        header("Location: giris.php");
        exit;
    }

    // Kullanıcının favori ekleme işlemi
    $ilan_id = $_POST['ilan_id'];
    $kullanici_id = $_SESSION['kullanici_id'];

    // Aynı ilanı tekrar favoriye eklememek için kontrol
    $sql_check = "SELECT * FROM favori WHERE kullanici_id = $kullanici_id AND ilan_id = $ilan_id";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) == 0) {
        // Favori tablosuna kayıt ekleme
        $sql_insert = "INSERT INTO favori (kullanici_id, ilan_id, favori_durum) VALUES ($kullanici_id, $ilan_id, 1)";
        if (mysqli_query($conn, $sql_insert)) {
            echo "<div class='alert alert-success'>İlan favorilere eklendi.</div>";
        } else {
            echo "<div class='alert alert-danger'>Favori ekleme başarısız.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Bu ilan zaten favorilerinizde.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İlan Detay</title>
    

</head>
<body>
    <div class="container my-3">
        <div class="row">
            <h4><?php echo htmlspecialchars($ilan['ilan_adi']); ?></h4>
        </div>
    </div>
    <div class="container">
        <div class="row">
           <!-- Fotoğraf Kısmı -->
           <div class="col-md-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Ana fotoğraf -->
                            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php if (!empty($resimler)): ?>
                                        <?php foreach ($resimler as $index => $resim): ?>
                                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                                <img src="<?php echo htmlspecialchars($resim['resim']); ?>" class="d-block w-100" alt="İlan Resmi">
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="carousel-item active">
                                            <img src="img/default.jpg" class="d-block w-100" alt="Varsayılan Resim">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <!-- Diğer küçük fotoğraflar -->
                        <div class="col-md-12 text-center">
                            <?php foreach ($resimler as $index => $resim): ?>
                                <img src="<?php echo htmlspecialchars($resim['resim']); ?>" class="thumbnail mx-1" data-bs-target="#carouselExampleControls" data-bs-slide-to="<?php echo $index; ?>" alt="Fotoğraf <?php echo $index + 1; ?>" style="max-width: 85px; height: 80px;">
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
  <!-- Orta Kısım -->
  <div class="col-md-3">
                <div class="container">
                    <h3>₺<?php echo htmlspecialchars($ilan['fiyat']); ?></h3>
                    <br>
                    <strong><p><?php echo htmlspecialchars($ilan['il_adi']) . " / " . htmlspecialchars($ilan['ilce_adi']) . " / " . htmlspecialchars($ilan['mahalle_adi']); ?></p></strong>
                    <table class="table">
                        <tbody>
                            <tr><td><b>İlan No</b></td><td><?php echo htmlspecialchars($ilan['ilan_id']); ?></td></tr>
                            <tr><td><b>İlan Tarihi</b></td><td><?php echo htmlspecialchars($ilan['tarih']); ?></td></tr>
                            <tr><td><b>Marka</b></td><td><?php echo htmlspecialchars($ilan['marka_adi']); ?></td></tr>
                            <tr><td><b>Seri</b></td><td><?php echo htmlspecialchars($ilan['seri_adi']); ?></td></tr>
                            <tr><td><b>Model</b></td><td><?php echo htmlspecialchars($ilan['paket_adi']); ?></td></tr>
                            <tr><td><b>Yıl</b></td><td><?php echo htmlspecialchars($ilan['yil']); ?></td></tr>
                            <tr><td><b>Yakıt</b></td><td><?php echo htmlspecialchars($ilan['yakit_adi']); ?></td></tr>
                            <tr><td><b>Araç Durumu</b></td><td><?php echo htmlspecialchars($ilan['arac_durum']) ? 'Sıfır' : 'İkinci El'; ?></td></tr>
                            <tr><td><b>KM</b></td><td><?php echo htmlspecialchars($ilan['km']); ?></td></tr>
                            <tr><td><b>Kasa Tipi</b></td><td><?php echo htmlspecialchars($ilan['kasa_adi']); ?></td></tr>
                            <tr><td><b>Motor Gücü</b></td><td><?php echo htmlspecialchars($ilan['motor_gucu_id']); ?> hp</td></tr>
                            <tr><td><b>Motor Hacmi</b></td><td><?php echo htmlspecialchars($ilan['motor_hacmi_id']); ?> cc</td></tr>
                            <tr><td><b>Çekiş</b></td><td><?php echo htmlspecialchars($ilan['cekis_adi']); ?></td></tr>
                            <tr><td><b>Renk</b></td><td><?php echo htmlspecialchars($ilan['renk_adi']); ?></td></tr>
                            <tr><td><b>Garanti</b></td><td><?php echo htmlspecialchars($ilan['garanti']) ? 'Evet' : 'Hayır'; ?></td></tr>
                            <tr><td><b>Ağır Hasar Kayıtlı</b></td><td><?php echo htmlspecialchars($ilan['hasar_kaydi']) ? 'Evet' : 'Hayır'; ?></td></tr>
                            <tr><td><b>Plaka / Uyruk</b></td><td><?php echo htmlspecialchars($ilan['tur']); ?></td></tr>
                            <tr><td><b>Kimden</b></td><td><?php echo htmlspecialchars($ilan['kimden']) ? 'Sahibinden' : 'Galeriden'; ?></td></tr>
                            <tr><td><b>Takas</b></td><td><?php echo htmlspecialchars($ilan['takas']) ? 'Evet' : 'Hayır'; ?></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Numara Kısmı -->
            <div class="col-md-4">
    <div class="card" style="width: 400px">
        <div class="card-body">
            <h4 class="card-title"><?php echo htmlspecialchars($ilan['ad']) . " " . htmlspecialchars($ilan['soyad']); ?></h4>
            <div class="card">
                <div class="card-body">
                    <h6><b>Cep:</b> <?php echo htmlspecialchars($ilan['tel']); ?></h6>
                </div>
            </div>
            <br>
           
            <br>
            <form method="POST" action="">
                <input type="hidden" name="ilan_id" value="<?php echo $ilan['ilan_id']; ?>">
                <center><button type="submit" class="btn btn-primary" name="favori_ekle">İlanı Favoriye Ekle</button></center>
            </form>
            <br>
       <center>  <a href="mesaj.php?ilan_id=<?php echo $ilan_id; ?>" class="btn btn-primary" onclick="return oturumKontrol();">Mesaj Gönder</a></center>

        
        </div>
    </div>
</div>

        </div>
    </div>
    <br>

    <div class="container">
        <div class="row">
            <h4>İlan Detayları</h4>
            <div class="card">
                <div class="card-header" id="ilanDetayHeader">
                    <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#ilanDetay" aria-expanded="true" aria-controls="ilanDetay">
                        Açıklama
                    </button>
                </div>
                <div id="ilanDetay" class="collapse" aria-labelledby="ilanDetayHeader">
                    <div class="card-body">
                        <h6><?php echo htmlspecialchars($ilan['ilan_aciklama']); ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
    include "footer.php";
    ?>
</body>
</html>
<script>
        // PHP oturum bilgisini JavaScript'e aktarın
        var oturumVar = <?php echo $oturum_var ? 'true' : 'false'; ?>;
        
        function oturumKontrol() {
            if (!oturumVar) {
                alert('Lütfen giriş yapın');
                return false; // Varsayılan işlemi engelle
            }
            return true; // Varsayılan işlemi izin ver
        }
    </script>