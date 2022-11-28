<?php
//On traite le formulaire nb

if (!empty($_POST)) {
  //POST n'est pas vide,on vérifie que toutes les données sont présentes
  if (
    isset($_POST["titre"], $_POST["description"])
    && !empty($_POST["titre"]) && !empty($_POST["description"])
  ) {
    //le formulaire est complet
    // On récupère les données en les protégeant (failles XSS)
    // On retire toute balises du titre
    $titre = strip_tags($_POST["titre"]);
    // On neutralise toutes balises de la description
    $description = htmlspecialchars($_POST["description"]);

    //On peut les enregistrer
    // On se connecte à la base
    require_once "../includes/connect.php";
    //On écrit la requête
    $sql = "INSERT INTO recettes(`titre`, `description`,`tps_preparation`,`tps_repos`,`tps_cuisson`,
    `ingredients`,`etapes`,`regime_vegetarien`,`regime_sans_lactose`,`regime_sans_sel`,`regime_sans_gluten`,`oeufs`,
    `lait`,`crustaces`,`arachides`,`ble`,`image`) VALUES (:titre, :description)";
    // ON prepare la requête
    $query = $db->prepare($sql);
    //On injecte des valeurs
    $query->bindValue("titre", $titre, PDO::PARAM_STR);
    $query->bindValue("description", $description, PDO::PARAM_STR);

    //ON execute la requête
    if (!$query->execute()) {
      die("Une erreur est survenue");
    }

    //On récupère l'id de la recette
    $id = $db->lastInsertId();
  } else {
    die("le formulaire est incomplet");
  }
}


$title = "Ajouter une recette";
//On inclut le header
include_once "../includes/header.php";
include_once "../includes/navbar.php";
?>

<h1>Ajouter une recette</h1>

<form method="post">
  <div>
    <label for="titre">Titre</label>
    <input type="text" name="titre" id="titre">
  </div>
  <div>
    <label for="description">Description</label>
    <textarea name="description" id="description"></textarea>
  </div>
  <button type="submit">Enregistrer</button>
</form>

<?php

include_once "../includes/footer.php";
