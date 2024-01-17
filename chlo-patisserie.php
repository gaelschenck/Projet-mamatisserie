<?php
// On recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion a la base de donn�es
include('config.php');
    
        $sql = "SELECT * FROM création WHERE Statut=1";
        $query = $dbh->prepare($sql);
        
    
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./css/style.css">
        <title>Les Délices de Chloë - Pâtisserie</title>
    </head>
    <body>
    <?php include('header.php');?>
    <h1>La Pâtisserie de Chloé</h1>
    <br>
    <div class="container">
        <div class="boutique">
            <?php  
            $query->execute();
            while($result = $query->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="vignette">
                <img src="<?php echo($result['CreationVignette']);?>" id="<?php echo($result['Id']);?>" onclick="getimage(id)">
            </div>
            <?php } ?>
        </div>
        <div class="panier">
            <div class="detail">
                <div class="titre">
                    <div id="answer"></div>          
                    <div id="answer1"></div>
                </div>
                <div class="description">
                    <div id="answer2"></div>
                </div>
            </div>   
        </div>
    </div>
    <?php include('footer.php');?>
    </body>
    <script>
    function getimage(id){
            let span = document.getElementById("answer");
            let span1 = document.getElementById("answer1");
            let span2 = document.getElementById("answer2");
                console.log(id); 
                // console.log(id.value);
            fetch('getimage.php?id='+id)
            .then(rep => rep.json())
            .then(data => {
                console.log(data.jajax);
                span.innerHTML = "<h2>" + data.jajax.CreationName + "</h2>";
                span1.innerHTML= '<img src="' + data.jajax.CreationImage + '" alt="'+ data.jajax.CreationName + '">'
                span2.innerHTML= "<p>" + data.jajax.CreationDescription + "</p>";
                }
            )               
        }
     </script>
</html>