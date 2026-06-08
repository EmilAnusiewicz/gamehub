<?php

require("admin_guard.php");
require("db.php");

$id = (int)$_GET["id"];

mysqli_query(
    $conn,
    "
    DELETE FROM games
    WHERE id = $id
    "
);

header("Location: catalog.php");
exit;