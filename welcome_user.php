<?php
// initialize the session
session_start();

// check if the user is logged in. redirect to login if not the case.
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: login.php');
    exit;
}
?>

<html>
    <head>
        <title>home</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    </head>
    <body>
        <div class="topnav">
          <a class="btn btn-outline-success" href="view_user_detail.php">view user information</a>
          <a class="btn btn-outline-danger" href="register.php">account registreren</a>
          <a class="btn btn-danger" href="logout.php">Logout</a>
        </div>
        <!-- make sure to encode to avoid loading any script -->
        <?php echo "Welcome " . htmlentities( $_SESSION['gebruikersnaam']) ."!" ?>
    </body>
</html>
