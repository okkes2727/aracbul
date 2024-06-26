<?php
include "ayar.php";

// Son 5 günde eklenmiş 25 ilanı al
$sql = "
    SELECT 
        ilan.ilan_id,
        ilan.ilan_adi,
        ilan.tarih,
        ilan_resim.resim
    FROM ilan
    LEFT JOIN ilan_resim ON ilan.ilan_id = ilan_resim.ilan_id AND ilan_resim.resim_sira = 1
    WHERE ilan.tarih >= NOW() - INTERVAL 40 DAY
    ORDER BY ilan.tarih DESC
    LIMIT 25
";
$result = mysqli_query($conn, $sql);
$ilanlar = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ilanlar[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vitrin İlanlar</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <center><h3>Anasayfa Vitrini</h3></center>
                <hr>
                <!-- Küçük resimler ve başlıklar -->
                <div class="row">
                    <?php foreach ($ilanlar as $ilan): ?>
                        <div class="col-md-2 mb-4">
                            <div class="card text-center">
                                <a href="ilandetay.php?ilan_id=<?php echo $ilan['ilan_id']; ?>">
                                    <?php if (!empty($ilan['resim'])): ?>
                                        <img src="<?php echo htmlspecialchars($ilan['resim']); ?>" class="card-img-top thumbnail" alt="İlan Resmi">
                                    <?php else: ?>
                                        <img src="default.jpg" class="card-img-top thumbnail" alt="Varsayılan Resim">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h6 class="card-title text-truncate"><?php echo htmlspecialchars($ilan['ilan_adi']); ?></h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h3>Otomobil Kategorisi Hakkında Daha Fazla Bilgi</h3>
                <p class="mt-3">
                    Ulaşımda lüks olmaktan çıkıp büyük bir çoğunluk için zorunluluk haline gelmiş olan otomobil modelleri, çok çeşitli donanım seviyeleri ile kategorimizde yer alıyor. Her zevke ve bütçeye hitap eden sıfır ve ikinci el yüz binlerce otomobil ilanının yer aldığı kategori, hayallerdeki modele en hızlı şekilde ulaşabilmenin yolunu açıyor.
                </p>
                <p>
                    Araba ilanları için yapacağınız aramalarda fiyat aralığının yanında, araç model yılı, vites tipi, kasa tipi, yakıt türü, araç kilometresi, motor hacmi, motor gücü, çekiş tipi, renk, garanti ve donanım özellikleri gibi birçok seçeneği kendiniz belirleyerek ilan sayısını sınırlandırabilir ve istediğiniz modele çok daha kolay bir şekilde ulaşabilirsiniz. Anahtar kelime araması yaparak istediğiniz sonuçlara daha hızlı şekilde ulaşabilir ve özelleştirdiğiniz arama kriterlerinizi kaydedebilirsiniz.
                </p>
                <p>
                    Volkswagen’den Mercedes’e, BMW’den Audi’ye, Honda’dan Chevrolet’ye, Toyota’dan Ferrari’ye ve Ford’dan Hyundai’ye tüm otomobil markaları, farklı donanım seviyelerindeki Sedan, Hatchback, Coupe, Cabrio ve Station Wagon modelleri ile kategorimizdeki ilanlarda yer alıyor. İkinci el otomobil modellerin yanında tercihinizi sıfır kilometre bir araç satın almaktan yana kullanmak isterseniz de bayiye gitmeden önce kategorimizdeki ilanlara göz atarak sıfır otomobil fiyatları hakkında bilgi sahibi olabilir ve hayalinizdeki modele avantajlı fiyatlarla sahip olabilirsiniz.
                </p>
                <p>
                    İlanlarda yer alan yüksek kaliteli fotoğraflardan ve videolardan ilgilendiğiniz modeli incelerken, ilan sahibinin açıklamalarını okuyarak detaylı bilgilere de ulaşabilirsiniz. Almak istediğiniz araçla ilgili olarak satıcı ile telefon ya da mesajla irtibata geçerek ayrıntıları konuşabilir ya da pazarlık yapabilirsiniz. Tüm bunların yanında kendi aracınızı satmak için de ücretsiz üyelik işlemlerinin ardından, birkaç basit adımda kategorimize ilan verebilir, ilanınızın ön plana çıkarak daha fazla görüntülenebilmesi ve kısa sürede satılabilmesi için de vitrin ve doping hizmetlerimizden uygun ücret ve kolay ödeme koşullarıyla faydalanabilirsiniz.
                </p>
            </div>
        </div>
    </div>

  
</body>
</html>
