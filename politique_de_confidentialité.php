<?php
session_id();
session_start();

$nav_en_cours = 'Politique_de_confidentialité';



//ON définit le titre
$titre = "Politique de confidentialité";

//On inclut le header
include "includes/header.php";

//On inclut la navbar
include "includes/navbar.php";

//On écrit le contenu de la page

?>

<h1 class="confidential-title text-center m-5">Politique de confidentialité</h1>

<div class="container-fluid">
  <div class="row justify-content-center">


    <section class="col-6 text-center p-2 mb-3">
      <p> Lorem ipsum dolor sit amet. Et quia nemo id sequi animi aut obcaecati iure et doloremque doloribus sit ipsa accusamus. Ab dolorem dolore et repellendus dolor et labore minima.
        Cum architecto error ab autem voluptatem qui consequatur accusantium ut quia autem qui officia commodi qui deserunt voluptatibus.
        Est galisum numquam sit nisi incidunt est animi eius non galisum internos in quia vero eum doloribus quas et modi illum.
      </p>
      <p>
        Sit alias veniam qui praesentium voluptatem eum quos porro est nostrum sint qui ullam voluptate non iusto reiciendis? Est animi tenetur qui enim galisum non consequatur illo aut ipsa quia.
        Eos praesentium unde et numquam consectetur est exercitationem doloribus in dolore repellat et voluptatibus ducimus rem enim enim est aperiam incidunt.
      </p>
      <p>
        Et repellendus sapiente ut laboriosam expedita vel perspiciatis quos qui nulla voluptate non voluptas quia non excepturi facilis.
        Ea exercitationem unde ut commodi obcaecati id doloribus nulla eum voluptas quis nam perspiciatis velit?
        Ut deleniti mollitia et dolores consequatur vel sunt eaque At unde nesciunt 33 rerum quis ut Quis sint sed incidunt dolorem!
        Et nisi optio ut quia eius et mollitia recusandae sit consequuntur nisi id voluptatem deserunt in atque omnis.
      </p>
    </section>
  </div>
</div>



<?php
//On inclut le footer
include "includes/footer.php";
?>