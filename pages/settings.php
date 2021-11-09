<?php
    require '../php/htmlFunctions.php';
    session_start();
    verifyLogin();
    $settings_error = 0;
    if (isset($_POST['submitButton'])) {
        $changed = 0;
        if($_FILES['profile-img']['size'] != 0) {
          $file_img = $_FILES["profile-img"];
          uploadUserImage($file_img, $_SESSION['user']);
          $changed = 1;
        }   

        if (!empty($_POST['settings-location'])) {
          $new_lid = validateLocation($_POST['settings-location']);
          updateLocation($new_lid);
          $_SESSION['location'] = $new_lid;
          $changed = 1;
        }

        if (!empty($_POST['change-bio'])) {
          updateBio($_POST['change-bio']);
          $changed = 1;
        }

        if ($changed) {
          header('Location: ./profile.php');
        }
    }

    if (isset($_SESSION['settings-error'])) {
      $settings_error = $_SESSION['settings-error'];
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
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
          <div class="setting-description">
            <div class="profile-image">
              <?php loadProfileImage(); ?> 
            </div>
            <?php if($settings_error != 0) : ?>
              <?php
                errorMessage($settings_error);
              ?>  
            <?php endif; ?>
            <form name="settings" action="#" method="POST" enctype="multipart/form-data">
            <h5>Profile Image Change:</h5>
              <input
                type="file"
                name="profile-img"
              />
            <div class="profile-info">
              <h2>
                <?php $actual_name  = getActualName($_SESSION['user']); echo "${actual_name}"; ?>
              </h2>
                <div class="settings-location">
                  <label for="settings-location">Location:</label>
                  <select name="settings-location" id="settings-location">
                    <option value="">&nbsp;</option>
                    <?php createLocationDropdown(); ?>
                  </select>
                </div>
            </div>
          </div>
          <div class="settings-bio">
            <h3>Change Bio:</h3>
              <textarea name="change-bio" id="" cols="50" rows="5" maxlength="150"></textarea>
              <input type="submit" name="submitButton" />
          </div>
          </form>
          <div class="profile-settings-holder">
            <a
              href="./profile.php"
              class="profile-settings-button"
              style="color: white"
              >Profile</a
            >
          </div>
        </div>
      </div>
    </section>
    <script src="../script.js"></script>
  </body>
</html>
<?php if($settings_error != 0) : ?>
  <?php
    unset($_SESSION['settings-error']);
  ?>
<?php endif; ?>
