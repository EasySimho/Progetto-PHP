<?php
session_start();
require_once '../includes/db_connect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    
    // Gestione File
    if (isset($_FILES['media_file']) && $_FILES['media_file']['error'] == 0) {
        $allowed_video = ['video/mp4'];
        $allowed_image = ['image/jpeg', 'image/png', 'image/gif'];
        
        $file_type = $_FILES['media_file']['type'];
        $file_name = time() . "_" . basename($_FILES['media_file']['name']);
        
        if (in_array($file_type, $allowed_video)) {
            $media_type = 'video';
            $target_dir = "../uploads/videos/";
        } elseif (in_array($file_type, $allowed_image)) {
            $media_type = 'image';
            $target_dir = "../uploads/images/";
        } else {
            $error = "Formato file non supportato.";
        }
        
        if (!isset($error)) {
            $target_file = $target_dir . $file_name;
            if (move_uploaded_file($_FILES['media_file']['tmp_name'], $target_file)) {
                // Il path salvato nel DB è relativo alla root del sito
                $db_path = str_replace("../", "", $target_file);
                
                $sql = "INSERT INTO media_contents (title, description, category, media_type, file_path) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssss", $title, $description, $category, $media_type, $db_path);
                
                if (mysqli_stmt_execute($stmt)) {
                    $success = "Contenuto caricato con successo.";
                } else {
                    $error = "Errore nel salvataggio nel DB.";
                }
            } else {
                $error = "Errore durante l'upload del file.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carica Contenuto</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <h1>Lanificio Maurizio Sella - Admin</h1>
        <nav>
            <a href="dashboard.php">Torna alla Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <div class="admin-container">
            <h2>Carica Nuova Immagine o Video</h2>
            
            <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
            <?php if (isset($success)) echo "<p class='text-success'>$success</p>"; ?>
            
            <form method="POST" action="upload.php" enctype="multipart/form-data">
                <label>Titolo:</label>
                <input type="text" name="title" required>
                
                <label>Descrizione:</label>
                <textarea name="description" rows="4"></textarea>
                
                <label>Categoria:</label>
                <select name="category">
                    <option value="Tradizione">Tradizione</option>
                    <option value="Innovazione">Innovazione</option>
                </select>
                
                <label>File (Video MP4 o Immagini):</label>
                <input type="file" name="media_file" accept="video/mp4, image/*" required>
                
                <button type="submit">Carica</button>
            </form>
        </div>
    </main>
</body>
</html>