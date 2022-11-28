<?php

$title = "Connexion";
//On inclut le header
include_once "../includes/header.php";
include_once "../includes/navbar.php";
?>

<h1>Connexion</h1>

<form method="post">
  <div>
    <label for="email">E-mail</label>
    <input type="email" name="email" id="email">
  </div>
  <div>
    <label for="mot_de_passe">Mot de passe</label>
    <textarea name="mot_de_passe" id="mot_de_passe"></textarea>
  </div>
  <button type="submit">Se connecter</button>
</form>



<?php
include_once "../includes/footer.php";
?>