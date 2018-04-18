<!DOCTYPE html>

<?php
try{
    $bdd= new PDO('mysql:host=127.0.0.1;dbname=feelin_db', 'root', ''); 

    if(isset($_POST['btinscription'])){
        if(isset($_POST['pseudo']) AND (!empty($_POST['pseudo'])) AND isset($_POST['mail']) AND (!empty($_POST['mail']))AND isset($_POST['nom']) AND (!empty($_POST['nom'])) AND isset($_POST['password']) AND (!empty($_POST['password']))AND isset($_POST['password1']) AND (!empty($_POST['password1'])))
          {
              if($_POST['password']!=$_POST['password1'])
              {
                  $erreur =  "verifier la correspondance des mots de passe";
              }
              else
              {
                 $pseudo = htmlspecialchars($_POST['pseudo']);
                 $mail = htmlspecialchars($_POST['mail']);
                 $nom = htmlspecialchars($_POST['nom']);
                 $password = sha1($_POST['password']);

                 //echo $pseudo." ".$mail." ".$nom." ".$password;
                 
                 $insertusr = $bdd->prepare("INSERT INTO users(nom,pseudo,mail,motdepasse) VALUES(?,?,?,?)");
                 $insertusr->execute(array($nom,$pseudo,$mail,$password)) or die(print_r($insertusr->errorInfo()));
                 $erreur= "votre compte a bien été créé";
                
              }
          }
          else
          {
               $erreur= "champs incomplets";
          }
      }
  

}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());

}

  
?>
<html>
<div id="container" align="center">
    </br>
   <h3>Inscription</h3>
   </br></br>
<form method="POST" name="formInscription" action="">
    <table>
    <tr>
        <td>
            <label for=""> pseudo: </label>
        </td>
        <td>
            <input type="text" name="pseudo">
        </td>
    </tr>
        <td>
            <label for=""> mail: </label>
        </td>
        <td> 
            <input type="email" name="mail">
        </td>
    <tr>
        <td>
            <label for=""> nom: </label>
         </td>
        <td>
            <input type="text" name="nom">
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
        <td>
            <label for=""> confirm password: </label>
        </td>
        <td>
            <input type="password" name="password1">
        </td>
    </tr>
    <tr>
        <td> </td>
        <td>
            <input type="submit" name="btinscription" value="inscription" />
        </td>
    </tr>
    <tr>
        <td>
            <a href="connexion.php"> retour Accueil </a>
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
        
        

        
       
        
       
        


        
        
        
        
         
         

    </table>


 </form>



</html>