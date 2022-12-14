<?php
session_start();

$nav_en_cours = 'ajoutPatients';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// On vérifie si le formulaire a bien été envoyé

if (!empty($_POST)) {
  //Le formulaire a été envoyé
  //On vérifie que tous les champs sont remplis
  if (
    isset($_POST["nom"], $_POST["prenom"], $_POST["email"], $_POST["ville"], $_POST["regime"]) &&
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

    //On va hasher le mot de passe
    //$password = password_hash($_POST[""], PASSWORD_ARGON2ID);

    // On récupère les données en les protegeant
    $nom = strip_tags($_POST["nom"]);
    $prenom = strip_tags($_POST["prenom"]);
    $email = ($_POST["email"]);

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
      $_SESSION["error"] = [];
      $_SESSION["error"] = ["Veuillez entrer un email valide"];
    }
    $ville = strip_tags($_POST["ville"]);
    $regime = ($_POST["regime"]);
    $allergie_oeufs = ($_POST["allergie_oeufs"]);
    $allergie_lait = ($_POST["allergie_lait"]);
    $allergie_crustaces = ($_POST["allergie_crustaces"]);
    $allergie_arachides = ($_POST["allergie_arachides"]);
    $allergie_ble = ($_POST["allergie_ble"]);


    //ON enregistre en base de données
    require_once "../includes/connect.php";

    $sql = "INSERT INTO patient(`nom`,`prenom`,`e_mail`,`pass`,`ville`,`regime`,`allergie_oeufs`,`allergie_lait`, `allergie_crustaces`,`allergie_arachides`, `allergie_ble`) 
    VALUES (:nom, :prenom, :email,'$passHash', :ville, :regime, :allergie_oeufs, :allergie_lait, :allergie_crustaces,:allergie_arachides, :allergie_ble)";

    $query = $db->prepare($sql);

    $query->bindValue(":nom", $nom, PDO::PARAM_STR);
    $query->bindValue(":prenom", $prenom, PDO::PARAM_STR);
    $query->bindValue(":email", $email, PDO::PARAM_STR);
    $query->bindValue(":pass", $passHash, PDO::PARAM_STR);
    $query->bindValue(":ville", $ville, PDO::PARAM_STR);
    $query->bindValue(":regime", $regime, PDO::PARAM_STR);
    $query->bindValue(":allergie_oeufs", $allergie_oeufs, PDO::PARAM_BOOL);
    $query->bindValue(":allergie_lait", $allergie_lait, PDO::PARAM_BOOL);
    $query->bindValue(":allergie_crustaces", $allergie_crustaces, PDO::PARAM_BOOL);
    $query->bindValue(":allergie_arachides", $allergie_arachides, PDO::PARAM_BOOL);
    $query->bindValue(":allergie_ble", $allergie_ble, PDO::PARAM_BOOL);

    $query->execute();

    //L'envoyer par mail au patient inscrit 
    if ($query->execute()) {

      require_once "../includes/phpmailer/Exception.php";
      require_once "../includes/phpmailer/PHPMailer.php";
      require_once "../includes/phpmailer/SMTP.php";

      $mail = new PHPMailer(true);

      try {
        //Configuration
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Je veux des infos de debug

        //On configure le SMTP
        $mail->isSMTP();
        $mail->Host = "localhost";

        //Charset
        $mail->CharSet = "utf-8";

        //Destinataire
        $mail->addAddress("$email");
        $mail->addCC("a_bertille@msn.com");
        //expediteur
        $mail->setFrom("a_bertille@msn.com");

        //Contenu
        $mail->isHTML();

        $mail->Subject = "Inscription sur le site de Sandrine Coupart";
        $mail->Body = "<h3>Bonjour !</h3> <p> Vous êtes bien inscit(e) sur le site de Sandrine Coupart !
        Vous pouvez dès à present bénéficier de recettes supplémentaires adaptées à votre régime et/
        ou vos allergies potentielles.</p>
        
        <p>Votre mot de passe : <?= $password ?></p>
        
        <p>Merci à bientôt !</p>
        
        <strong>Sandrine Coupart 
        Diététicienne-Nutritionniste </strong>";
        $mail->AltBody = "Bonjour ! Vous êtes bien inscit(e) sur le site de Sandrine Coupart !
Vous pouvez dès à present bénéficier de recettes supplémentaires adaptées à votre régime et/
ou vos allergies potentielles.

Votre mot de passe : <?= $password ?>

Merci à bientôt !

Sandrine Coupart 
Diététicienne-Nutritionniste ";
        //ON envoi
        $mail->send();
        echo "Message envoyé";
      } catch (Exception) {
        echo "Message non envoyé. Erreur:{$mail->ErrorInfo}";
      }
    }

    /* $dest = $email;
      $objet = "Inscription sur le site de Sandrine Coupart";
      $message =
        "<font face='arial'>
Bonjour ! Vous êtes bien inscit(e) sur le site de Sandrine Coupart !
Vous pouvez dès à present bénéficier de recettes supplémentaires adaptées à votre régime et/
ou vos allergies potentielles.

Votre mot de passe : <?=. $password .?>

Merci à bientôt !

Sandrine Coupart 
Diététicienne-Nutritionniste 

</font>";
      $entetes = "From:
a_bertille@msn.comn";
      $entetes .= "Cc: $email";
      $entetes .= "Content-Type:
text/html; charset=iso-8859-1";
      if (mail($dest, $objet, $message, $entetes))
        echo "Mail envoyé avec succés.";
      else echo "Le mail n'a pas pu être envoyé";
      exit;
    }*/

    if ($query->execute()) {
      $_SESSION["success"] = [];
      $_SESSION["success"] = ["Le patient a été ajouté avec succès !"];
    }

    if (!$query->execute()) {
      $_SESSION["error"] = [];
      $_SESSION["error"] = ["Une erreur est survenue"];
    } else {
      $_SESSION["error"] = ["Le formualire est incomplet"];
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
  <h1 class="titre-patient pt-5">Ajouter un patient</h1>
  <?php
  if (isset($_SESSION["success"])) {
    foreach ($_SESSION["success"] as $message) {
  ?>
      <p><?= $message ?></p>
    <?php
    }
    unset($_SESSION["success"]);
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
  <form class="" method="post">

    <div class="col-md-2">
      <label for="inputName" class="form-label">Nom</label>
      <input type="text" name="nom" class="form-control" id="inputName">
    </div>
    <div class=" col-md-2">
      <label for="inputFirstname" class="form-label">Prénom</label>
      <input type="text" name="prenom" class="form-control" id="inputFirstname">
    </div>
    <div class="col-md-2">
      <label for="inputEmail" class="form-label">E-mail</label>
      <input type="text" name="email" class="form-control" id="inputEmail">
    </div>
    <div class="col-md-1">
      <label for="inputCity" class="form-label">Ville</label>
      <input type="text" name="ville" class="form-control" id="inputCity">
    </div>
    <div class="col-md-1">
      <label for="inputRegime" class="form-label">Régime :</label>
      <select id="inputRegime" name="regime" class="form-select">
        <option selected>Choisir...</option>
        <option value="aucun">Aucun</option>
        <option value="vegetarien">Végétarien</option>
        <option value="sans_sel">Sans sel</option>
        <option value="sans_lactose">Sans lactose</option>
        <option value="sans_gluten">Sans gluten</option>
      </select>
    </div>
    <div class="col-md-2 row g-3">
      <label for="exampleFormControlInput1" class="form-label">Allergies :</label>
      <div class="form-check form-check-inline">
        <input class="form-check-input" name="allergie_oeufs" type="checkbox" id="gridCheck" value="1">
        <label class="form-check-label" for="gridCheck">
          Oeufs
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" name="allergie_arachides" type="checkbox" id="gridCheck" value="1">
        <label class="form-check-label" for="gridCheck">
          Arachides
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" name="allergie_lait" type="checkbox" id="gridCheck" value="1">
        <label class="form-check-label" for="gridCheck">
          Lait
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" name="allergie_crustaces" type="checkbox" id="gridCheck" value="1">
        <label class="form-check-label" for="gridCheck">
          Crustacés
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" name="allergie_ble" type="checkbox" id="gridCheck" value="1">
        <label class="form-check-label" for="gridCheck">
          Blé
        </label>
      </div>
      <div class="col-12">
        <label for="bouton">Enregistrer pour générer un mot de passe et l'envoyer au patient.</label>

        <!--<div class="cont">
          <button class="btn"><span>Submit</span><img src="https://i.cloudup.com/2ZAX3hVsBE-3000x3000.png" height="62" width="62"></button>
        </div>-->


        <button type="submit" class="btn btn-warning" name="bouton">Enregistrer</button>


      </div>
    </div>
  </form>
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

<h1>Liste des patients</h1>

<section>
  <?php foreach ($patients as $patient) : ?>
    <article>
      <h1><?= $patient["id"] ?><?= strip_tags($patient["nom"]) ?></h1>

      <div><?= strip_tags($patient["prenom"]) ?></div>
    </article>

  <?php endforeach; ?>
</section>

<?php

// On inclut le footer
@include_once "../includes/footer.php";
?>