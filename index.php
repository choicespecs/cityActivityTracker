<?php
    require_once('./php/htmlFunctions.php');
    session_start();
    verifyCookie();
    $logged_in = 0;
    if (isset($_SESSION['logged_in'])) {
      $logged_in = $_SESSION['logged_in'];
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home Page</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <nav>
      <div class="logo">
        <h2>City / Activity Tracker</h2>
      </div>
      <ul class="nav-menu">
        <li><a href="index.php">Home</a></li>
        <?php if($logged_in == 1) : ?>
          <li><a href="./php/logout.php">Logout</a></li>
          <li><a href="./pages/search.php">Search</a></li>
          <li><a href="./pages/profile.php">Profile</a></li>
          <li><a href="./pages/createPost.php">Create Post</a></li>
        <?php endif; ?>
        <?php if($logged_in == 0) : ?>
          <li><a href="./pages/login.php">Log In / Sign Up</a></li>
        <?php endif; ?>   
      </ul>
    </nav>
    <section class="screen">
      <div class="post-screen">
        <div class="post-screen-cityinfo">
          <h2 class="city-info-name">
            <?php if($logged_in == 0) : ?>
              Recent Activities
            <?php endif; ?>
            <?php if($logged_in != 0) : ?>
              Recent Activities in 
              <?php 
                  $location = getLocationName($_SESSION['user'], $_SESSION['location']); 
                  echo "${location}"; 
                ?>
            <?php endif; ?>
          </h2>
        </div>
        <div class="post-screen-card-holder">
          <?php if($logged_in == 0) : ?>
            <?php createRecentActivities(); ?>
          <?php endif; ?>
          <?php if($logged_in != 0) : ?>
            <?php createRecentActivitiesLocation(); ?>
          <?php endif; ?>
        </div>
      </div>
    </section>
    <script src="./script.js"></script>
  </body>
</html>
