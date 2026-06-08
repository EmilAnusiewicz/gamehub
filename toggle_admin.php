<?php

require("admin_guard.php");
require("db.php");

$id = (int)$_GET["id"];

$user = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "
        SELECT is_admin
        FROM users
        WHERE id = $id
        "
    )
);

$newValue = $user["is_admin"] ? 0 : 1;

mysqli_query(
    $conn,
    "
    UPDATE users
    SET is_admin = $newValue
    WHERE id = $id
    "
);

header("Location: admin_users.php");
exit;