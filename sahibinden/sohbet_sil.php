<?php
include "ayar.php";

session_start();

if (!isset($_SESSION['kullanici_adi'])) {
    echo "Giriş yapılmamış.";
    exit;
}

$current_user_id = $_SESSION['kullanici_id'] ?? null;
$ilan_id = $_GET['ilan_id'] ?? null;

if ($ilan_id) {
    $sql = "DELETE FROM mesaj WHERE ilan_id = $ilan_id AND (alicikullanici_id = $current_user_id OR ilansahibikullanici_id = $current_user_id)";
    if (mysqli_query($conn, $sql)) {
        header("Location: mesajliste.php"); // Mesajlar sayfasına yönlendirin
        exit;
    } else {
        echo "Hata: " . mysqli_error($conn);
    }
} else {
    echo "Geçersiz ilan ID.";
}
?>
