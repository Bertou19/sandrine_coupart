<?php
session_id();
session_start();



// On vérifie si on a un id
if (!isset($_GET["id"]) || empty($_GET["id"])) {
  //Je n'ai pas d'id
  header("Location: recettes.php");
  exit;
}

//Je récupère l'id

$id = $_GET["id"];

//On se connecte à la base
require_once "includes/connect.php";

//ON va chercher la recette dans la base
//On écrit la requête
$sql = "SELECT * FROM recettes WHERE id = :id";

//On prépare la requête
$requete = $db->prepare($sql);

//On injecte les paramètres
$requete->bindValue(":id", $id, PDO::PARAM_INT);

//On execute la requête
$requete->execute();


//On recupèrela recette
$recette = $requete->fetch();

//on vérifie si la recette est vide
if (!$recette) {
  //Pas de recette, erreur 404
  http_response_code(404);
  echo "Recette inexistante";
  exit;
}
//Ici on a une recette


//ON définit le titre et les autres champs
$titre = strip_tags($recette["titre"]);
$description = strip_tags($_POST["description"]);
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
$id_recette = ($recette["id"]);


// Formulaire d'avis du patient 

if (!empty($_POST)) {
  //Le formulaire a été envoyé
  //On vérifie que tous les champs sont remplis
  if (
    isset($_POST["titre"], $_POST["message"], $_POST["note"]) &&
    !empty($_POST["titre"]) && !empty($_POST["message"]) && !empty($_POST["note"])

  ) {

    $titre = strip_tags($_POST["titre"]);
    $message = strip_tags($_POST["message"]);
    $note = ($_POST["note"]);

    //ON enregistre en base de données
    require_once "includes/connect.php";


    $sql = "INSERT INTO avis(`titre`,`message`,`note`,`id_recettes`)
    VALUES (:titre, :message, :note, $id)";

    $query = $db->prepare($sql);

    $query->bindValue(":titre", $titre, PDO::PARAM_STR);
    $query->bindValue(":message", $message, PDO::PARAM_STR);
    $query->bindValue(":note", $note, PDO::PARAM_INT);

    if ($query->execute()) {
      $_SESSION["success"] = [];
      $_SESSION["success"] = ["Votre avis a été ajouté avec succès !"];
    } else {
      $_SESSION["error"] = [];
      $_SESSION["error"] = ["Une erreur est survenue"];
    }
  }
}

//On inclut le header
include "includes/header.php";

//On inclut la navbar
include "includes/navbar.php";

//On écrit le contenu de la page

?>
<div class="text-center mt-3">
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
</div>

<article>

  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-6">

        <h1 class="titreRecette text-center text-danger mt-5"><?= strip_tags($recette["titre"]) ?></h1>

        <div class="text-center mt-4"><?= strip_tags($recette["description"]) ?></div>
        <div class="text-center">
          <h5 class="text-secondary mt-4">Temps de préparation :</h5><?= strip_tags($recette["tps_preparation"]) ?>
        </div>
        <div class="text-center">
          <h5 class="text-secondary mt-2">Temps de repos :</h5><?= strip_tags($recette["tps_repos"]) ?>
        </div>
        <div class="text-center">
          <h5 class="text-secondary mt-2">Temps de cuisson :</h5><?= strip_tags($recette["tps_cuisson"]) ?>
        </div>
        <div class="text-center">
          <h5 class="text-secondary mt-2">Ingrédients :</h5><?= strip_tags($recette["ingredients"]) ?>
        </div>
        <div class="text-center">
          <h5 class="text-secondary mt-2">Étapes :</h5><?= strip_tags($recette["etapes"]) ?>
        </div>
        <div class="text-center">
          <h5 class="text-secondary mt-2">Type de régime(s) :</h5><?php if ($recette["regime_vegetarien"] == 1) {
                                                                    echo "Regime végétarien";
                                                                  } ?>

          <div><?php if ($recette["regime_sans_lactose"] == 1) {
                  echo "Regime sans lactose";
                } ?></div>
          <div><?php if ($recette["regime_sans_sel"] == 1) {
                  echo "Regime sans sel";
                } ?></div>
          <div><?php if ($recette["regime_sans_gluten"] == 1) {
                  echo "Regime sans gluten";
                } ?></div>
        </div>
        <div class="text-center">
          <h5 class="text-secondary mt-2">Allergène(s) :</h5><?php if ($recette["oeufs"] == 1) {
                                                                echo "Oeufs";
                                                              } ?>

          <div><?php if ($recette["lait"] == 1) {
                  echo "Lait";
                } ?></div>
          <div><?php if ($recette["crustaces"] == 1) {
                  echo "Crustacés";
                } ?></div>
          <div><?php if ($recette["arachides"] == 1) {
                  echo "Arachides";
                } ?></div>
          <div><?php if ($recette["ble"] == 1) {
                  echo "Blé";
                } ?></div>
        </div>
      </div>

    </div>
  </div>
</article>

<?php
if (isset($_SESSION["patient"])) {
?>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-4 col-sm-6 text-center">
        <h1 class="commentaireTitle text-warning pt-5">Laisser un commentaire</h1>

        <form action="" method="post">
          <div class="mb-3 p-3">
            <label for="exampleFormControlInput1" class="form-label">Titre</label>
            <input type="text" name="titre" class="form-control" id="exampleFormControlInput1">
          </div>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Message</label>
            <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3"></textarea>
          </div>
          <div class="stars text-center">

            <i class="lar la-star" data-value="1"></i><i class="lar la-star" data-value="2"></i><i class="lar la-star" data-value="3"></i><i class="lar la-star" data-value="4"></i><i class="lar la-star" data-value="5"></i>
          </div>
          <div>
            <label for="note" class="form-label">Note</label>
            <input type="hidden" name="note" id="note" value="0">
          </div>
          <button type="submit" class="btn btn-warning text-white mt-4">Soumettre l'avis</button>
        </form>
      </div>
    </div>
  </div>
<?php } ?>


<?php
//On va chercher les avis dans la base
//On se connecte à la base



require "includes/connect.php";

//On écrit la requête
$sql = "SELECT * FROM avis WHERE id_recettes = $id";


//On execute la requête
$requete = $db->query($sql);


$requete->bindValue(":id", $id, PDO::PARAM_INT);


//On recupère les données
$commentaires = $requete->fetchAll();



//On écrit le contenu de la page

?>


<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-5">
      <img class="w-50 h-75 mt-4" src="photos/legumes.png" alt="legumes">
    </div>

  </div>
</div>

<h1 class="commentaires text-center mb-5 text-warning">Commentaires</h1>
<section class="mb-6">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-5 col-sm-5">

        <?php foreach ($commentaires as $commentaire) : ?>
          <h5 class="text-danger text-center mt-3 ">Titre</h5>
          <div class="text-center"><?= ($commentaire["titre"]) ?></div>
          <h5 class="text-danger text-center">Message</h5>
          <div class="text-center"><?= ($commentaire["message"]) ?></div>
          <h5 class="text-danger text-center">Note</h5>


          <div class="text-center"><?php if ($commentaires["note"] == 1) {
                                      echo '<img class="etoileJaune" src="photos/etoileJaune.jpg" alt="étoile jaune"/>';
                                    }
                                    if ($commentaire["note"] == 2) {
                                      echo '<img class="etoileJaune" src="photos/etoileJaune.jpg" alt="étoile jaune"/>';
                                      echo '<img class="etoileJaune" src="photos/etoileJaune.jpg" alt="étoile jaune"/>';
                                    }
                                    if ($commentaire["note"] == 3) {
                                      echo '<img class="etoileJaune" src="photos/etoileJaune.jpg" alt="étoile jaune"/>';
                                      echo '<img class="etoileJaune" src="photos/etoileJaune.jpg" alt="étoile jaune"/>';
                                      echo '<img class="etoileJaune" src="photos/etoileJaune.jpg" alt="étoile jaune"/>';
                                    }
                                    if ($commentaire["note"] == 4) {
                                      echo '<img class="etoileJaune" src="photos/etoileJaune.jpg" alt="étoile jaune"/>';
                                      echo '<img class="etoileJaune" src="photos/etoileJaune.jpg" alt="étoile jaune"/>';
                                      echo '<img class="etoileJaune" src="photos/etoileJaune.jpg" alt="étoile jaune"/>';
                                      echo '<img class="etoileJaune" src="photos/etoileJaune.jpg" alt="étoile jaune"/>';
                                    }
                                    if ($commentaire["note"] == 5) {
                                      echo '<img class="etoileJaune" src="photos/etoileJaune.jpg" alt="étoile jaune"/>';
                                      echo '<img class="etoileJaune" src="photos/etoileJaune.jpg" alt="étoile jaune"/>';
                                      echo '<img class="etoileJaune" src="photos/etoileJaune.jpg" alt="étoile jaune"/>';
                                      echo '<img class="etoileJaune" src="photos/etoileJaune.jpg" alt="étoile jaune"/>';
                                      echo '<img class="etoileJaune" src="photos/etoileJaune.jpg" alt="étoile jaune"/>';
                                    } ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>




<?php
//On inclut le footer
@include_once "includes/footer.php";
?>