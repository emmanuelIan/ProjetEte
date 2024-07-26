<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les équipes</title>
</head>
<header>
    <?php
    include('page_nav_bar.php');
    ?>
</header>
<?php
if (isset($_POST['logout'])) {
    header('Location: page_logout.php');
}
$equipes = getAllEquipe();
?>

<body>
    <div id="equipe">
        <?php foreach ($equipes as $equipe) : ?>
            <div>
                <a href="<?= 'page_joueur.php#tableuJoueur' . $equipe['EQU_ID'] ?>">
                    <h2><?= $equipe['EQU_NOM'] ?></h2>
                </a>
            </div>
        <?php endforeach ?>
    </div>
    <br>
    <a href="page_index_volley.php"><input type="button" name="valider" value="Retour"></a>
    </div>

</body>

</html>