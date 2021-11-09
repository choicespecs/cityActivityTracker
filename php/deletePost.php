<?php
    require __DIR__ . '/DBfunctions.php';

    $pid = $_GET['pid'];

    $conn = currentDB();

    $query = "SELECT pimg_path from post where post.pid = {$pid}";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $pimg_path = $row['pimg_path'];
    unlink($pimg_path);

    $query = "DELETE FROM post WHERE post.pid = {$pid}";
    $result = mysqli_query($conn, $query);

    header('Location: ../index.php');
    die();

?>