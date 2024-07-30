<?php
include('page_fonctions.php');
if (!empty($_SESSION['estConnecte']) && $_SESSION['estConnecte'] == true) :
    $idJou = $_GET['id'];
    $joueur = getJoueur($idJou);

?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="utf-8" />
        <title>Summer Project Volley-Ball</title>
        <link rel="stylesheet" href="style_Css_Vb.css">
    </head>
    <?php
    if (isset($_POST['logout'])) {
        header('Location: page_logout.php');
    }
    ?>
    <header>
        <?php
        include('page_nav_bar.php');
        ?>
    </header>

    <body>
        <?php
        if (isset($_POST['valider'])) {
            $nom = $_POST['joueurNom'];                     //insertion pour table "joueur"
            $prenom = $_POST['joueurPrenom'];               //insertion pour table "joueur"
            $adresse = $_POST['joueurAdresse'];             //insertion pour table "joueur"    
            $npa = $_POST['joueurNPA'];                     //insertion pour table "joueur"
            $nationnalite = $_POST['joueurNationnalite'];   //insertion pour table "joueur"
            $num_joue = $_POST['joueurNumero'];             //insertion pour table "joueur"
            $equipe = $_POST['choixEquipe'];
            updateJoueur($nom, $prenom, $adresse, $npa, $nationnalite, $num_joue, $idJou, $equipe);
            header('Location: page_joueur.php');
        }
        ?>
        <div id="form">
            <form action="" method="post">
                <table>
                    <colgroup span="2" width="250px">
                    <tr>
                        <td><label for="joueurNom">Nom:</label></td>
                        <td><input type="text" name="joueurNom" value="<?= $joueur['JOU_NOM'] ?>" alt="Saisie du nom de famille." size="20" maxlength="60" required></td>
                    </tr>
                    <tr>
                        <td><label for="joueurPrenom">Prenom:</label></td>
                        <td><input type="text" name="joueurPrenom" value="<?= $joueur['JOU_PREN'] ?>" alt="Saisie du prénom." size="20" maxlength="20" required></td>
                    </tr>
                    <tr>
                        <td><label for="joueurPost">Post Volley-Ball:</label></td>
                        <td>
                            <?php
                            $postActuel = getActuelPost($idJou);
                            echo "<label>Post Actuel: " . $postActuel['POS_NOM'] . "</label> ";
                            echo '<a href="page_joueur_post_historique.php?id=' . $idJou . '"><input type="button" value="modifier"></a>';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="joueurAdresse">Adresse:</label></td>
                        <td><input type="text" name="joueurAdresse" value="<?= $joueur['JOU_ADRES'] ?>" alt="Saisie de l'adresse du joueur." size="20" maxlength="20" required></td>
                    </tr>
                    <tr>
                        <td><label for="joueurNPA">NPA:</label></td>
                        <td><input type="text" name="joueurNPA" value="<?= $joueur['JOU_NPA'] ?>" alt="Saisie du NPA." size="20" maxlength="20" required></td>
                    </tr>
                    <tr>
                        <td><label for="joueurNationnalite">Nationalité du joueur:</label></td>
                        <td><input type="text" name="joueurNationnalite" value="<?= $joueur['JOU_NATIO'] ?>" alt="Saisie de la nationalité." size="20" maxlength="20" required></td>
                    </tr>
                    <tr>
                        <td><label for="joueurNum">Numéro du joueur:</label></td>
                        <td><input type="text" name="joueurNumero" value="<?= $joueur['JOU_NUM'] ?>" alt="Saisie du num." size="20" maxlength="20" required></td>
                    </tr>
                    <tr>
                        <td><label for="equipe">Equipe</label></td>
                        <td>
                            <select name="choixEquipe" id="choixEquipe">
                                <?php
                                $teams = getAllEquipe();
                                foreach ($teams as $team) :
                                    if ($team['EQU_ID'] === $joueur['JOU_EQU']) : ?>
                                        <option value="<?= $team['EQU_ID'] ?>" selected id=""><?= $team['EQU_NOM'] ?></option>
                                    <?php
                                    else : ?>
                                        <option value="<?= $team['EQU_ID'] ?>" id=""><?= $team['EQU_NOM'] ?></option>
                                <?php endif;
                                endforeach; ?>
                        </td>
                    </tr>
                    </colgroup>
                </table>
                <br><br>
                <a href="page_joueur.php"><input type="button" name="valider" value="Retour"></a>
                <input type="submit" name="valider" value="Valider">
            </form>
        </div>
    </body>
    <footer>
    </footer>

    </html>
<?php
else :
    header("Location: page_joueur.php");

endif;

?>