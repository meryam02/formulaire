<?php
session_start();

// connect to the database
include 'config.php';
include 'registration.html';
// define constants for input validation
define('USERNAME_MAX_LENGTH', 50);
define('PASSWORD_MIN_LENGTH', 8);
define('PASSWORD_MAX_LENGTH', 20);

if(isset($_POST['username_or_email']) && isset($_POST['password'])){
    // sanitize and validate inputs
    $username_or_email = filter_var(trim($_POST['username_or_email']), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
    if (empty($username_or_email) || empty($password)) {
        // both fields are required
        echo "<p class='error'>Les deux champs sont obligatoires.</p> ";
        exit;
    }
    if (strlen($username_or_email) > USERNAME_MAX_LENGTH) {
        echo "<p class='error'>L'identifiant doit contenir au plus ".USERNAME_MAX_LENGTH." caractères.</p> ";
        exit;
    }
    if (strlen($password) < PASSWORD_MIN_LENGTH || strlen($password) > PASSWORD_MAX_LENGTH) {
        echo "<p class='error'>Le mot de passe doit contenir entre ".PASSWORD_MIN_LENGTH." et ".PASSWORD_MAX_LENGTH." caractères.</p> ";
        exit;
    }

    // check if the username or email already exists in the database
    $stmt = mysqli_prepare($db, "SELECT * FROM registration WHERE username_or_email = ?");
    mysqli_stmt_bind_param($stmt, "s", $username_or_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // username or email already exists
        echo "<p class='error'>Un compte avec le même identifiant existe déjà.</p> ";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // insert data into the database
        $stmt = mysqli_prepare($db, "INSERT INTO registration (username_or_email, password) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $username_or_email, $hashed_password);
        mysqli_stmt_execute($stmt);

        if(mysqli_affected_rows($db) > 0) {
            echo "<p class='success'>Le compte a été ajouté avec succès.</p>";
        } else {
            echo "<p class='error'>Une erreur est survenue lors de l'ajout du compte. Veuillez réessayer plus tard.</p>";
        }
    }
}
?>





