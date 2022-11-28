<?php

//On definit le titre
$titrePrincipal = "Accueil";




// On inclut le header
@include_once "includes/header.php";
// On inclut la navbar
@include_once "includes/navbar.php";


//On écrit le contenu de la page
?>




<?php
require_once "includes/connect.php";

$recettes = "quiche";


$sql = "SELECT * FROM `recettes`";

// On prepare la requête
$requete = $db->prepare($sql);

// On injecte les valeurs "bindValue"

$requete->bindValue($recettes, PDO::PARAM_STR);

// On execute
$requete->execute();

$recette = $requete->fetchAll();


?>


<p><?php echo $recette['author']; ?></p>

<?php
// On inclut le footer
@include_once "includes/footer.php";
?>