<!--Gemaakt door Yusa Celiker OITAOO8B -->
<?php

session_start();

include 'database.php';

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
      <a class="btn btn-danger" href="login.php" style="margin-left:1790px; margin-top:-200px">login</a>
        <div class="topnav">
          <a class="btn btn-outline-info" href="welcome_user.php">home</a><br><br>
          <a class="btn btn-outline-info" href="voorraad_klant.php">voorraad bekijken</a><br><br>
          <a class="btn btn-outline-info" href="contact.php">contact pagina</a><br><br>
        </div>
      </div>

    <?php

        // admin should be able to see all users. should not filter on user, hence the NULL.
        $results = $db->get_voorraad_information(NULL);

        // get the first index of results, which is an associative array.
        $columns = array_keys($results[0]);
        $values = array_values($results);
        ?>


      <div class="container" style="margin-top:-200px; margin-right:500px;">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>View edit and delete locatie</b></h2>
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
                        <?php $row_id = $row; ?>
                        <tr>
                            <?php foreach($row as $row_data){?>
                                <td>
                                    <?php echo $row_data ?>
                                </td>
                            <?php } ?>
                      </tr>
                    <?php } ?>
              </table>
            </body>
        </html>
