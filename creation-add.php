<?php
session_start();

include('config.php');

if (strlen($_SESSION['alogin']) == 0) {
  header('location:creation-adminlogin.php');
} else {
      if (isset($_POST['create'])){
      $creationname= valid_donnees($_POST['creationname']);
      $creationdescription= valid_donnees($_POST['creationdescription']);
      $statut= valid_donnees($_POST['statut']);
      $creationimage= valid_donnees($_POST['creationimage']);
      $creationvignette= valid_donnees($_POST['creationvignette']);
        if (!empty($creationname)
        && strlen($creationname) <= 30
        && preg_match("#^[A-Za-z0-9 '-éàè^¨]+$#",$creationname)
        && !empty($creationdescription)
        && strlen($creationdescription) <= 500
        && preg_match("#^[A-Za-z0-9 '-éàè^¨]+#",$creationdescription)
        && !empty($statut)
        && strlen($statut) <= 1
        && preg_match("#^[1-2]#",$statut)
        && !empty($creationimage)
        && strlen($creationimage) <= 100
        && preg_match("#^[A-Za-z0-9 '_-éàè^¨]+#",$creationimage)
        && !empty($creationvignette)
        && strlen($creationvignette) <= 100
        && preg_match("#^[A-Za-z0-9 '_-éàè^¨]+#",$creationvignette))
      {
      $sql2= "INSERT INTO création (CreationName, CreationDescription, Statut, CreationImage, CreationVignette) VALUES (:creationname, :creationdescription, :statut, :creationimage, :creationvignette) ";
      $query2 = $dbh->prepare($sql2);
      $query2->bindParam(':creationname', $creationname , PDO::PARAM_STR);
      $query2->bindParam(':creationdescription', $creationdescription, PDO::PARAM_STR);
      $query2->bindParam(':statut', $statut, PDO::PARAM_INT);
      $query2->bindParam(':creationimage', $creationimage, PDO::PARAM_STR);
      $query2->bindParam(':creationvignette', $creationvignette, PDO::PARAM_STR);
      $query2->execute();
      }
}
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./css/style.css">
        <title>Ajout d'une pâtisserie</title>
    </head>
<body>
      <!------MENU SECTION START-->
<?php include('headeradmin.php');?>
<!-- MENU SECTION END-->
<div class="">
        <div class="">
            <div class="">
                <h4 class="">AJOUTER UNE PÂTISSERIE</h4>
            </div>
        </div>
        <div class="">
            <div class="">
            <form method="post" action="creation-add.php" >

                    <div class="">
                      <div>
                        <label>Nom</label>
                      </div>
                      <input type="text" name="creationname" required maxlength="100" pattern="^[A-Za-z0-9 '-]+$">
                    </div>

                    <div class="">
                      <div>
                        <label>Description</label>
                      </div>
                      <input type="text" name="creationdescription" required maxlength="200" pattern="^[A-Za-z0-9 '-]+$">
                    </div>

                    <div>
                      <div>
                        <input type="radio" name="statut" value="1" checked>
                        <label for="1">Pâtisserie</label>
                      </div>
                      <div>
                        <input type="radio" name="statut" value="2" checked>
                        <label for="2">Boulangerie</label>
                      </div>                        
                    </div>
                    
                    <div class="">
                      <div>
                        <label>Image</label>
                      </div>
                      <input type="file" name="creation" accept="image/png, image/jpeg">
                    </div>

                    <div class="">
                      <div>
                        <label>Vignette</label>
                      </div>
                      <input type="file" name="creation" accept="image/png, image/jpeg">
                    </div>
                        
                        <button type="submit" name="create" class="btn btn-info">Créer</button>
                </form>
            </div>
        </div>
    </div>
     <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('footer.php');?>
      <!-- FOOTER SECTION END-->

</body>
</html>
