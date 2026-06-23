<?php

require("session.php");
require("db.php");

$id = (int) $_GET["id"];
$user_id = $_SESSION["id"];

$result = mysqli_query(
    $conn,
    "
    SELECT *
    FROM reviews
    WHERE id = $id
    AND user_id = $user_id
    "
);

$review = mysqli_fetch_assoc($result);

if (!$review) {
    header("Location: my_reviews.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $score = (int) $_POST["score"];
    $content = mysqli_real_escape_string(
        $conn,
        $_POST["content"]
    );

    mysqli_query(
        $conn,
        "
        UPDATE reviews
        SET
            score = $score,
            content = '$content'
        WHERE id = $id
        "
    );

    header("Location: my_reviews.php");
    exit;
}

require("header.php");
?>

<div class="auth-container">

    <div class="auth-card">

        <h1>Edytuj recenzję</h1>

        <form method="POST">

            <label>Ocena</label>

            <select name="score">

                <?php for ($i = 1; $i <= 10; $i++): ?>

                    <option value="<?= $i ?>" <?= $review["score"] == $i ? "selected" : "" ?>>

                        <?= $i ?>/10

                    </option>

                <?php endfor; ?>

            </select>

            <label>Treść recenzji</label>

            <textarea name="content" rows="8"><?= htmlspecialchars($review["content"]) ?></textarea>

            <button type="submit" class="btn">

                Zapisz zmiany

            </button>

        </form>

    </div>

</div>

<?php require("footer.php"); ?>