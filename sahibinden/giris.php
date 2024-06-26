<?php
session_start(); // Oturumu başlat

include "ayar.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $sifre = $_POST['pswd'];
    
    // Kullanıcı adı ve şifreyi kontrol ettirelim
    $sorgu = "SELECT * FROM kullanici WHERE e_posta='$email' AND sifre='$sifre'"; 
    $calistir = mysqli_query($conn, $sorgu);  
    
    // Döngüyü dizi şeklinde alalım.
    if (mysqli_num_rows($calistir) > 0) { 
        $kullanici = mysqli_fetch_assoc($calistir);
        $_SESSION['kullanici_id'] = $kullanici["kullanici_id"]; // Oturum anahtarını kullanici_id olarak ayarlayın
        $_SESSION['kullanici_adi'] = $kullanici["k_adi"]; // Oturum anahtarını k_adi olarak ayarlayın
        header("Location: index.php");
        exit();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Kullanıcı adı veya parola hatalı</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GİRİŞ YAP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .btn-primary {
            width: 100%;
            border-radius: 25px;
        }
        .form-control {
            border-radius: 10px;
        }
        .text-center {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <div class="text-center py-3">
        <h3><img src="img/aracbul.jpeg" width="300px" alt="Sahibinden Banneri"></h3>

            <p>Size daha iyi bir deneyim sağlayabilmemiz için aracbul.com’a giriş yapmanız gerekmektedir.<br> Hesabınız yoksa ücretsiz bir şekilde hesap açabilirsiniz.</p>
            <h3>Giriş Yap</h3>
        </div>

        <form action="" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">E Posta:</label>
                <input type="email" class="form-control" id="email" placeholder="E postanızı giriniz" name="email" required>
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">Şifre:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Şifrenizi Giriniz" name="pswd" required>
            </div>
            <button type="submit" class="btn btn-primary">E posta ile giriş Yap</button>
            <div class="text-center mt-3">
                <p>Henüz hesap yok mu? <a href="kayit.php" class="btn btn-link">Hesap Aç</a></p>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
