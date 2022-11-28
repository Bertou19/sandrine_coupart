<?php
// On vérifie si on a un id
if (!isset($_GET["id"]) && !empty($_GET["id"])) {
  //Je n'ai pas d'id
  header("Location: recettes.php");
  exit;
}


//Je récupère l'id

$id = $_GET["id"];


//On se connecte à la base
require_once "includes/connect.php";

//ON va chercher les recettes dans la base
//On écrit la requête
$sql = "SELECT * FROM 'recettes' WHERE 'id' = :id";

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


//ON définit le titre
$titre = strip_tags($recette["titre"]);

//On inclut le header
include "includes/header.php";

//On inclut la navbar
include "includes/navbar.php";

//On écrit le contenu de la page

?>


<article>
  <h1><?= strip_tags($recette["titre"]) ?></h1>

  <div><?= strip_tags($recette["description"]) ?></div>
</article>

<?php
//On inclut le footer
include "includes/footer.php";
?>