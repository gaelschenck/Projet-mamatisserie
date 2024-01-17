<?php 
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('config.php');

if (isset($_SESSION['login']) && $_SESSION['alogin'] != '') {
    $_SESSION['alogin'] = '';
}
if (TRUE === isset($_POST['alogin'])) {
    if ($_POST['vercode'] != $_SESSION['vercode']) {
        echo '<script>alert ("Erreur"); </script>';
    }else{
        $name = valid_donnees($_POST['username']);
        $mdp = valid_donnees($_POST['password']);
        if (!empty($name)
		&& strlen($name) <=50
		&& preg_match("#[0-9a-zA-Z.+_@]+#",$name)
        && !empty($mdp)
		&& strlen($mdp) <=50
		&& preg_match("#[0-9a-zA-Z.+_@]+#",$mdp))
		{
        $password = password_hash($mdp, PASSWORD_DEFAULT);
        $sql = "SELECT UserName, Password FROM admin WHERE UserName=:username";
        $query=$dbh->prepare($sql);
        $query->bindParam(':username', $name, PDO::PARAM_STR);
        $query->execute();
        $result= $query->fetch(PDO::FETCH_OBJ);
        // On décompose les éléments du test
        // error_log(print_r($result, 1));
        //Le résultat de $result
        // error_log(password_verify($_POST['password'], $result->Password));
        //Le résuktat de ce que donne le password_verify
        // error_log(print_r($_POST,1));
        //Ce qui est dans le $_POST
        // error_log(password_hash('Kiki456',PASSWORD_DEFAULT));
        //Récupération de l'encodage du mot de passe


if (!empty($result) && password_verify($_POST['password'], $result->Password)){
    $_SESSION['alogin']= $_POST['username'];
    header ('location:creation-manage.php');
 } else{
    echo '<script>alert ("Login refusé"); </script>';
 }
    }}
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./css/style.css">
        <title>Les Délices de Chloë - Accueil</title>
    </head>
    <body>
    <?php include('header.php');?>

    <div class="">
        <!--On affiche le titre de la page-->
        <div class="">
        <div class="">
            <div class="">
                    <h3>LOGIN ADMIN</h3>
            </div>
        </div>
       
        <div class="">
			<div class="">
				<form method="post" action="creation-admin-log.php" >
                    <div class="">
						<label>Entrez votre nom</label>
						<input type="text" name="username" required maxlength="50" pattern="[0-9a-zA-Z.+_@]+">
					</div>
					<div class="">
						<label>Entrez votre mot de passe</label>
						<input type="password" name="password" id="password" required maxlength="50" pattern="[0-9a-zA-Z.+_@]+">
					</div>
					<div class="">
						<label>Code de vérification</label>
						<input type="text" name="vercode" required style="height:25px;">&nbsp;&nbsp;&nbsp;<img src="captcha.php">
					</div>
					<button type="submit" name="alogin" class="" >VALIDER</button>
				</form>
			</div>
		</div>
	</div>
        <!--A la suite de la zone de saisie du captcha, on ins�re l'image cr��e par captcha.php : <img src="captcha.php">  -->
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('footer.php'); ?>
    <!-- FOOTER SECTION END-->
</body>

</html>