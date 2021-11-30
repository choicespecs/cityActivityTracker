<?php
    require '../php/htmlFunctions.php';
    session_start();
    $error_login = 0;
    if (isset($_POST['submitButton'])) {
      if(isset($_POST['username']) && isset($_POST['password'])) {
          try {
              connectDB();
              $success = loginDB($_POST["username"], $_POST["password"]);
              if ($success) { 
                if(isset($_POST['rememberMe']) && $_POST['rememberMe'] == 'yes') {
                  setcookie("username", $_POST["username"], time() + (86400 * 30), "/");
                }
                header('Location: ../index.php');
                die();
              }
          } catch(\Exception $e) {
              var_dump($e->getMessage());
          }
      }
    }

    if (isset($_SESSION['error_login'])) {
      $error_login = $_SESSION['error_login'];
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link rel="stylesheet" href="../style.css" />
  </head>
  <body>
    <nav>
      <div class="logo">
        <h2>City / Activity Tracker</h2>
      </div>
      <ul class="nav-menu">
        <li><a href="../index.php">Home</a></li>
        <li><a href="./login.php">Log In / Sign Up</a></li>
      </ul>
    </nav>
    <section class="screen">
      <div class="login-screen">
        <div class="login-menu">
          <div class="login-description"><h2>Sign In</h2></div>
          <?php if($error_login != 0) : ?>
            <?php
              errorMessage($error_login);
            ?>  
          <?php endif; ?>
          <div class="login-form">
            <form action="#" method="POST">
              <div class="login-name">
                <label for="username">Username</label>
                <input type="text" name="username" required />
              </div>
              <div class="login-password">
                <label for="password">Password</label>
                <input type="password" name="password" required />
              </div>
              <div class="remBox">
                <input type="checkbox" name="rememberMe" value="yes">
                <label for="rememberMe">Remember Me?</label>
              </div>
              <div class="login-bottom">
                <a
                  class="login-bottom-button"
                  href="./register.php"
                  style="color: white"
                  >Don't have an account?</a
                >
                <button type="submit" name="submitButton"> submit </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <script src="../script.js"></script>
  </body>
</html>
<?php if($error_login != 0) : ?>
  <?php
    unset($_SESSION['error_login']);
  ?>
<?php endif; ?>
