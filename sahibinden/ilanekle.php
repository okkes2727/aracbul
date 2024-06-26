<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Seçimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-bs4.min.css" rel="stylesheet">
    <!-- jQuery (gerekli) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-bs4.min.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

      <!-- Summernote CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
</head>

</head>
<body>


<?php
include "ayar.php";
session_start();

if(isset($_SESSION['kullanici_adi'])) {
   
  } else {
    echo "Giriş yapılmamış.";
  }


// İlçeleri ve mahalleleri getirme isteklerini işleme
if(isset($_REQUEST['marka'])) {
    $il = mysqli_real_escape_string($conn, $_REQUEST['marka']);
    $sql = "SELECT * FROM seri WHERE marka_id='$il'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<select name="seri_name" onchange="seri(this.value)">';
        echo '<option value="0">Seri Seçin:</option>';
        while($row = mysqli_fetch_assoc($result)) {
            echo "<option value=".$row['seri_id'].">".$row['seri_adi']."</option>";
        }
        echo '</select>';
        echo '<div id="paket"></div>';
    }
    mysqli_close($conn);
    exit;
}

if(isset($_REQUEST['seri'])) {
    $ilce = mysqli_real_escape_string($conn, $_REQUEST['seri']);
    $sql = "SELECT * FROM paket WHERE seri_id='$ilce'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<select name="paket_name" onchange="paket(this.value)">';
        echo '<option value="0">Paket seçin:</option>';
        while($row = mysqli_fetch_assoc($result)) {
            echo "<option value=".$row['paket_id'].">".$row['paket_adi']."</option>";
        }
        echo '</select>';
    }
    mysqli_close($conn);
    exit;
}


// İlçeleri ve mahalleleri getirme isteklerini işleme
if(isset($_REQUEST['il'])) {
    // İlçeleri getir
    $il = $_REQUEST['il'];
    $sql = "SELECT * FROM ilce WHERE il_id='".$il."'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<select name="ilce_name" onchange="ilce(this.value)">';
        echo '<option value="0">İlce seçin:</option>';
        while($row = mysqli_fetch_assoc($result)) {
            echo "<option value=".$row['ilce_id'].">".$row['ilce_adi']."</option>";
        }
        echo '</select>';
        echo '<div id="mah"></div>';
    }
    mysqli_close($conn);
    exit;
}

if(isset($_REQUEST['ilce'])) {
    // Mahalleleri getir
    $ilce = $_REQUEST['ilce'];
    $sql = "SELECT * FROM mahalle WHERE ilce_id='".$ilce."'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<select name="mahalle_name" onchange="mahalle(this.value)">';
        echo '<option value="0">Mahalle seçin:</option>';
        while($row = mysqli_fetch_assoc($result)) {
            echo "<option value=".$row['mahalle_id'].">".$row['mahalle_adi']."</option>";
        }
        echo '</select>';
    }
    mysqli_close($conn);
    exit;
}






//KASA TİPİ
$kasaTipisql = "SELECT * FROM kasa_tipi";
$result = mysqli_query($conn, $kasaTipisql);

$kasaTipi = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $kasaTipi[$row["kasa_tipi_id"]] = $row["kasa_adi"];
    }
} 

$yakitTurusql = "SELECT * FROM yakit_turu";
$result = mysqli_query($conn, $yakitTurusql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $yakitTuru[$row["yakit_turu_id"]] = $row["tur_adi"];
    }
} else {
    echo "Sorgu çalıştırılamadı: " . mysqli_error($conn);
}

// Vites Türü
$vitesTurusql = "SELECT * FROM vites_turu";
$result_vitesTuru = mysqli_query($conn, $vitesTurusql);   

$vitesTuru = array();
if ($result_vitesTuru) {
    while ($row = $result_vitesTuru->fetch_assoc()) {
        $vitesTuru[$row["vites_turu_id"]] = $row["tur_adi"];
    }
} else {
    echo "Vites türü sorgusunda hata: " . mysqli_error($conn);
}

// Renk
$renksql = "SELECT * FROM renk";
$result_renk = mysqli_query($conn, $renksql);   

$renkler = array();
if ($result_renk) {
    while ($row = $result_renk->fetch_assoc()) {
        $renkler[$row["renk_id"]] = $row["renk_adi"];
    }
} else {
    echo "Renk sorgusunda hata: " . mysqli_error($conn);
}

// Plaka
$plakasql = "SELECT * FROM plaka";
$result_plaka = mysqli_query($conn, $plakasql);   

$plakalar = array();
if ($result_plaka) {
    while ($row = $result_plaka->fetch_assoc()) {
        $plakalar[$row["plaka_id"]] = $row["tur"];
    }
} else {
    echo "Plaka sorgusunda hata: " . mysqli_error($conn);
}

// Motor Gücü
$motorGucusql = "SELECT * FROM motor_gucu";
$result_motorGucu = mysqli_query($conn, $motorGucusql);

$motorGucu = array();
if ($result_motorGucu) {
    while ($row = $result_motorGucu->fetch_assoc()) {
        $motorGucu[$row["motor_gucu_id"]] = $row["guc_degeri"];
    }
} else {
    echo "Motor gücü sorgusunda hata: " . mysqli_error($conn);
}

// Çekiş Türü
$cekisTurusql = "SELECT * FROM cekis";
$result_cekisTuru = mysqli_query($conn, $cekisTurusql);

$cekisTuru = array();
if ($result_cekisTuru) {
    while ($row = $result_cekisTuru->fetch_assoc()) {
        $cekisTuru[$row["cekis_id"]] = $row["cekis_adi"];
    }
} else {
    echo "Çekiş türü sorgusunda hata: " . mysqli_error($conn);
}

// Motor Hacmi
$motorHacmisql = "SELECT * FROM motor_hacmi";
$result_motorHacmi = mysqli_query($conn, $motorHacmisql);

$motorHacmi = array();
if ($result_motorHacmi) {
    while ($row = $result_motorHacmi->fetch_assoc()) {
        $motorHacmi[$row["motor_hacmi_id"]] = $row["hacim_degeri"];
    }
} else {
    echo "Motor hacmi sorgusunda hata: " . mysqli_error($conn);
}


$success = false;
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form']) && $_POST['form'] == 'ilanekle') {
    $aciklama = $_POST['text'];
    $plainText = strip_tags($aciklama);
    
    // Formdan gelen verileri alın
    $selected_marka = $_POST['selected_marka'];
    $selected_seri = $_POST['selected_seri'];
    $selected_paket = $_POST['selected_paket'];
    $ilan_adi = $_POST['ilan_adi'];
    $yil = $_POST['yil']; 
    $yakit_turu_id = $_POST['yakit_turu'];
    $vites_turu_id = $_POST['vites_turu'];
    $km = $_POST['km'];
    $kasa_tipi_id = $_POST['kasa_tipi'];
    $motor_gucu_id = $_POST['motorGucu'];
    $cekis_turu_id = $_POST['cekisTuru'];
    $motor_hacmi_id = $_POST['motorHacmi']; // Motor hacmini ekleyin
    $renk_id = $_POST['renk'];
    $garanti = $_POST['garanti'];
    $hasar_kaydi = $_POST['hasar_kaydi'];
    $plaka_id = $_POST['plaka'];
    $kimden = $_POST['kimden'];
    $takas = $_POST['takas'];
    $fiyat = $_POST['fiyat'];
    $aciklama = $_POST['text'];
    $plainText = strip_tags($aciklama);
 
    
    // Formdan gelen adres bilgilerini al
    $il_id = $_POST['selected_il'];
    $ilce_id = $_POST['selected_ilce'];
    $mahalle_id = $_POST['selected_mahalle'];
    
    $kullanici_id = $_SESSION['kullanici_id'];
    $tarih = date('Y-m-d'); // Mevcut tarihi al

    $sql = "INSERT INTO ilan (
                kullanici_id, marka_id, seri_id, paket_id, ilan_adi, yil, yakit_turu_id, 
                vites_turu_id, cekis_id, km, kasa_tipi_id, motor_gucu_id, renk_id, 
                garanti, hasar_kaydi, plaka_id, kimden, takas, fiyat, ilan_aciklama, 
                il_id, ilce_id, mahalle_id, motor_hacmi_id, tarih
            ) VALUES (
                '$kullanici_id', '$selected_marka', '$selected_seri', '$selected_paket', '$ilan_adi', 
                '$yil', '$yakit_turu_id', '$vites_turu_id', '$cekis_turu_id', '$km', 
                '$kasa_tipi_id', '$motor_gucu_id', '$renk_id', '$garanti', 
                '$hasar_kaydi', '$plaka_id', '$kimden', '$takas', '$fiyat', 
                '$plainText', '$il_id', '$ilce_id', '$mahalle_id', '$motor_hacmi_id', '$tarih'
            )";
    if (mysqli_query($conn, $sql)) {
        // Yeni ilanın ID'sini al
$ilan_id = mysqli_insert_id($conn);
$resimler = $_FILES["resimler"];

if (!empty($resimler) && is_array($resimler["tmp_name"])) {
    foreach ($resimler["tmp_name"] as $key => $tmp_name) {
        if (!empty($tmp_name)) { // Boş resim alanlarını kontrol et
            $resim_name = $resimler["name"][$key];
            $resim_tmp = $resimler["tmp_name"][$key];
            $resim_sira = $key + 1; // Resim sırasını key değerinden alabiliriz
            
            // Resim dosya yolunu belirle
            $hedef_klasor = "img/";
            $resim_yolu = $hedef_klasor . $resim_name;

            // İlan resmini ilan_resim tablosuna ekle
            $resim_ekle_sql = "INSERT INTO ilan_resim (ilan_id, resim, resim_sira) VALUES ($ilan_id, '$resim_yolu', $resim_sira)";
            if (mysqli_query($conn, $resim_ekle_sql)) {
                // Resmi hedef klasöre taşı
                move_uploaded_file($resim_tmp, $resim_yolu);
            } else {
                echo "<div class='alert alert-danger' role='alert'>
                        Resim eklenirken hata: " . mysqli_error($conn) . "
                    </div>";
            }
        }
            }
    
            $success = true;
            $message = "İlan başarıyla eklendi.";
        } else {
            echo "<div class='alert alert-danger' role='alert'>
                    Lütfen bir veya daha fazla resim seçin.
                </div>";
        }
    } 
}
?>
<script>
function marka(id) {
    if (id == "0") {
        document.getElementById("seri").innerHTML = "";
        document.getElementById("paket").innerHTML = "";
        document.getElementById("selected_marka").value = id;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("seri").innerHTML = this.responseText;
                document.getElementById("paket").innerHTML = "";
                document.getElementById("selected_marka").value = id;
            } else if (this.readyState == 4) {
                alert("Bir hata oluştu: " + this.status);
            }
        };
        xmlhttp.open("POST", "ilanekle.php?marka=" + id, true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send();
    }
}

function seri(id) {
    if (id == "0") {
        document.getElementById("paket").innerHTML = "";
        document.getElementById("selected_seri").value = id;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("paket").innerHTML = this.responseText;
                document.getElementById("selected_seri").value = id;
            } else if (this.readyState == 4) {
                alert("Bir hata oluştu: " + this.status);
            }
        };
        xmlhttp.open("POST", "ilanekle.php?seri=" + id, true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send();
    }
}

function paket(id) {
    if (id == "0") {
        document.getElementById("selected_paket").value = "";
    } else {
        document.getElementById("selected_paket").value = id;
    }
}

function submitForm() {
    document.getElementById("ilanForm").submit();
}
</script>


<script>
// JavaScript fonksiyonları burada yer alacak
function il(id) {
    if (id == "0") {
        document.getElementById("ilce").innerHTML = "";
        document.getElementById("mah").innerHTML = "";
        // Seçilen ilin değerini hidden input alanına yaz
        document.getElementById("selected_il").value = id;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ilce").innerHTML = this.responseText;
                document.getElementById("mah").innerHTML = ""; // İlçe seçildiğinde mahalle listesini temizle
                // Seçilen ilin değerini hidden input alanına yaz
                document.getElementById("selected_il").value = id;
            }
        };
        xmlhttp.open("POST", "ilanekle.php?il=" + id, true);
        xmlhttp.send();
    }
}

function ilce(id) {
    if (id == "0") {
        document.getElementById("mah").innerHTML = "";
        // Seçilen ilçenin değerini hidden input alanına yaz
        document.getElementById("selected_ilce").value = id;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("mah").innerHTML = this.responseText;
                // Seçilen ilçenin değerini hidden input alanına yaz
                document.getElementById("selected_ilce").value = id;
            }
        };
        xmlhttp.open("POST", "ilanekle.php?ilce=" + id, true);
        xmlhttp.send();
    }
}

function mahalle(id) {
    if (id == "0") {
        // Mahalle seçimi temizlendiğinde hidden input alanını temizle
        document.getElementById("selected_mahalle").value = "";
    } else {
        // Seçilen mahalle bilgisini hidden input alanına yaz
        document.getElementById("selected_mahalle").value = id;
    }
}

function submitForm() {
    document.getElementById("ilanForm").submit();
}
</script>


<div class="container mt-5">
<center><img src="img/aracbul.jpeg" alt="Araç Bul" width="300px">    </center>
    <h1 class="mb-4">Araç İlanı Ekle</h1>
    <!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İlan Ekle</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <style>
        .form-label {
            font-weight: bold;
        }
        .thumbnail {
            max-width: 150px;
            height: auto;
        }
        .text-truncate {
            max-width: 120px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
<div class="container mt-5">
<?php if ($success): ?>
        <div class='alert alert-success' role='alert'>
            <?= $message ?>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = 'ilanlar.php';
            }, 3000); // 3 saniye sonra yönlendirme
        </script>
    <?php else: ?>

    <h2 class="mb-4 text-center">İlan Ekle</h2>
    <form method="POST" action="ilanekle.php" enctype="multipart/form-data">
        <!-- Marka ve Seri Seçimi -->
        <div class="mb-3">
            <label for="marka_name" class="form-label">Marka Seçin</label>
            <select class="form-select" name="marka_name" id="marka_name" onchange="marka(this.value)">
                <option value="0">Marka seçin:</option>
                <?php 
                $sql = "SELECT * FROM marka";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=".$row['marka_id'].">".$row['marka_adi']."</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div id="seri" class="mb-3"></div>
        <div id="paket" class="mb-3"></div>

        <!-- Gizli input alanları seçilen marka, seri ve paket için -->
        <input type="hidden" name="selected_marka" id="selected_marka">
        <input type="hidden" name="selected_seri" id="selected_seri">
        <input type="hidden" name="selected_paket" id="selected_paket">

        <hr>
        <h4 class="mb-3 text-center">Diğer Özellikler</h4>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="kasaTipi" class="form-label">Kasa Tipi</label>
                <select class="form-select" name="kasa_tipi" id="kasaTipi">
                    <?php
                    foreach ($kasaTipi as $kasaTipiId => $kasa_adi) {
                        echo "<option value='$kasaTipiId'>$kasa_adi</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="yakitTuru" class="form-label">Yakıt Türü</label>
                <select class="form-select" name="yakit_turu" id="yakitTuru">
                    <?php
                    foreach ($yakitTuru as $yakitTuruId => $tur_adi) {
                        echo "<option value='$yakitTuruId'>$tur_adi</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <hr>

        <div class="row mb-3">
            <h4 class="mb-3">Vites Türü</h4>
            <?php
            // Vites türlerini döngüyle radio butonlarına yazdırma
            foreach ($vitesTuru as $key => $value) {
                echo '<div class="form-check col-md-3">';
                echo '<input type="radio" class="form-check-input" id="radio'.$key.'" name="vites_turu" value="'.$key.'"';
                if ($key == 1) { // Örnek olarak otomatik vitesi seçili olarak başlatma
                    echo ' checked';
                }
                echo '>';
                echo '<label class="form-check-label" for="radio'.$key.'">'.$value.'</label>';
                echo '</div>';
            }
            ?>
        </div>

        <hr>

        <div class="mb-3">
            <label for="ilan_adi" class="form-label">İlan Başlığı</label>
            <textarea class="form-control" rows="2" id="ilan_adi" name="ilan_adi"></textarea>
        </div>
        <div class="mb-3">
            <label for="text" class="form-label">Açıklama</label>
            <textarea class="form-control" rows="2" id="text" name="text"></textarea>
        </div>
    </div>


        <hr>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="fiyat" class="form-label">Fiyat</label>
                <input type="text" class="form-control" id="fiyat" name="fiyat">
            </div>
            <div class="col-md-6 mb-3">
                <label for="km" class="form-label">KM</label>
                <input type="text" class="form-control" id="km" name="km">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="renk" class="form-label">Renk</label>
                <select class="form-select" id="renk" name="renk">
                    <?php
                    foreach ($renkler as $renk_id => $renk_adi) {
                        echo "<option value='$renk_id'>$renk_adi</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="garanti" class="form-label">Garanti</label>
                <select class="form-select" id="garanti" name="garanti">
                    <option value="0">Hayır</option>
                    <option value="1">Evet</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="hasar_kaydi" class="form-label">Ağır Hasar Kayıtlı</label>
                <select class="form-select" id="hasar_kaydi" name="hasar_kaydi">
                    <option value="0">Hayır</option>
                    <option value="1">Evet</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="plaka" class="form-label">Plaka / Uyruk</label>
                <select class="form-select" id="plaka" name="plaka">
                    <?php
                    foreach ($plakalar as $plaka_id => $plaka_adi) {
                        echo "<option value='$plaka_id'>$plaka_adi</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="takas" class="form-label">Takaslı</label>
                <select class="form-select" id="takas" name="takas">
                    <option value="0">Hayır</option>
                    <option value="1">Evet</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="motorGucu" class="form-label">Motor Gücü</label>
                <select class="form-select" id="motorGucu" name="motorGucu">
                    <?php
                    foreach ($motorGucu as $motor_gucu_id => $guc_degeri) {
                        echo "<option value='$motor_gucu_id'>$guc_degeri</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="kimden" class="form-label">Kimden</label>
                <select class="form-select" id="kimden" name="kimden">
                    <option value="1">Sahibinden</option>
                    <option value="0">Galeriden</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="yil" class="form-label">Yıl</label>
                <input type="text" class="form-control" id="yil" name="yil">
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="arac_durumu" class="form-label">Aracın Durumu</label>
                <select class="form-select" id="arac_durumu" name="arac_durumu">
                    <option value="0">Sıfır</option>
                    <option value="1">İkinci El</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="cekisTuru" class="form-label">Çekiş Türü</label>
                <select class="form-select" id="cekisTuru" name="cekisTuru">
                    <?php
                    foreach ($cekisTuru as $cekis_id => $cekis_adi) {
                        echo "<option value='$cekis_id'>$cekis_adi</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="motorHacmi" class="form-label">Motor Hacmi</label>
                <select class="form-select" id="motorHacmi" name="motorHacmi">
                    <?php
                    foreach ($motorHacmi as $motor_hacmi_id => $hacim_degeri) {
                        echo "<option value='$motor_hacmi_id'>$hacim_degeri</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <hr>

        <div class="mb-3">
            <h6>Adres Seçin</h6>
            <label for="il_name" class="form-label">İl</label>
            <select class="form-select" name="il_name" id="il_name" onchange="il(this.value)">
                <option value="0">İl seçin:</option>
                <?php 
                // İllerin seçeneklerini getir
                $sql = "SELECT * FROM il";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=".$row['il_id'].">".$row['il_adi']."</option>";
                    }
                }
                ?>
            </select>
            <div id="ilce" class="mt-3"></div>
            <div id="mah" class="mt-3"></div>
            <!-- Hidden input fields for selected il, ilce, and mahalle -->
            <input type="hidden" name="selected_il" id="selected_il">
            <input type="hidden" name="selected_ilce" id="selected_ilce">   
            <input type="hidden" name="selected_mahalle" id="selected_mahalle">
        </div>

        <hr>

        <!-- Fotoğraf yükleme -->
        <div class="mb-3">
            <h4>Fotoğraflar</h4>
            <?php
            $resim_sayisi = isset($_POST["resim_sayisi"]) ? $_POST["resim_sayisi"] : 10;

            for ($i = 1; $i <= $resim_sayisi; $i++) {
                echo '<div class="mb-3">';
                echo '<label for="resim_' . $i . '">Resim ' . $i . ':</label>';
                echo '<input type="file" name="resimler[]" multiple class="form-control">';
                echo '</div>';

                echo '<div class="mb-3">';
                echo '<label for="resim_sira_' . $i . '">Resim ' . $i . ' Sıra:</label>';
                echo '<input type="number" class="form-control" name="resim_sira[]" min="1" value="' . $i . '">';
                echo '</div>';
            }
            ?>
        </div>

        <button type="submit" class="btn btn-primary">Yolla</button>
        <input type="hidden" name="form" value="ilanekle">
    </form>
   
</div>


<a href="index.php"><button  class="btn btn-danger">Anasayfaya Dön</button></a>
<?php endif; ?>
<!-- Bootstrap Bundle with Popper -->

</div>

<script>
    $(document).ready(function() {
        $('#comment').summernote({
            placeholder: 'Buraya yazınız...',
            tabsize: 2,
            height: 150,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });
</script>
<script>
        // CKEditor'u textarea'ya uygulamak
        CKEDITOR.replace('text');
    </script>
<?php
/*

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['resim_ekle'])) {
    // İzin verilen dosya türleri
    $izinVerilenUzantilar = array('jpg', 'jpeg', 'png');

    // Hedef klasör
    $hedefKlasor = $_SERVER['DOCUMENT_ROOT'] . '/sahibinden/img/';

   
    // Son eklenen ilanın ID'sini al
    $sql_last_id = "SELECT MAX(ilan_id) AS last_id FROM ilan";
    $result_last_id = mysqli_query($conn, $sql_last_id);
    $row_last_id = mysqli_fetch_assoc($result_last_id);
    $last_id = $row_last_id['last_id'];

    for ($i = 1; $i <= 10; $i++) {
        // Dosya adını al
        if (isset($_FILES['resim_' . $i]['name']) && !empty($_FILES['resim_' . $i]['name'])) {
            $dosyaAdi = $_FILES['resim_' . $i]['name'];

            // Dosya uzantısını alma
            $dosyaUzantisi = strtolower(pathinfo($dosyaAdi, PATHINFO_EXTENSION));

            // Dosya adını kontrol etme
            if (in_array($dosyaUzantisi, $izinVerilenUzantilar)) {
                // dosya boyutunu kontrol ediyoruz
                if ($_FILES['resim_' . $i]['size'] <= 5 * 1024 * 1024) {
                    // Dosya yolunu belirleme
                    $dosyaYolu = $hedefKlasor . $dosyaAdi;

                    if (move_uploaded_file($_FILES['resim_' . $i]['tmp_name'], $dosyaYolu)) {
                        // Resim sırası
                        $resimSira = isset($_POST['resim_sira_' . $i]) ? $_POST['resim_sira_' . $i] : 0;
                        
                        // İlan resmini veritabanına ekleme
                        $sql_slayt_ekle = "INSERT INTO ilan_resim (ilan_id, , resim, resim_sira) VALUES ('$last_id',  '$dosyaAdi', '$resimSira')";
                        $result = mysqli_query($conn, $sql_slayt_ekle);
                        if ($result) {
                            echo "Resim $i başarıyla eklendi.<br>";    
                        } else {
                            echo "Hata: " . $sql_slayt_ekle . "<br>" . $conn->error;
                        }
                    } else {
                        echo "Resim $i yükleme hatası.<br>";
                    }
                } else {
                    echo "Resim $i boyutu çok büyük. Maksimum 5MB olmalı.<br>";
                }
            } else {
                echo "Resim $i: Geçersiz dosya uzantısı. Sadece JPG, JPEG, PNG ve GIF dosyaları kabul edilir.<br>";
            }
        }
    }
}
*/
?>



<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resim Yükle</title>

</head>
<body>

<?php 
/*
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Resim Yükle</h5>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <div class="form-group">
                                <label for="resim_<?php echo $i; ?>">Resim <?php echo $i; ?>:</label>
                                <input type="file" class="form-control-file" name="resim_<?php echo $i; ?>" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label for="resim_sira_<?php echo $i; ?>">Resim <?php echo $i; ?> Sıra:</label>
                                <input type="number" class="form-control" name="resim_sira_<?php echo $i; ?>" min="1" value="1">
                            </div>
                        <?php endfor; ?>
                        <button type="submit" class="btn btn-primary" name="resim_ekle">Resimleri Ekle</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
*/
?>

<!-- Bootstrap JS ve jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>

<!--
<script>
function validateForm() {
    var selectedFiles = 0;
    for (var i = 1; i <= 10; i++) {
        var fileInput = document.querySelector('input[name="resim_' + i + '"]');
        if (fileInput.files.length > 0) {
            selectedFiles++;
        }
    }
    if (selectedFiles < 3) {
        alert("En az 3 resim seçmelisiniz.");
        return false;
    }
    return true;
}
</script>
-->
</body>
</html>


  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 5 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<!-- Summernote JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>