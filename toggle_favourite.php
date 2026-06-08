<?php

require("session.php");
require("db.php");

$user_id = $_SESSION["id"];
$game_id = (int)$_GET["id"];

$check = mysqli_query(
    $conn,
    "
    SELECT id
    FROM favourites
    WHERE user_id = $user_id
    AND game_id = $game_id
    "
);

if(mysqli_num_rows($check) == 0){

    mysqli_query(
        $conn,
        "
        INSERT INTO favourites
        (user_id, game_id)
        VALUES
        ($user_id, $game_id)
        "
    );

    header(
        "Location: details.php?id=$game_id&fav=added"
    );

}else{

    mysqli_query(
        $conn,
        "
        DELETE FROM favourites
        WHERE user_id = $user_id
        AND game_id = $game_id
        "
    );

    header(
        "Location: details.php?id=$game_id&fav=removed"
    );
}

exit();