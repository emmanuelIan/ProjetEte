<?php
session_start();
//================================Connexion à la Bas de donnée================================
function connexion($dbname)
{
    try {
        $bdd = new PDO("mysql:host=localhost;dbname=" . $dbname, "root", "");
        $bdd->query("SET NAMES 'utf8'");
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
    return $bdd;
}
//================================Insertion joueur===========================================
function insertion_joueur()
{
    $bdd = connexion('volley_bdd');

    $nom = $_POST['joueurNom'];                     //insertion pour table "joueur"
    $prenom = $_POST['joueurPrenom'];               //insertion pour table "joueur"
    $adresse = $_POST['joueurAdresse'];             //insertion pour table "joueur"    
    $npa = $_POST['joueurNPA'];                     //insertion pour table "joueur"
    $nationnalite = $_POST['joueurNationnalite'];   //insertion pour table "joueur"
    $num_joue = $_POST['joueurNumero'];             //insertion pour table "joueur"
    $equipe = $_POST['choixEquipe'];
    $post_Vb = $_POST['choix'];                     //insertion pour table "post"

    try {
        //insertion pour table "joueur"------------------------------------------------------------------------------
        $req_tab_jou = $bdd->prepare("INSERT INTO joueur (JOU_NOM, JOU_PREN, JOU_ADRES, JOU_NPA, JOU_NATIO,JOU_NUM,JOU_EQU) VALUES (:nom, :prenom, :adresse, :npa, :nationalite,:numJou,:idEquipe)");
        $req_tab_jou->execute(
            [
                'nom' => $nom,
                'prenom' => $prenom,
                'adresse' => $adresse,
                'npa' => $npa,
                'nationalite' => $nationnalite,
                'numJou' => $num_joue,
                'idEquipe' => $equipe
            ],
        );
        $id_joueur = $bdd->lastInsertId();

        $req_tab_jou = $bdd->prepare("INSERT INTO joueur_post (POS_ID, JOU_ID, DATE_DEBUT) VALUES (:post, :joueur, :debut)");
        $req_tab_jou->execute(
            [
                'post' => $post_Vb,
                'joueur' => $id_joueur,
                'debut' => date('Y-m-d'),

            ],
        );



        echo "insertion avec succès";
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}

//================================Récuperer tous les joueurs de la Table joueur===========================================
function getAllJoueur()
{
    $bdd = connexion('volley_bdd');
    try {
        $req = $bdd->prepare("SELECT 
            joueur.JOU_ID,
            joueur.JOU_NOM,
            joueur.JOU_PREN,
            joueur.JOU_POST,
            joueur.JOU_ADRES,
            joueur.JOU_NPA,
            joueur.JOU_NATIO,
            joueur.JOU_NUM,
            joueur.JOU_EQU,
            post.POS_NOM
        FROM 
            joueur
        JOIN 
            joueur_post ON joueur.JOU_ID = joueur_post.JOU_ID
        JOIN 
            post ON joueur_post.POS_ID = post.POS_ID
        WHERE 
            joueur_post.DATE_DEBUT <= :date_auj AND 
            (joueur_post.DATE_FIN IS NULL OR joueur_post.DATE_FIN >= :date_auj)");
        $req->execute([
            'date_auj' => date('Y-m-d'),
        ],);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}
//================================Récuperer tous les joueurs de la Table joueur===========================================
function getJoueur($id)
{
    $bdd = connexion('volley_bdd');
    try {
        $req = $bdd->prepare("SELECT JOU_NOM,JOU_PREN,JOU_NATIO,JOU_NUM,JOU_ADRES,JOU_NPA,EQU_NOM,POS_NOM,JOU_EQU,post.POS_ID FROM joueur JOIN equipe ON JOU_EQU = EQU_ID JOIN 
            joueur_post ON joueur.JOU_ID = joueur_post.JOU_ID
        JOIN 
            post ON joueur_post.POS_ID = post.POS_ID
        WHERE 
            joueur_post.DATE_DEBUT <= :date_auj AND 
            (joueur_post.DATE_FIN IS NULL OR joueur_post.DATE_FIN >= :date_auj) AND joueur.JOU_ID = :id" );
        $req->execute(['id' => $id,
                        'date_auj'=> date('Y-m-d')]);
        return $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : trouver' . $e->getMessage();
    }
}
//================================ Page de Connexion ===============================================================

function valider_identifiants($username, $password)
{
    $bdd = connexion('volley_bdd');
    try {
        $req = $bdd->prepare("SELECT CON_MDP FROM connexion WHERE CON_PSEUDO = :username");
        $req->execute(['username' => $username]);
        $result = $req->fetch(PDO::FETCH_ASSOC);
        if (!empty($result) && password_verify($password, $result['CON_MDP'])) {
            return true;
        } else {
            error_log("Authentification échouée pour l'utilisateur $username.");
            return false;
        }
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}
//================================ Effacer joueur ===============================================================

function deletJoueur($idJou)
{
    $bdd = connexion('volley_bdd');
    try {
        $req = $bdd->prepare("DELETE FROM joueur WHERE JOU_ID = :id");
        $req->execute(['id' => $idJou]);
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}
//================================ Modifier info de joueur ===============================================================
function updateJoueur($nom, $prenom, $postVoll, $adre, $npa, $nation, $numJou, $id, $equipe)
{
    $bdd = connexion('volley_bdd');
    try {
        $req = $bdd->prepare("UPDATE joueur SET JOU_NOM=:nom,JOU_PREN=:pren,JOU_POST=:postVoll,JOU_ADRES=:adre,JOU_NPA=:npa,JOU_NATIO= :nation,JOU_NUM= :numJou,JOU_EQU =:equipe WHERE JOU_ID = :id");
        $req->execute([
            'nom' => $nom,
            'pren' => $prenom,
            'postVoll' => $postVoll,
            'adre' => $adre,
            'npa' => $npa,
            'nation' => $nation,
            'numJou' => $numJou,
            'id' => $id,
            'equipe' => $equipe
        ]);
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}
//================================ Récupérer tous les posts ===============================================================
function getAllPost()
{
    $bdd = connexion('volley_bdd');
    try {
        $req = $bdd->prepare("SELECT * FROM post ");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}
//================================ Récupere toutes les équipes ===============================================================
function getAllEquipe()
{
    $bdd = connexion('volley_bdd');
    try {
        $req = $bdd->prepare("SELECT * FROM equipe ");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}
//================================ Récupere tous les joueurs d'une équipe ===============================================================
function getAllJoueurByEquipe($idEquipe)
{
    $bdd = connexion('volley_bdd');
    try {
        $req = $bdd->prepare("SELECT * FROM joueur JOIN 
            joueur_post ON joueur.JOU_ID = joueur_post.JOU_ID
        JOIN 
            post ON joueur_post.POS_ID = post.POS_ID
        WHERE 
            joueur_post.DATE_DEBUT <= :date_auj AND 
            (joueur_post.DATE_FIN IS NULL OR joueur_post.DATE_FIN >= :date_auj) AND JOU_EQU = :idEquipe");
        $req->execute([
            'idEquipe' => $idEquipe,
            'date_auj' => date('Y-m-d'),
        ]);

        return $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}
//================================ Récupere un joueur par URL ===============================================================
function searchtJoueurByName($name)
{
    $bdd = connexion('volley_bdd');
    try {
        $req = $bdd->prepare("SELECT JOU_NOM,JOU_PREN,EQU_NOM,JOU_ID FROM joueur JOIN equipe ON JOU_EQU = EQU_ID  WHERE JOU_NOM LIKE :nom");
        $req->execute(['nom' => "%" . $name . "%"]);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}
//================================ Insertion de Matchs ===============================================================
function insertMatch($equ1, $equ2, $mat_date, $lieu)
{
    $bdd = connexion('volley_bdd');
    try {
        $req_tab_jou = $bdd->prepare("INSERT INTO matchs (MAT_EQU1,MAT_EQU2,MAT_DATE,MAT_LIEU) VALUES (:equ1, :equ2, :mat_date,  :lieu)");
        $req_tab_jou->execute(
            [
                'equ1' => $equ1,
                'equ2' => $equ2,
                'mat_date' => $mat_date,
                'lieu' => $lieu
            ],
        );

        echo "insertion avec succès";
        return $bdd->lastInsertId();
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}
//================================ Récupere tous le Matchs ===============================================================
function getallMatch()
{
    $bdd = connexion('volley_bdd');
    try {
        $req = $bdd->prepare("SELECT MAT_DATE,MAT_LIEU,equ1.EQU_NOM AS nom1,equ2.EQU_NOM AS nom2,MAT_ID FROM matchs JOIN equipe AS equ1 ON MAT_EQU1 = equ1.EQU_ID JOIN equipe AS equ2 ON MAT_EQU2 = equ2.EQU_ID");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}
//================================ Insertion de Set ===============================================================
function insertSet($idScore, $numSet, $scor1, $scor2)
{
    $bdd = connexion('volley_bdd');
    try {
        //insertion pour table "joueur"------------------------------------------------------------------------------
        $req = $bdd->prepare("INSERT INTO setss (SET_SCORE_ID,SET_NUMERO,SET_POINTS_EQUIPE1,SET_POINTS_EQUIPE2) VALUES ( :idScore,:numSet, :scor1, :scro2)");
        $req->execute(
            [
                'numSet' => $numSet,
                'idScore' => $idScore,
                'scor1' => $scor1,
                'scro2' => $scor2,
            ],
        );
        echo "insertion avec succès";
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}
//================================ Insertion de Set ===============================================================
function insertScore($idMatch)
{
    $bdd = connexion('volley_bdd');
    try {
        $req = $bdd->prepare("INSERT INTO score (SCO_MATCH_ID) VALUES (:idMatch)");
        $req->execute(
            [
                'idMatch' => $idMatch
            ],
        );
        return $bdd->lastInsertId();
        echo "insertion avec succès";
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}

function getScoreByMatchId($matchId)
{

    $bdd = connexion('volley_bdd');
    try {
        $req = $bdd->prepare("SELECT * FROM score WHERE SCO_MATCH_ID = :id");
        $req->execute(['id' => $matchId]);
        return $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}


function getAllSetByScoreId($ScoreId)
{

    $bdd = connexion('volley_bdd');
    try {
        $req = $bdd->prepare("SELECT * FROM setss WHERE SET_SCORE_ID = :id");
        $req->execute(['id' => $ScoreId]);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}

function getAllPostById($id){
    $bdd = connexion('volley_bdd');
    try {
        $req = $bdd->prepare("SELECT * FROM joueur_post JOIN post ON post.POS_ID = joueur_post.POS_ID WHERE JOU_ID =:id ");
        $req->execute(['id' => $id]);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}

function getActuelPost($id){
    $bdd = connexion('volley_bdd');
    try {
        $req = $bdd->prepare("SELECT * FROM joueur_post 
        JOIN 
            post ON joueur_post.POS_ID = post.POS_ID
        WHERE IS_ACTIF = :isActif AND JOU_ID = :id" );
        $req->execute(['id' => $id,
                        'isActif' => 1]);
        return $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}

function modifierPostJoueur($id,$idPost,$debut,$fin,$oldPost,$oldDate,$isActif){
    $bdd = connexion('volley_bdd');
    try {
        if($isActif == "on"){
            $req = $bdd->prepare("UPDATE joueur_post SET IS_ACTIF = :isActif WHERE JOU_ID = :id ");
            $req->execute(
                [
                    'id' => $id,
                    'isActif' => 0,
                ],
            );
        }
        $req = $bdd->prepare("UPDATE joueur_post SET POS_ID = :idPost, DATE_DEBUT = :debut, DATE_FIN = :fin, IS_ACTIF = :isActif WHERE JOU_ID = :id AND POS_ID = :oldPost AND DATE_DEBUT = :oldDate");
        $req->execute(
            [
                'id' => $id,
                'idPost' => $idPost,
                'debut' => $debut,
                'fin' => $fin,
                'oldPost' => $oldPost,
                'oldDate' => $oldDate,
                'isActif' => $isActif == "on" ? 1:0,
            ],
        );

        return $bdd->lastInsertId();
        echo "insertion avec succès";
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}

function insererPostJoueur($id,$idPost,$debut,$fin,$isActif){
    $bdd = connexion('volley_bdd');
    try {
        if($isActif == "on"){
            $req = $bdd->prepare("UPDATE joueur_post SET IS_ACTIF = :isActif WHERE JOU_ID = :id ");
            $req->execute(
                [
                    'id' => $id,
                    'isActif' => 0,
                ],
            );
        }
        $req = $bdd->prepare("INSERT INTO joueur_post (POS_ID,DATE_DEBUT,DATE_FIN,JOU_ID, IS_ACTIF) VALUES (:idPost,:debut,:fin,:id,:isActif) ");
        $req->execute(
            [
                'id' => $id,
                'idPost' => $idPost,
                'debut' => $debut,
                'fin' => $fin,
                'isActif' => $isActif == "on" ? 1:0
            ],
        );
        return $bdd->lastInsertId();
        echo "insertion avec succès";
    } catch (PDOException $e) {
        echo 'Erreur d\'insertion : ' . $e->getMessage();
    }
}