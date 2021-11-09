<?php
    require __DIR__ . '/DBfunctions.php';

    $conn = currentDB();
    closeDB($conn);
    removeSessions();

    header('Location: ../index.php');
    die();
?>