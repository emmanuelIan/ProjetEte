<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<header>
    <?php
    include('page_nav_bar.php');
    ?>
</header>
<?php
$nom = $_GET['nomRechercher'];
$joueurs = searchtJoueurByName($nom);
if(!empty($joueurs)){
    foreach ($joueurs as $joueur) {
        echo "<a href='page_info_joueur.php?id=" . $joueur['JOU_ID'] . "&from=".$nom."'><p>" . $joueur['JOU_PREN'] . " " . $joueur['JOU_NOM'] . " " . $joueur['EQU_NOM'] . "</p></a>";
    }
}else{
    echo"Aucun correspondant";
}

?>
<div>
    <br>
    <a href="page_joueur.php"><input type="button" name="valider" value="Retour"></a>
</div>

<body>

</body>

</html>