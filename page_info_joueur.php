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
    $idJou = $_GET['id'];
    $infoJou = getJoueur($idJou);
    ?>
</header>

<body>

    <table id="tableauJoueur">
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Post Volley</th>
            <th>Nationalité </th>
            <th>N° du joueur</th>
            <th>Adresse </th>
            <th>Equipe</th>
        </tr>
        <tr> <?= "<td>" . htmlspecialchars($infoJou['JOU_NOM']) . "</td>" ?>
            <?= "<td>" . htmlspecialchars_decode($infoJou['JOU_PREN']) . "</td>" ?>
            <?= "<td>" . htmlspecialchars($infoJou['POS_NOM']) . "</td>" ?>
            <?= "<td>" . htmlspecialchars($infoJou['JOU_NATIO']) . "</td>" ?>
            <?= "<td>" . htmlspecialchars($infoJou['JOU_NUM']) . "</td>" ?>
            <?= "<td>" . htmlspecialchars($infoJou['JOU_ADRES']) . "</td>" ?>
            <?= "<td>" . htmlspecialchars($infoJou['EQU_NOM']) . "</td>" ?>
        </tr>
    </table>
    <div>
        <br>
        <a href="page_donnee_joueur.php?nomRechercher=<?= $_GET['from']?>"><input type="button" name="valider" value="Retour"></a>
    </div>
</body>

</html>