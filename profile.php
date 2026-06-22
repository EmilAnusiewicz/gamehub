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
$success = "";
$error = "";

if(isset($_POST["change_password"])){

    $currentPassword = $_POST["current_password"];
    $newPassword = $_POST["new_password"];
    $repeatPassword = $_POST["repeat_password"];

    if(!password_verify(
        $currentPassword,
        $user["password"] ?? ""
    )){
        $error = "Aktualne hasło jest nieprawidłowe.";
    }
    elseif($newPassword != $repeatPassword){
        $error = "Nowe hasła nie są takie same.";
    }
    else{

        $hash = password_hash(
            $newPassword,
            PASSWORD_DEFAULT
        );

        mysqli_query(
            $conn,
            "
            UPDATE users
            SET password = '$hash'
            WHERE id = $userId
            "
        );

        $success = "Hasło zostało zmienione.";
        header("Refresh:3; url=profile.php");
    }
}

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

<?php if($success): ?>

    <div class="success-message">
        <?= $success ?>
    </div>

<?php endif; ?>

<?php if($error): ?>

    <div class="error-message">
        <?= $error ?>
    </div>

<?php endif; ?>

 <div class="profile-actions">

            <button
                id="showPasswordForm"
                class="btn">

                🔒 Zmień hasło

            </button>

        </div>

        <form
    method="POST"
    id="passwordForm"
    style="display:none;margin-top:20px;">

    <input
        type="password"
        name="current_password"
        placeholder="Aktualne hasło"
        required>

    <input
        type="password"
        name="new_password"
        placeholder="Nowe hasło"
        required>

    <input
        type="password"
        name="repeat_password"
        placeholder="Powtórz nowe hasło"
        required>

    <button
        type="submit"
        name="change_password"
        class="btn">

        Zapisz hasło

    </button>

</form>

    </div>

</div>

<script>
document
.getElementById("showPasswordForm")
.addEventListener("click", function(){

    const form =
    document.getElementById("passwordForm");

    form.style.display =
        form.style.display === "none"
        ? "block"
        : "none";
});

</script>
<?php require("footer.php"); ?>