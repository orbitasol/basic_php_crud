<?php include_once "includes/header.php"; ?>

<?php
function nouveau_matricule($con, $classe, $annee)
{
  try {
    // Obtenir le dernier ID de l'étudiant
    $query = "SELECT MAX(e.`id`) AS number FROM `etudiant` e INNER JOIN inscription i ON i.`idEtudiant` = e.`id` WHERE i.`idClasse` = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $classe);//permet de lier une variable à une autre et est doit être suivi de (  "execute()")
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);// retourne un tableau indexé de nom de colonne 
    $nbre_suivant = ($row['number'] != NULL) ? $row['number'] + 1 : 1;

    // Obtenir la description de la classe sélectionnée
    $query = "SELECT `description` FROM `classe` WHERE `id` = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $classe);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $classe_select =  ($row['description'] != NULL) ? substr($row['description'], 0, 1) . substr($row['description'], -1) : "";

    return $classe_select . str_pad($nbre_suivant, 3, "0", STR_PAD_LEFT) . substr($annee, -2);
  } catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
    error_reporting(E_ALL);
  }
}

if ($_POST) {
  require_once 'config/database.php';

  try {
    $id   =   htmlspecialchars(strip_tags($_POST['id']));
    $matricule   =   htmlspecialchars(strip_tags($_POST['matricule']));
    $annee       =   htmlspecialchars(strip_tags($_POST['annee']));
    $nom         =   htmlspecialchars(strip_tags($_POST['nom']));
    $prenom      =   htmlspecialchars(strip_tags($_POST['prenom']));
    $genre       =   htmlspecialchars(strip_tags($_POST['genre']));
    $age         =   htmlspecialchars(strip_tags($_POST['age']));
    $classe      =   htmlspecialchars(strip_tags($_POST['classe']));
    $filiere     =   htmlspecialchars(strip_tags($_POST['filiere']));

    $_POST['matricule'] = $matricule = (!empty($matricule)) ? $matricule : nouveau_matricule($con, $classe, $annee);

    if (empty($id)) {
      // Code pour inserer un nouveau
      $query = "SELECT MAX(id) AS number FROM `etudiant` WHERE 1";
      $stmt = $con->prepare($query);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $nbr_suiv = ($row['number'] != NULL) ? $row['number'] + 1 : 1;
      $_POST['matricule'] = $matricule = (!empty($matricule)) ? $matricule : "MT" . str_pad($nbr_suiv, 3, "0", STR_PAD_LEFT);

      $query = "INSERT INTO `etudiant`(`matricule`, `nom`, `prenom`, `genre`, `age`) VALUES (:matricule, :nom, :prenom, :genre, :age)";
      $stmt = $con->prepare($query);
      $stmt->bindParam(':matricule', $matricule);
      $stmt->bindParam(':nom', $nom);
      $stmt->bindParam(':prenom', $prenom);
      $stmt->bindParam(':genre', $genre);
      $stmt->bindParam(':age', $age);

      if ($stmt->execute()) {
        $_POST['id'] = $idEtudiant = $con->lastInsertId();
        $query = "INSERT INTO `inscription`(`idEtudiant`, `idClasse`, `idFiliere`, `annee`) VALUES (:idEtudiant, :idClasse, :idFiliere, :annee)";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':idEtudiant', $idEtudiant);
        $stmt->bindParam(':idClasse', $classe);
        $stmt->bindParam(':idFiliere', $filiere);
        $stmt->bindParam(':annee', $annee);

        if ($stmt->execute()) {
          $succes = "<div class='col-md-12 alert alert-success'>Etudiant enregistré avec succès.</div>";
          header("Location: index.php");
          exit();
        }
      } else {
        $erreur = "<div class='col-md-12 alert alert-danger'>Erreur lors de l'enregistrement de l'étudiant.</div>";
      }
    } else {
      // Code pour mettre à jour
    }
  } catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
    error_reporting(E_ALL);
  }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

  <div class="card-header">
    <h5>Formulaire d'inscription</h2>
  </div>

  <div class="card-body">

    <div class="container">
      <?php if (isset($erreur) && !empty($erreur)) echo $erreur; ?>
      <?php if (isset($succes) && !empty($succes)) echo $succes; ?>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="matricule">Matricule</label>
            <input type="hidden" class="form-control" id="id" name="id" value="<?php if (isset($_POST['id'])) echo $_POST['id']; ?>" readonly>
            <input type="text" class="form-control" id="matricule" name="matricule" value="<?php if (isset($_POST['matricule'])) echo $_POST['matricule']; ?>" readonly>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="annee">Année</label>
            <input type="number" class="form-control" id="annee" name="annee" value="<?php echo date("Y"); ?>" readonly>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?php if (isset($_POST['nom'])) echo $_POST['nom']; ?>" placeholder="Saisir votre nom">
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php if (isset($_POST['prenom'])) echo $_POST['prenom']; ?>" placeholder="Saisir votre prénom">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="nom">Genre</label>
            <select class="form-control" id="genre" name="genre" id="genre">
              <option value="Masculin">Masculin</option>
              <option value="Feminin">Feminin</option>
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="age">Age</label>
            <input type="number" class="form-control" id="age" name="age" value="<?php if (isset($_POST['age'])) echo $_POST['age']; ?>" min="0" max="99" placeholder="Saisir votre age">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="classe">Classe</label>
            <?php
            require_once 'config/database.php';
            $query = "SELECT * FROM `classe` WHERE 1 ORDER BY `Description`";
            $stmt = $con->prepare($query);
            $stmt->execute();
            echo "<select class='form-control' name='classe' id='classe'>";
            echo "<option disable>Sélectionner classe...</option>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $classe_id = $row['id'];
              $classe_description = $row['description'];
              echo "<option value='$classe_id'>$classe_description</option>";
            }
            echo "</select>";
            ?>
            <!-- 
            <select class="form-control" id="classe" name="classe">
              <option value="1" selected="selected">L1 glrs</option>
              <option value="2">L2 glrs</option>
              <option value="3">L3 glrs</option>
              <option value="4">L1 mae</option>
              <option value="5">L2 mae</option>
              <option value="6">L3 mae</option>
            </select> 
            -->
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="filiere">Filière</label>
            <?php
            require_once 'config/database.php';
            $query = "SELECT * FROM `filiere` WHERE 1 ORDER BY `description`";
            $stmt = $con->prepare($query);
            $stmt->execute();
            echo "<select class='form-control' name='filiere' id='filiere'>";
            echo "<option disable>Sélectionner filière...</option>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $filiere_id = $row['id'];
              $filiere_description = $row['description'];
              echo "<option value='$filiere_id'>" . $filiere_description . "</option>";
            }
            echo "</select>";
            ?>
            <!-- 
                  <select class="form-control" id="filiere" name="filiere">
                    <option value="1" selected="selected">Genie logiciel</option>
                    <option value="2">Mathematiques appliquees</option>
                  </select> 
                  -->
          </div>
        </div>
      </div>

    </div>

  </div>

  <div class="card-footer text-center">
    <button type="submit" class="btn btn-primary">Valider</button>
    <a href="index.php" class="btn btn-primary">Annuler</a>
  </div>

</form>

<?php include_once "includes/footer.php"; ?>