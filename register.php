<!--Gemaakt door furkan ucar OITAOO8B -->
<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    // header('location: index.php');
    // exit;
  }
include 'database.php';
include 'HelperFunctions.php';

if(isset($_POST['submit'])){

  // maak een array met alle name attributes
  $fields = [
      "voorletters",
      "voorvoegsels",
      "achternaam",
      "gebruikersnaam",
      "Wachtwoord"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
  if($no_error){
    $usertype_id = $_POST['usertype_id'];
    $voorletters = $_POST['voorletters'];
    $voorvoegsels = $_POST['voorvoegsels'];
    $achternaam = $_POST['achternaam'];
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $Wachtwoord = $_POST['Wachtwoord']; {


    $db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');
    $db->create_medewerker($usertype_id, $voorletters, $voorvoegsels, $achternaam, $gebruikersnaam, $Wachtwoord);

      header('location: index.php');
      exit;
    }
  }
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Registratie scherm</title>
  </head>

  <body>
      <form method="post" align="center" action='register.php' method='post' accept-charset='UTF-8'>
      <fieldset >
        <legend>Registratie medewerker</legend>
        <input type="text" name="usertype_id" placeholder="usertype_id" required/>
        <input type="text" name="voorletters" placeholder="voorletters" required/>
        <input type="text" name="voorvoegsels" placeholder="voorvoegsels" required/>
        <input type="text" name="achternaam" placeholder="achternaam" required/>
        <input type="text" name="gebruikersnaam" placeholder="gebruikersnaam" required/>
        <input type="password" name="Wachtwoord" placeholder="Wachtwoord" required/><br><br>
        <button class="btn btn-outline-success" type="submit" name="submit" value="Sign up!">Register</button>
        <a class="btn btn-outline-info" href="index.php">homepagina</a>
      </fieldset>
    </form>
  </body>
</html>
