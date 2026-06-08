<?php

require("session.php");
require("db.php");
require("header.php");

$userId = $_SESSION["id"];

$user = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "
        SELECT *
        FROM users
        WHERE id = $userId
        "
    )
);

$reviews = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "
        SELECT COUNT(*) AS total
        FROM reviews
        WHERE user_id = $userId
        "
    )
);

$favorites = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "
        SELECT COUNT(*) AS total
FROM favourites
WHERE user_id = $userId
        "
    )
);

?>

<div class="auth-container">

    <div class="auth-card">

        <h1>Mój profil</h1>

        <div class="profile-info">

            <p>
                <strong>👤 Login:</strong>
                <?= htmlspecialchars($user["login"]) ?>
            </p>

            <p>
                <strong>📝 Recenzje:</strong>
                <?= $reviews["total"] ?>
            </p>

            <p>
                <strong>❤️ Ulubione gry:</strong>
                <?= $favorites["total"] ?>
            </p>

            <p>
                <strong>🛡️ Rola:</strong>

                <?= !empty($user["is_admin"])
                    ? "Administrator"
                    : "Użytkownik" ?>

            </p>
            <p>
    <strong>📅 Data rejestracji:</strong>

    <?= date(
        "d.m.Y",
        strtotime($user["created_at"])
    ) ?>

</p>

        </div>

    </div>

</div>

<?php require("footer.php"); ?>