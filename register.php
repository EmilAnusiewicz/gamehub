<?php

require("db.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = trim($_POST["login"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $password2 = $_POST["password2"];

    if ($password != $password2) {

        $message = "Hasła nie są takie same!";

    } else {

        $check = mysqli_query(
            $conn,
            "SELECT id FROM users WHERE login='$login'"
        );

        if (mysqli_num_rows($check) > 0) {

            $message = "Taki login już istnieje!";

        } else {

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "
            INSERT INTO users(login,email,password)
            VALUES('$login','$email','$hash')
            ";

            if (mysqli_query($conn, $sql)) {

                header("Location: login.php?registered=1");
                exit();

            } else {

                $message = "Błąd podczas rejestracji.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja - GameHub</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<header>
    <div class="logo">
    <i class="fa-solid fa-gamepad"></i>
    GameHub
</div>
    <nav>
        <a href="index.php">Strona główna</a>
        <a href="login.php">Logowanie</a>
        <a href="register.php">Rejestracja</a>
    </nav>
</header>

<div class="auth-container">

    <div class="auth-card">

        <h1>Rejestracja</h1>

        <p class="auth-subtitle">
            Dołącz do społeczności graczy
        </p>

        <?php if($message): ?>
            <div class="error-message">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <label>Login</label>
            <input type="text" name="login" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Hasło</label>
            <input type="password" name="password" required>

            <label>Powtórz hasło</label>
            <input type="password" name="password2" required>

            <button type="submit" class="auth-btn">
                Utwórz konto
            </button>

        </form>

        <div class="auth-footer">
            <p class="auth-text">
                Masz już konto?
            </p>

            <a href="login.php">
                Zaloguj się
            </a>
        </div>

    </div>

</div>

</body>
</html>