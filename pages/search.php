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
    <title>Search Activities</title>
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
      <div class="search-post-screen">
        <div class="post-screen-card-holder">
          <?php
              if (isset($_POST['submitButton'])) {
                $search_uid = -1;
                $search_lid = -1;
                $search_activity = -1;

                if (!empty($_POST['search-username'])) {
                  $search_uid = returnUsernameID($_POST['search-username']);
                }
                if (!empty($_POST['search-location'])) {
                  $search_lid = validateLocation($_POST['search-location']);
                }

                if (!empty($_POST['search-activity'])) {
                  $search_activity = validateActivity($_POST['search-activity']);
                }
                
                searchActivitiesThumbnail($search_uid, $search_lid, $search_activity); 
              }
          ?>
        </div>
      </div>
      <div class="post-detail-screen" style="justify-content: flex-start">
        <div class="search-box-menu">
          <form action="#" class="search-activity-form" method="POST">
            <h2>Search Activity</h2>
            <div class="search-activity-box">
              <div class="search-box-location">
                <label for="search-location">Location:</label>
                <select name="search-location" id="search-location">
                  <option value="">&nbsp;</option>
                  <?php createLocationDropdown(); ?>
                </select>
              </div>
              <div class="search-box-activity">
                <label for="search-activity">Activity:</label>
                <select name="search-activity" id="search-activity">
                  <option value="">&nbsp;</option>
                  <?php createActivityDropdown(); ?>
                </select>
              </div>
            </div>
            <div class="search-name">
              <label for="search-username">Username</label>
              <input type="text" name="search-username" />
            </div>
            <input type="submit" name="submitButton" />
          </form>
        </div>
      </div>
    </section>
    <script src="../script.js"></script>
  </body>
</html>
