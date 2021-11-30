<?php
    require __DIR__ . '/DBfunctions.php';

    session_start();
    $uid = $_SESSION['user'];
    $pid = $_GET['pid'];

    $query = "select pid from postlikes where pid = {$pid} AND uid = {$uid}";
    $conn = currentDB();
    $result = mysqli_query($conn, $query);
    $likeExists = 0;
    if (mysqli_num_rows($result) == 1) {
        $likeExists = 1;
    }

    if ($likeExists) {
        $query = "delete from postlikes where pid = {$pid} AND uid = {$uid}";
        $conn = currentDB();
        $result = mysqli_query($conn, $query);
    } else {
        $query = "insert into postlikes(pid,uid) values({$pid},{$uid});";
        $conn = currentDB();
        $result = mysqli_query($conn, $query);
    }
?>