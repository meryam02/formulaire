<?php
session_start();

if (!isset($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


// connect to the database
include 'config.php';
$error_message = "";
// check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // check if the username/email and password fields are set
    if (isset($_POST['username_or_email'], $_POST['password'])) {
        $username_or_email = mysqli_real_escape_string($db, $_POST['username_or_email']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        // Use prepared statements to prevent SQL injection
        $stmt = mysqli_prepare($db, "SELECT * FROM registration WHERE username_or_email = ?");
        mysqli_stmt_bind_param($stmt, "s", $username_or_email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($row && password_verify($password, $row['password'])) {

            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            // Set a secure flag for the session cookie to prevent it from being sent over unencrypted connections
            $session_cookie_params = session_get_cookie_params();
            $session_cookie_secure = true;
            $session_cookie_httponly = true;
            setcookie(session_name(), session_id(), 0, $session_cookie_params['path'], $session_cookie_params['domain'], $session_cookie_secure, $session_cookie_httponly);

            // Clear the session variables array and only store the necessary information
            $_SESSION = array();
            $_SESSION['username_or_email'] = $username_or_email;

            header('Location: logout.php');
            exit();

        } else {
            // Use htmlspecialchars to prevent XSS attacks
            $error_message = "<span class='error'>" . htmlspecialchars(" L'identifiant ou le mot de passe saisi est incorrect.") . "</span>";

        }
    } else {
        // display error message
        $error_message = "Erreur de soumission du formulaire.";
    }
}
?>


<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <img src="logo.png" alt="Logo" alt="Your Logo" width="100" height="100">
    <form class="form-signin" method="POST" name="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
      <h2 class="form-signin-heading">Se connecter</h2>
      <?php if(isset($error_message)) { ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
      <?php } ?>
      <?php if(isset($success_message)) { ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
      <?php } ?>
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">Identifiant</span>
        <input type="text" name="username_or_email" id="username_or_email" class="form-control" placeholder="Username or Email" required>
      </div>
      <br>
      <label for="inputPassword" class="sr-only">Mot de passe</label>
      <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
      <br>
      <div class="buttons">
        <input name="submit" type="submit" value="Ok" />
        <input name="reset" type="reset" value="Reset"/>
        <a class="btn btn-lg btn-primary btn-block" href="registration.php">Ajouter un compte</a>
      </div>
      <!-- Include the CSRF token as a hidden input field in the form -->
      <input type="hidden" name="csrf_token" value = " <?php echo $_SESSION['csrf_token']; ?> ">
    </form>
  </div>

  <script>
    function validateForm() {
      var username_or_email = document.forms["login"]["username_or_email"].value;
      var password = document.forms["login"]["password"].value;
      if (username_or_email == "" || password == "") {
        alert("Both fields are required.");
        return false;
      }
      return true;
    }
  </script>
</body>
