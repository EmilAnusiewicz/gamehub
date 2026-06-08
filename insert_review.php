<?php

require("session.php");
require("db.php");

$user_id = $_SESSION["id"];

$game_id = (int)$_POST["game_id"];
$score = (int)$_POST["score"];

$content = mysqli_real_escape_string(
    $conn,
    $_POST["content"]
);

mysqli_query(
    $conn,
    "
    INSERT INTO reviews
    (
        game_id,
        user_id,
        score,
        content
    )
    VALUES
    (
        $game_id,
        $user_id,
        $score,
        '$content'
    )
    "
);

header(
    "Location: details.php?id=" . $game_id
);

exit();