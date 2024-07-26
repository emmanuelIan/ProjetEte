<?php
require_once('page_fonctions.php');
?>
    <link rel="stylesheet" href="style_Css_Vb.css">
        <nav>
            <ul>
                <li><a href="page_joueur.php">Liste Joueur</a></li>
                <li><a href="page_equipe.php">Equipes</a></li>
                <li><a href="page_index_volley.php">Enregistrement</a></li>
                <li><a href="page_match.php">Matchs</a></li>
            </ul>
            <ul>
                <form method="get" action="page_logout.php">
                    <button type="submit" name="logout">Déconnexion</button>
                </form>
            </ul>
        </nav>