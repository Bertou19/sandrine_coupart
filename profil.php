<?php
session_start();

$title = "Profil";
//On inclut le header
include_once "includes/header.php";
include_once "includes/navbar.php";
//ON ecrit le contenu de la page
?>
<h1>Profil de <?= $_SESSION["user"]["prenom"] ?></h1>

<p>Nom : <?= $_SESSION["user"]["nom"] ?></p>
<p>Prenom : <?= $_SESSION["user"]["prenom"] ?> </p>
<p>Regime : <?= $_SESSION["user"]["regime"] ?></p>


<?

//On inclut le footer
include_once "includes/footer.php";
