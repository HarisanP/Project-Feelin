<!DOCTYPE html>
<?php
session_start();

try
{
    $bdd= new PDO('mysql:host=127.0.0.1;dbname=feelin_db', 'root', '');

        /*if(isset($_GET['id']) AND $_GET['id']>0)
        {
                $getid= intval($_GET['id']);
                $requser = $bdd->prepare('SELECT * FROM users WHERE id = ?');
                $requser->execute(array($getid));

                $userinfo = $requser->fetch();
        }

        */
        if(isset($_SESSION['id']) AND $_SESSION['id']>0)
         {
                $getid= intval($_SESSION['id']);
                $requser = $bdd->prepare('SELECT * FROM users WHERE id = ?');
                $requser->execute(array($getid));

                $userinfo = $requser->fetch();

        }

}
catch(Exception $e)
{
    echo "catch IN";
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
 <div align="center" class="container">
 <table> 
    <tr>
            <td> <h3> Profil de </h3> </td> 
            <td> <?php  echo "<h3>".$userinfo['pseudo']."</h3>";?> </td> 
    </tr> </br></br>

    <tr>
            <td>  </td> 
            <td> <img src="users/avatars/<?php echo $userinfo['avatar']?>" width="150px "</td>
    </tr>
    <tr>
            <td> Nom: </td> 
            <td> <?php echo $userinfo['nom'];?></td> 
    </tr>
    <tr>
            <td> Mail: </td> 
            <td> <?php echo $userinfo['mail'];?></td> 
    </tr>

     <tr>
            <td> <a href="edition_profil.php"> Editer mon profil </a></td> 
    </tr>
    <tr>
            <td> <a href="envoi.php"> Envoyer un message </a></td> 
    </tr>
    <tr>
            <td> <a href="reception.php"> Boite de réception </a></td> 
    </tr>

    <tr>
            <td> <a href="deconnexion.php"> Déconnexion </a></td> 
    </tr>
    
</table>
 
 </div>

</body>
</html>