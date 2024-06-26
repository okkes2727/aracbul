<?php
include "ayar.php"; // Veritabanı bağlantısı

if (isset($_REQUEST['marka'])) {
    $il = mysqli_real_escape_string($conn, $_REQUEST['marka']);
    $sql = "SELECT * FROM seri WHERE marka_id='$il'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<select name="seri_name" onchange="seri(this.value)" class="form-select mb-3">';
        echo '<option value="0">Tüm Serileri Göster</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value=\"" . $row['seri_id'] . "\">" . $row['seri_adi'] . "</option>";
        }
        echo '</select>';
        echo '<div id="paket"></div>';
    }
    mysqli_close($conn);
    exit;
}

if (isset($_REQUEST['seri'])) {
    $ilce = mysqli_real_escape_string($conn, $_REQUEST['seri']);
    $sql = "SELECT * FROM paket WHERE seri_id='$ilce'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<select name="paket_name" onchange="paket(this.value)" class="form-select mb-3">';
        echo '<option value="0">Tüm Paketleri Göster</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value=\"" . $row['paket_id'] . "\">" . $row['paket_adi'] . "</option>";
        }
        echo '</select>';
    }
    mysqli_close($conn);
    exit;
}


if (isset($_GET['il'])) {
    $il = mysqli_real_escape_string($conn, $_GET['il']);
    $sql = "SELECT * FROM ilce WHERE il_id='$il'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="checkbox" name="ilce_id[]" value="' . $row['ilce_id'] . '" id="ilce' . $row['ilce_id'] . '">';
            echo '<label class="form-check-label" for="ilce' . $row['ilce_id'] . '">' . htmlspecialchars($row['ilce_adi']) . '</label>';
            echo '</div>';
        }
    }
    mysqli_close($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtre Formu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .scrollable-checkboxes {
            max-height: 150px;
            overflow-y: auto;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
        }
        .fixed-button {
            position: fixed;
            bottom: 20px;
            left: 210px;
        }

        
        .bold-title {
    font-weight: bold;
  }

    </style>
</head>
<body>
<div style="height: 1000px; overflow-y: auto;">

<form id="ilanForm" action="index.php" method="POST" class="container mt-4">
        <!-- Marka Seçimi -->
        <div class="mb-3">
            <label for="marka_name" class="form-label bold-title">Marka</label>
            <select name="marka_name" id="marka_name" onchange="marka(this.value)" class="form-select">
                <option value="0">Tüm Markaları Göster</option>
                <?php 
                $sql = "SELECT * FROM marka";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"" . $row['marka_id'] . "\">" . $row['marka_adi'] . "</option>";
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

        <div class="mb-3">
    <label class="form-label bold-title">İl:</label>
    <div class="scrollable-checkboxes">
        <?php
        $result = mysqli_query($conn, "SELECT il_id, il_adi FROM il");
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="checkbox" name="il_id[]" value="' . $row['il_id'] . '" id="il' . $row['il_id'] . '" onclick="il(this.value)">';
            echo '<label class="form-check-label" for="il' . $row['il_id'] . '">' . htmlspecialchars($row['il_adi']) . '</label>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<!-- İlçe Seçimi (Checkboxes) -->
<div class="mb-3">
    <label class="form-label bold-title">İlçe:</label>
    <div id="ilceContainer" class="scrollable-checkboxes" style="display: none;"></div>
</div>

    <hr>

    <!-- Fiyat Aralığı -->
    <div class="mb-3">
        <label for="min_fiyat"  class="form-label bold-title">Minimum Fiyat (₺)</label>
        <input type="number" class="form-control" id="min_fiyat" name="min_fiyat" placeholder="Minimum Fiyat">
    </div>
    <div class="mb-3">
        <label for="max_fiyat" class="form-label bold-title">Maksimum Fiyat (₺)</label>
        <input type="number" class="form-control" id="max_fiyat" name="max_fiyat" placeholder="Maksimum Fiyat">
    </div>
    <hr>
    <!-- Yıl Aralığı -->
    <div class="mb-3">
        <label for="min_yil"  class="form-label bold-title">Minimum Yıl</label>
        <input type="number" class="form-control"```php
        id="min_yil" name="min_yil" placeholder="Minimum Yıl">
    </div>
    <div class="mb-3">
        <label for="max_yil" class="form-label bold-title">Maksimum Yıl</label>
        <input type="number" class="form-control" id="max_yil" name="max_yil" placeholder="Maksimum Yıl">
    </div>
    <hr>
    <!-- KM Aralığı -->
    <div class="mb-3">
        <label for="min_km" class="form-label bold-title">Minimum Km</label>
        <input type="number" class="form-control" id="min_km" name="min_km" placeholder="Minimum km">
    </div>
    <div class="mb-3">
        <label for="max_km" class="form-label bold-title">Maksimum Km</label>
        <input type="number" class="form-control" id="max_km" name="max_km" placeholder="Maksimum km">
    </div>
    <hr>
    <!-- Yakıt Türü Seçimi (Checkbox) -->
    <div class="form-group mb-2">
        <label  class="form-label bold-title">Yakıt Türü</label>
        <br>
        <?php
        $result = mysqli_query($conn, "SELECT yakit_turu_id, tur_adi FROM yakit_turu");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='form-check form-check-inline'>";
            echo "<input class='form-check-input' type='checkbox' name='yakit_turu_id[]' value='" . $row['yakit_turu_id'] . "' id='yakit" . $row['yakit_turu_id'] . "'>";
            echo "<label class='form-check-label' for='yakit" . $row['yakit_turu_id'] . "'>" . $row['tur_adi'] . "</label>";
            echo "</div>";
        }
        ?>
    </div>
    <hr>
    <!-- Vites Türü Seçimi (Checkbox) -->
    <div class="form-group mb-2">
        <label  class="form-label bold-title">Vites Türü:</label>
        <?php
        $result = mysqli_query($conn, "SELECT vites_turu_id, tur_adi FROM vites_turu");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='form-check form-check-inline'>";
            echo "<input class='form-check-input' type='checkbox' name='vites_turu_id[]' value='" . $row['vites_turu_id'] . "' id='vites" . $row['vites_turu_id'] . "'>";
            echo "<label class='form-check-label' for='vites" . $row['vites_turu_id'] . "'>" . $row['tur_adi'] . "</label>";
            echo "</div>";
        }
        ?>
    </div>
 <!-- Kasa Tipi Seçimi (Checkbox) -->
 <div class="form-group mb-2">
            <label  class="form-label bold-title">Kasa Tipi</label>
            <br>
            <?php
            $result = mysqli_query($conn, "SELECT kasa_tipi_id, kasa_adi FROM kasa_tipi");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='form-check form-check-inline'>";
                echo "<input class='form-check-input' type='checkbox' name='kasa_tipi_id[]' value='" . $row['kasa_tipi_id'] . "' id='kasaTipi" . $row['kasa_tipi_id'] . "'>";
                echo "<label class='form-check-label' for='kasaTipi" . $row['kasa_tipi_id'] . "'>" . $row['kasa_adi'] . "</label>";
                echo "</div>";
            }
            ?>
        </div>
    <div class="form-group mb-2">
        <label  class="form-label bold-title">Çekiş</label>
        <br>
        <?php
        $result = mysqli_query($conn, "SELECT cekis_id, cekis_adi FROM cekis");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='form-check form-check-inline'>";
            echo "<input class='form-check-input' type='checkbox' name='cekis_id[]' value='" . $row['cekis_id'] . "' id='cekis" . $row['cekis_id'] . "'>";
            echo "<label class='form-check-label' for='cekis" . $row['cekis_id'] . "'>" . $row['cekis_adi'] . "</label>";
            echo "</div>";
        }
        ?>
    </div>
    <hr>
    <!-- Renk Seçimi (Checkbox) -->
    <div class="form-group mb-2">
        <label  class="form-label bold-title">Renk</label>
        <br>
        <?php
        $result = mysqli_query($conn, "SELECT renk_id, renk_adi FROM renk");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='form-check form-check-inline'>";
            echo "<input class='form-check-input' type='checkbox' name='renk_id[]' value='" . $row['renk_id'] . "' id='renk" . $row['renk_id'] . "'>";
            echo "<label class='form-check-label' for='renk" . $row['renk_id'] . "'>" . $row['renk_adi'] . "</label>";
            echo "</div>";
        }
        ?>
    </div>
    <hr>
    <!-- Motor Gücü Seçenekleri -->
    <div>
    <label  class="form-label bold-title">Motor Gücü:</label>
    <br>
        <input type="checkbox" name="motor_gucu[]" value="1-50" id="mg1"><label for="mg1">1 - 50 HP</label><br>
        <input type="checkbox" name="motor_gucu[]" value="51-100" id="mg2"><label for="mg2">51 - 100 HP</label><br>
        <input type="checkbox" name="motor_gucu[]" value="101-150" id="mg3"><label for="mg3">101 - 150 HP</label><br>
        <input type="checkbox" name="motor_gucu[]" value="151-200" id="mg4"><label for="mg4">151 - 200 HP</label><br>
        <input type="checkbox" name="motor_gucu[]" value="201-250" id="mg5"><label for="mg5">201- 250 HP</label><br>
        <input type="checkbox" name="motor_gucu[]" value="251-300" id="mg6"><label for="mg6">251 - 300 HP</label><br>
        <input type="checkbox" name="motor_gucu[]" value="301-400" id="mg7"><label for="mg7">301 - 400 HP</label><br>
        <input type="checkbox" name="motor_gucu[]" value="401-500" id="mg8"><label for="mg8">401 - 500 HP</label><br>
        <input type="checkbox" name="motor_gucu[]" value="501-600" id="mg9"><label for="mg9">501- 600 HP</label><br>
        <input type="checkbox" name="motor_gucu[]" value="601-700" id="mg10"><label for="mg10">601 - 700 HP</label><br>
        <input type="checkbox" name="motor_gucu[]" value="701-800" id="mg11"><label for="mg11">701 - 800 HP</label><br>
        <input type="checkbox" name="motor_gucu[]" value="801-900" id="mg12"><label for="mg12">801 - 900 HP</label><br>
        <input type="checkbox" name="motor_gucu[]" value="901-1000" id="mg13"><label for="mg13">901- 1000 HP</label><br>
    </div>
    <hr>
    <!-- Motor Hacmi Seçenekleri -->
    <div>
    <label  class="form-label bold-title">Motor Hacmi:</label>
    <br>
        <input type="checkbox" name="motor_hacmi[]" value="0-1000" id="mh1"><label for="mh1">0 - 1000 cm³</label><br>
        <input type="checkbox" name="motor_hacmi[]" value="1001-1600" id="mh2"><label for="mh2">1001 - 1600 cm³</label><br>
        <input type="checkbox" name="motor_hacmi[]" value="1601-2000" id="mh3"><label for="mh3">1601 - 2000 cm³</label><br>
        <input type="checkbox" name="motor_hacmi[]" value="2001-2500" id="mh4"><label for="mh4">2001 - 2500 cm³</label><br>
        <input type="checkbox" name="motor_hacmi[]" value="2501-3000" id="mh5"><label for="mh5">2501 - 3000 cm³</label><br>
        <input type="checkbox" name="motor_hacmi[]"```php
        value="3001-3500" id="mh6"><label for="mh6">3001 - 3500 cm³</label><br>
        <input type="checkbox" name="motor_hacmi[]" value="3501-4000" id="mh7"><label for="mh7">3501 - 4000 cm³</label><br>
        <input type="checkbox" name="motor_hacmi[]" value="4001-4500" id="mh8"><label for="mh8">4001 - 4500 cm³</label><br>
        <input type="checkbox" name="motor_hacmi[]" value="4501-5000" id="mh9"><label for="mh9">4501 - 5000 cm³</label><br>
        <input type="checkbox" name="motor_hacmi[]" value="5001-5500" id="mh10"><label for="mh10">5001 - 5500 cm³</label><br>
        <input type="checkbox" name="motor_hacmi[]" value="5501-6000" id="mh11"><label for="mh11">5501 - 6000 cm³</label><br>
        <input type="checkbox" name="motor_hacmi[]" value="6000" id="mh12"><label for="mh12">6000 cm³ ve üzeri</label><br>
    </div>
    <hr>
  
    <div class="col-md-12">
        <p class="form-label bold-title">Plaka</p>
        <?php
        $result = mysqli_query($conn, "SELECT plaka_id, tur FROM plaka");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='form-check'>";
            echo "<input class='form-check-input' type='checkbox' name='plaka_id[]' value='" . $row['plaka_id'] . "' id='plaka" . $row['plaka_id'] . "'>";
            echo "<label class='form-check-label' for='plaka" . $row['plaka_id'] . "'>" . $row['tur'] . "</label>";
            echo "</div>";
        }
        ?>
    </div>
    <hr>
    <div class="col-md-6">
        <label class="form-check-label bold-title">Garanti Durumu</label>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="garanti[]" value="1" id="garantili">
            <label class="form-check-label" for="garantili">Garantili</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="garanti[]" value="0" id="garantisiz">
            <label class="form-check-label" for="garantisiz">Garantisiz</label>
        </div>
    </div>
        <hr>
    <div class="col-md-6">
        <label class="form-check-label bold-title">Hasar Kaydı</label>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="hasar_kaydi[]" value="1" id="hasar_kaydi">
            <label class="form-check-label" for="hasar_kaydi">Evet</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="hasar_kaydi[]" value="0" id="hasar_kaydi">
            <label class="form-check-label" for="hasar_kaydi">Hayır</label>
        </div>
    </div>
    <hr>
    <div class="col-md-6">
        <p class="form-label bold-title">Kimden</p>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="kimden" value="1" id="sahibinden">
            <label class="form-check-label" for="sahibinden">Sahibinden</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="kimden" value="0" id="galeriden">
            <label class="form-check-label" for="galeriden">Galeriden</label>
        </div>
    </div>
    <hr>
    <div class="col-md-6">
        <p class="form-label bold-title">Takas</p>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="takas" value="1" id="evet">
            <label class="form-check-label" for="evet">Evet</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="takas" value="0" id="hayır">
            <label class="form-check-label" for="hayır">Hayır</label>
        </div>
    </div>
    <hr>
    <div class="col-md-6">
        <p class="form-label bold-title">Araç Durumu</p>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="arac_durum" value="1" id="sıfır">
            <label class="form-check-label" for="sıfır">Sıfır</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="arac_durum" value="0" id="ikinci_el">
            <label class="form-check-label" for="ikinci_el">İkinci El</label>
        </div>
    </div>

    <div style="position: fixed; bottom: 20px; left: 210px;">
        <button class="btn btn-primary" onclick="submitForm()" type="button">Filtrele</button>
    </div>
</form>

</div>
<script>
        function il(id) {
    var ilceContainer = document.getElementById("ilceContainer");

    if (id == "0") {
        ilceContainer.style.display = "none";
        ilceContainer.innerHTML = "";
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                ilceContainer.innerHTML = this.responseText;
                ilceContainer.style.display = "block";
            } else if (this.readyState == 4) {
                console.error("Bir hata oluştu: " + this.status);
            }
        };
        xmlhttp.open("GET", "filtre.php?il=" + id, true);
        xmlhttp.send();
    }
}

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
                xmlhttp.open("POST", "filtre.php?marka=" + id, true);
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
                xmlhttp.open("POST", "filtre.php?seri=" + id, true);
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