<?php include_once "includes/header.php"; ?>

<div class="card-header">
  <h5>Liste des étudiants</h2>
</div>

<div class="card-body">

  <a href="inscription.php  " class="btn btn-primary mb-2">Nouveau</a>

  <?php
  require_once 'config/database.php';
  $query = "SELECT e.*, i.`idClasse`, c.`Description` AS classe, i.`idFiliere`, f.`Description` AS filiere, i.`annee` FROM `etudiant` e LEFT JOIN `inscription` i ON i.`idEtudiant` = e.`id` LEFT JOIN `classe` c ON c.`id` = i.`idClasse` LEFT JOIN `filiere` f ON f.`id`= i.`idFiliere` WHERE 1 ORDER BY e.`matricule`"; // requête pour afficher tout ce que l'utilisateur entrera
  $stmt = $con->prepare($query);
  $stmt->execute();
  $num = $stmt->rowCount();//pas compris
  if ($num > 0) {
  ?>
    <table class='table table-bordered table-hover text-center'>
      <thead class='thead-dark'>
        <tr>
          <th>Matricules</th>
          <th>Noms</th>
          <th>Prénoms</th>
          <th>Classes</th>
          <th>Filières</th>
          <th class='text-center' style='width: 190px;'>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // echo "<table class='table table-bordered table-hover text-center'>";
        // echo "<thead class='thead-dark'>";
        // echo "<tr>";
        // echo "<th>Matricules</th>";
        // echo "<th>Noms</th>";
        // echo "<th>Prénoms</th>";
        // echo "<th>Classes</th>";
        // echo "<th>Filières</th>";
        // echo "<th class='text-center' style='width: 190px;'>Action</th>";
        // echo "</tr>";
        // echo "</thead>";
        // echo "<tbody>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {  //  appel de la requête :tant que les données sont entrées et valider ; faire
          // Utiliser la fonction 'extract' sur la variable '$row'
          // Ce qui convertira chaque indice $row['classe'] à une variable du même nom comme ceci $classe
          extract($row); 
          // chaque ligne devient une variable(voilà pourquoi on a de nouvelles variables:$matricule, $nom...) à cause de extract($row);
          echo "<tr>";
          echo "<td>{$matricule}</td>";
          echo "<td>{$nom}</td>";
          echo "<td>{$prenom}</td>";
          echo "<td>{$classe}</td>";
          echo "<td>{$filiere}</td>";
          echo "<td class='text-center'>";
          echo "<div>";
          echo "<a href='modification.php?etudiant={$id}' class='btn btn-primary btn-sm' title='Modifier' style='margin-right:5px;'>Modifier</a>";// tant que l'étudiant existe(ie la validation a réussi et nous sommes sur la page index avec le nouveau étudiant) , affichage du bouton modifier qui nous amène à la page de modification(ex:http://localhost/Gesco/modification.php?etudiant=2)
          echo "<button type='button' class='btn btn-primary btn-sm'>Supprimer</button>";//et affichage du bouton "supprimer"
          echo "</div>";
          echo "</td>";
          echo "</tr>";
        }
        // echo "</tbody>";
        // echo "</table>";
        ?>
      </tbody>
    </table>
  <?php
  } else {
    echo "<div class='col-md-12 alert alert-info text-center'>Aucun étudiant dans la liste.</div>";
  }
  ?>
</div>

<?php include_once "includes/footer.php"; ?>