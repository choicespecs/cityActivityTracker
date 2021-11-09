<?php
    $pid = $_GET['pid'];
    header("Location: ../pages/post.php?pid={$pid}");
    exit();
?>