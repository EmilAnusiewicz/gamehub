<?php

require("admin_guard.php");
require("db.php");

$id = (int) $_GET["id"];

if ($id != $_SESSION["id"]) {

    mysqli_query(
        $conn,
        "
        UPDATE users
        SET is_blocked = NOT is_blocked
        WHERE id = $id
        "
    );
}

header("Location: admin_users.php");
exit();