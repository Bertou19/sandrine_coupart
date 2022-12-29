<body>

  <nav class="navbar navbar-expand-lg bg-info p-5">
    <div class="container-fluid">
      <a href="../index.php" class="navbar-brand p-0 me-0"><img class="logo d-block" height="90" width="90" src="/photos/logo.png" alt="logo"></a>
      <h2 class="navbarTitle">Sandrine Coupart</h2>
      <h3 class="navbarSecondTitle position-absolute mt-6 ms-10">Diététicienne-nutritionniste</h3>
      <button class="navbar-toggler navbar-toggler-right text-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
        </svg>
      </button>

      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

        <div class="offcanvas-header">

          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Sandrine Coupart</h5>
          <h3 class="offcanvasSecondTitle position-absolute mt-6 ms-7">Diététicienne-nutritionniste</h3>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li <?php if ($nav_en_cours == 'Index') {
                  echo 'id = "en_cours"';
                } ?> class="nav-item">
              <a href="/index.php" class="nav-link ">Accueil</a>
            </li>
            <?php if (isset($_SESSION["user"])) : ?>
              <li <?php if ($nav_en_cours == 'ajoutPatients') {
                    echo 'id = "en_cours"';
                  } ?> class="nav-item">
                <a href="/admin/ajoutPatients.php" class="nav-link">Gestion des patients</a>
              </li>
              <li <?php if ($nav_en_cours == 'ajoutRecettes') {
                    echo 'id = "en_cours"';
                  } ?> class="nav-item">
                <a href="/admin/ajoutRecettes.php" class="nav-link">Gestion des recettes</a>
              </li>
            <?php endif; ?>
            <li <?php if ($nav_en_cours == 'Recettes') {
                  echo 'id = "en_cours"';
                } ?> class="nav-item">
              <a href="../recettes.php" class="nav-link  ">Recettes</a>
            </li>
            <?php if (isset($_SESSION["user"])) : ?>
              <li class="nav-item" <?php if ($nav_en_cours == 'deconnexion') {
                                      echo 'id = "en_cours"';
                                    } ?>>
                <a href="/deconnexion.php" class="nav-link ">Se deconnecter(admin)</a>
              </li>
            <?php endif; ?>
            <?php if (!isset($_SESSION["user"])) : ?>
              <li <?php if ($nav_en_cours == 'Contact') {
                    echo 'id = "en_cours"';
                  } ?> class="nav-item">
                <a href="/contact.php" class="nav-link ">Contact</a>
              </li>
            <?php endif; ?>
            <?php if (isset($_SESSION["patient"])) : ?>

              <li <?php if ($nav_en_cours == 'profil') {
                    echo 'id = "en_cours"';
                  } ?> class="nav-item">
                <a href="/profil.php" class="nav-link ">Mon compte</a>
              </li>
            <?php endif; ?>





            <?php if (!isset($_SESSION["patient"])) : ?>

              <li class="nav-item" <?php if ($nav_en_cours == 'connexion') {
                                      echo 'id = "en_cours"';
                                    } ?>>
                <a href="/connexionPatient.php" class="nav-link ">Se connecter(patient)</a>
              </li>
            <?php else : ?>

              <li class="nav-item" <?php if ($nav_en_cours == 'deconnexion') {
                                      echo 'id = "en_cours"';
                                    } ?>>
                <a href="/deconnexion.php" class="nav-link ">Se deconnecter</a>
              </li>
            <?php endif; ?>

          </ul>
          <img class="tomates-offcanvas d-lg-none" src="../photos/tomates.jpg" alt="tomates">
        </div>
      </div>
    </div>
  </nav>