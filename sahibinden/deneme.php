<?php

include "ayar.php";


// Form gönderildiğinde ilanı kaydet
if(isset($_POST['submit'])) {
    $selected_marka = $_POST['selected_marka'];
    $selected_seri = $_POST['selected_seri'];
    $selected_paket = $_POST['selected_paket'];
    
    // İlan tablosuna ekleme işlemi
    $sql = "INSERT INTO ilan (marka_id, seri_id, paket_id) VALUES ('$selected_marka', '$selected_seri', '$selected_paket')";
    
    if (mysqli_query($conn, $sql)) {
        echo "İlan başarıyla eklendi.";
    } else {
        echo "Hata: " . $sql . "<br>" . mysqli_error($conn);
    }
    
    mysqli_close($conn);
}

// İlçeleri ve mahalleleri getirme isteklerini işleme
if(isset($_REQUEST['marka'])) {
    // İlçeleri getir
    $il = $_REQUEST['marka'];
    $sql = "SELECT * FROM seri WHERE seri_id='".$il."'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<select name="seri_name" onchange="seri(this.value)">';
        echo '<option value="0">İlçe seçin:</option>';
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
    // Mahalleleri getir
    $ilce = $_REQUEST['seri'];
    $sql = "SELECT * FROM paket WHERE seri_id='".$ilce."'";
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
?>
<script>
// JavaScript fonksiyonları burada yer alacak
function marka(id) {
    if (id == "0") {
        document.getElementById("seri").innerHTML = "";
        document.getElementById("paket").innerHTML = "";
        // Seçilen markanın değerini hidden input alanına yaz
        document.getElementById("selected_marka").value = id;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("seri").innerHTML = this.responseText;
                document.getElementById("paket").innerHTML = ""; // Marka seçildiğinde seri listesini temizle
                // Seçilen markanın değerini hidden input alanına yaz
                document.getElementById("selected_marka").value = id;
            }
        };
        xmlhttp.open("POST", "deneme.php?marka=" + id, true);
        xmlhttp.send();
    }
}

function seri(id) {
    if (id == "0") {
        document.getElementById("paket").innerHTML = "";
        // Seçilen serinin değerini hidden input alanına yaz
        document.getElementById("selected_seri").value = id;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("paket").innerHTML = this.responseText;
                // Seçilen serinin değerini hidden input alanına yaz
                document.getElementById("selected_seri").value = id;
            }
        };
        xmlhttp.open("POST", "deneme.php?seri=" + id, true);
        xmlhttp.send();
    }
}

function paket(id) {
    if (id == "0") {
        // Paket seçimi temizlendiğinde hidden input alanını temizle
        document.getElementById("selected_paket").value = "";
    } else {
        // Seçilen paketin bilgisini hidden input alanına yaz
        document.getElementById("selected_paket").value = id;
    }
}

function submitForm() {
    document.getElementById("ilanForm").submit();
}
</script>

<div class="row">
    <h6>ADRES SEÇİN</h6>
    <form id="ilanForm" method="post" action="">
        <select name="marka_name" onchange="marka(this.value)">
            <option value="0">Marka seçin:</option>
            <?php 
            // Markaların seçeneklerini getir
            $sql = "SELECT * FROM marka";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<option value=".$row['marka_id'].">".$row['marka_adi']."</option>";
                }
            }
            ?>
        </select>
        <div id="seri"></div>
        <div id="paket"></div>
        <!-- Gizli input alanları seçilen marka, seri ve paket için -->
        <input type="hidden" name="selected_marka" id="selected_marka">
        <input type="hidden" name="selected_seri" id="selected_seri">
        <input type="hidden" name="selected_paket" id="selected_paket">
        <input type="submit" name="submit" value="İlanı Kaydet">
    </form>
</div>