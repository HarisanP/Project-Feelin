<!DOCTYPE html>

<?php
session_start();

if (isset($_SESSION['id']))
{
    $bdd= new PDO('mysql:host=127.0.0.1;dbname=feelin_db', 'root', ''); 
    $requser = $bdd->prepare("SELECT * FROM users WHERE Id = ?");
    $requser->execute(array($_SESSION['id']));
    $userinfo = $requser->fetch();
    

    if (isset($_POST['btModification']))
    {
        if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND isset($_POST['newmail']) AND !empty($_POST['newmail'])AND isset($_POST['newnom']) AND !empty($_POST['newnom']) AND isset($_POST['newpassword']) AND isset($_POST['newpassword1']) )
        {    
            if(empty($_POST['newpassword'] OR $_POST['newpassword1']))
            {
              
                 $newpseudo = htmlspecialchars($_POST['newpseudo']);
                    $newmail = htmlspecialchars($_POST['newmail']);
                    $newnom = htmlspecialchars($_POST['newnom']);
                    

                    $reqedit = $bdd->prepare("UPDATE users SET pseudo=?,nom=?,mail=?  WHERE Id=? ");
                    $reqedit->execute(array($newpseudo,$newnom,$newmail,$_SESSION['id']));

                    //header("Location:profil.php?id=".$_SESSION['id']);

            }  

           else if($_POST['newpassword'] == $_POST['newpassword1'])

            {        
                    $newpseudo = htmlspecialchars($_POST['newpseudo']);
                    $newmail = htmlspecialchars($_POST['newmail']);
                    $newnom = htmlspecialchars($_POST['newnom']);
                    $newpassword = sha1($_POST['newpassword']);

                    $reqedit = $bdd->prepare("UPDATE users SET pseudo=?,nom=?,mail=?,motdepasse=?  WHERE Id=? ");
                    $reqedit->execute(array($newpseudo,$newnom,$newmail,$newpassword,$_SESSION['id']));

                   // header("Location:profil.php?id=".$_SESSION['id']);

                }
            else
            {
                $erreur = "veuillez vérifier l'intégrité des mots de passe entrés";
            }

        } 

        else
        {
                    $erreur = "veuillez remplir tous les champs";

        }  
        
      
            if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name']))
            {
                
                $tailleMax = 2097152; // en octets --> 2 Mo
                $extensionsValides = array('jpg','jpeg','gif','png');

                if($_FILES['avatar']['size'] <= $tailleMax)
                {
                    $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'],'.'), 1)); // Pour vérifier si l'extension du fichier est bon ou pas.

                    if(in_array($extensionUpload,$extensionsValides))
                    {   
                        $chemin = "users/avatars/".$_SESSION['id'].'.'.$extensionUpload;
                        $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                        if($resultat)
                        {
                        $updateavatar = $bdd->prepare("UPDATE users SET avatar = :avatar WHERE Id =:id");
                        $updateavatar->execute(array(
                            'avatar'=> $_SESSION['id'].".".$extensionUpload,
                            'id' => $_SESSION['id']
                        ));
                        
                        header("Location:profil.php?id=".$_SESSION['id']); 

                        }
                        else
                        {
                            echo "erreur durant l'importation de votre photo de profil";
                        }
                    }
                    else
                    {
                        echo " votre photo de profil ne respecte pas le format requis";
                    }
                }
                else
                {
                    echo "Votre image de profil ne doit pas exceder 2 Mo";
                }

            }

            else
            {
                header("Location:profil.php?id=".$_SESSION['id']); 
            }

    }

?>

<html>
    <div id="container" align="center">
       
        <h3>Edition profil</h3>
    
        <form action="" method="POST" enctype="multipart/form-data">
            <table>
            <tr>
                <td>
                    <label for=""> pseudo: </label>
                </td>
                <td>
                    <input type="text" name="newpseudo" value=<?php echo '"'.$userinfo['pseudo'].'"'; ?>>
                </td>
            </tr>
                <td>
                    <label for=""> mail: </label>
                </td>
                <td> 
                    <input type="email" name="newmail" value=<?php echo '"'.$userinfo['mail'].'"'; ?>>
                </td>
            <tr>
                <td>
                    <label for=""> nom: </label>
                </td>
                <td>
                    <input type="text" name="newnom" value=<?php echo '"'.$userinfo['nom'].'"'; ?>>
                </td>
            </tr>
            <tr>
                <td>
                    <label for=""> password: </label>
                </td>
                <td>
                    <input type="password" name="newpassword">
                </td>
            </tr>
            <tr>
                <td>
                    <label for=""> confirm password: </label>
                </td>
                <td>
                    <input type="password" name="newpassword1">
                </td>
            </tr>
            <tr>
                <td>
                    <label for=""> Avatar: </label>
                </td>
                <td>
                    <input type="file" name="avatar"> <br />
                </td>
            </tr> 

            <tr>
                <td> </td>
                <td>
                    <input type="submit" name="btModification" value="Mettre à jour profil et retour" />
                </td>
            </tr>
            <tr>
                <td>
                    
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

</html>

<?php
}

else
{
    header("Location:connexion.php");
}

?>