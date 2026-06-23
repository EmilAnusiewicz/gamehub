<?php
require("admin_guard.php");
require("session.php");
require("db.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $developer = $_POST["developer"];
    $release_year = $_POST["release_year"];
    $genre_id = $_POST["genre_id"];
    $description = $_POST["description"];
    $rating = $_POST["rating"];

    $cover = "";

    if (isset($_FILES["cover"]) && $_FILES["cover"]["error"] == 0) {

        $filename = time() . "_" . basename($_FILES["cover"]["name"]);

        move_uploaded_file(
            $_FILES["cover"]["tmp_name"],
            "uploads/covers/" . $filename
        );

        $cover = $filename;
    }

    $sql = "
    INSERT INTO games
    (
        genre_id,
        title,
        developer,
        release_year,
        cover,
        description,
        rating
    )
    VALUES
    (
        '$genre_id',
        '$title',
        '$developer',
        '$release_year',
        '$cover',
        '$description',
        '$rating'
    )
    ";

    if (mysqli_query($conn, $sql)) {
        $message = "Gra została dodana.";
    }
}

$genres = mysqli_query(
    $conn,
    "SELECT * FROM genres ORDER BY name"
);

require("header.php");
?>

<div class="auth-container">

    <div class="auth-card game-form">

        <h1>Dodaj grę</h1>

        <?php if ($message): ?>
            <div class="success-message">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <label>Tytuł</label>
            <input type="text" name="title" required>

            <label>Producent</label>
            <input type="text" name="developer">

            <label>Rok wydania</label>
            <input type="number" name="release_year">

            <label>Gatunek</label>
            <select name="genre_id">

                <?php while ($genre = mysqli_fetch_assoc($genres)): ?>

                    <option value="<?= $genre["id"] ?>">
                        <?= $genre["name"] ?>
                    </option>

                <?php endwhile; ?>

            </select>

            <label>Ocena</label>
            <input type="number" step="0.1" min="0" max="10" name="rating">

            <label>Opis</label>
            <textarea rows="5" name="description"></textarea>

            <label>Okładka gry</label>

            <div class="upload-box">
                <input type="file" name="cover" id="cover" accept="image/*">
            </div>

            <img id="preview" src="" alt="" style="display:none;">

            <button type="submit" class="auth-btn">

                Dodaj grę

            </button>

        </form>

    </div>

</div>
<?php
require("footer.php");
?>