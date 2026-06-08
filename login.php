<?php

session_start();

require("db.php");

$message = "";
$success = "";

if(isset($_GET["registered"])){
    $success = "Dziękujemy za rejestrację! Możesz się teraz zalogować.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = $_POST["login"];
    $password = $_POST["password"];

    $sql = "
    SELECT *
    FROM users
    WHERE login='$login'
    ";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user["password"])) {

            $_SESSION["id"] = $user["id"];
            $_SESSION["login"] = $user["login"];
            $_SESSION["is_admin"] = $user["is_admin"];

            header("Location: index.php");
            exit();
        }
    }

    $message = "Nieprawidłowy login lub hasło.";
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie - GameHub</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div class="logo">
    <i class="fa-solid fa-gamepad"></i>
    GameHub
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</div>

    <nav>
        <a href="index.php">Strona główna</a>
        <a href="login.php">Logowanie</a>
        <a href="register.php">Rejestracja</a>
    </nav>
</header>

<div class="auth-container">

    <div class="auth-card">

        <h1>Logowanie</h1>

        <p class="auth-subtitle">
            Witaj ponownie w GameHub
        </p>

        <?php if($success): ?>
            <div class="success-message">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <?php if($message): ?>
            <div class="error-message">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <label>Login</label>
            <input type="text" name="login" required>

            <label>Hasło</label>
            <input type="password" name="password" required>

            <button type="submit" class="auth-btn">
                Zaloguj się
            </button>

        </form>

        <div class="auth-footer">
            <p class="auth-text">
                Nie masz konta?
            </p>

            <a href="register.php">
                Zarejestruj się
            </a>
        </div>

    </div>

</div>

</body>
</html>