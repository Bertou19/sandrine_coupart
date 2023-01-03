<?php
session_id();
session_start();

$nav_en_cours = 'profil';

$title = "Profil";
//On inclut le header
include_once "includes/header.php";
include_once "includes/navbar.php";
//ON ecrit le contenu de la page

?>

<div class="container-fluid">
  <div class="row justify-content-center">

    <h1 class="profil text-center mt-6 text-warning">Bonjour <?= $_SESSION["patient"]["prenom"] ?></h1>

    <a href="recettes.php#reservee" class="text-center text-warning text-decoration-none mt-4">
      Voir mes recettes personnalisées </a>
    <p class="text-center text-secondary">(Adaptées à votre/vos régime(s) et allergie(s))</p>
    <img class="h-50 w-25 mt-6 ms-10" src="photos/peches.png" alt="peches">
  </div>
</div>
<?php
// On inclut le footer
@include_once "includes/footer.php";
?>