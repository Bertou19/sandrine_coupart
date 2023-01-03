<?php
session_id();
session_start();

$nav_en_cours = 'Recettes';

//ON va chercher les recettes non reservees dans la base
//On se connecte à la base
require_once "includes/connect.php";


$sql = "SELECT * FROM recettes WHERE recette_reservee = 0 ORDER BY 'created_at' DESC ";

//On execute la requête
$requete = $db->query($sql);

//On recupère les données
$recettes = $requete->fetchAll();
//On écrit la requête

// Si il y a une session user, on affiche tout
if ($_SESSION["user"]) {

  $sql = "SELECT * FROM recettes ";

  $requete = $db->query($sql);
  $recettes = $requete->fetchAll();
}

// Si il y a une session patient, on va chercher les recettes qui sont reservees aux patients connectés 
if ($_SESSION["patient"]) {

  //$sql = "SELECT FROM * recette case recette_reservee WHEN regime_vegetarien = 1 then 'regime_vegetarien'";

  $sql = "SELECT * from recettes
  WHERE (recette_reservee = 1)";

  $requete = $db->query($sql);
  $reservees = $requete->fetchAll();
}


//ON définit le titre
$titre = "Recettes";

//On inclut le header
include "includes/header.php";

//On inclut la navbar
include "includes/navbar.php";

//On écrit le contenu de la page

?>



<img class="imgBackgroundRecettes" src="./photos/bgAccueil.jpg" alt="image avec legumes pour cuisiner">
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-6 col-sm-10">
      <div class="bgRecettes mt-2 mb-8 ">
        <section>
          <h1 class="recettes-title text-center mt-5">Recettes</h1>

          <?php foreach ($recettes as $recette) : ?>
            <article>
              <div class="container-fluid">
                <div class="row justify-content-center">
                  <div class="col-md-6 col-sm-10">
                    <h2 class="recetteLittleTitle text-center p-2 mb-3"><a class="text-danger text-decoration-none" href="recette.php?id=<?= $recette["id"] ?>"><?= strip_tags($recette["titre"]) ?></h2>
                  </div>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </section>

        <section>
          <?php if ($_SESSION["patient"]) {
            echo '<h1 id="reservee" class="titleRecettesReservees text-center m-5 text-warning">Vos recettes personnalisées</h1>';
          } ?>

          <?php foreach ($reservees as $reservee) : ?>
            <?php

            if (($_SESSION["patient"]["regime_vegetarien"] === $reservee["regime_vegetarien"]) && ($_SESSION["patient"]["regime_vegetarien"] === 1) ||
              ($_SESSION["patient"]["regime_sans_gluten"] === $reservee["regime_sans_gluten"]) && ($_SESSION["patient"]["regime_sans_gluten"] === 1) ||
              ($_SESSION["patient"]["regime_sans_lactose"] === $reservee["regime_sans_lactose"]) && ($_SESSION["patient"]["regime_sans_lactose"] === 1) ||
              ($_SESSION["patient"]["regime_sans_sel"] === $reservee["regime_sans_sel"]) && ($_SESSION["patient"]["regime_sans_sel"] === 1)
            ) {
              if (
                ($_SESSION["patient"]["allergie_oeufs"] === 1 && $reservee["oeufs"] === 1) ||
                ($_SESSION["patient"]["allergie_lait"] === 1 && $reservee["lait"] === 1) ||
                ($_SESSION["patient"]["allergie_crustaces"] === 1 && $reservee["crustaces"] === 1) ||
                ($_SESSION["patient"]["allergie_arachides"] === 1 && $reservee["arachides"] === 1) ||
                ($_SESSION["patient"]["allergie_ble"] === 1 && $reservee["ble"] === 1)
              ) {
              } else {
            ?>
                <article>
                  <div class="container-fluid">
                    <div class="row justify-content-center">
                      <div class="col-md-6 col-sm-10">
                        <h2 class="recetteLittleTitle text-center p-2 mb-3"><a class="text-danger text-decoration-none" href="recette.php?id=<?= $reservee["id"] ?>"><?= strip_tags($reservee["titre"]) ?></h2>
                      </div>
                    </div>
                  </div>
                </article>
            <?php
              }
            }
            ?>
          <?php endforeach; ?>
        </section>
      </div>
    </div>
  </div>
</div>

<?php
//On inclut le footer
@include_once "includes/footer.php";
?>