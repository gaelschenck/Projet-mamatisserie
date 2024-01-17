<?php
session_start();

include('config.php');
if (strlen($_SESSION['alogin']) == 0) {
      header('location:creation-admin-log.php');
 } else {
     $id = valid_donnees($_GET['edit']);
    //  echo $id;
     if (!empty($id)
        && strlen($id) <= 3
        && preg_match("#^[0-9]{1,}#",$id))
        {
          $sql="SELECT * FROM création WHERE Id= $id ";
          $query = $dbh->prepare($sql);
          $query->execute();
           $result=$query->fetch(PDO::FETCH_ASSOC);
           $name=$result['CreationName'];
           $description=$result['CreationDescription'];
           $statut=$result['Statut'];
           $image=$result['CreationImage'];
           $vignette=$result['CreationVignette'];
        }
      if (isset($_POST['update'])){

        if (TRUE === isset($_POST['update'])) {

          $newname =$_POST['creationname'];
          if(!$newname){
              $newname = $name;
          }
          $newdescription=$_POST['creationdescription'];
          if(!$newdescription){
              $newdescription = $description;
          }
          $newstatut=$_POST['statut'];
          if(!$newstatut){
              $newstatut = $statut;
          }
          $newimage=$_POST['creationimage'];
          if(!$newimage){
              $newimage = $image;
          }
          $newvignette=$_POST['creationvignette'];
          if(!$newvignette){
              $newvignette = $vignette;
          }

          $sql = "UPDATE création SET CreationName=:creationname, CreationDescription=:creationdescription, Statut=:statut, CreationImage=:creationimage, CreationVignette=:creationvignette,Updation";
          $query = $dbh->prepare($sql);
          $query->bindParam(':creationname',$newname, PDO::PARAM_STR);
          $query->bindParam(':creationdescription',$newdescription, PDO::PARAM_STR);
          $query->bindParam(':statut',$newstatut, PDO::PARAM_INT);
          $query->bindParam(':creationimage',$newimage, PDO::PARAM_STR);
          $query->bindParam(':creationvignette',$newvignette, PDO::PARAM_STR);
          $query->execute();
          echo '<script>alert ("Données mises à jour");
          location.href="creation-manage.php" </script>';
          }
         }
        }
        
?>

<<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Edition d'une entrée</title>
    <link href="./css/style.css" rel="stylesheet" />
</head>

<body>
      <!------MENU SECTION START-->
      <?php include('headeradmin.php'); ?>
      <!-- MENU SECTION END-->
      <br>
      <div class="">
        <div class="">
            <div class="">
                <h4 class="">ÉDITER UNE PÂTISSERIE</h4>
            </div>
        </div>
        <div class="">
            <div class="">
            <form method="post" action="creation-edit.php" >

                    <div class="">
                      <div>
                        <label>Nom</label>
                      </div>
                      <input type="text" name="creationname" maxlength="100" pattern="^[A-Za-z0-9 âêôùèàéöëïäü'-,;.:]+$"placeholder="<?php echo($name);?>">
                    </div>

                    <div class="">
                      <div>
                        <label>Description</label>
                      </div>
                      <input type="text" size="200"name="creationdescription" maxlength="500" pattern="^[A-Za-z0-9 âêôùèàéöëïäü'-,;.:]+$" placeholder="<?php echo($description);?>">
                    </div>

                    <div>
                      <div>
                        <input type="radio" name="statut" value="1">
                        <label for="1">Pâtisserie</label>
                      </div>
                      <div>
                        <input type="radio" name="statut" value="2">
                        <label for="2">Boulangerie</label>
                      </div>                        
                    </div>
                    
                    <div class="">
                      <div>
                        <label>Image</label>
                      </div>
                      <input type="file" name="creationimage" accept="image/png, image/jpeg">
                    </div>

                    <div class="">
                      <div>
                        <label>Vignette</label>
                      </div>
                      <input type="file" name="creationvignette" accept="image/png, image/jpeg">
                    </div>
                        
                        <button type="submit" name="update" class="">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
    <br>
      <!-- CONTENT-WRAPPER SECTION END-->
      <?php include('footer.php'); ?>
      <!-- FOOTER SECTION END-->
</body>

</html>