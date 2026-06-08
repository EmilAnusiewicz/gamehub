<?php

require("session.php");
require("db.php");

$id = (int)$_GET["id"];
$user_id = $_SESSION["id"];

mysqli_query(
    $conn,
    "
    DELETE FROM reviews
    WHERE id = $id
    AND user_id = $user_id
    "
);

header("Location: my_reviews.php");
exit;