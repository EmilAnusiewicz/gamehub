<?php

require("db.php");

$search = $_GET["q"] ?? "";

$search = mysqli_real_escape_string(
    $conn,
    $search
);

if(strlen($search) < 2){
    exit;
}

$result = mysqli_query(
    $conn,
    "
    SELECT
    games.id,
    games.title,
    games.cover,
    games.rating,
    genres.name AS genre_name
FROM games
LEFT JOIN genres
ON games.genre_id = genres.id
    WHERE title LIKE '%$search%'
    ORDER BY title
    LIMIT 5
    "
);

while($game = mysqli_fetch_assoc($result))
{
?>
    <a
    class="search-item"
    href="details.php?id=<?= $game["id"] ?>">

    <img
        src="uploads/covers/<?= htmlspecialchars($game["cover"]) ?>"
        alt=""
        class="search-thumb">

    <div class="search-info">

    <strong>
        <?= htmlspecialchars($game["title"]) ?>
    </strong>

    <small>
        🎮 <?= htmlspecialchars($game["genre_name"]) ?>
        •
        ⭐ <?= $game["rating"] ?>/10
    </small>

</div>

</a>
<?php
}
?>