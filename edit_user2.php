<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: index.php');
    exit;
  }

include 'database.php';

$db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');

if (isset($_GET['id'])) {

  $account=$db->getAccountInformation($_GET['id']);

  echo $account['voorletters'];

  // $db->editUser($voorletters, $voorvoegsels, $achternaam, $gebruikersnaam);

    // redirect to overview
    // header("location: view_edit_delete_medewerker.php");
    // exit;
}
// stap 1: select statement met where id= getid (haal info op. store in variable. geef mee als value of the value attribute)
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>edit user</title>
  </head>
  <body>
    <form align="center" action='edit_user.php' method='get' accept-charset='UTF-8'>
      <input type="text" name="gebruikersnaam" placeholder="gebruikersnaam" value="" readonly required/><br><br>
      <input type="text" name="voorletters" placeholder="voorletters" value="" required/><br><br>
      <input type="text" name="voorvoegsels" placeholder="voorvoegsels" value="" required/><br><br>
      <input type="text" name="achternaam" placeholder="achternaam" value="" required/><br><br>
    </form>
  </body>
</html>
