<?php

// database connection information
define("DB_HOST", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "login_db");

// connect to the database
$db = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$db) {
    die("Connection error..." . mysqli_connect_error());
}

?>
