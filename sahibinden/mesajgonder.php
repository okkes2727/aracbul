

<?php

include "ayar.php";
include "menu.php";

if (isset($_SESSION['kullanici_adi'])) {
    $kullanici_id = $_SESSION['kullanici_id'];
} else {
    echo "Giriş yapılmamış.";
    exit; // Giriş yapılmamışsa işlemi sonlandır.
}

// Form verilerini al
$ilan_id = $_POST['ilan_id'];
$gonderen_id = $_POST['gonderen_id'];
$text = $_POST['text'];

// Mesajı veritabanına ekle
$sql = "INSERT INTO mesajlar (ilan_id, gonderen_id, text, tarih, okundu_durumu) VALUES ($ilan_id, $gonderen_id, '$text', NOW(), 0)";
if ($conn->query($sql) === TRUE) {
    echo "Mesaj başarıyla gönderildi.";
} else {
    echo "Hata: " . $sql . "<br>" . $conn->error;
}

// Veritabanı bağlantısını kapat
$conn->close();

// Mesajlar sayfasına geri dön
header("Location: mesajlar.php?ilan_id=$ilan_id");
exit;
?>
