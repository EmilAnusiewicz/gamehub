<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameHub</title>

    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<header>

    <div class="header-left">

    <div class="logo">
        <i class="fa-solid fa-gamepad"></i>
        GameHub
    </div>

    <?php if(basename($_SERVER["PHP_SELF"]) != "catalog.php"): ?>

<form class="header-search"
      action="index.php"
      method="GET">

    <input
        type="text"
        id="searchInput"
        name="search"
        placeholder="🔍 Szukaj gry..."
        autocomplete="off">

    <div id="searchResults"></div>

</form>

<?php endif; ?>
</div>
    <nav>

        <a href="index.php">Strona główna</a>
        <a href="catalog.php">Katalog gier</a>

        <?php if(isset($_SESSION["id"])): ?>

            <a href="favourites.php">Ulubione</a>

            <a href="my_reviews.php">Moje recenzje</a>
            <a href="insert_game.php">Dodaj grę</a>
            <?php if(isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1): ?>

    <a href="admin_users.php">
        Użytkownicy
    </a>

<?php endif; ?>
            <a href="profile.php">Mój profil</a>

            <span class="user-info">
                Witaj, <?= htmlspecialchars($_SESSION["login"]) ?>
            </span>

            <a href="logout.php">Wyloguj</a>

        <?php else: ?>

            <a href="login.php">Logowanie</a>
            <a href="register.php">Rejestracja</a>

        <?php endif; ?>

    </nav>

</header>

<main>