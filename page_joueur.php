<?php
include('page_fonctions.php');
if (!empty($_SESSION['estConnecte']) && $_SESSION['estConnecte'] == true) :
    if (isset($_POST['effacerJou'])) {
        $idJouSupprimme = $_POST['id'];
        deletJoueur($idJouSupprimme);
    }
    $equipe = getAllEquipe();
?>
    <!DOCTYPE html>
    <html lang="fr">
    <?php
    if (isset($_POST['logout'])) {
        header('Location: page_logout.php');
    }
    ?>

    <head>
        <meta charset="utf-8" />
        <title><?= $_SESSION['userName'] ?></title>
        <link rel="stylesheet" href="style_Css_Vb.css">
    </head>

    <body>
        <header>
            <?php
            include('page_nav_bar.php');
            ?>
        </header>
        <section>
            <div class="containerRechercheJoueur">
                <table>
                    <form action="page_donnee_joueur.php" method="get">
                        <tr>
                            <td>
                                <label for="rechercher">Chercher un joueur </label>
                            </td>
                            <td>
                                <input type="text" name="nomRechercher" required>
                                <input type="submit" name="rechercher" value="Rechercher">
                            </td>
                        </tr>
                    </form>
                </table>
            </div>
            <div class="container">
                <h1>Infos des équipes:</h1>
                <?php foreach ($equipe as $e) :
                    $lstJoueur = getAllJoueurByEquipe($e['EQU_ID']);
                ?>
                    <hr class="epais">
                    <h2><?= $e['EQU_NOM'] ?></h2>
                    <div id="<?= 'tableuJoueur' . $e['EQU_ID'] ?>">
                        <h3><?=sizeof($lstJoueur)." joueurs"?></h3>
                        <table id="tableauJoueur">
                            <tr>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Post Volley</th>
                                <th>Nationalité </th>
                                <th>N° du joueur</th>
                                <th> </th>
                                <th> </th>
                            </tr>
                            <?php foreach ($lstJoueur as $joueur) : ?>
                                <?= "<tr><td>" . htmlspecialchars($joueur['JOU_NOM']) . "</td>" ?>
                                <?= "<td>" . htmlspecialchars_decode($joueur['JOU_PREN']) . "</td>" ?>
                                <?= "<td>" . htmlspecialchars($joueur['POS_NOM']) . "</td>" ?>
                                <?= "<td>" . htmlspecialchars($joueur['JOU_NATIO']) . "</td>" ?>
                                <?= "<td>" . htmlspecialchars($joueur['JOU_NUM']) . "</td>" ?>
                                <!-- <td><input type="checkbox" name="deletJoueur"></td> -->
                                <td>
                                    <form action="" method="post" onsubmit="return confimerSuppression()">
                                        <input type="hidden" name="id" value="<?= $joueur['JOU_ID'] ?>">
                                        <button name="effacerJou">supprimer</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="page_modifi_jou.php" method="get">
                                        <input type="hidden" name="id" value="<?= $joueur['JOU_ID'] ?>">
                                        <button name="modifiJou">modifier</button>
                                    </form>
                                </td>
                                <?= "</tr>" ?>
                            <?php endforeach; ?>
                        </table>
                        <br>
                        <div>
                            <br>
                            <a href="page_index_volley.php"><input type="button" name="valider" value="Retour"></a>
                        </div>
                    <?php endforeach; ?>
                    </div>
                    <script>
                        function confimerSuppression() {
                            return confirm("T\es sur wallah ?")
                        }
                    </script>
            </div>
        </section>
        <footer>

        </footer>


    </body>

    </html>

<?php
else :
    echo $_SESSION['test'];
endif;

?>