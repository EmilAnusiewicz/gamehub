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
    SELECT id, title, cover
    FROM games
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
        <?= $game["cover"] ?>

    <span>
        <?= htmlspecialchars($game["title"]) ?>
    </span>

</a>
<?php
}
?>