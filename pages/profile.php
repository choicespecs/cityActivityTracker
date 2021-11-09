<?php
    require '../php/htmlFunctions.php';
    session_start();
    verifyLogin();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile Page</title>
    <link rel="stylesheet" href="../style.css" />
  </head>
  <body>
    <nav>
      <div class="logo">
        <h2>City / Activity Tracker</h2>
      </div>
      <ul class="nav-menu">
        <li><a href="../index.php">Home</a></li>
        <li><a href="../php/logout.php">Logout</a></li>
        <li><a href="./search.php">Search</a></li>
        <li><a href="./profile.php">Profile</a></li>
        <li><a href="./createPost.php">Create Post</a></li>
      </ul>
    </nav>
    <section class="screen">
      <div class="profile-screen">
        <div class="profile-menu">
          <div class="profile-description">
            <div class="profile-image">
              <?php loadProfileImage(); ?>
            </div>
            <div class="profile-info">
              <h2>
                <?php $actual_name  = getActualName($_SESSION['user']); echo "${actual_name}"; ?>
              </h2>
              <ul class="profile-stats">
                <li>
                  Activities: <br />
                  <span class="user-activities">
                    <?php $number_activity = getNumberActivity($_SESSION['user']); echo "${number_activity}"; ?></span>
                </li>
                <li>
                  Location:<br />
                  <span class="user-location">
                    <?php $location = getLocationName($_SESSION['user'], $_SESSION['location']); echo "${location}"; ?>
                  </span>
                </li>
              </ul>
            </div>
          </div>
          <div class="profile-bio">
            <h3>Bio:</h3>
            <p>
              <?php $bio = getBio($_SESSION['user']); echo "${bio}"; ?>
            </p>
          </div>
          <div class="profile-settings-holder">
            <a
              href="./settings.php"
              class="profile-settings-button"
              style="color: white"
              >Settings</a
            >
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
