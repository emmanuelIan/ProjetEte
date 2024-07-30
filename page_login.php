<?php
include('page_fonctions.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Connexion</title>
    <link rel="stylesheet" href="style_Css_Vb.css">
</head>
<?php
$messageErreur = '';
if (isset($_POST['btnConnexion'])) {
    $pseudo = $_POST['username'];   
    $mdp = $_POST['password'];
    if (valider_identifiants($pseudo, $mdp)) {
        $_SESSION['estConnecte'] = true;
        $_SESSION['userName'] = $pseudo;
        header('Location: page_index_volley.php');
        echo "changegment de page effectué";
    } else {
        $messageErreur = "Il y a une erreur dans le mot de passe ou le nom d'utilisateur";
    }
}
?>

<body>
    <header>
    <?php
    include('page_nav_bar.php');
    ?>
    </header>
    <section>
        <div id="formConnexion">
            <h1>Connexion</h1>
            <?php if ($messageErreur != '') : ?>
                <p style="color: red;"><?php echo $messageErreur; ?></p>
            <?php endif; ?>
            <div>
                <table>
                    <form method="post">
                        <tr>
                            <td><label for="username">Nom d'utilisateur :</label></td>
                            <td><input type="text" name="username" required autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td> <label for="password">Mot de passe :</label></td>
                            <td> <input type="password" name="password" required></td>
                        </tr>
                        <br><br>
                        <tr>
                            <td colspan="2"><input name="btnConnexion" type="submit" value="Se connecter"></td>
                        </tr>
                    </form>
                </table><br><br>
            </div>
        </div>
    </section>
    <footer>

    </footer>
</body>


</html>