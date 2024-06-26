<?php
include "ayar.php";
include "menu.php";

if (isset($_SESSION['kullanici_adi'])) {
    $kullanici_id = $_SESSION['kullanici_id'];
} else {
    echo "Giriş yapılmamış.";
    exit; // Giriş yapılmamışsa işlemi sonlandır.
}

$sql = "SELECT * FROM kullanici WHERE kullanici_id = $kullanici_id";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Hesabı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <?php include "panel.php"; ?>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="text-center mt-3">
                    <h3>Kullanıcı Bilgileri</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            ?>
                            <li class="list-group-item">Ad: <?php echo $row["ad"]; ?></li>
                            <li class="list-group-item">Soyad: <?php echo $row["soyad"]; ?></li>
                            <li class="list-group-item">Tel: <?php echo $row["tel"]; ?></li>
                            <li class="list-group-item">E-posta: <?php echo $row["e_posta"]; ?></li>
                        <?php
                        } else {
                            echo "<li class='list-group-item'>Kullanıcı bulunamadı</li>";
                        }
                        ?>
                    </ul>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <button type="submit" class="btn btn-primary mt-3" name="duzenle">Düzenle</button>
                    </form>
                </div>

                <?php
                if (isset($_POST['duzenle'])) {
                    ?>
                    <div class="text-center mt-3">
                        <h3>Güncelle</h3>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group mb-3">
                            <label>Ad:</label>
                            <input type="text" class="form-control" name="ad" value="<?php echo $row['ad']; ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label>Soyad:</label>
                            <input type="text" class="form-control" name="soyad" value="<?php echo $row['soyad']; ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label>Tel:</label>
                            <input type="text" class="form-control" name="tel" value="<?php echo $row['tel']; ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label>E-posta:</label>
                            <input type="text" class="form-control" name="e_posta" value="<?php echo $row['e_posta']; ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label>Şifre:</label>
                            <input type="password" class="form-control" name="sifre" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Şifre (Tekrar):</label>
                            <input type="password" class="form-control" name="sifre_tekrar" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="kaydet">Kaydet</button>
                    </form>
                <?php
                }

                if (isset($_POST['kaydet'])) {
                    $ad = $_POST['ad'];
                    $soyad = $_POST['soyad'];
                    $tel = $_POST['tel'];
                    $e_posta = $_POST['e_posta'];
                    $sifre = $_POST['sifre'];
                    $sifre_tekrar = $_POST['sifre_tekrar'];

                    if ($sifre === $sifre_tekrar) {
                        // Kullanıcı ID'sini al
                        $user_id = $_SESSION['kullanici_id'];

                        // SQL sorgusu ile kullanıcı bilgilerini güncelle
                        $sql = "UPDATE kullanici SET ad='$ad', soyad='$soyad', tel='$tel', e_posta='$e_posta', sifre='$sifre' WHERE kullanici_id='$user_id'";
                        $result = mysqli_query($conn, $sql);

                        if ($result) {
                            echo "<div class='alert alert-success mt-3' role='alert'>Bilgiler başarıyla güncellendi.</div>";
                        } else {
                            echo "<div class='alert alert-danger mt-3' role='alert'>Bilgileri güncelleme başarısız.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger mt-3' role='alert'>Şifreler uyuşmuyor.</div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <?php
    include "footer.php";
    ?>


</body>

</html>
