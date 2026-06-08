<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(
    !isset($_SESSION["id"])
    || $_SESSION["is_admin"] != 1
){
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="10;url=index.php">
    <title>Brak dostępu</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="auth-container">

    <div class="auth-card">

        <div class="auth-logo">
            🎮 <span>GameHub</span>
        </div>

        <h1>Brak uprawnień</h1>

        <div class="error-message">

            Musisz posiadać konto administratora,
            aby uzyskać dostęp do tej strony.

        </div>

        <p class="auth-subtitle">

            Jeżeli uważasz, że to błąd,
            skontaktuj się z administratorem:

            <br><br>

            <strong>
                ea93369@stud.uws.edu.pl
            </strong>

        </p>

        <p class="auth-subtitle">

            Za 10 sekund nastąpi przekierowanie
            do strony głównej.

        </p>

        <div class="admin-btn-center">

    <a href="index.php" class="btn">
        Powrót do strony głównej
    </a>

</div>

    </div>

</div>

</body>
</html>
<?php
exit;
}