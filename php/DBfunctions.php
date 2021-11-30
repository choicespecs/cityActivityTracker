<?php

    function connectDB() {
        // Working on Local Machine
        $host = '127.0.0.1';
        $port = 3306;
        $dbname = 'csci4300project';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $db = new mysqli($host, $user, $pass, $dbname, $port);
            $db->set_charset($charset);
            $db->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
            echo "<script>console.log('Connected to the DB' );</script>";
        } catch (\mysqli_sql_exception $e) {
            throw new \mysqli_sql_exception($e->getMessage(), $e->getCode());
            echo "<script>console.log('not connected' );</script>";
        }
    }

    function currentDB() {
        // Working on Local MACHINE
        $host = '127.0.0.1';
        $dbname = 'csci4300project';
        $user = 'root';
        $pass = '';
        $conn = mysqli_connect($host, $user, $pass, $dbname);
        return $conn;
    }

    function loginDB($uname, $upass) {
        $query = "select * from user where username = '".$uname."' AND password = '".$upass."' limit 1";
        $conn = currentDB();
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $user_data = mysqli_fetch_assoc($result);
            $_SESSION['user'] = $user_data['uid'];
            $_SESSION['location'] = $user_data['lid'];
            $_SESSION['logged_in'] = 1;
            $_SESSION['error_login'] = 0;
            return 1;
        } 
        else 
        {
            closeDB($conn);
            $_SESSION['error_login'] = 3;
            return 0;
        }
    }

    function loginDBCookie($uname) {
        $query = "select * from user where username = '".$uname."' limit 1";
        $conn = currentDB();
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $user_data = mysqli_fetch_assoc($result);
            $_SESSION['user'] = $user_data['uid'];
            $_SESSION['location'] = $user_data['lid'];
            $_SESSION['logged_in'] = 1;
            $_SESSION['error_login'] = 0;
        } 
    }

    function registerDB($username, $password, $actual_name, $location) {
        $username = cleanString($username);
        $usernameExists = checkUsername($username);
        if ($usernameExists == 0) {
            header('Location: ../pages/register.php');
            die();
        } else {
            $password = cleanString($password);
            $actual_name = validateActualName($actual_name);
            $lid = validateLocation($location);

            $conn = currentDB();    
            $query = "INSERT INTO user(uid, username, password, actual_name, bio, lid)  VALUES (NULL, '$username', '$password', '$actual_name', '', '$lid')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                header('Location: ../pages/login.php');
            } else {
                echo "<script>console.log('cannot insert' );</script>";
            }
        }
    }

    function baseString($string) {
        // Strip HTML Tags
        $clear = strip_tags($string);
        // Clean up things like &amp;
        $clear = html_entity_decode($clear);
        // Strip out any url-encoded stuff
        $clear = urldecode($clear);
        // Replace non-AlNum characters with space
        $clear = preg_replace('/[^_.A-Za-z0-9]/', ' ', $clear);
        // Replace Multiple spaces with single space
        $clear = preg_replace('/ +/', ' ', $clear);
        // Trim the string of leading/trailing space
        $clear = trim($clear);
        $clear = preg_replace("/\s+/", "", $clear);

        return $clear;
    }

    function closeDB($conn) {
        mysqli_close($conn);
        echo "<script>console.log('you have disconnected from Database' );</script>";
    }

    function removeSessions() {
        session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(), '', 0, '/');
    }

    function checkUsername($username) {
        if (empty($username)) {
            $_SESSION['register_error'] = 1;
            return 0;
            die();
        }

        $conn = currentDB();
        $query = "select * from user where username = '{$username}' limit 1";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['register_error'] = 2;
            return 0;
        } 
        else 
        {
            $_SESSION['register_error'] = 0;
            return 1;
        }
    }

    function returnUsernameID($username) {
        $conn = currentDB();
        $query = "select uid from user where username = '{$username}' limit 1";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $uid = intval($row['uid']);
        return $uid;
    }


    function cleanString($string) {
        $clean = trim($string);
        $clean = strip_tags($clean);
        $clean = htmlspecialchars($clean);
        return $clean;
    }

    function validateActualName($name) {
        $clean_name = strip_tags($name);
        $clean_name = htmlspecialchars($clean_name);
        return $clean_name;
    }

    function lidToLocation($lid) {
        $conn = currentDB();
        $query = "select city from location where lid = '{$lid}' limit 1";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $location = $row['city'];
        return $location;
    }

    function validateLocation($location) {
        $conn = currentDB();
        $query = "select lid from location where city = '{$location}' limit 1";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $lid = intval($row['lid']);
        return $lid;
    }

    function validateImage($img) {
        $check = getimagesize($img['tmp_name']);
        if ($check == false) {
            return 0;
        }

        if ($img['size'] > 500000) {
            return 0;
        }
    }

    function validateActivity($activity) {
        $conn = currentDB();
        $query = "select aid from activity where aname = '{$activity}' limit 1";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $aid = intval($row['aid']);
        return $aid;
    }

    function getLikes($pid) {
        $conn = currentDB();
        $query = "select count(uid) from postlikes where pid = {$pid}";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $postLikes = intval($row['count(uid)']);
        return $postLikes;
    }

    function confirmLike($pid) {
        $query = "select pid from postlikes where pid = {$pid} AND uid = {$_SESSION['user']}";
        $conn = currentDB();
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    function checkUserImage($img) {
        $user_img_dir = "../user_img/";
        $target_file = $target_dir . basename($img["name"]);

        if (file_exists($img)) {
            return 0;
        } else {
            return 1;
        }
    }

    function checkPostImage($img) {
        $user_img_dir = "../post_img/";
        $target_file = $target_dir . basename($img["name"]);

        if (file_exists($img)) {
            return 0;
        } else {
            return 1;
        }
    }

    function uploadUserImage($img, $uid) {
        $target_dir = "../user_img/";
        $img_name = baseString($img['name']);
        $target_file = $target_dir . basename($img_name);

        if (file_exists($target_file)) {
            $_SESSION['settings-error'] = 1;
        } else {
            move_uploaded_file($img['tmp_name'], $target_file);
    
            $conn = currentDB();
            $query = "update user set img_path = '${target_file}' where uid = {$uid} limit 1";
            $result = mysqli_query($conn, $query);
        }
        
    }

    function uploadPostImage($img, $uid, $pid) {  
        $img_name = baseString($img["name"]);
        $target_dir = "../post_img/";
        $target_file = $target_dir . basename($img_name);
        if (file_exists($target_file)) {
            $_SESSION['create-error'] = 1;
            $target_file = 'error';
        } else {
            move_uploaded_file($img['tmp_name'], $target_file);
        }
        return $target_file;
    }

    function updateLocation($new_lid) {
        $conn = currentDB();
        $query = "update user set lid = {$new_lid}";
        $result = mysqli_query($conn, $query);
    }

    function updateBio($new_bio) {
        $conn = currentDB();
        $query = "update user set bio = '{$new_bio}' where uid = {$_SESSION['user']}";
        $result = mysqli_query($conn, $query);
    }

    function verifyUserToPost($pid) {
        $userPostTrue = 0;
        $conn = currentDB();
        $query = "select uid from post where pid = {$pid} limit 1";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $uid = intval($row['uid']);
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user'] == $uid) {
                $userPostTrue = 1;
            }
        }
        return $userPostTrue;
    }

    function createActivityPost($img, $activity_name, $activity_location, $activity_type, $activity_description) {
        $post_img_path = uploadPostImage($img, $_SESSION['user'], $_SESSION['location']);
        if ($post_img_path != 'error') {
            $location = validateLocation($activity_location);
            $activity = validateActivity($activity_type);
            $user_id = $_SESSION['user'];
    
            $conn = currentDB();
            $query = "INSERT INTO `post` (`pid`, `uid`, `lid`, `aid`, `title`, `description`, `pimg_path`) VALUES (NULL, '$user_id', '$location', '$activity', '$activity_name', '$activity_description', '$post_img_path')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                echo "<script>console.log('post created' );</script>";
            } else {
                echo "<script>console.log('cannot add post' );</script>";
            }
        }
    }

?>