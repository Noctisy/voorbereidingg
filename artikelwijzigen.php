<!--Gemaakt door Yusa Celiker OITAOO8B -->
<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: homepagina.php');
    exit;
  }
include 'database.php';
include 'HelperFunctions.php';

$db = new database('localhost', 'root', '', 'hengelsport', 'utf8');

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $product = $_GET['product'];
  // $type = $_GET['type'];
  // $inkoopprijs = $_GET['inkoopprijs'];
  // $verkoopprijs = $_GET['verkoopprijs'];

  $account=$db->get_artikel_information($id);
  // redirect to overview
  header("location: artikelwijzigen.php");
  exit;
}

if(isset($_POST['submit'])){

  // maak een array met alle name attributes
  $fields = [
      "id",
      "product",
      "type",
      "inkoopprijs",
      "verkoopprijs"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
  if($no_error){
    $id = $_POST['id'];
    $product = $_POST['product'];
    $type = $_POST['type'];
    $inkoopprijs = $_POST['inkoopprijs'];
    $verkoopprijs = $_POST['verkoopprijs'];


    $db->update_artikel($id, $product, $type, $inkoopprijs, $verkoopprijs);

      header('location: artikelwijzigen.php');
      exit;
    }
  }
?>

<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Artikel wijzigen</title>
    <style>
        .table-responsive{
            overflow-x: unset !important;
        }
    </style>
  </head>

  <body>
    <div>
      <legend style="text-align: center;"> DE HENGELSPORT </legend>
      <img src="img\logo.png">
      <a class="btn btn-success" href="view_edit_delete_artikelen.php" style="margin-left:530;">artikel beheer</a>
      <a class="btn btn-danger" href="logout.php" style="margin-left:760px; margin-top:-200px">Logout</a>
        <div class="topnav">
          <a class="btn btn-outline-info" href="view_edit_delete_artikelen.php">view edit artikelen</a><br><br>
          <a class="btn btn-outline-info" href="view_edit_delete_leverancier.php">view edit leverancier</a><br><br>
          <a class="btn btn-outline-info" href="view_edit_delete_locatie.php">view edit locatie</a><br><br>
          <a class="btn btn-outline-info" href="voorraad.php">voorraad bekijken</a><br><br>
          <a class="btn btn-outline-info" href="contact.php">contact pagina</a><br><br>
        </div>
      </div>
    <?php

        // admin should be able to see all users. should not filter on user, hence the NULL.
        $results = $db->get_artikel_information(NULL);

        // get the first index of results, which is an associative array.
        $columns = array_keys($results[0]);
        ?>

    <div class="container" style="margin-top:-250px; margin-right:500px;">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>Artikel wijzigen</b></h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                          <?php foreach($columns as $column){ ?>
                              <th><strong> <?php echo $column ?> </strong></th>
                          <?php } ?>
                        </tr>
                    </thead>
                    <?php foreach($results as $rows => $row){ ?>
                        <?php $row_id = $row['id']; ?>
                        <tr>
                            <?php foreach($row as $row_data){?>
                                <td>
                                    <?php echo $row_data ?>
                                </td>
                            <?php } ?>
                      </tr>
                    <?php } ?>
              </table>
              <form method="post" align="center" action='artikelwijzigen.php' method='post' accept-charset='UTF-8'>
                <fieldset>
                  <input type="text" name="id" placeholder="id" required/>
                  <input type="text" name="levID" placeholder="cant change" disabled required/>
                  <input type="text" name="product" placeholder="product" required/>
                  <input type="text" name="type" placeholder="type" required/>
                  <input type="text" name="inkoopprijs" placeholder="inkoopprijs" required/>
                  <input type="text" name="verkoopprijs" placeholder="verkoopprijs" required/>
                  <button class="btn btn-outline-success" type="submit" name="submit" value="Sign up!">Update!</button>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
    </body>
  </html>
