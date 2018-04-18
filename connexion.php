<!DOCTYPE html>
<?php 
session_start();  // Il faut ouvrir une session lorsqu'on va créer ou appeler des variables sessions
 try{
    $bdd= new PDO('mysql:host=127.0.0.1;dbname=feelin_db', 'root', '');

    if(isset($_POST['btconnexion'])){

 

        if(isset($_POST['mail']) AND (!empty($_POST['mail'])) AND isset($_POST['password']) AND (!empty($_POST['password'])))
          {

              $mail = htmlspecialchars($_POST['mail']);
              $password = sha1($_POST['password']);

              $requser = $bdd->prepare("SELECT * FROM users WHERE mail=? AND motdepasse=?");
              $requser->execute(array($mail,$password));
              $userexist = $requser->rowCount();
               


              if($userexist == 1)
              {     

                    $userinfo = $requser->fetch();  // met tous les attributs de la table dans un array
                    $_SESSION['id']= $userinfo['Id'];
                    $_SESSION['pseudo'] = $userinfo['pseudo'];
                    $_SESSION['mail'] = $userinfo['mail'];
                    header("Location: profil.php?id=".$_SESSION['id']);  // Redirection vers le profil de l'utilisateur 
              } 
              else
              {
                    $erreur = "Mauvais mail ou mdp";
              }



          }
          else
          {
               $erreur =  "champs incomplets";
          }
      }

 }
 catch(Exception $e)
 {  echo "erreur connex BDD";
    die('Erreur : '.$e->getMessage());
 }

?>

<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="css\Styles.css">
</head>

<body>
  
<div id="container" align="center">
 </br>
   <h3>Connexion</h3>
   </br></br>
    <form method="POST" name="formConnexion" action="">
    <table>
     <tr> 
         <td> 
            <label for=""> mail: </label>
         </td>

         <td>
            <input type="text" name="mail">
        </td>
     </tr>
     <tr>
        <td>
            <label for=""> password: </label>
        </td>

        <td>
            <input type="password" name="password">
        </td>
     </tr>  

     <tr>
        <td> </td>
        <td>
            <input type="submit" name="btconnexion" value="connexion" />  
        </td> 
     </tr> 
   
     <tr>
         <td> </td>
        <td>
            <a href="inscription.php"> S'inscrire </a>
        </td>
     </tr>    
     <tr>
         <td> </br> </td>
        <td>
            <?php if (isset($erreur)){
                echo '<font color="red">'.$erreur;
            }
            
            ?>
        </td>
     </tr>  
    </table>    
 
    </form>

 </div> 
    

</body>

</html>