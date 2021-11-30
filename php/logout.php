<?php
    require __DIR__ . '/DBfunctions.php';

    $conn = currentDB();
    closeDB($conn);
    removeSessions();
    if (isset($_COOKIE["username"])) {
        unset($_COOKIE["username"]);
        setcookie("username", "", time() - 3600, "/");
    }
    header('Location: ../index.php');
    die();
?>