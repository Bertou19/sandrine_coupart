<?php
session_id();
session_start();

$nav_en_cours = 'ajoutPatients';


// On vérifie si le formulaire a bien été envoyé

if (!empty($_POST)) {
  //Le formulaire a été envoyé
  //On vérifie que tous les champs sont remplis
  if (
    isset($_POST["nom"], $_POST["prenom"], $_POST["email"], $_POST["ville"]) &&
    !empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["email"]) && !empty($_POST["ville"])
    //&& !empty($_POST["regime"])
  ) {
    // Le formulaire est complet

    //Generer un mot de passe aléatoire
    $comb = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $combLen = strlen($comb) - 1;
    for ($i = 0; $i < 8; $i++) {
      $n = rand(0, $combLen);
      $pass[] = $comb[$n];
    }
    //création de la valeur $password avec le mot de passe
    $password = (implode($pass));

    //Hasher le mot de passe et le mettre dans la variable $passHash
    $passHash = password_hash($password, PASSWORD_ARGON2ID);

    // On récupère les données en les protegeant
    $nom = strip_tags($_POST["nom"]);
    $prenom = strip_tags($_POST["prenom"]);
    $email = ($_POST["email"]);

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
      $_SESSION["error"] = [];
      $_SESSION["error"] = ["Veuillez entrer un email valide"];
    }
    $ville = strip_tags($_POST["ville"]);

    $regime_vegetarien = ($_POST["regime_vegetarien"]);
    $regime_sans_lactose = ($_POST["regime_sans_lactose"]);
    $regime_sans_sel = ($_POST["regime_sans_sel"]);
    $regime_sans_gluten = ($_POST["regime_sans_gluten"]);
    $allergie_oeufs = ($_POST["allergie_oeufs"]);
    $allergie_lait = ($_POST["allergie_lait"]);
    $allergie_crustaces = ($_POST["allergie_crustaces"]);
    $allergie_arachides = ($_POST["allergie_arachides"]);
    $allergie_ble = ($_POST["allergie_ble"]);


    //ON enregistre en base de données
    require_once "../includes/connect.php";

    $sql = "INSERT INTO patient(`nom`,`prenom`,`email`,`password`,`ville`,`regime_vegetarien`,`regime_sans_lactose`,`regime_sans_sel`,`regime_sans_gluten`,`allergie_oeufs`,`allergie_lait`, `allergie_crustaces`,`allergie_arachides`, `allergie_ble`) 
    VALUES (:nom, :prenom, :email,'$passHash', :ville, :regime_vegetarien,:regime_sans_lactose,:regime_sans_sel,:regime_sans_gluten, :allergie_oeufs, :allergie_lait, :allergie_crustaces,:allergie_arachides, :allergie_ble)";

    $query = $db->prepare($sql);

    $query->bindValue(":nom", $nom, PDO::PARAM_STR);
    $query->bindValue(":prenom", $prenom, PDO::PARAM_STR);
    $query->bindValue(":email", $email, PDO::PARAM_STR);

    $query->bindValue(":ville", $ville, PDO::PARAM_STR);
    $query->bindValue(":regime_vegetarien", $regime_vegetarien, PDO::PARAM_BOOL);
    $query->bindValue(":regime_sans_lactose", $regime_sans_lactose, PDO::PARAM_BOOL);
    $query->bindValue(":regime_sans_sel", $regime_sans_sel, PDO::PARAM_BOOL);
    $query->bindValue(":regime_sans_gluten", $regime_sans_gluten, PDO::PARAM_BOOL);
    $query->bindValue(":allergie_oeufs", $allergie_oeufs, PDO::PARAM_BOOL);
    $query->bindValue(":allergie_lait", $allergie_lait, PDO::PARAM_BOOL);
    $query->bindValue(":allergie_crustaces", $allergie_crustaces, PDO::PARAM_BOOL);
    $query->bindValue(":allergie_arachides", $allergie_arachides, PDO::PARAM_BOOL);
    $query->bindValue(":allergie_ble", $allergie_ble, PDO::PARAM_BOOL);

    if ($query->execute()) {
      $_SESSION["success"] = [];
      $_SESSION["success"] = ["Le patient a été ajouté avec succès !"];

      //L'envoyer par mail au patient inscrit 


      $to = "a_bertille@msn.com";
      $subject = "Inscription sur le site de Sandrine Coupart";
      $message = "Bonjour !
      Vous êtes bien inscit(e) sur le site de Sandrine Coupart !
      Vous pouvez dès à present bénéficier de recettes supplémentaires adaptées à votre régime et/
      ou vos allergies potentielles.
      
      Votre mot de passe : <?= '$password' ?>
      
      Merci à bientôt !
      
      Sandrine Coupart 
      Diététicienne-Nutritionniste";


      $headers = "Content-Type: text/plain; charset=utf-8\r\n";
      $headers .= "From: bertilledev07@gmail.com\r\n";

      if (mail($to, $subject, $message, $headers)) {
        $_SESSION["successMail"] = [];
        $_SESSION["successMail"] = ["Le mail avec son mot de passe a bien été envoyé."];
      } else echo 'Erreur envoi';
    } else {
      $_SESSION["error"] = [];
      $_SESSION["error"] = ["Une erreur est survenue"];
    }
  }
}

//On definit le titre
$titrePrincipal = "Ajouter un patient";


// On inclut le header
@include_once "../includes/header.php";
// On inclut la navbar
@include_once "../includes/navbar.php";

//On écrit le contenu de la page
?>
<div>
  <h1 class="addTitle pt-5">Ajouter un patient</h1>
  <div class="text-center">
    <?php
    if (isset($_SESSION["success"])) {
      foreach ($_SESSION["success"] as $message) {
    ?>
        <p><?= $message ?></p>
      <?php
      }
      unset($_SESSION["success"]);
    }
    if (isset($_SESSION["successMail"])) {
      foreach ($_SESSION["successMail"] as $message) {
      ?>
        <p><?= $message ?></p>
      <?php
      }
      unset($_SESSION["successMail"]);
    }
    if (isset($_SESSION["error"])) {
      foreach ($_SESSION["error"] as $message) {
      ?>
        <p><?= $message ?></p>
    <?php
      }
      unset($_SESSION["error"]);
    }
    ?>
  </div>
  <div class="container-fluid">
    <div class="row">

      <form class="col-12" method="post">

        <div class="form text-warning col-md-2 ">
          <label for="inputName" class="form-label">Nom :</label>
          <input type="text" name="nom" class="form-control" id="inputName">
        </div>
        <div class="form text-warning col-md-2">
          <label for="inputFirstname" class="form-label">Prénom :</label>
          <input type="text" name="prenom" class="form-control" id="inputFirstname">
        </div>
        <div class="form text-warning col-md-2">
          <label for="inputEmail" class="form-label">E-mail :</label>
          <input type="text" name="email" class="form-control" id="inputEmail">
        </div>
        <div class="form text-warning col-md-1">
          <label for="inputCity" class="form-label">Ville :</label>
          <input type="text" name="ville" class="form-control" id="inputCity">
        </div>
        <div class="form text-warning col-md-2 g-3">
          <label for="exampleFormControlInput1" class="form-label">Régime(s) :</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="regime_vegetarien" type="checkbox" id="gridCheck" value="1">
            <label class="form-check-label text-secondary" for="gridCheck">
              Végétarien
            </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="regime_sans_lactose" type="checkbox" id="gridCheck" value="1">
            <label class="form-check-label text-secondary" for="gridCheck">
              Sans lactose
            </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="regime_sans_sel" type="checkbox" id="gridCheck" value="1">
            <label class="form-check-label text-secondary" for="gridCheck">
              Sans sel
            </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="regime_sans_gluten" type="checkbox" id="gridCheck" value="1">
            <label class="form-check-label text-secondary" for="gridCheck">
              Sans gluten
            </label>
          </div>
        </div>
        <div class="form text-warning  col-md-2 g-3">
          <label for="exampleFormControlInput1" class="form-label">Allergies :</label>
          <div class="form text-secondary form-check form-check-inline">
            <input class="form-check-input" name="allergie_oeufs" type="checkbox" id="gridCheck" value="1">
            <label class="form-check-label" for="gridCheck">
              Oeufs
            </label>
          </div>
          <div class="form text-secondary form-check form-check-inline">
            <input class="form-check-input" name="allergie_arachides" type="checkbox" id="gridCheck" value="1">
            <label class="form-check-label" for="gridCheck">
              Arachides
            </label>
          </div>
          <div class="form text-secondary form-check form-check-inline">
            <input class="form-check-input" name="allergie_lait" type="checkbox" id="gridCheck" value="1">
            <label class="form-check-label" for="gridCheck">
              Lait
            </label>
          </div>
          <div class="form text-secondary form-check form-check-inline">
            <input class="form-check-input" name="allergie_crustaces" type="checkbox" id="gridCheck" value="1">
            <label class="form-check-label" for="gridCheck">
              Crustacés
            </label>
          </div>
          <div class="form text-secondary form-check form-check-inline">
            <input class="form-check-input" name="allergie_ble" type="checkbox" id="gridCheck" value="1">
            <label class="form-check-label" for="gridCheck">
              Blé
            </label>
          </div>
          <div class="form col-12 text-center text-secondary pt-5">
            <label for="button">(Enregistrer pour générer un mot de passe et l'envoyer au patient.)</label>
            <button type="submit" class="button btn btn-warning text-light " name="bouton">Enregistrer</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php

//ON va chercher les patients dans la base
//On se connecte à la base
require "../includes/connect.php";

//On écrit la requête
$sql = "SELECT * FROM patient";

//On execute la requête
$requete = $db->query($sql);

//On recupère les données
$patients = $requete->fetchAll();


//On écrit le contenu de la page

?>

<h1 class="titleListPatients text-warning text-center pt-5 mb-5">Liste des patients inscrits</h1>

<section class="mb-6">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8 col-sm-10 table-responsive">
        <table class="table table-warning table-striped">
          <thead>
            <tr>
              <th></th>
              <th scope="col p-2" class="text-danger text-center ">Nom</th>
              <th scope="col p-2" class="text-danger text-center">Prenom</th>
              <th scope="col p-2" class="text-danger text-center">E-mail</th>
              <th scope="col p-2" class="text-danger text-center">Ville</th>
              <th scope="col p-2" class="text-danger text-center">Régime</th>
              <th scope="col p-2" class="text-danger text-center">Allergies</th>
            </tr>
          </thead>
          <?php foreach ($patients as $patient) : ?>
            <tbody>
              <tr>
                <th scope="row"></th>
                <td class="text-center"><?= strip_tags($patient["nom"]) ?></td>
                <td class="text-center"><?= strip_tags($patient["prenom"]) ?></td>
                <td class="text-center"><?= strip_tags($patient["email"]) ?></td>
                <td class="text-center"><?= strip_tags($patient["ville"]) ?></td>
                <td class="text-center"><?php if ($patient["regime_vegetarien"] == 1) {
                                          echo "Végétarien   ";
                                        }
                                        if ($patient["regime_sans_lactose"] == 1) {
                                          echo "Sans lactose   ";
                                        }
                                        if ($patient["regime_sans_sel"] == 1) {
                                          echo "Sans sel   ";
                                        }
                                        if ($patient["regime_sans_gluten"] == 1) {
                                          echo "Sans gluten   ";
                                        } ?></td>
                <td class="text-center"><?php if ($patient["allergie_oeufs"] == 1) {
                                          echo "Oeufs   ";
                                        }
                                        if ($patient["allergie_lait"] == 1) {
                                          echo "Lait   ";
                                        }
                                        if ($patient["allergie_crustaces"] == 1) {
                                          echo "Crustacés   ";
                                        }
                                        if ($patient["allergie_arachides"] == 1) {
                                          echo "Arachides   ";
                                        }
                                        if ($patient["allergie_ble"] == 1) {
                                          echo "Blé   ";
                                        }
                                        ?></td>
              </tr>
            </tbody>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
</section>

<?php

// On inclut le footer
@include_once "../includes/footer.php";
?>