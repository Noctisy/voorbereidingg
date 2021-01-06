<!--Gemaakt door Yusa Celiker OITAOO8B -->
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

    // kijkt of de account die probeert in te loggen admin is met usertype_id. Als hij een admin is dan word 1 door gestuurt, anders 2.
    private function is_admin($gebruikersnaam){
        // query houd de gegevens in die naar de database gestuurd gaat worden
        $query = "SELECT usertype_id FROM medewerker WHERE gebruikersnaam = :gebruikersnaam";

        // dit voert de query uit
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['gebruikersnaam'=>$gebruikersnaam]);

        $result = $stmt->fetch();

        // kijkt of usertype_id gelijk is aan admin zo ja dan ben je admin en word je gestuurt naar homepagina.php
        if($result['usertype_id'] == self::ADMIN){
            return true;
        }

        // user is not admin
        return false;
    }

    // Verwijderd users uit de database. Pagina: view_edit_delete_medewerker
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

    // wijzigd de gegevens van een account. Pagina: edit_user.php
    public function editUser($id, $usertype_id, $voorletters, $voorvoegsels, $achternaam){
      $query = "  UPDATE
                    medewerker
                  SET
                    usertype_id = :usertype_id,
                    voorletters = :voorletters,
                    voorvoegsels = :voorvoegsels,
                    achternaam = :achternaam
                  WHERE id = :id";

      $statement = $this->pdo->prepare($query);

      $statement->execute([
      'id'=>$id,
      'usertype_id'=>$usertype_id,
      'voorletters'=>$voorletters,
      'voorvoegsels'=>$voorvoegsels,
      'achternaam'=>$achternaam
      ]);

      $medewerker_id = $this->pdo->lastInsertId();
      return $medewerker_id;
    }

    // pakt de account gegevens vanuit de database om het te laten zien in een tabel in pagina: view_edit_delete_medewerker
    public function view_user_detail($gebruikersnaam){

        $query = "SELECT id, usertype_id, voorletters, voorvoegsels, achternaam, gebruikersnaam FROM medewerker

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

    // maakt een medewerker aan in het database. Pagina: Register.php
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

    // ----------------------------------------------------------------------------------------------------------------------------------

    // verwijderd artikelen die zn ids overeen komen met die gegeven is. Pagina: view_edit_delete_artikelen
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

    // pakt artikel informatie uit de database pagina: view_edit_delete_artikelen
    public function get_artikel_information($product){

        $query = "SELECT id, levID, product, type, inkoopprijs, verkoopprijs FROM artikel

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

    // maakt een artikel aan in het database. Pagina: artikel_toevoegen.php
    public function create_artikel($levID, $product, $type, $inkoopprijs, $verkoopprijs){
      $query = "INSERT INTO artikel
            (id, levID, product, type, inkoopprijs, verkoopprijs)
            VALUES
            (NULL, :levID, :product, :type, :inkoopprijs, :verkoopprijs)";

      $statement = $this->pdo->prepare($query);

      $statement->execute([
        'levID'=>$levID,
        'product'=>$product,
        'type'=>$type,
        'inkoopprijs'=>$inkoopprijs,
        'verkoopprijs'=>$verkoopprijs
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $medewerker_id = $this->pdo->lastInsertId();
      return $medewerker_id;
    }

    // update de gegevens van een bestaande artikel. Pagina: artikelwijzigen.php
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

    // ----------------------------------------------------------------------------------------------------------------------------------

    // verwijderd leverancier die zn ids overeen komen met die gegeven is. Pagina: view_edit_delete_leverancier
    public function deleteLeverancier($id){
        try{
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("DELETE FROM leverancier WHERE id=:id");
            $stmt->execute(['id'=>$id]);

            $this->pdo->commit();
        }catch(Exception $e){
            $this->pdo->rollback();
            echo 'Error: '.$e->getMessage();
        }
    }

    // pakt leverancier informatie uit de database pagina: view_edit_delete_leverancier
    public function get_leverancier_information($leverancier){

        $query = "SELECT id, leverancier, telefoon FROM leverancier

        ";

        if($leverancier !== NULL){
            // query for specific user when a username is supplied
            $query .= 'WHERE leverancier = :leverancier';
        }

        $stmt = $this->pdo->prepare($query);

        // check if username is supplied, if so, pass assoc array to execute
        $leverancier !== NULL ? $stmt->execute(['leverancier'=>$leverancier]) : $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    // maakt een leverancier aan in het database. Pagina: leverancier_toevoegen.php
    public function create_leverancier($leverancier, $telefoon){
      $query = "INSERT INTO leverancier
            (id, leverancier, telefoon)
            VALUES
            (NULL, :leverancier, :telefoon)";

      $statement = $this->pdo->prepare($query);

      $statement->execute([
        'leverancier'=>$leverancier,
        'telefoon'=>$telefoon
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $medewerker_id = $this->pdo->lastInsertId();
      return $medewerker_id;
    }

    // update de gegevens van een bestaande leverancier. Pagina: leverancier_wijzigen.php
    public function update_leverancier($id, $leverancier, $telefoon){
      $query = "UPDATE leverancier
      SET leverancier = :leverancier, telefoon = :telefoon
      WHERE id = :id";
      $statement = $this->pdo->prepare($query);
      $statement->execute([
        'id'=>$id,
        'leverancier'=>$leverancier,
        'telefoon'=>$telefoon
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $artikel_id = $this->pdo->lastInsertId();
      return $artikel_id;
    }

    // ----------------------------------------------------------------------------------------------------------------------------------

    // verwijderd Locatie die zn ids overeen komen met die gegeven is. Pagina: view_edit_delete_locatie
    public function deleteLocatie($id){
        try{
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("DELETE FROM locatie WHERE id=:id");
            $stmt->execute(['id'=>$id]);

            $this->pdo->commit();
        }catch(Exception $e){
            $this->pdo->rollback();
            echo 'Error: '.$e->getMessage();
        }
    }

    // pakt Locatie informatie uit de database pagina: view_edit_delete_locatie
    public function get_locatie_information($locatie){

        $query = "SELECT id, locatie FROM locatie

        ";

        if($locatie !== NULL){
            // query for specific user when a username is supplied
            $query .= 'WHERE locatie = :locatie';
        }

        $stmt = $this->pdo->prepare($query);

        // check if username is supplied, if so, pass assoc array to execute
        $locatie !== NULL ? $stmt->execute(['locatie'=>$locatie]) : $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    // maakt een Locatie aan in het database. Pagina: locatie_toevoegen.php
    public function create_locatie($locatie){
      $query = "INSERT INTO locatie
            (id, locatie)
            VALUES
            (NULL, :locatie)";

      $statement = $this->pdo->prepare($query);

      $statement->execute([
        'locatie'=>$locatie
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $medewerker_id = $this->pdo->lastInsertId();
      return $medewerker_id;
    }

    // update de gegevens van een bestaande Locatie. Pagina: locatie_wijzigen.php
    public function update_locatie($id, $locatie){
      $query = "UPDATE locatie
      SET locatie = :locatie
      WHERE id = :id";
      $statement = $this->pdo->prepare($query);
      $statement->execute([
        'id'=>$id,
        'locatie'=>$locatie
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $artikel_id = $this->pdo->lastInsertId();
      return $artikel_id;
    }

    // ----------------------------------------------------------------------------------------------------------------------------------

    // niet genoeg tijd om het werkent te krijgen
    // public function update_rotterdam($id, $locatieID, $productIdD, $aantal){
    //   $query = "UPDATE locatie
    //   SET locatieID = :locatieID, productIdD = :productIdD, aantal = :aantal
    //   WHERE id = :id";
    //   $statement = $this->pdo->prepare($query);
    //   $statement->execute([
    //     'id'=>$id,
    //     'locatie'=>$locatie
    //   ]);
    //
    //   // haalt de laatst toegevoegde id op uit de db
    //   $artikel_id = $this->pdo->lastInsertId();
    //   return $artikel_id;
    // }

    // niet genoeg tijd om het werkent te krijgen
    // public function update_zoutermeer($id, $locatieID, $productIdD, $aantal){
    //   $query = "UPDATE locatie
    //   SET locatieID = :locatieID, productIdD = :productIdD, aantal = :aantal
    //   WHERE id = :id";
    //   $statement = $this->pdo->prepare($query);
    //   $statement->execute([
    //     'id'=>$id,
    //     'locatie'=>$locatie
    //   ]);
    //
    //   // haalt de laatst toegevoegde id op uit de db
    //   $artikel_id = $this->pdo->lastInsertId();
    //   return $artikel_id;
    // }

    // niet genoeg tijd om het werkent te krijgen
    // public function update_amsterdam($id, $locatieID, $productIdD, $aantal){
    //   $query = "UPDATE locatie
    //   SET locatieID = :locatieID, productIdD = :productIdD, aantal = :aantal
    //   WHERE id = :id";
    //   $statement = $this->pdo->prepare($query);
    //   $statement->execute([
    //     'id'=>$id,
    //     'locatie'=>$locatie
    //   ]);
    //
    //   // haalt de laatst toegevoegde id op uit de db
    //   $artikel_id = $this->pdo->lastInsertId();
    //   return $artikel_id;
    // }

    // pakt gegevens voor rotterdam. Pagina: voorraad.php
    public function get_rotterdam_information($aantal){

      $query = "SELECT a.product, a.type, le.leverancier, v.aantal, a.inkoopprijs, a.verkoopprijs, l.locatie
      FROM voorraad as v
      INNER JOIN locatie as l on v.LocatieID = l.id
      INNER JOIN artikel as a on v.productID = a.id
      INNER JOIN leverancier as le on v.locatieID = le.id
      WHERE L.locatie = 'rotterdam'";

      if($aantal !== NULL){
        // query for specific user when a username is supplied
        $query .= 'WHERE aantal = :aantal';
      }

      $stmt = $this->pdo->prepare($query);

      // check if username is supplied, if so, pass assoc array to execute
      $aantal !== NULL ? $stmt->execute(['aantal'=>$aantal]) : $stmt->execute();

      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results;
    }

    // pakt gegevens voor zoutermeer. Pagina: voorraad.php
    public function get_zoutermeer_information($aantal){

      $query = "SELECT a.product, a.type, le.leverancier, v.aantal, a.inkoopprijs, a.verkoopprijs, l.locatie
      FROM voorraad as v
      INNER JOIN locatie as l on v.LocatieID = l.id
      INNER JOIN artikel as a on v.productID = a.id
      INNER JOIN leverancier as le on v.locatieID = le.id
      WHERE L.locatie = 'zoutermeer'";

      if($aantal !== NULL){
        // query for specific user when a username is supplied
        $query .= 'WHERE aantal = :aantal';
      }

      $stmt = $this->pdo->prepare($query);

      // check if username is supplied, if so, pass assoc array to execute
      $aantal !== NULL ? $stmt->execute(['aantal'=>$aantal]) : $stmt->execute();

      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results;
    }

    // pakt gegevens voor amsterdam. Pagina: voorraad.php
    public function get_amsterdam_information($aantal){

      $query = "SELECT a.product, a.type, le.leverancier, v.aantal, a.inkoopprijs, a.verkoopprijs, l.locatie
      FROM voorraad as v
      INNER JOIN locatie as l on v.LocatieID = l.id
      INNER JOIN artikel as a on v.productID = a.id
      INNER JOIN leverancier as le on v.locatieID = le.id
      WHERE L.locatie = 'amsterdam'";

      if($aantal !== NULL){
        // query for specific user when a username is supplied
        $query .= 'WHERE aantal = :aantal';
      }

      $stmt = $this->pdo->prepare($query);

      // check if username is supplied, if so, pass assoc array to execute
      $aantal !== NULL ? $stmt->execute(['aantal'=>$aantal]) : $stmt->execute();

      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results;
    }

    // pakt alle gegevens van voorraad
    public function get_voorraad_information($aantal){

        $query = "SELECT a.product, a.type, le.leverancier, v.aantal, a.inkoopprijs, a.verkoopprijs, l.locatie
                  FROM voorraad as v
                  INNER JOIN locatie as l on v.LocatieID = l.id
                  INNER JOIN artikel as a on v.productID = a.id
                  INNER JOIN leverancier as le on v.locatieID = le.id";

        $stmt = $this->pdo->prepare($query);

        // check if username is supplied, if so, pass assoc array to execute
        $aantal !== NULL ? $stmt->execute(['aantal'=>$aantal]) : $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

// ----------------------------------------------------------------------------------------------------------------------------------
    // bekijkt of de gegevens die zijn ingevuld in login.php kloppen zodat je kunt inloggen.
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
                  header("location: homepagina.php");
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
