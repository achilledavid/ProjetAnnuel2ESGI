<?php
session_start();

require("./function.php");

if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == "logout") {
  clean_php_session();
  header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="fr">

<head> <?php require("head.php"); ?>
  <link rel="stylesheet" href="./public/css/login.css">
  <link rel="stylesheet" href="./public/css/style.css">
  <title>Espace Admin - A.S. BEUVRY LA FORÊT</title>
</head>

<body>
  <?php if (is_logged()) : ?>
    <?php include('header.php'); ?>
    <div class="container">
      <div class="container-content">
        <div class="welcome-admin">
          <h1>Bonjour <?= htmlspecialchars($_SESSION['prenom']); ?>,
            <p>Tu es sur l'espace d'administration</p>
          </h1>
        </div>
        <div class="admin-panel">
          <a>
            <img src="https://image.shutterstock.com/image-illustration/plus-sign-icon-element-web-260nw-1098707264.jpg" />
            <p>Ajouter un &eacute;ducateur</p>
          </a>
          <a>
            <img src="https://image.shutterstock.com/image-vector/add-user-iconsaveavatar-vector-illustration-260nw-1894423480.jpg" />
            <p>Ajouter un licenci&eacute;</p>
          </a>
          <a>
            <img src="https://image.shutterstock.com/image-vector/vector-line-icon-stat-260nw-2050503608.jpg" />
            <p>Statistiques de la saison</p>
          </a>
          <a>
            <img src="https://image.shutterstock.com/image-vector/settings-gears-flat-icon-apps-260nw-1908713974.jpg" />
            <p>Mon compte</p>
          </a>
          <a>
            <img src="https://image.shutterstock.com/image-vector/profil-account-icon-simple-logo-260nw-1368469286.jpg" />
            <p>Gestion des &eacute;ducateurs</p>
          </a>
          <a>
            <img src="https://image.shutterstock.com/image-vector/people-talking-line-icon-group-260nw-1359171593.jpg" />
            <p>Gestion des licenci&eacute;s</p>
          </a>
          <a>
            <img src="https://image.shutterstock.com/image-vector/euro-symbol-icon-vector-isolated-260nw-1736791196.jpg" />
            <p>Suivi des cotisations</p>
          </a>
          <a>
            <img src="https://image.shutterstock.com/image-vector/best-pdf-document-icon-vector-260nw-1670462920.jpg" />
            <p>G&eacute;n&eacute;rer une attestation</p>
          </a>
        </div>
        <div class="separator"></div>
        <div class="deconnect">
          <a href="index.php?action=logout" class="deco-button">Deconnexion</a>
        </div>
        <div class="li-admin">
          <h2>
            Dernier(e)s liscencié(e)s ajouté(e)s :
          </h2>
          <?php
          $req = $db->prepare("SELECT categorie.nomCategorie, licencie.prenom, licencie.nom, licencie.USRCRE  FROM `licencie` INNER JOIN categorie ON licencie.idCategorie = categorie.idCategorie ORDER BY dateN ASC LIMIT 10"); //Derniers licenciés ajoutés classé par date croissant et limités à 10. 
          $req->execute();
          $rowCount = $req->rowCount();
          if ($rowCount > 0) : //si on trouve des licenciés ajoutés on affiche la liste de la requete.
          ?>
            <ul>
              <?php while ($LIC = $req->fetch(PDO::FETCH_ASSOC)) : ?>
                <li>
                  <p><?= $LIC["nomCategorie"] ?> - <span><?= $LIC["prenom"] . " " . strtoupper($LIC["nom"]) ?></span>
                    <?php if (isset($LIC["USRCRE"])) : ?>par <span><?= ($LIC["USRCRE"]) ?> </span></p> <?php endif; ?>
                </li>
              <?php endwhile; ?>
            </ul>
          <?php else : ?>
            <p> Aucun licencié n'a encore été crée </p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php else : ?> <section class="formulaire_login">
      <form method="POST" action="login.php" class="form_container">
        <div class="form_content">
          <div class="logo_association">
            <img draggable="false" src="./public/images/logo-asb.svg" alt="">
          </div>
          <div class="mail">
            <label for="mail" class="field_label_top">Adresse mail</label>
            <input id="mail" type="mail" pattern="[^ @]*@[^ @]*" placeholder="Adresse mail" name="email" autocomplete='on' <?php if (isset_flash_message_by_name(ERROR_MAIL)) : ?>style="border-bottom: 2px solid rgb(210, 0, 0);" <?php endif; ?>>
            <div class="form_field_error_mail" <?php if (isset_flash_message_by_name(ERROR_MAIL)) : ?>style="display: block;" <?php endif; ?>>
              <span role="alert"> <?php display_flash_message_by_name(ERROR_MAIL); ?> </span>
            </div>
          </div>
          <div class="password">
            <label for="password" class="field_label_top">Mot de passe</label>
            <input id="password" type="password" placeholder="Mot de passe" name="password" autocomplete='on' <?php if (isset_flash_message_by_name(ERROR_PSWD)) : ?>style="border-bottom: 2px solid rgb(210, 0, 0);" <?php endif; ?>>
            <a href="#" role="button" class="view_password_link">
              <i class="fas fa-eye"></i>
            </a>
            <a href="./resetpw.php" class="forgot_pwd">Mot de passe oublié ?</a>
            <div class="form_field_error_password" <?php if (isset_flash_message_by_name(ERROR_PSWD)) : ?>style="display: block;" <?php endif; ?>>
              <span role="alert"> <?php display_flash_message_by_name(ERROR_PSWD); ?> </span>
            </div>
          </div>
          <div class="submit">
            <button type="submit" name="submit">Se connecter</button>
          </div>
      </form>
    </section>
    <script src="./public/js/login.js" type="text/javascript" async></script> <?php endif; ?>
</body>

</html>