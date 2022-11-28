<?php

define("DBHOST", "localhost");
define("DBUSER", "bda");
define("DBPASS", "bda");
define("DBNAME", "sandrine_coupart");

// On définit le DSN(Data Source Name) de connexion
$dsn = "mysql:dbname=" . DBNAME . ";host=" . DBHOST;

try {
  //On se connecte à la base de données en "instanciant" PDO
  $db = new PDO($dsn, DBUSER, DBPASS);

  //On définit le charsert à "utf8"
  $db->exec("SET NAMES utf8");

  //On définit la méthode de récupération (fetch) des données
  $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  //PDOExeception $e -> on attrape l'erreur provoquée par le new PDO en cas d'échec
  //On affiche le message d'erreur si le new PDO échoue
  die($e->getMessage());
}
//Ici on est connectés