<?php
session_id();
session_start();

/* CONNEXION ADMIN-USER */

if (isset($_SESSION["user"])) {
  header("Location: /index.php");
  exit;
}

// On vérifie si le formulaire a été envoyé
if (!empty($_POST)) {
  //Le formulaire a été envoyé
  //On vérifie que tous les champs requis sont remplis
  if (
    isset($_POST["email"], $_POST["password"])
    && !empty($_POST["email"]) && !empty($_POST["password"])
  ) {
    $_SESSION["error"] = [];
    //On vérifie que l'email en est un
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
      $_SESSION["error"] = ["Veuillez saisir une adresse email valide"];
    }
    if ($_SESSION["error"] === []) {
      //On va se connecter à la base de données
      require "includes/connect.php";

      $sql = "SELECT * FROM user WHERE `email` = :email";


      $query = $db->prepare($sql);

      $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);

      $query->execute();

      $user = $query->fetch();

      if (!$user) {
        $_SESSION["error"][] = ["L'utilisateur  est incorrect"];
      }
      if (!($_POST["password"] === $user["password"])) { //if (!password_verify($_POST["password"], $user["password"])) {
        $_SESSION["error"][] = [" le mot de passe est incorrect"];
      }


      //Ici l'utilsateur et le mot de passe sont corrects
      //On va pouvoir "connecter" l'utilisateur

      if ($_SESSION["error"] === []) {
        //On stocke dans $_SESSION les informations de l'utilisateur
        $_SESSION["user"] = [
          "id" => $user["id"],
          "email" => $user["email"]

        ];

        //On redirige vers la page d'accueil
        header("Location: /index.php");
        
      }
    }
  }
}

$title = "Connexion";
//On inclut le header
include_once "includes/header.php";
include_once "includes/navbar.php";
?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-8 col-sm-5">
      <h1 class="connexion-title text-center pt-5">Me connecter (admin) :</h1>
      <?php
      if (isset($_SESSION["error"])) {
        foreach ($_SESSION["error"] as $message) {
      ?>
          <p><?= $message ?></p>
      <?php
        }
        unset($_SESSION["error"]);
      }
      ?>

      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-4 col-sm-6">
            <form class="" method="post">
              <div class=" pt-2">
                <label for="exampleInputEmail1" class="form-label"></label>
                <input type="text" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email">
              </div>
              <div class="w-50 w-2 pt-2">
                <label for="exampleInputPassword1" class="form-label"></label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Mot de passe">
              </div>
              <div class="text-center pt-5">
                <button type="submit" class="button btn btn-warning text-light mb-7">Connexion</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include_once "includes/footer.php";
?>
