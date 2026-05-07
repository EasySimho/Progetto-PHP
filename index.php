<?php
require_once 'includes/db_connect.php';

$category_filter = isset($_GET['category']) ? $_GET['category'] : 'Tutte';
$sql = "SELECT * FROM media_contents";

if ($category_filter != 'Tutte') {
    $sql .= " WHERE category = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $category_filter);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $sql .= " ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanificio Maurizio Sella - Viaggio nel tempo</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Lanificio Maurizio Sella</h1>
        <nav>
            <a href="index.php">Tutti</a>
            <a href="index.php?category=Tradizione">Tradizione</a>
            <a href="index.php?category=Innovazione">Innovazione</a>
            <a href="admin/login.php" style="margin-left: auto;" class="btn">Area Privata</a>
        </nav>
    </header>

    <main>
        <h2>Galleria Multimediale - <?php echo htmlspecialchars($category_filter); ?></h2>
        <div class="gallery">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="gallery-item">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <?php if ($row['media_type'] == 'video'): ?>
                        <video width="100%" controls>
                            <source src="<?php echo htmlspecialchars($row['file_path']); ?>" type="video/mp4">
                            Il tuo browser non supporta i video HTML5.
                        </video>
                    <?php elseif ($row['media_type'] == 'image'): ?>
                        <img src="<?php echo htmlspecialchars($row['file_path']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" width="100%">
                    <?php endif; ?>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Progetto UDA Lanificio Maurizio Sella</p>
    </footer>
</body>
</html>