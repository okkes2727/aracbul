<?php
session_start();
session_destroy(); // Bu Fonksiyon ile tüm Session siliyoruz.
header('Location: index.php');
?>