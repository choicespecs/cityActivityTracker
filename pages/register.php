<?php
    require '../php/htmlFunctions.php';
    session_start();
    $reg_error = 0;

    if (isset($_POST['submitButton'])) {
      registerDB($_POST["username"], $_POST['password'], $_POST['real-name'], $_POST['user-location']);
    }

    if (isset($_SESSION['register_error'])) {
      $reg_error = $_SESSION['register_error'];
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register Account</title>
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
          <div class="login-description"><h2>Register</h2></div>
          <?php if($reg_error != 0) : ?>
            <?php
              errorMessage($reg_error);
            ?>
          <?php endif; ?>
          <div class="register-form">
            <form name="register" action="#" method ="POST" onsubmit = "return validateRegisterForm()">
              <div class="login-name">
                <label for="real-name">Actual Name</label>
                <input type="text" name="real-name" required />
                <label for="username">Username</label>
                <input type="text" name="username" required />
              </div>
              <div class="login-password">
                <label for="password">Password</label>
                <input type="password" name="password" required />
              </div>
              <div class="login-location">
                <label for="user-location">Location:</label>
                <select name="user-location" id="user-location">
                  <?php createLocationDropdown(); ?>
                </select>
              </div>
              <div class="login-bottom">
                <a
                  class="login-bottom-button"
                  href="./login.php"
                  style="color: white; justify-content: center"
                  >Already have an account?</a
                >
                <button type="submit" name="submitButton"> register </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <script src="../script.js"></script>
  </body>
</html>
<?php if($reg_error != 0) : ?>
  <?php
    unset($_SESSION['register_error']);
  ?>
<?php endif; ?>
