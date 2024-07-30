<?php
include('page_fonctions.php');
if (!empty($_SESSION['estConnecte']) && $_SESSION['estConnecte'] == true) :
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_Css_Vb.css">
    <title>Match</title>
</head>

<body>
    <header>
        <?php
        include('page_nav_bar.php');
        if (isset($_POST['inserer_match'])) {
            $equ1 = $_POST['equ1'];
            $equ2 = $_POST['equ2'];
            $lieu = $_POST['lieu'];
            $date = $_POST['date'];
            $idMatch = insertMatch($equ1, $equ2, $date, $lieu);
            $idScore = insertScore($idMatch);
            for ($i = 1; $i <= 5; $i++) {
                $scorEqu1 = $_POST['Equip1Set' . $i];
                $scorEqu2 = $_POST['Equip2Set' . $i];
                insertSet($idScore, $i, $scorEqu1, $scorEqu2);
            }
        }
        ?>
    </header>
    <section>
        <?php
        $equs = getAllEquipe();
        $matchs = getallMatch();
        ?>
        <h1>Insérer Match</h1>
        <div>
            <form action="" method="post">
                <label for="equ1">Equipe 1</label>
                <select name="equ1">
                    <option value="" selected disabled>Séléctionnez une équipe</option>
                    <?php foreach ($equs as $equ) : ?>
                        <option value="<?= $equ["EQU_ID"] ?>"><?= $equ['EQU_NOM'] ?></option>
                    <?php endforeach ?>
                </select>
                <br><br>
                <label>Equipe 2</label>
                <select name="equ2">
                    <option value="" selected disabled>Séléctionnez une équipe</option>
                    <?php foreach ($equs as $equ) : ?>
                        <option value="<?= $equ["EQU_ID"] ?>"><?= $equ['EQU_NOM'] ?></option>
                    <?php endforeach ?>
                </select>
                <?php
                for ($i = 1; $i <= 5; $i++) {
                    echo    '<h3>Set ' . $i . '</h3>';
                    echo '<label>Equipe 1:</label>';
                    echo '<input type="text" class="score" name="Equip1Set' . $i . '"><br><br>    ';
                    echo '<label>Equipe 2:</label>';
                    echo '<input type="text" class="score" name="Equip2Set' . $i . '"><br><br>';
                }
                ?>
                <input type="button" id="mettre0" value="Tout mettre a 0">
                <label>Lieu:</label>
                <input type="text" name="lieu"><br><br>
                <label>Date de match:</label>
                <input type="date" name="date"><br><br>
                <input type="submit" value="Insérer" name="inserer_match">
            </form>
        </div>
        <div>
            <?php foreach ($matchs as $match) : ?>
                <div class="match">
                    <h2>
                        <?= $match['nom1'] . ' VS ' . $match['nom2'] . ' à ' . $match['MAT_LIEU'] . ' le ' . date('d/m/Y', strtotime($match['MAT_DATE'])) ?>
                    </h2>
                    <?php
                    $equipe1 = $match['nom1'];
                    $equipe2 = $match['nom2'];
                    $score = getScoreByMatchId($match["MAT_ID"]);
                    $sets = getAllSetByScoreId($score["SCO_ID"]);
                    if ($sets) : ?>
                        <div class="sets">
                            <?php foreach ($sets as $set) : ?>
                                <div class="set">
                                    <h3>Set <?= $set['SET_NUMERO'] ?></h3>
                                    <p>Équipe 1 : <?= $set['SET_POINTS_EQUIPE1'] ?> points</p>
                                    <p>Équipe 2 : <?= $set['SET_POINTS_EQUIPE2'] ?> points</p>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php else : ?>
                        <p>Aucun set disponible pour ce match.</p>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
        </div>
    </section>
    <footer>

    </footer>

</body>
<script>
    document.getElementById("mettre0").addEventListener("click", function() {
        let scores = document.getElementsByClassName("score");
        for (let i = 0; i < scores.length; i++) {
            scores[i].value = 0;
        }
    })
</script>

</html>
<?php

else:
    echo "<span>Il faut <a href='page_login.php'> se connecter </a> pour voir cette page</span>";


endif;


?>