<?php
    include_once(__DIR__ . '/DBfunctions.php');
    
    function errorMessage($num) {
        $error = "";
        switch ($num) {
            case 1:
                $error = "Error: Image already exists.";
                break;
            case 2:
                $error = "Error: Username is already registered.";
                break;
            case 3:
                $error = "Error: Incorrect user name or password.";
                break;
            case 4:
                $error = "Error: You must login / register to access page.";
                break;
        }
        echo "<div class='login-error' style='text-align: center;'><h4> {$error} </h4></div>";
    }

    function getActualName($uid) {
        $conn = currentDB();
        $query = "select actual_name from user where uid = {$uid} limit 1";
        $result = mysqli_query($conn, $query);
        $actual_name = mysqli_fetch_assoc($result);
        $actual_name = $actual_name['actual_name'];
        return $actual_name;
    }

    function getLocationName($uid, $lid) {
        $conn = currentDB();
        $query = "select city from user, location where user.uid = {$uid} and user.lid = location.lid limit 1";
        $result = mysqli_query($conn, $query);
        $location = mysqli_fetch_assoc($result);
        $location = $location['city'];
        return $location;
    }

    function getNumberActivity($uid) {
        $conn = currentDB();
        $query = "select count(*) as count from post where uid = {$uid}";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $number = $row['count'];
        return $number;
    }

    function getBio($uid) {
        $conn = currentDB();
        $query = "select bio from user where uid = {$uid} limit 1";
        $result = mysqli_query($conn, $query);
        $bio = mysqli_fetch_assoc($result);
        $bio = $bio['bio'];
        return $bio;
    }



    function createActivityDropdown() {
        $conn = currentDB();
        $query = "select aname from activity";
        $result = mysqli_query($conn, $query);
        while ($row = $result -> fetch_row()) {
            echo "<option value = '{$row[0]}' > {$row[0]} </option>";
        }
    }

    function createLocationDropdown() {
        $conn = currentDB();
        $query = "select city from location";
        $result = mysqli_query($conn, $query);
        while ($row = $result -> fetch_row()) {
            echo "<option value= '{$row[0]}' > {$row[0]} </option>";
        }
    }

    function verifyLogin() {
        $logged_in = 0;
        if (isset($_SESSION['logged_in'])) {
            $logged_in = $_SESSION['logged_in'];
        } else if (isset($_COOKIE["username"])) {
            loginDBCookie($_COOKIE["username"]);
            $logged_in = $_SESSION['logged_in'];
        }

        if ($logged_in == 0) {
            $_SESSION['error_login'] = 4;
            header('Location: ../pages/login.php');
            die();
        }
    }

    function verifyCookie() {
        if (isset($_COOKIE["username"]) && !isset($_SESSION["logged_in"])) {
            loginDBCookie($_COOKIE["username"]);
        }
    }

    function createCardThumbnail($pid, $username, $title, $img, $index) {
        $postLikes = getLikes($pid);
        $logged_in = 0;
        if (isset($_SESSION['logged_in'])) {
            $logged_in = $_SESSION['logged_in'];
        }
        $confirmLike = 0;
        if ($logged_in) {
            $confirmLike = confirmLike($pid);
        }
        $data_liked = '';
        $like_string = '';
        if ($logged_in && $confirmLike) {
            $data_liked = 'yes';
            $like_string = 'Unlike';
        } else if ($logged_in && !$confirmLike) {
            $data_liked = 'no';
            $like_string = 'Like';
        }
        $img_path = $img;
        if ($index == 1) {
            $img_path = substr($img_path, 1);
        }
        echo "
            <div class='post-screen-card'>
            <a class='post-screen-card-content' href='./php/linkPost.php?pid={$pid}'>
            <div class='post-screen-card-userinfo'> 
                <h2 class='post-screen-card-username'> {$username} </h2> 
            </div>
            <h5 class='post-screen-card-type'> {$title} </h5>
            <div class='post-screen-card-image'>
            <img src= '{$img_path}' alt='' />
            </div>
            </a>";
        
        if ($logged_in) {
            echo "<button class='likeButton' onclick='likePost(this);' data-liked='{$data_liked}' data-number-likes='{$postLikes}' data-pid='{$pid}'> {$like_string} {$postLikes}</button>";
        } else {
            echo "<span class = 'likeBox'> Likes : {$postLikes}</span>";
        }
        echo "</div>";
    }

    function createSearchCardThumbnail($pid, $username, $title, $img, $index) {
        $img_path = $img;
        $postLikes = getLikes($pid);
        $confirmLike = confirmLike($pid);
        $data_liked = '';
        $like_string = '';
        if ($confirmLike) {
            $data_liked = 'yes';
            $like_string = 'Unlike';
        } else {
            $data_liked = 'no';
            $like_string = 'Like';
        }
        if ($index == 1) {
            $img_path = substr($img_path, 1);
        }
        echo "<div class='post-screen-card'>
            <a class='post-screen-card-content' href='../php/linkPost.php?pid={$pid}'>
            <div class='post-screen-card-userinfo'> 
                <h2 class='post-screen-card-username'> {$username} </h2> 
            </div>
            <h5 class='post-screen-card-type'> {$title} </h5>
            <div class='post-screen-card-image'>
                <img src= '{$img_path}' alt='' />
            </div>
            </a>
            <button class='likeButton' onclick='likePost(this);' data-liked='{$data_liked}' data-number-likes='{$postLikes}' data-pid='{$pid}'> {$like_string} {$postLikes}</button>
            </div>";
    }

    function searchActivitiesThumbnail($uid, $lid, $aid) {
        $conn = currentDB();
        $query = "select * from post where";
        $and = 0;

        if ($uid != -1) {
            $query .= " uid = {$uid}";
            $and = 1;
        } 

        if ($lid != -1) {
            if ($and) {
                $query .= " and";
            }
            $query .= " lid = {$lid}";
            $and = 1;
        }

        if ($aid != -1) {
            if ($and) {
                $query .= " and";
            }
            $query .= " aid = {$aid}";
        }

        $query .= ";";

        if ($result = mysqli_query($conn, $query)) {

            /* fetch associative array */
            while ($row = $result -> fetch_assoc()) {
                $username = getActualName($row['uid']);
                $pid = $row['pid'];
                $title = $row['title'];
                $img_path = $row['pimg_path'];
                createSearchCardThumbnail($pid, $username, $title, $img_path, 0);
            }
        }
    }

    function createRecentActivities() {
        $conn = currentDB();
        $query = "SELECT * FROM post order by pid desc limit 10";
        $result = mysqli_query($conn, $query);
        while ($row = $result -> fetch_assoc()) {
            $username = getActualName($row['uid']);
            $pid = $row['pid'];
            $title = $row['title'];
            $img_path = $row['pimg_path'];
            createCardThumbnail($pid, $username, $title, $img_path, 1);
        }
    }

    function createRecentActivitiesLocation() {
        $conn = currentDB();
        $query = "SELECT * FROM post where lid = {$_SESSION['location']} order by pid desc limit 10";
        $result = mysqli_query($conn, $query);
        while ($row = $result -> fetch_assoc()) {
            $username = getActualName($row['uid']);
            $pid = $row['pid'];
            $title = $row['title'];
            $img_path = $row['pimg_path'];
            createCardThumbnail($pid, $username, $title, $img_path, 1);
        }
    }

    function loadProfileImage() {
        $conn = currentDB();
        $query = "SELECT img_path FROM user where uid = {$_SESSION['user']} limit 1";
        $result = mysqli_query($conn, $query);
        while ($row = $result -> fetch_assoc()) {
            $img_path = $row['img_path'];
            echo "<img src = '{$img_path}' alt='' />";
        }
    }

    function createPost($pid, $userPostVerify) {
        $postLikes = getLikes($pid);
        $conn = currentDB();
        $query = "SELECT * FROM post where pid = {$pid} limit 1";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $username = getActualName($row['uid']);
        $img_path = $row['pimg_path'];
        $description = $row['description'];
        $location = lidToLocation($row['lid']);

        echo "<div class='post-more-card'>
                <div class = 'post-more-information'>
                    <div class ='post-more-activity-name'>
                        <h2> {$title} </h2>
                    </div>
                    <div class = 'post-more-image'>
                        <img src = '{$img_path}' alt='' />
                    </div>
                    <div class='post-more-same-line'>
                        <div class='post-more-user-info'>
                            <h3>{$username}</h3>
                            <h4>{$location}</h4>
                        </div>
                    </div>
                    <p class ='post-more-description'>
                    {$description}
                    </p>";
                    if ($userPostVerify) {
                        echo "<a class='login-bottom-button' href='../php/deletePost.php?pid={$pid}' style='color:white'>Delete Post</a>";
                    }
            echo "<span class='likeBox'> Likes : {$postLikes}</span>
                </div>
            </div>";
    }
?>