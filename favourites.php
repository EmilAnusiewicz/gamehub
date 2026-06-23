<?php

require("session.php");
require("db.php");
require("header.php");

$user_id = $_SESSION["id"];

$sql = "
SELECT
    games.*
FROM favourites
JOIN games
ON favourites.game_id = games.id
WHERE favourites.user_id = $user_id
";

$result = mysqli_query($conn, $sql);

?>

<section class="games-section">

    <h2 class="section-title">
        ❤️ Moje ulubione gry
    </h2>

    <div class="games-grid">

        <?php while ($game = mysqli_fetch_assoc($result)): ?>

            <div class="game-card">

                <img src="uploads/covers/<?= $game["cover"] ?>" alt="">

                <div class="game-content">

                    <h3>
                        <?= htmlspecialchars($game["title"]) ?>
                    </h3>

                    <p>
                        ⭐ <?= $game["rating"] ?>/10
                    </p>

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