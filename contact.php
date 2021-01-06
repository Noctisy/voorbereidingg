<?php
// initialize the session
session_start();

?>

<html>
    <head>
        <title>home</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    </head>
    <body>
      <div>
        <legend style="text-align: center;"> DE HENGELSPORT </legend>
      <img src="img\logo.png">
        <a class="btn btn-danger" href="logout.php" style="margin-left:1790px; margin-top:-200px">Logout</a>
          <div class="topnav">
            <a class="btn btn-outline-info" href="welcome_user.php">home</a><br><br>
            <a class="btn btn-outline-info" href="voorraad_klant.php">voorraad bekijken</a><br><br>
            <a class="btn btn-outline-info" href="contact.php">contact pagina</a><br><br>
          </div>
        <!-- make sure to encode to avoid loading any script -->

      <div align="center" style="margin-top:-100px;">
        <p>1e adres: Rotterdam de herenstraat 42069 1069pp tel:062342312</p>
        <p>2e adres: zoutermeer de heeheestraat 123 1069pp tel:062344442</p>
        <p>3e adres: amsterdam de kees 420619 1239pp tel:06235477812</p>
      </div>
    </body>
</html>
