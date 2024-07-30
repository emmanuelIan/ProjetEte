<?php
include('page_fonctions.php');
if (!empty($_SESSION['estConnecte']) && $_SESSION['estConnecte'] == true) :
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="utf-8" />
        <title>Summer Project Volley-Ball</title>
        <link rel="stylesheet" href="style_Css_Vb.css">
    </head>
    <header>
    <?php
    include('page_nav_bar.php');
    ?>
    </header>
    <?php
    if (isset($_POST['valider'])) {
        insertion_joueur();
        header('Location: page_joueur.php');
    }
    ?>

    <body>
        <div><h1>Enregistrer un joueur</h1></div>
        <div id="form">
            <form action="" method="post">
                <table>
                    <colgroup span="2" width="250px">
                    <tr>
                        <td><label for="joueurNom">Nom:</label></td>
                        <td><input type="text" name="joueurNom" alt="Saisie du nom de famille." size="20" maxlength="20" required></td>
                    </tr>
                    <tr>
                        <td><label for="joueurPrenom">Prenom:</label></td>
                        <td><input type="text" name="joueurPrenom" alt="Saisie du prénom." size="20" maxlength="20" required></td>
                    </tr>
                    <tr>
                        <td><label for="joueurPost">Post Volley-Ball:</label></td>
                        <td>
                            <select name="choix" id="choix">
                                <option value="" selected disabled>Séléctionnez un post</option>
                                <?php
                                $posts = getAllPost();
                                foreach ($posts as $post) : ?>
                                    <option value="<?= $post['POS_ID'] ?>"><?= $post['POS_NOM'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="joueurAdresse">Adresse:</label></td>
                        <td><input type="text" name="joueurAdresse" alt="Saisie de l'adresse du joueur." size="20" maxlength="20" required></td>
                    </tr>
                    <tr>
                        <td><label for="joueurNPA">NPA:</label></td>
                        <td><input type="text" name="joueurNPA" alt="Saisie du NPA." size="20" maxlength="20" required></td>
                    </tr>
                    <tr>
                        <td><label for="joueurNationnalite">Nationalité du joueur:</label></td>
                        <td><input type="text" name="joueurNationnalite" alt="Saisie de la nationalité." size="20" maxlength="20" required></td>
                    </tr>
                    <tr>
                        <td><label for="joueurNum">Numéro du joueur:</label></td>
                        <td><input type="text" name="joueurNumero" alt="Saisie du num." size="20" maxlength="20" required></td>
                    </tr>
                    <tr>
                        <td><label for="equipe">Equipe</label></td>
                        <td>
                            <select name="choixEquipe" id="choixEquipe">
                                <option value="" selected disabled>Séléctionnez une équipe</option>
                                <?php
                                $teams = getAllEquipe();
                                foreach ($teams as $team) : ?>
                                    <option value="<?= $team['EQU_ID'] ?>"><?= $team['EQU_NOM'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </td>
                    </tr>
                    </colgroup>
                </table>
                <br><br>
                <input type="reset" value="Effacer">
                <input type="submit" name="valider" value="Valider">
            </form>
        </div>
    </body>
    <footer>
    </footer>

    </html>


<?php

else:
    echo "<span>Il faut <a href='page_login.php'> se connecter </a> pour voir cette page</span>";


endif;


?>