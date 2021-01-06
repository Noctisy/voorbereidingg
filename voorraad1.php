<!--Gemaakt door Yusa Celiker OITAOO8B -->
<?php

session_start();

include 'database.php';

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: homepagina.php');
    exit;
  }

$db = new database('localhost', 'root', '', 'hengelsport', 'utf8');
  ?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Voorraad</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
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
      <a class="btn btn-success" href="voorraad.php" style="margin-left:570;">voorrad beheer</a>
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
          $results = $db->get_rotterdam_information(NULL);

          // get the first index of results, which is an associative array.
          $columns = array_keys($results[0]);
          ?>

      <div class="container" style="margin-top:-150px; margin-right:500px;">
          <div class="table-responsive">
              <div class="table-wrapper">
                  <div class="table-title">
                      <div class="row">
                          <div class="col-sm-5">
                              <h2>View edit and delete medewerkers</b></h2>
                          </div>
                      </div>
                  </div>
                  <table class="table table-striped table-hover">
                      <thead>
                          <tr>
                            <?php foreach($columns as $column){ ?>
                                <th><strong> <?php echo $column ?> </strong></th>
                            <?php } ?>
                            <th colspan="2">action</th>
                          </tr>
                      </thead>
                      <?php foreach($results as $rows => $row){ ?>
                          <?php $row_id = $row; ?>
                          <tr>
                              <?php foreach($row as $row_data){?>
                                  <td>
                                      <?php echo $row_data ?>
                                  </td>
                              <?php } ?>
                              <td>
                                  <a class="btn btn-info" href="voorrad1_wijzigen.php?id=<?php echo $row_id; ?>" class="edit_btn" >Edit</a>
                              </td>
                              <td>
                                  <a class="btn btn-danger" href="voorraad1.php?user_id=<?php echo $row_id; ?>&id=<?php echo $row['id']?>" class="del_btn">Delete</a>
                              </td>
                        </tr>
                      <?php } ?>
                </table>
            </body>
        </html>
