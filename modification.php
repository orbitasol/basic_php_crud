<?php include_once "includes/header.php"; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    
      <div class="card-header">
        <h5>Formulaire de modification</h2>
      </div>
      
      <div class="card-body">
        
        <div class="container">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="matricule">Matricule</label>
                <input type="text" class="form-control" id="matricule" name="matricule" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="annee">Année</label>
                <input type="number" class="form-control" id="annee" name="annee">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Saisir votre nom">
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Saisir votre prénom">
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
                <input type="number" class="form-control" id="age" name="age" placeholder="Saisir votre age">
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nom">Genre</label>
                <select class="form-control" id="genre" name="genre">
                  <option value="1" selected="selected">L1 glrs</option>
                  <option value="2">L2 glrs</option>
                  <option value="3">L3 glrs</option>
                  <option value="4">L1 mae</option>
                  <option value="5">L2 mae</option>
                  <option value="6">L3 mae</option>
                </select>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="filiere">Filière</label>
                <select class="form-control" id="filiere" name="filiere">
                  <option value="1" selected="selected">Genie logiciel</option>
                  <option value="2">Mathematiques appliquees</option>
                </select>
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