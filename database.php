<!--Gemaakt door furkan ucar OITAOO8B -->
  <?php
  //class database aan gemaakt
  class database{
    // class met allemaal private variables aangemaakt (property)
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset;
    private $pdo;

    // maakt class constants (admin en user)
    const ADMIN = 1; // these are the values from the db
    const USER = 2;

    public function __construct($host, $user, $pass, $db, $charset){
      $this->host = $host;
      $this->user = $user;
      $this->pass = $pass;
      $this->charset = $charset;

      try {
          $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
          $options = [
              PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
              PDO::ATTR_EMULATE_PREPARES   => false,
          ];

          $this->pdo = new PDO($dsn, $user, $pass, $options);
      } catch (\PDOException $e) {
          echo $e->getMessage();
          throw $e;
          // throw new \PDOException($e->getMessage(), (int)$e->getCode());
      }
    }

    private function is_admin($gebruikersnaam){
        $query = "SELECT usertype_id FROM medewerker WHERE gebruikersnaam = :gebruikersnaam";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['gebruikersnaam'=>$gebruikersnaam]);

        // result is an associative array (key-value pair)
        $result = $stmt->fetch();

        if($result['usertype_id'] == self::ADMIN){
            return true;
        }

        // user is not admin
        return false;
    }

    private function check_username($username){
        $query = "SELECT *
                FROM account
                WHERE username=:username";

        $stmt = $this->pdo->prepare($query);

        $stmt->execute(['username'=>$username]);

        $result = $stmt->fetch();

    }

    public function deleteUser($id){
        echo $id;
        try{
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("DELETE FROM medewerker WHERE id=:id");
            $stmt->execute(['id'=>$id]);

            $this->pdo->commit();

        }catch(Exception $e){
            $this->pdo->rollback();
            echo 'Error: '.$e->getMessage();
        }
    }

    public function editUser($id, $voorletters, $voorvoegsels, $achternaam){
      $query = "  UPDATE
                    medewerker
                  SET
                    voorletters = :voorletters,
                    voorvoegsels = :voorvoegsels,
                    achternaam = :achternaam
                  WHERE id = :id";

      $statement = $this->pdo->prepare($query);

      $statement->execute([
      'id'=>$id,
      'voorletters'=>$voorletters,
      'voorvoegsels'=>$voorvoegsels,
      'achternaam'=>$achternaam
      ]);

      $medewerker_id = $this->pdo->lastInsertId();
      return $medewerker_id;
    }

    public function getAccountInformation($id){
        $statement = $this->pdo->prepare("SELECT * FROM medewerker WHERE id=:id");
        $statement->execute(['id'=>$id]);
        $account = $statement->fetch(PDO::FETCH_ASSOC);
        return $account;
    }

    public function view_user_detail($gebruikersnaam){

        $query = "SELECT id, voorletters, voorvoegsels, achternaam, gebruikersnaam FROM medewerker

        ";

        if($gebruikersnaam !== NULL){
            // query for specific user when a username is supplied
            $query .= 'WHERE gebruikersnaam = :gebruikersnaam';
        }

        $stmt = $this->pdo->prepare($query);

        // check if username is supplied, if so, pass assoc array to execute
        $gebruikersnaam !== NULL ? $stmt->execute(['gebruikersnaam'=>$gebruikersnaam]) : $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function create_medewerker($usertype_id, $voorletters, $voorvoegsels, $achternaam, $gebruikersnaam, $wachtwoord){
      $query = "INSERT INTO medewerker
            (id, usertype_id, voorletters, voorvoegsels, achternaam, gebruikersnaam, wachtwoord)
            VALUES
            (NULL, :usertype_id, :voorletters, :voorvoegsels, :achternaam, :gebruikersnaam, :wachtwoord)";

      $statement = $this->pdo->prepare($query);

      // password hashen
      $hashed_password =  password_hash($wachtwoord, PASSWORD_DEFAULT);

      $statement->execute([
        'usertype_id'=>$usertype_id,
        'voorletters'=>$voorletters,
        'voorvoegsels'=>$voorvoegsels,
        'achternaam'=>$achternaam,
        'gebruikersnaam'=>$gebruikersnaam,
        'wachtwoord'=>$hashed_password
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $medewerker_id = $this->pdo->lastInsertId();
      return $medewerker_id;
    }

    public function deleteArtikelen($id){
        try{
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("DELETE FROM artikel WHERE id=:id");
            $stmt->execute(['id'=>$id]);

            $this->pdo->commit();
        }catch(Exception $e){
            $this->pdo->rollback();
            echo 'Error: '.$e->getMessage();
        }
    }

    public function get_artikel_information($product){

        $query = "SELECT id, fabriekid, product, type, inkoopprijs, verkoopprijs FROM artikel

        ";

        if($product !== NULL){
            // query for specific user when a username is supplied
            $query .= 'WHERE product = :product';
        }

        $stmt = $this->pdo->prepare($query);

        // check if username is supplied, if so, pass assoc array to execute
        $product !== NULL ? $stmt->execute(['product'=>$product]) : $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function create_artikel($fabriekid, $product, $type, $inkoopprijs, $verkoopprijs){
      $query = "INSERT INTO artikel
            (id, fabriekid, product, type, inkoopprijs, verkoopprijs)
            VALUES
            (NULL, :fabriekid, :product, :type, :inkoopprijs, :verkoopprijs)";

      $statement = $this->pdo->prepare($query);

      $statement->execute([
        'fabriekid'=>$fabriekid,
        'product'=>$product,
        'type'=>$type,
        'inkoopprijs'=>$inkoopprijs,
        'verkoopprijs'=>$verkoopprijs,
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $medewerker_id = $this->pdo->lastInsertId();
      return $medewerker_id;
    }

    public function update_artikel($id, $product, $type, $inkoopprijs, $verkoopprijs){
      $query = "UPDATE artikel
      SET product = :product, type = :type, inkoopprijs = :inkoopprijs, verkoopprijs = :verkoopprijs
      WHERE id = :id";
      $statement = $this->pdo->prepare($query);
      $statement->execute([
        'id'=>$id,
        'product'=>$product,
        'type'=>$type,
        'inkoopprijs'=>$inkoopprijs,
        'verkoopprijs'=>$verkoopprijs
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $artikel_id = $this->pdo->lastInsertId();
      return $artikel_id;
    }

    public function authenticate_user($gebruikersnaam, $wachtwoord){

          $query = "SELECT wachtwoord
          FROM medewerker
          WHERE gebruikersnaam = :gebruikersnaam";

          $stmt = $this->pdo->prepare($query);
          // voorbereide instructieobject wordt uitgevoerd.
          $stmt->execute(['gebruikersnaam' => $gebruikersnaam]); //-> araay
          $result = $stmt->fetch(); // returned een array

          // checkt of $result een array is
          if(is_array($result)){
          // voerd count uit als #result een array is
          if(count($result) > 0){

          $hashed_password = $result['wachtwoord'];

          if($gebruikersnaam && password_verify($wachtwoord, $hashed_password)){
              // session_start();
              // slaat userdata in sessie veriable
              $_SESSION['gebruikersnaam'] = $gebruikersnaam;
              $_SESSION['usertype'] = $result['usertype_id'];
              $_SESSION['loggedin'] = true;

              if($this->is_admin($gebruikersnaam)){
                  header("location: index.php");
                  //make sure that code below redirect does not get executed when redirected.
                  exit;
              }  // redirect user to the user-page if not admin.
                header("location: welcome_user.php");
                exit;


              }
            }
          }
        }
  }
?>
