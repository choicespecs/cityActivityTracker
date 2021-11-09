<?php
    require '../php/htmlFunctions.php';
    session_start();
    verifyLogin();
    $create_error = 0;

    if (isset($_POST['submitButton'])) {
      createActivityPost($_FILES["post-img"], $_POST['post-name'], $_POST['post-location'], $_POST['post-activity'], $_POST['post-description']);

      /*
      $file_img = $_FILES["post-img"];
      $post_img_path = uploadPostImage($file_img, $_SESSION['user'], $_SESSION['location']);
      $activityName = $_POST['post-name'];
      $location = validateLocation($_POST['post-location']);
      $activity = validateActivity($_POST['post-activity']);
      $user_id = $_SESSION['user'];
      $description = $_POST['post-description'];

      $conn = currentDB();
      $query = "INSERT INTO `post` (`pid`, `uid`, `lid`, `aid`, `title`, `description`, `pimg_path`) VALUES (NULL, '$user_id', '$location', '$activity', '$activityName', '$description', '$post_img_path')";
      $result = mysqli_query($conn, $query);
      if ($result) {
          echo "<script>console.log('post created' );</script>";
      } else {
          echo "<script>console.log('cannot add post' );</script>";
      }
      */
    }

    if (isset($_SESSION['create-error'])) {
      $create_error = $_SESSION['create-error'];
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Activity Post</title>
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
      <div class="post-more-screen">
        <div class="post-more-card">
          <h2 style="margin-bottom: 1em">Create Activity Post</h2>
            <?php if($create_error != 0) : ?>
              <?php
                errorMessage($create_error);
              ?>  
            <?php endif; ?>
          <form name="create" action="#" class="create-post-form" method="POST" enctype="multipart/form-data" onsubmit="return validateCreatePost()">
            <div class="create-post-info">
              <h4>Upload Photo</h4>
              <input type="file" name="post-img" required />
              <label for="post-name">Create Actvity name</label>
              <input type="text" name="post-name" required />
              <div class="create-post-location-activity">
                <label for="create-post-location">Location:</label>
                <select name="post-location">
                  <?php createLocationDropdown(); ?>
                </select>
                <label for="create-post-activity">Activity:</label>
                <select name="post-activity">
                  <?php createActivityDropdown(); ?>
                </select>
              </div>
            </div>
            <div class="create-post-description-flex">
              <h4>Create Description:</h4>
              <textarea
                name="post-description"
                id=""
                cols="60"
                rows="10"
              ></textarea>
            </div>
            <button type="submit" name="submitButton">Submit</button>
          </form>
        </div>
      </div>
    </section>
    <script src="../script.js"></script>
  </body>
</html>
<?php if($create_error != 0) : ?>
  <?php
    unset($_SESSION['create-error']);
  ?>
<?php endif; ?>