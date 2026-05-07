<?php
session_start();
require_once '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password_hash FROM admins WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_username'] = $row['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Password errata.";
        }
    } else {
        $error = "Utente non trovato.";
    }
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Amministratore</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <header>
        <h1>Lanificio Maurizio Sella</h1>
        <nav>
            <a href="../index.php" class="btn">Torna al sito</a>
        </nav>
    </header>
    <main>
        <div class="admin-container">
            <h2>Area Amministrativa - Login</h2>
            <?php if (isset($error))
                echo "<p class='text-danger'>$error</p>"; ?>
            <form method="POST" action="login.php">
                <label>Username:</label>
                <input type="text" name="username" required>
                <label>Password:</label>
                <input type="password" name="password" required>
                <button type="submit" class="btn">Accedi</button>
            </form>
        </div>
    </main>
</body>

</html>