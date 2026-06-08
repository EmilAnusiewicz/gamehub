<?php

require("admin_guard.php");
require("db.php");
require("header.php");

$users = mysqli_query(
    $conn,
    "
    SELECT *
    FROM users
    ORDER BY id DESC
    "
);

?>

<div class="auth-container">

    <div class="auth-card" style="max-width:900px;">

        <h1>
            👑 Zarządzanie użytkownikami
        </h1>

        <table class="admin-table">

            <tr>

                <th>ID</th>

                <th>Login</th>

                <th>Rola</th>

                <th>Data rejestracji</th>

                <th>Akcja</th>


            </tr>

            <?php while($user = mysqli_fetch_assoc($users)): ?>

                <tr>

                    <td>
                        <?= $user["id"] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($user["login"]) ?>
                    </td>

                    <td>

                        <?= $user["is_admin"]
                            ? "Administrator"
                            : "Użytkownik" ?>

                    </td>
<td>
    <?= date(
        "d.m.Y H:i",
        strtotime($user["created_at"])
    ) ?>
</td>
                    <td>

                        <?php if($user["id"] != $_SESSION["id"]): ?>

                            <a
                                href="toggle_admin.php?id=<?= $user["id"] ?>"
                                class="btn">

                                <?= $user["is_admin"]
                                    ? "Odbierz admina"
                                    : "Nadaj admina" ?>

                            </a>

                        <?php endif; ?>

                    </td>

                </tr>

            <?php endwhile; ?>

        </table>

    </div>

</div>

<?php require("footer.php"); ?>