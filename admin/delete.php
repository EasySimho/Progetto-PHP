<?php
session_start();
require_once '../includes/db_connect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Recupera le info per eliminare il file fisico
    $sql = "SELECT file_path FROM media_contents WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    if ($row) {
        $file_to_delete = "../" . $row['file_path'];
        if (file_exists($file_to_delete)) {
            unlink($file_to_delete);
        }
        
        $sql_delete = "DELETE FROM media_contents WHERE id = ?";
        $stmt_delete = mysqli_prepare($conn, $sql_delete);
        mysqli_stmt_bind_param($stmt_delete, "i", $id);
        mysqli_stmt_execute($stmt_delete);
    }
}
header("Location: dashboard.php");
exit();
?>