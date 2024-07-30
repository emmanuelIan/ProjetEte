<?php
include('page_fonctions.php');
if (!empty($_SESSION['estConnecte']) && $_SESSION['estConnecte'] == true) :
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <header>
            <?php
            include('page_nav_bar.php');
            $idJoueur = $_GET['id'];
            $getAllPost = getAllPostById($idJoueur);
            $postActuel = getActuelPost($idJoueur);
            $posts = getAllPost();
            if (isset($_POST['modifier'])) {
                $choix = $_POST['choix'];
                $dateDebut = $_POST['dateDebut'];
                $dateFin = $_POST['dateFin'];
                $oldPost = $_POST['idOld'];
                $oldDate = $_POST['dateOld'];
                $isActif = $_POST['isActif'];
                echo $isActif;
                modifierPostJoueur($idJoueur, $choix, $dateDebut, $dateFin, $oldPost, $oldDate, $isActif);
                header('Refresh: 0');
            }
            if (isset($_POST['ajouter'])) {
                $choix = $_POST['choix'];
                $dateDebut = $_POST['dateDebut'];
                $dateFin = $_POST['dateFin'];
                $isActif = $_POST['isActif'];
                insererPostJoueur($idJoueur, $choix, $dateDebut, $dateFin, $isActif);
                header('Refresh: 0');
            }

            ?>
        </header>
        <section>
            <h1>Post Actuel:</h1><br>
            <?= $postActuel['POS_NOM'] . " de " . $postActuel['DATE_DEBUT'] . " à  " . $postActuel['DATE_FIN'] ?>
            <h1>Tout les posts:</h1>
            <?php foreach ($getAllPost as $post) : ?>
                <form action="#" method="post">
                    <select name="choix" id="choix">
                        <?php
                        foreach ($posts as $postn) :
                            if ($postn['POS_ID'] === $post['POS_ID']) : ?>
                                <option value="<?= $postn['POS_ID'] ?>" selected id=""><?= $postn['POS_NOM'] ?></option>
                            <?php
                            else : ?>
                                <option value="<?= $postn['POS_ID'] ?>" id=""><?= $postn['POS_NOM'] ?></option>
                        <?php endif;
                        endforeach; ?>
                    </select>
                    <span>de</span>
                    <input type="date" name="dateDebut" value="<?= $post['DATE_DEBUT'] ?>">
                    <span>à</span> <input type="date" name="dateFin" value="<?= $post['DATE_FIN'] ?>"><span> est actif</span> <input type="checkbox" name="isActif" <?= $post['IS_ACTIF'] ? "is checked" : "" ?>>
                    <input type="hidden" name="idOld" value="<?= $post['POS_ID'] ?>">
                    <input type="hidden" name="dateOld" value="<?= $post['DATE_DEBUT'] ?>">
                    <input type="submit" value="modifier" name="modifier">
                </form>
            <?php endforeach; ?>
            <h1>Ajouter un Post:</h1>
            <form action="#" method="post">
                <select name="choix" id="choix">
                    <?php foreach ($posts as $postn) : ?>
                        <option value="<?= $postn['POS_ID'] ?>" id=""><?= $postn['POS_NOM'] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="date" name="dateDebut" required>
                <input type="date" name="dateFin">
                <span> est actif</span> <input type="checkbox" name="isActif" <?= $post['IS_ACTIF'] ? "is checked" : "" ?>>
                <input type="submit" value="Ajouter" name="ajouter">
            </form>
        </section>
        <footer>

        </footer>
    </body>

    </html>
<?php

else :
    echo "<span>Il faut <a href='index.php'> se connecter </a> pour voir cette page</span>";


endif;


?>