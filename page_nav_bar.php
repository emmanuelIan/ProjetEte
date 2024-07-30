<?php
require_once('page_fonctions.php');
?>
<link rel="stylesheet" href="style_Css_Vb.css">
<nav>
    <ul>
        <li><a href="page_joueur.php">Liste Joueur</a></li>
        <li><a href="page_equipe.php">Equipes</a></li>
        <?= !empty($_SESSION['estConnecte']) && $_SESSION['estConnecte'] == true ? '<li><a href="page_index_volley.php">Enregistrement</a></li>' : "" ?>
        <?= !empty($_SESSION['estConnecte']) && $_SESSION['estConnecte'] == true ? '<li><a href="page_match.php">Matchs</a></li>' : "" ?>
    </ul>
    <ul>
        <form method="get" action="page_logout.php">
            <button type="submit" name="logout"><?= !empty($_SESSION['estConnecte']) && $_SESSION['estConnecte'] == true ? 'se déconnecter ' : "se connecter" ?>
            </button>
        </form>
    </ul>
</nav>