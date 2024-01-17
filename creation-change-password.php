<?php
// On recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('config.php');

if(strlen($_SESSION['alogin'])==0) {
    header('location:chlo-index.php');
}else{
	if (TRUE === isset($_POST['change'])) {
		$mail = valid_donnees($_SESSION['alogin']);
		if (!empty($mail)
		&& strlen($mail) <= 7
		&& preg_match("#[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}#",$mail))
{
		$sql = "SELECT * FROM admin WHERE AdminEmail=:mail";
		$query=$dbh->prepare($sql);
		// $query->bindParam(':password', $password, PDO::PARAM_STR);
		$query->bindParam(':name', $mail, PDO::PARAM_STR);
		$query->execute();
		$result= $query->fetch(PDO::FETCH_OBJ);
}
	if(!empty($result) && password_verify($_POST['password'], $result->Password)){
		$newmdp = valid_donnees($_POST['newpassword']);
		if (!empty($newmdp)
		&& strlen($newmdp) <=10
		&& preg_match("#[-0-9a-zA-Z.+_@]+#",$newmdp))
{
		$newpassword = password_hash($newmdp, PASSWORD_DEFAULT);
		$sql = "UPDATE admin SET Password=:newpassword WHERE EmailId=:mail";
     $query = $dbh->prepare($sql);
     $query->bindParam(':newpassword',$newpassword, PDO::PARAM_STR);
	 $query->bindParam(':mail', $mail, PDO::PARAM_STR);
     $query->execute();
     echo '<script>alert ("mot de passe modifié");
	 location.href="creation-manage.php";  </script>';
	}else{
		echo '<script>alert ("erreur dans la modification du mot de passe"); </script>';
	}
	}}
}
// Si l'utilisateur n'est pas logue, on le redirige vers la page de login (index.php)
// sinon, on peut continuer,
// si le formulaire a ete envoye : $_POST['change'] existe
// On recupere le mot de passe et on le crypte (fonction php password_hash)
// On recupere l'email de l'utilisateur dans le tabeau $_SESSION
// On cherche en base l'utilisateur avec ce mot de passe et cet email
// Si le resultat de recherche n'est pas vide
// On met a jour en base le nouveau mot de passe (tblreader) pour ce lecteur
// On stocke le message d'operation reussie
// sinon (resultat de recherche vide)
// On stocke le message "mot de passe invalide"

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./css/style.css">
        <title>Changer de mot de passe</title>
    </head>
	<script type="text/javascript">
	valid();
	/* On cree une fonction JS valid() qui verifie si les deux mots de passe saisis sont identiques 
	Cette fonction retourne un booleen*/
	</script>
    <body>
    <?php include('headeradmin.php');?>


<body>
	<!-- Mettre ici le code CSS de mise en forme des message de succes ou d'erreur -->
	<?php include('headeradmin.php'); ?>

	<div class="">
		<div class="">
			<div class="">
				<h3>CHANGER MOT DE PASSE</h3>
			</div>
		</div>
		<div class="">
			<div class="">
				<form method="post" action="creation-change-password.php" >
                    <div class="">
						<label>Mot de passe actuel</label>
						<input type="password" name="password" required pattern="[-0-9a-zA-Z.+_@]" maxlength="30">
					</div>
                    <div class="">
                         <label>Entrez votre nouveau mot de passe</label>
                         <input type="password" name="newpassword" id ="password"required required pattern="[-0-9a-zA-Z.+_@]" maxlength="30">
                    <span id="answer"></span>
                    </div>

                    <div class="">
                         <label>Confirmez votre nouveau mot de passe</label>
                         <input type="password" name="confirmnewpassword" id="password2" required required pattern="[-0-9a-zA-Z.+_@]" maxlength="30">
                    </div>
					<button type="submit" name="change" class="" <?php $status ?>>VALIDER</button>
				</form>
			</div>
		</div>
	</div>
	<!--On affiche le titre de la page : CHANGER MON MOT DE PASSE-->
	<!--  Si on a une erreur, on l'affiche ici -->
	<!--  Si on a un message, on l'affiche ici -->

	<!--On affiche le formulaire-->
	<!-- la fonction de validation de mot de passe est appelee dans la balise form : onSubmit="return valid();"-->


	<?php include('footer.php'); ?>
	
	<script>
	window.addEventListener("load", () =>{
        let password = document.getElementById("password");
        let confirm = document.getElementById("password2");
        let button = document.querySelector("button[name='change']");
               valid(); 
          function valid(){
          confirm.addEventListener("keyup" ,() => {
          if (password.value != confirm.value){
               button.disabled = true;
          } else {
               button.disabled = false;
               alert ("Concordance du mot de passe");
          }})
          }
     })
	 </script>
</body>

</html>