<?php

require("admin_guard.php");
require("session.php");
require("db.php");

$id = (int) $_GET["id"];

$gameQuery = mysqli_query(
    $conn,
    "SELECT * FROM games WHERE id = $id"
);

$game = mysqli_fetch_assoc($gameQuery);

if (!$game) {
    header("Location: catalog.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $developer = $_POST["developer"];
    $release_year = $_POST["release_year"];
    $genre_id = $_POST["genre_id"];
    $description = $_POST["description"];
    $rating = $_POST["rating"];

    $cover = $game["cover"];

    if (
        isset($_FILES["cover"])
        && $_FILES["cover"]["error"] == 0
    ) {

        $filename =
            time() . "_" .
            basename($_FILES["cover"]["name"]);

        move_uploaded_file(
            $_FILES["cover"]["tmp_name"],
            "uploads/covers/" . $filename
        );

        $cover = $filename;
    }

    mysqli_query(
        $conn,
        "
        UPDATE games
        SET
            genre_id = '$genre_id',
            title = '$title',
            developer = '$developer',
            release_year = '$release_year',
            cover = '$cover',
            description = '$description',
            rating = '$rating'
        WHERE id = $id
        "
    );

    $message = "Zmiany zostały zapisane.";
    header("Refresh: 5; url=catalog.php");
    $gameQuery = mysqli_query(
        $conn,
        "SELECT * FROM games WHERE id = $id"
    );

    $game = mysqli_fetch_assoc($gameQuery);
}

$genres = mysqli_query(
    $conn,
    "SELECT * FROM genres ORDER BY name"
);

require("header.php");
?>

<div class="auth-container">

    <div class="auth-card game-form">

        <h1>Edytuj grę</h1>

        <?php if ($message): ?>

            <div class="success-message">
                <?= $message ?>
                <br><br>

                Za 5 sekund nastąpi powrót
                do katalogu gier.

            </div>

        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <label>Tytuł</label>

            <input type="text" name="title" value="<?= htmlspecialchars($game["title"]) ?>" required>

            <label>Producent</label>

            <input type="text" name="developer" value="<?= htmlspecialchars($game["developer"]) ?>">

            <label>Rok wydania</label>

            <input type="number" name="release_year" value="<?= $game["release_year"] ?>">

            <label>Gatunek</label>

            <select name="genre_id">

                <?php while ($genre = mysqli_fetch_assoc($genres)): ?>

                    <option value="<?= $genre["id"] ?>" <?= $genre["id"] == $game["genre_id"] ? "selected" : "" ?>>

                        <?= htmlspecialchars($genre["name"]) ?>

                    </option>

                <?php endwhile; ?>

            </select>

            <label>Ocena</label>

            <input type="number" step="0.1" min="0" max="10" name="rating" value="<?= $game["rating"] ?>">

            <label>Opis</label>

            <textarea rows="5" name="description"><?= htmlspecialchars($game["description"]) ?></textarea>

            <label>Aktualna okładka</label>

            <img src="uploads/covers/<?= htmlspecialchars($game["cover"]) ?>" id="preview" style="display:block;">

            <label>Nowa okładka (opcjonalnie)</label>

            <div class="upload-box">

                <input type="file" name="cover" id="cover" accept="image/*">

            </div>

            <button type="submit" class="auth-btn">

                Zapisz zmiany

            </button>

        </form>

    </div>

</div>

<?php require("footer.php"); ?>