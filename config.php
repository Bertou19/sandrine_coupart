<?php
// Vérifie qu'il provient d'un formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //identifiants mysql
  $host = "localhost";
  $username = "bda";
  $password = "bda";
  $database = "sandrine_coupart";

  //Ouvrir une nouvelle connexion au serveur MySQL
  $mysqli = new mysqli($host, $username, $password, $database);

  //Afficher toute erreur de connexion
  if ($mysqli->connect_error) {
    die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
  }
}
