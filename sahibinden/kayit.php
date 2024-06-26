<?php
include "ayar.php";

if(isset($_SESSION['kullanici_adi'])) {
  echo "Hoşgeldin, " . $_SESSION['k_adi'];
} else {
 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
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
        .alert-danger {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-3">
    <div class="text-center py-3">
        <h3><img src="img/aracbul.jpeg" width="300px" height="auto" alt="Sahibinden Banneri"></h3>
        <p>Size daha iyi bir deneyim sağlayabilmemiz için aracbul.com’a giriş yapmanız gerekmektedir.<br> Hesabınız yoksa ücretsiz bir şekilde hesap açabilirsiniz.</p>
        <h3>Kayıt Ol</h3>
    </div>

    <form action="kayit.php" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">E posta:</label>
            <input type="email" class="form-control" id="email" placeholder="E posta Giriniz" name="email" required>
        </div>
        <div class="mb-3">
            <label for="pwd" class="form-label">Şifre:</label>
            <input type="password" class="form-control" id="pwd" placeholder="Şifre Giriniz" name="pswd" required>
        </div>
        <div class="row">
            <div class="col">
                <label for="ad" class="form-label">Ad</label>
                <input type="text" class="form-control" placeholder="Ad Giriniz" id="ad" name="ad" required>
            </div>
            <div class="col">
                <label for="soyad" class="form-label">Soyad</label>
                <input type="text" class="form-control" placeholder="Soyad Giriniz" id="soyad" name="soyad" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="tel" class="form-label">Telefon</label>
            <input type="tel" class="form-control" placeholder="Telefon Giriniz" id="tel" name="tel" required>
        </div>
        <button type="submit" class="btn btn-primary">Kayıt Ol</button>
        <div class="text-center mt-3">
            <p>Zaten hesabın var mı? <a href="giris.php" class="btn btn-link">Giriş yap</a></p>
        </div>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $eposta = $_POST['email'];
        $sifre = $_POST['pswd'];
        $ad = $_POST['ad'];
        $soyad = $_POST['soyad'];
        $tel = $_POST['tel'];

        $ekle = "INSERT INTO kullanici (e_posta, sifre, ad, soyad, tel) VALUES ('$eposta', '$sifre', '$ad', '$soyad', '$tel')";
        $calistir = mysqli_query($conn, $ekle);
        if ($calistir) {
            header("Location: index.php"); // Başka bir sayfaya yönlendir
            exit();
        } else {
            echo "<div class='alert alert-danger' role='alert'>
            <strong>Hata!</strong> Kayıt işlemi sırasında bir hata oluştu. Lütfen tekrar deneyiniz.
          </div>";
        }
    }
    ?>
</div>

<div class="container text-center mt-5">
    <p>aracbul.com'da yer alan kullanıcıların oluşturduğu tüm içerik, görüş ve bilgilerin doğruluğu, eksiksiz ve değişmez olduğu, yayınlanması ile ilgili yasal yükümlülükler içeriği oluşturan kullanıcıya aittir. Bu içeriğin, görüş ve bilgilerin yanlışlık, eksiklik veya yasalarla düzenlenmiş kurallara aykırılığından sahibinden.com hiçbir şekilde sorumlu değildir. Sorularınız için ilan sahibi ile irtibata geçebilirsiniz.</p>
    <br>
    <i>Copyright © 2024-2024 aracbul.com</i>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
