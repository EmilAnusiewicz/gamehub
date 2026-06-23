<?php
require("db.php");
require("header.php");
$favouriteMessage = "";

if (isset($_GET["fav"])) {

    if ($_GET["fav"] == "added") {
        $favouriteMessage = "❤️ Gra została dodana do ulubionych.";
    }

    if ($_GET["fav"] == "removed") {
        $favouriteMessage = "💔 Gra została usunięta z ulubionych.";
    }
}

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET["id"];

$sql = "
SELECT
    games.*,
    genres.name AS genre_name
FROM games
JOIN genres
ON games.genre_id = genres.id
WHERE games.id = $id
";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}

$game = mysqli_fetch_assoc($result);
$avgResult = mysqli_query(
    $conn,
    "
    SELECT
        ROUND(AVG(score),1) AS avg_score,
        COUNT(*) AS reviews_count
    FROM reviews
    WHERE game_id = $id
    "
);

$avgData = mysqli_fetch_assoc($avgResult);

$averageScore = $avgData["avg_score"];
$reviewsCount = $avgData["reviews_count"];
$reviews = mysqli_query(
    $conn,
    "
    SELECT
        reviews.*,
        users.login
    FROM reviews
    JOIN users
    ON reviews.user_id = users.id
    WHERE reviews.game_id = $id
    ORDER BY reviews.created_at DESC
    "
);
$isFavourite = false;

if (isset($_SESSION["id"])) {

    $user_id = $_SESSION["id"];

    $favCheck = mysqli_query(
        $conn,
        "
        SELECT id
        FROM favourites
        WHERE user_id = $user_id
        AND game_id = $id
        "
    );

    $isFavourite = mysqli_num_rows($favCheck) > 0;
}

?>
<?php if ($favouriteMessage): ?>

    <div class="success-message">
        <?= $favouriteMessage ?>
    </div>

<?php endif; ?>
<div class="details-container">

    <div class="details-image">

        <?php if ($game["cover"]): ?>

            <img src="uploads/covers/<?= $game["cover"] ?>" alt="<?= htmlspecialchars($game["title"]) ?>">

        <?php endif; ?>

    </div>

    <div class="details-info">

        <h1>
            <?= htmlspecialchars($game["title"]) ?>
        </h1>

        <div class="details-badges">

            <a href="catalog.php?genre=<?= $game["genre_id"] ?>" class="detail-badge">

                🎮 <?= htmlspecialchars($game["genre_name"]) ?>

            </a>

            <span class="detail-badge">
                ⭐ Ocena redakcji:
                <?= $game["rating"] ?>/10
            </span>

            <?php if ($reviewsCount > 0): ?>

                <span class="detail-badge">

                    👥 Średnia użytkowników:
                    <?= $averageScore ?>/10
                    (<?= $reviewsCount ?> recenzji)

                </span>


            <?php endif; ?>

        </div>

        <div class="details-meta">

            <p>
                <strong>Producent:</strong>
                <?= htmlspecialchars($game["developer"]) ?>
            </p>

            <p>
                <strong>Rok wydania:</strong>
                <?= $game["release_year"] ?>
            </p>

        </div>

        <h3>Opis gry</h3>

        <p class="details-description">
            <?= nl2br(htmlspecialchars($game["description"])) ?>
        </p>

        <br>

        <?php if (isset($_SESSION["id"])): ?>

            <a href="toggle_favourite.php?id=<?= $game["id"] ?>" class="btn">

                <?php if ($isFavourite): ?>

                    💔 Usuń z ulubionych

                <?php else: ?>

                    ❤️ Dodaj do ulubionych

                <?php endif; ?>

            </a>

        <?php endif; ?>

        <a href="index.php" class="btn">
            ← Powrót
        </a>

    </div>

</div>
<section class="reviews-section">

    <h2>
        💬 Recenzje graczy
    </h2>
    <?php if (isset($_SESSION["id"])): ?>
        <div class="review-form">

            <h3>
                Dodaj swoją opinię
            </h3>

            <form action="insert_review.php" method="POST">

                <input type="hidden" name="game_id" value="<?= $game["id"] ?>">

                <div class="review-row">

                    <div class="review-score">

                        <label>Ocena</label>

                        <select name="score">

                            <?php for ($i = 1; $i <= 10; $i++): ?>

                                <option value="<?= $i ?>">
                                    <?= $i ?>/10
                                </option>

                            <?php endfor; ?>

                        </select>

                    </div>

                </div>
            <?php else: ?>

                <div class="review-form">

                    <p>
                        Aby dodać recenzję musisz się zalogować.
                    </p>

                </div>

            <?php endif; ?>
            <label>Twoja recenzja</label>

            <textarea name="content" placeholder="Napisz swoją opinię o grze..." required></textarea>

            <button type="submit" class="btn">

                Dodaj recenzję

            </button>

        </form>

    </div>



    <?php while ($review = mysqli_fetch_assoc($reviews)): ?>

        <div class="review-card">

            <div class="review-header">

                <div class="review-user">
                    👤 <?= htmlspecialchars($review["login"]) ?>
                </div>

                <div class="review-rating">
                    ⭐ <?= $review["score"] ?>/10
                </div>

            </div>

            <div class="review-content">

                <?= nl2br(
                    htmlspecialchars(
                        $review["content"]
                    )
                ) ?>

            </div>
        </div>

    <?php endwhile; ?>

</section>
<?php
require("footer.php");
?>