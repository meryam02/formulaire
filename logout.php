<html>
<head>
    <title>My Page</title>
    <style>

        .welcome {
            font-size: 24px;
            font-weight: bold;
            color :  blue;
        }

        input[type="submit"] {
            font-weight: bold;
            font-size: 24px;
            padding: 10px 20px;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <?php
        session_start();
        include 'config.php';
        if (isset($_SESSION['username_or_email'])) {
            //echo "<p>Welcome, " . $_SESSION['username_or_email'] . "!</p>";
            echo '<p><span class="welcome">Welcome, ' . $_SESSION['username_or_email'] . '!</span></p>';
            echo "<form action='index.php'><input type='submit' value='Logout'></form>";
            if (isset($_POST['logout'])) {
                session_destroy();
                header("Location: index.php");
                exit;
            }
        } else {
            header("Location: index.php");
            exit;
        }        
    ?>
</body>
</html>


