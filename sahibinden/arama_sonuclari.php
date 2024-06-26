<?php
include "ayar.php";
include "menu.php";

$query = $_GET['query'] ?? '';

$sql = "SELECT * FROM ilan WHERE 1=1";

if ($query) {
    $sql .= " AND ilan_adi LIKE '%$query%'";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arama Sonuçları</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h3>Arama Sonuçları</h3>
        <?php if ($query): ?>
            <p><strong><?php echo htmlspecialchars($query); ?></strong> için arama sonuçları:</p>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <ul class="list-group">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <li class="list-group-item">
                            <a href="ilandetay.php?ilan_id=<?php echo $row['ilan_id']; ?>"><?php echo htmlspecialchars($row['ilan_adi']); ?></a>
                            <p>Fiyat: <?php echo htmlspecialchars($row['fiyat']); ?> TL</p>
                            <p>KM: <?php echo htmlspecialchars($row['km']); ?></p>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>Arama kriterlerinize uyan ilan bulunamadı.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>Arama yapmak için bir kelime girin.</p>
        <?php endif; ?>
    </div>
    <?php include "footer.php"; ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
