<?php    
    require '../php/htmlFunctions.php';
    session_start();
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
    <title>Post Page</title>
    <link rel="stylesheet" href="../style.css" />
  </head>
  <body>
    <nav>
      <div class="logo">
        <h2>City / Activity Tracker</h2>
      </div>
      <ul class="nav-menu">
        <li><a href="../index.php">Home</a></li>
        <?php if($logged_in == 1) : ?>
          <li><a href="../php/logout.php">Logout</a></li>
          <li><a href="./search.php">Search</a></li>
          <li><a href="./profile.php">Profile</a></li>
          <li><a href="./createPost.php">Create Post</a></li>
        <?php endif; ?>
        <?php if($logged_in == 0) : ?>
          <li><a href="./login.php">Log In / Sign Up</a></li>
        <?php endif; ?>  
      </ul>
    </nav>
    <section class="screen">
      <div class="post-more-screen">
        <?php createPost($_GET['pid']); ?>
      </div>
    </section>
  </body>
</html>
