<!--Gemaakt door Yusa Celiker OITAOO8B -->
<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: homepagina.php');
    exit;
  }
include 'database.php';
include 'HelperFunctions.php';

if(isset($_POST['submit'])){

  // maak een array met alle name attributes
  $fields = [
      "leverancier",
      "telefoon"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
  if($no_error){
    $leverancier = $_POST['leverancier'];
    $telefoon = $_POST['telefoon'];


    $db = new database('localhost', 'root', '', 'hengelsport', 'utf8');
    $db->create_leverancier($leverancier, $telefoon);

      header('location: view_edit_delete_leverancier.php');
      exit;
    }
  }
?>

<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>leverancier toevoegen</title>
  </head>

  <body>
    <div>
      <legend style="text-align: center;"> DE HENGELSPORT </legend>
      <img src="img\logo.png">
      <a class="btn btn-success" href="view_edit_delete_leverancier.php" style="margin-left:530;">leverancier beheer</a>
      <a class="btn btn-danger" href="logout.php" style="margin-left:760px; margin-top:-200px">Logout</a>
        <div class="topnav">
          <a class="btn btn-outline-info" href="view_edit_delete_artikelen.php">view edit artikelen</a><br><br>
          <a class="btn btn-outline-info" href="view_edit_delete_leverancier.php">view edit leverancier</a><br><br>
          <a class="btn btn-outline-info" href="view_edit_delete_locatie.php">view edit locatie</a><br><br>
          <a class="btn btn-outline-info" href="voorraad.php">voorraad bekijken</a><br><br>
          <a class="btn btn-outline-info" href="contact.php">contact pagina</a><br><br>
        </div>
      </div>

      <form method="post" align="center" action='leverancier_toevoegen.php' method='post' accept-charset='UTF-8' style="margin-top:-200px;">
      <fieldset>
        <legend>leverancier toevoegen</legend>
        <input type="text" name="leverancier" placeholder="leverancier" required/>
        <input type="text" name="telefoon" placeholder="telefoon" required/>
        <button class="btn btn-outline-success" type="submit" name="submit" value="Sign up!">Register</button>
      </fieldset>
    </form>
  </body>
</html>
