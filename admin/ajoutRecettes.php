<?php
session_start();

$nav_en_cours = 'ajoutRecettes';

//On traite le formulaire

if (!empty($_POST)) {
  //POST n'est pas vide,on vérifie que toutes les données sont présentes
  if (
    isset(
      $_POST["titre"],
      $_POST["description"],
      $_POST["tps_preparation"],
      $_POST["tps_repos"],
      $_POST["tps_cuisson"],
      $_POST["ingredients"],
      $_POST["etapes"],
      $_POST["regime_vegetarien"],
      $_POST["regime_sans_lactose"],
      $_POST["regime_sans_sel"],
      $_POST["regime_sans_gluten"],
      $_POST["recette_reservee"]
    )
    && !empty($_POST["titre"]) && !empty($_POST["description"]) && !empty($_POST["tps_preparation"]) && !empty($_POST["tps_repos"])
    && !empty($_POST["tps_cuisson"]) && !empty($_POST["ingredients"]) && !empty($_POST["etapes"]) && !empty($_POST["regime_vegetarien"]) && !empty($_POST["regime_sans_lactose"]) && !empty($_POST["regime_sans_sel"])
    && !empty($_POST["regime_sans_gluten"]) && !empty($_POST["recette_reservee"])
  );

  //le formulaire est complet
  // On récupère les données en les protégeant (failles XSS)
  // On retire toute balises du titre
  $titre = strip_tags($_POST["titre"]);


  // On neutralise toutes balises de la description et des autres champs jusqu'aux cases à cocher
  $description = htmlspecialchars($_POST["description"]);
  $preparation = strip_tags($_POST["tps_preparation"]);
  $repos = strip_tags($_POST["tps_repos"]);
  $cuisson = strip_tags($_POST["tps_cuisson"]);
  $ingredients = strip_tags($_POST["ingredients"]);
  $etapes = strip_tags($_POST["etapes"]);
  $regime_vegetarien = ($_POST["regime_vegetarien"]);
  $regime_sans_lactose = ($_POST["regime_sans_lactose"]);
  $regime_sans_sel = ($_POST["regime_sans_sel"]);
  $regime_sans_gluten = ($_POST["regime_sans_gluten"]);
  $oeufs = ($_POST["oeufs"]);
  $lait = ($_POST["lait"]);
  $crustaces = ($_POST["crustaces"]);
  $arachides = ($_POST["arachides"]);
  $ble = ($_POST["ble"]);
  $recette_reservee = ($_POST["recette_reservee"]);

  //On peut les enregistrer
  // On se connecte à la base
  require_once "../includes/connect.php";
  //On écrit la requête
  $sql = "INSERT INTO recettes(`titre`, `description`,`tps_preparation`,`tps_repos`,`tps_cuisson`,
    `ingredients`,`etapes`,`regime_vegetarien`,`regime_sans_lactose`,`regime_sans_sel`,`regime_sans_gluten`,`oeufs`,
    `lait`,`crustaces`,`arachides`,`ble`,`recette_reservee`) VALUES (:titre,:description, :tps_preparation,:tps_repos,
    :tps_cuisson,:ingredients,:etapes,:regime_vegetarien,:regime_sans_lactose,:regime_sans_sel,:regime_sans_gluten,:oeufs,:lait,:crustaces,:arachides,:ble,:recette_reservee)";


  // ON prepare la requête
  $query = $db->prepare($sql);
  //On injecte des valeurs
  $query->bindValue(":titre", $titre, PDO::PARAM_STR);
  $query->bindValue(":description", $description, PDO::PARAM_STR);
  $query->bindValue(":tps_preparation", $preparation, PDO::PARAM_STR);
  $query->bindValue(":tps_repos", $repos, PDO::PARAM_STR);
  $query->bindValue(":tps_cuisson", $cuisson, PDO::PARAM_STR);
  $query->bindValue(":ingredients", $ingredients, PDO::PARAM_STR);
  $query->bindValue(":etapes", $etapes, PDO::PARAM_STR);
  $query->bindValue(":regime_vegetarien", $regime_vegetarien, PDO::PARAM_BOOL);
  $query->bindValue(":regime_sans_lactose", $regime_sans_lactose, PDO::PARAM_BOOL);
  $query->bindValue(":regime_sans_sel", $regime_sans_sel, PDO::PARAM_BOOL);
  $query->bindValue(":regime_sans_gluten", $regime_sans_gluten, PDO::PARAM_BOOL);
  $query->bindValue(":oeufs", $oeufs, PDO::PARAM_BOOL);
  $query->bindValue(":lait", $lait, PDO::PARAM_BOOL);
  $query->bindValue(":crustaces", $crustaces, PDO::PARAM_BOOL);
  $query->bindValue(":arachides", $arachides, PDO::PARAM_BOOL);
  $query->bindValue(":ble", $ble, PDO::PARAM_BOOL);
  $query->bindValue(":recette_reservee", $recette_reservee, PDO::PARAM_BOOL);

  //ON execute la requête

  if ($query->execute()) {
    $_SESSION["success"] = [];
    $_SESSION["success"] = ["La recette a été ajoutée avec succès !"];
  };

  if (!$query->execute()) {
    $_SESSION["error"] = [];
    $_SESSION["error"] = ["Une erreur est survenue"];
  }
}

$title = "Ajouter une recette";
//On inclut le header
include_once "../includes/header.php";
include_once "../includes/navbar.php";
?>

<h1 class="addTitle d-flex justify-content-center mt-6 mb-6">Ajouter une recette</h1>
<?php
if (isset($_SESSION["success"])) {
  foreach ($_SESSION["success"] as $message) {
?>
    <p><?= $message ?></p>
  <?php
  }
  unset($_SESSION["success"]);
}
if (isset($_SESSION["error"])) {
  foreach ($_SESSION["error"] as $message) {
  ?>
    <p><?= $message ?></p>
<?php
  }
  unset($_SESSION["error"]);
}
?>
<div class="container-fluid ">
  <div class="row">
    <div class="col-12">
      <form class="col-12 " method="post" enctype="multipart/form-data">

        <div class="col-md-4 top-50 start-50">
          <label for="inputTitre" class="form-label">Titre</label>
          <input type="text" name="titre" class="form-control" id="inputTitre">
        </div>
        <div class="col-md-4">
          <label for="inputDescription" class="form-label">Description</label>
          <input type="text" name="descritption" class="form-control" id="inputDescription">
        </div>

        <div class="col-md-2">
          <label for="inputPreparation" class="form-label">Temps de préparation</label>
          <input type="text" name="tps_preparation" class="form-control" id="inputPreparation">

        </div>

        <div class="col-md-1">
          <label for="inputRepos" class="form-label">Temps de repos</label>
          <input type="text" name="tps_repos" class="form-control" id="inputRepos">
        </div>
        <div class="col-md-1">
          <label for="inputCuisson" class="form-label">Temps de cuisson</label>
          <input type="text" name="tps_cuisson" class="form-control" id="inputCuisson">
        </div>
        <div class="col-md-5">
          <label for="ingredients" class="form-label">Ingrédients</label>
          <textarea name="ingredients" class="form-control" id="ingredients" cols="30" rows="15"></textarea>
        </div>
        <div class="col-md-8">
          <label for="etapes" class="form-label">Étapes</label>
          <textarea name="etapes" class="form-control" id="etapes" cols="30" rows="30"></textarea>
        </div>
        <div class="col-md-2 row g-3">
          <label for="exampleFormControlInput1" class="form-label">Régime(s) :</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="regime_vegetarien" type="checkbox" id="gridCheck" value="1">
            <label class="form-check-label" for="gridCheck">
              Végétarien
            </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="regime_sans_lactose" type="checkbox" id="gridCheck" value="1">
            <label class="form-check-label" for="gridCheck">
              Sans lactose
            </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="regime_sans_sel" type="checkbox" id="gridCheck" value="1">
            <label class="form-check-label" for="gridCheck">
              Sans sel
            </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="regime_sans_gluten" type="checkbox" id="gridCheck" value="1">
            <label class="form-check-label" for="gridCheck">
              Sans gluten
            </label>
          </div>
        </div>

        <div class="col-md-2 row g-3">
          <label for="exampleFormControlInput1" class="form-label">Allergènes :</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="oeufs" type="checkbox" id="gridCheck" value="1">
            <label class="form-check-label" for="gridCheck">
              Oeufs
            </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="arachides" type="checkbox" id="gridCheck" value="1">
            <label class="form-check-label" for="gridCheck">
              Arachides
            </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="lait" type="checkbox" id="gridCheck" value="1">
            <label class="form-check-label" for="gridCheck">
              Lait
            </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="crustaces" type="checkbox" id="gridCheck" value="1">
            <label class="form-check-label" for="gridCheck">
              Crustacés
            </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-input" name="ble" type="checkbox" id="gridCheck" value="1">
            <label class="form-label" for="gridCheck">
              Blé
            </label>
          </div>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault">
          <label class="form-check-label" for="flexCheckDefault">
            Recette reservée aux patients
          </label>
        </div>
        <div class="col-12">


          <!--<div class="cont">
      <button class="btn"><span>Submit</span><img src="https://i.cloudup.com/2ZAX3hVsBE-3000x3000.png" height="62" width="62"></button>
    </div>-->
          <button type="submit" class="btn btn-warning" name="bouton">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php

include_once "../includes/footer.php";
?>