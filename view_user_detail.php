<!--Gemaakt door furkan ucar OITAOO8B -->
<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: index.php');
    exit;
  }
include 'database.php';
  ?>

<html>
  <head>
    <meta charset="utf-8">
    <title>View user details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
        .table-responsive{
            overflow-x: unset !important;
        }
    </style>
  </head>

  <body>

    <div align="center">
        <legend> View user details </legend>
        <a class="btn btn-success" href="index.php">Home</a> |
        <a class="btn btn-info" href="view_edit_delete_medewerker.php">View edit delete medewerker</a>
    </div> <br><br>

    <?php

    $db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');
    // show_profile_details_user returns an associative array (get first index first)
    $result_set = $db->view_user_detail($_SESSION['gebruikersnaam'])[0];

    // result_set is an associative array, get keys with array_keys and values with array_values.
    $columns = array_keys($result_set);
    $row_data = array_values($result_set);
    ?>

    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>View user details</b></h2>
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

                    <tr>
                    <?php foreach($row_data as $value){ ?>
                      <td>
                        <?php  echo $value ?>
                      </td>
                    <?php } ?>

                      </tr>
              </table>
            </div>
          </div>
        </div>
    </body>
</html>
