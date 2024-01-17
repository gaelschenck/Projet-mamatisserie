<?php
// On recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion a la base de donn�es
include('config.php');
    if (strlen($_SESSION['alogin']) == 0) {
        header('location:creation-admin-log.php');
    } else { 
        $sql = "SELECT * FROM création WHERE (Statut=1 || Statut=2)";
        $query = $dbh->prepare($sql);
    }
           
      
    if (isset($_GET['edit'])){
        $id= valid_donnees($_GET['edit']);
         if (!empty($id)
        && strlen($id) <= 3
        && preg_match("#^[0-9]{1,}#",$id))
        {
        $dbh->exec("SELECT * FROM création WHERE Id=$id");
    }
    };

    if (isset($_GET['suppress'])){ 
        $id= valid_donnees($_GET['suppress']);
         if (!empty($id)
        && strlen($id) <= 3
        && preg_match("#^[0-9]{1,}#",$id))
        {
        $dbh->exec("UPDATE création SET Status=0 WHERE Id=$id");
        echo "<script>alert('Catégorie modifiée')</script>";
            header ('location:manage-categories.php');
    }
    };
// Si l'utilisateur est déconnecté
// L'utilisateur est renvoyé vers la page de login : index.php

// On recupere l'identifiant de la catégorie a supprimer

// On prepare la requete de suppression

// On execute la requete

// On informe l'utilisateur du resultat de loperation

// On redirige l'utilisateur vers la page manage-categories.php

?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>GÉRER LES PÂTISSERIES</title>
    <link href="./css/style.css" rel="stylesheet" />
</head>
<body>
    <!------MENU SECTION START-->
    <?php include('headeradmin.php'); ?>
    <!-- MENU SECTION END-->
    <div class="">
      <div class="">
        <div class="">
          <h3>GÉRER LES CATÉGORIES</h3>
        </div>
      </div>
      <div class="">
			<div class="">
                <table class="">
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                    Nom
                    </th>
                    <th>
                        Statut
                    </th>
                    <th>
                        Crée le
                    </th>
                    <th>
                        Mis à jour le 
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
                <?php  $query->execute();
                 while($result = $query->fetch(PDO::FETCH_ASSOC)){
                    
                    if($result['Statut']== 1 ){
                        $result['Statut']= "Pâtisserie";
                    } else{
                        $result['Statut']= "Boulangerie";
                    }
                     ?>
                <tr>
                    <th>
                       <?php echo($result['Id']); ?>
                    </th>
                    <th>
                        <?php echo($result['CreationName']); ?>
                    </th>
                    <th>
                        <?php echo($result['CreationDescription']); ?>
                    </th>
                    <th>
                        <?php echo($result['Statut']); ?>
                    </th>
                    <th>
                        <?php echo($result['CreationImage']); ?>
                    </th>
                    <th>
                        <?php echo($result['CreationVignette']); ?>
                    </th>
                    <th><a href="creation-edit.php?edit=<?php echo ($result['Id']) ?>"><button type="submit" name="edit" class="">Éditer</button></a>
                    <a href="creation-manage.php?suppress=<?php echo ($result['Id']) ?>"><button type="submit" name="suppress" class="">Supprimer</button></a>
                    </th>
                </tr>
                <?php 
                  }
             

           
 ?>
                </table>
            </div>
		</div>
    </div>
    <!-- On affiche le titre de la page-->

    <!-- On prevoit ici une div pour l'affichage des erreurs ou du succes de l'operation de mise a jour ou de suppression d'une categorie-->

    <!-- On affiche le formulaire de gestion des categories-->

    </div>

    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('footer.php'); ?>
    <!-- FOOTER SECTION END-->

</body>

</html>