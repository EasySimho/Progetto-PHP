<?php
session_start();
require_once '../includes/db_connect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM media_contents ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <header>
        <h1>Lanificio Maurizio Sella - Admin</h1>
        <nav>
            <a href="upload.php" class="btn">Carica nuovo contenuto</a>
            <a href="../index.php" class="btn">Torna al sito</a>
            <a href="logout.php" class="btn">Logout</a>
        </nav>
    </header>
    <main>
        <h2>Benvenuto, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></h2>

        <h3>Gestione Contenuti</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Titolo</th>
                <th>Categoria</th>
                <th>Tipo</th>
                <th>File</th>
                <th>Azioni</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['category']); ?></td>
                    <td><?php echo htmlspecialchars($row['media_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['file_path']); ?></td>
                    <td>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="action-link danger"
                            onclick="return confirm('Sei sicuro?');">Elimina</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </main>
</body>

</html>