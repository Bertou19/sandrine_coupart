<?php
session_start();

$nav_en_cours = 'Recettes';

//ON va chercher les recettes dans la base
//On se connecte à la base
require_once "includes/connect.php";

//On écrit la requête
$sql = "SELECT* FROM recettes ORDER BY 'created_at' DESC";

//On execute la requête
$requete = $db->query($sql);

//On recupère les données
$recettes = $requete->fetchAll();

//ON définit le titre
$titre = "Recettes";

//On inclut le header
include "includes/header.php";

//On inclut la navbar
include "includes/navbar.php";

//On écrit le contenu de la page

?>

<h1>Recettes</h1>

<section>
  <?php foreach ($recettes as $recette) : ?>
    <article>
      <h1><a href="recette.php?id=<?= $recette["id"] ?>"><?= strip_tags($recette["titre"]) ?></h1>

      <div><?= strip_tags($recette["description"]) ?></div>
    </article>

  <?php endforeach; ?>
</section>
<?php
//On inclut le footer
include "includes/footer.php";
?>