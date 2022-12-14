<?php
session_start();

$nav_en_cours = 'deconnexion';


if (!isset($_SESSION["user"])) {
  header("Location: connexion.php");
  exit;
}

//On supprime une variable
unset($_SESSION["user"]);

header("Location: index.php");
