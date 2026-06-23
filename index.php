<?php

require("db.php");
require("header.php");

$search = $_GET["search"] ?? "";
$genre = $_GET["genre"] ?? "";

$sql = "
SELECT
    games.*,
    genres.name AS genre_name
FROM games
JOIN genres
ON games.genre_id = genres.id
WHERE 1=1
";

if ($search != "") {

    $search = mysqli_real_escape_string(
        $conn,
        $search
    );

    $sql .= "
    AND games.title LIKE '%$search%'
    ";
}

if ($genre != "") {

    $genre = (int) $genre;

    $sql .= "
    AND games.genre_id = $genre
    ";
}

$sql .= "
ORDER BY games.id DESC
LIMIT 4
";

$result = mysqli_query($conn, $sql);

$genresResult = mysqli_query(
    $conn,
    "SELECT * FROM genres"
);

$result = mysqli_query($conn, $sql);
$topGames = mysqli_query(
    $conn,
    "
    SELECT
        games.*,
        genres.name AS genre_name
    FROM games
    LEFT JOIN genres
        ON games.genre_id = genres.id
    ORDER BY rating DESC
    LIMIT 4
    "
);

?>

<section class="hero">

    <span class="badge">
        NOWA GENERACJA KATALOGU GIER
    </span>

    <h1>
        Odkrywaj najlepsze gry<br>
        w jednym miejscu
    </h1>

    <p>
        Recenzje, oceny, ulubione gry
        i społeczność graczy.
    </p>

    <?php if (!isset($_SESSION["id"])): ?>
        <a href="register.php" class="btn">
            Rozpocznij za darmo
        </a>
    <?php endif; ?>

</section>
<?php

$gamesCount = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM games"
    )
);

$usersCount = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM users"
    )
);

$reviewsCount = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM reviews"
    )
);

?>

<section class="stats-section">

    <div class="stat-card">

        <h3>
            🎮
        </h3>

        <strong>
            <?= $gamesCount["total"] ?>
        </strong>

        <span>
            Gier
        </span>

    </div>

    <div class="stat-card">

        <h3>
            ⭐
        </h3>

        <strong>
            <?= $reviewsCount["total"] ?>
        </strong>

        <span>
            Recenzji
        </span>

    </div>

    <div class="stat-card">

        <h3>
            👤
        </h3>

        <strong>
            <?= $usersCount["total"] ?>
        </strong>

        <span>
            Użytkowników
        </span>

    </div>

</section>

<section class="games-section">

    <h2 class="section-title">
        🔥 Najnowsze gry
    </h2>

    <div class="games-grid">

        <?php while ($game = mysqli_fetch_assoc($result)): ?>
            <?php

            $gameId = $game["id"];

            $avgResult = mysqli_query(
                $conn,
                "
    SELECT
        ROUND(AVG(score),1) AS avg_score,
        COUNT(*) AS reviews_count
    FROM reviews
    WHERE game_id = $gameId
    "
            );

            $avgData = mysqli_fetch_assoc($avgResult);

            ?>

            <div class="game-card">

                <?php if ($game["cover"]): ?>

                    <img src="uploads/covers/<?= $game["cover"] ?>" alt="<?= htmlspecialchars($game["title"]) ?>">

                <?php endif; ?>

                <div class="game-content">

                    <h3>
                        <?= htmlspecialchars($game["title"]) ?>
                    </h3>

                    <p>
                        🎮 <?= htmlspecialchars($game["genre_name"]) ?>
                    </p>

                    <?php if ($avgData["reviews_count"] > 0): ?>

                        <p>
                            ⭐ <?= $game["rating"] ?>/10 ocena redakcji<br>
                            👥 <?= $avgData["avg_score"] ?>/10 ocena użytkowników
                            (<?= $avgData["reviews_count"] ?>)
                        </p>

                    <?php else: ?>

                        <p>
                            Brak ocen użytkowników
                        </p>

                    <?php endif; ?>

                    <br>

                    <a href="details.php?id=<?= $game["id"] ?>" class="btn">

                        Szczegóły

                    </a>

                </div>

            </div>

        <?php endwhile; ?>

    </div>

</section>
<section class="games-section">

    <h2 class="section-title">
        🏆 Najwyżej oceniane gry
    </h2>

    <div class="games-grid">

        <?php while ($game = mysqli_fetch_assoc($topGames)): ?>

            <div class="game-card">

                <?php if ($game["cover"]): ?>

                    <img src="uploads/covers/<?= $game["cover"] ?>" alt="<?= htmlspecialchars($game["title"]) ?>">

                <?php endif; ?>

                <div class="game-content">

                    <h3>
                        <?= htmlspecialchars($game["title"]) ?>
                    </h3>

                    <p>
                        🎮 <?= htmlspecialchars($game["genre_name"]) ?>
                    </p>

                    <p>
                        ⭐ <?= $game["rating"] ?>/10
                    </p>

                    <br>

                    <a href="details.php?id=<?= $game["id"] ?>" class="btn">

                        Szczegóły

                    </a>

                </div>

            </div>

        <?php endwhile; ?>

    </div>

</section>

<?php
require("footer.php");
?>