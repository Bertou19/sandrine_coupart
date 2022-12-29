<?php
session_id();
session_start();
//On definit le titre
$titrePrincipal = "Accueil";

$nav_en_cours = 'Index';


// On inclut le header
@include_once "includes/header.php";
// On inclut la navbar
@include_once "includes/navbar.php";


//On écrit le contenu de la page
?>


<section>
  <div>
    <img class="background" src="./photos/vegetables.jpg" alt="legumes">
    <div class="home text-sm-center text-xs-center text-center">
      <h1 class="h1-index text-center">Du lundi au vendredi:</h1>
      <h1 class="h1-index2 text-center">De 8h à 12h et 14h à 18h</h1>
      <button type="button" class="btn btn-warning mx-auto  p-2 mb-5"><a href="contact.php" class="btn-contact">Prendre un rendez-vous</a></button>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-4 col-md-5 item ">
        <h2 class="title-section p-4 border-top border-start border-warning mt-5">Mes services</h2>
        <p class="text-home ps-4">At vero eos et accusamus et iusto odio dignissimos ducimus</p>
        <p class="text-home ps-4">qui blanditiis praesentium voluptatum deleniti atque corrupti quos</p>
        <p class="text-home ps-4">dolores et quas molestias excepturi sint occaecati cupiditate non provident.</p>
        <p class="text-home ps-4">Quo pariatur quam aut numquam facere 33 delectus asperiores ut voluptatem sunt non rerum dolore et nostrum sunt!</p>
        <p class="text-home ps-4">Non culpa deleniti eum quas possimus aut doloremque libero quo veniam fuga qui sunt dolore ea sunt quaerat.</p>
        <p class="text-home ps-4">Est eaque nemo et molestiae ullam qui quia similique. Vel maxime omnis aut earum nulla aut inventore</p>
        <p class="text-home ps-4">facilis et eveniet laudantium qui neque esse qui galisum incidunt!</p>
      </div>

      <div class="col-sm-4 col-md-5 item">
        <h2 class="title-section p-4 border-top border-start border-warning mt-5" id="A_propos">À propos</h2>
        <p class="text-home ps-4">At vero eos et accusamus et iusto odio dignissimos ducimus</p>
        <p class="text-home  ps-4">qui blanditiis praesentium voluptatum deleniti atque corrupti quos</p>
        <p class="text-home  ps-4">dolores et quas molestias excepturi sint occaecati cupiditate non provident.</p>
        <p class="text-home ps-4">Est eaque nemo et molestiae ullam qui quia similique. Vel maxime omnis aut earum.</p>
        <img class="photo-profil rounded-circle shadow-lg border border-end-0 border-bottom-0 border-warning border-5 w-75 h-50 mb-6 ms-5 img-fluid" src="photos/profil.jpg" alt="photo-profil">
      </div>
    </div>
  </div>
  </div>
  </div>
</section>

<?php
// On inclut le footer
@include_once "includes/footer.php";
?>