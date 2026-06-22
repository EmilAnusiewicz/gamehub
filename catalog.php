<?php

require("db.php");
require("header.php");
$genres = mysqli_query(
    $conn,
    "SELECT * FROM genres ORDER BY name"
);

$where = "";

if(isset($_GET["genre"]) && $_GET["genre"] != ""){

    $genre = (int)$_GET["genre"];

    $where = "
    WHERE games.genre_id = $genre
    ";
}

$query = mysqli_query(
    $conn,
    "
    SELECT
        games.*,
        genres.name AS genre_name
    FROM games
    LEFT JOIN genres
        ON games.genre_id = genres.id

    $where

    ORDER BY games.id DESC
    "
);

?>

<section class="games-section">

    <h2 class="section-title">
        🎮 Katalog gier
    </h2>
    <div class="catalog-tools">

    <input
        type="text"
        id="catalogSearch"
        placeholder="🔍 Szukaj gry...">

    <form method="GET" class="filter-form">

        <select name="genre">

            <option value="">
                Wszystkie gatunki
            </option>

            <?php while($genre = mysqli_fetch_assoc($genres)): ?>

                <option
                    value="<?= $genre["id"] ?>"
                    <?= isset($_GET["genre"]) && $_GET["genre"] == $genre["id"] ? "selected" : "" ?>>

                    <?= htmlspecialchars($genre["name"]) ?>

                </option>

            <?php endwhile; ?>

        </select>

        <button
            type="submit"
            class="btn">

            Filtruj

        </button>

    </form>

</div>

<div class="games-grid">

        <?php while($game = mysqli_fetch_assoc($query)): ?>

            <div
    class="game-card"
    data-title="<?= strtolower(htmlspecialchars($game["title"])) ?>">

                <img
                    src="uploads/covers/<?= htmlspecialchars($game["cover"]) ?>"
                    alt="<?= htmlspecialchars($game["title"]) ?>">

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

                   <div class="game-actions">

    <a
        href="details.php?id=<?= $game["id"] ?>"
        class="btn">

        🎮 Szczegóły

    </a>

    <?php if(isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1): ?>

        <a
            href="edit_game.php?id=<?= $game["id"] ?>"
            class="btn">

            ✏️ Edytuj

        </a>

        <a
            href="delete_game.php?id=<?= $game["id"] ?>"
            class="btn btn-danger delete-btn">

            🗑 Usuń

        </a>

    <?php endif; ?>

</div>

                </div>

            </div>

        <?php endwhile; ?>

    </div>

</section>
<script>

const searchInput =
document.getElementById("catalogSearch");

if(searchInput){

    searchInput.addEventListener(
        "keyup",
        function(){

            const value =
            this.value.toLowerCase();

            document
                .querySelectorAll(".game-card")
                .forEach(card=>{

                    const title =
                    card.dataset.title;

                    card.style.display =
                        title.includes(value)
                        ? ""
                        : "none";
                });
        }
    );
}

</script>
<?php require("footer.php"); ?>