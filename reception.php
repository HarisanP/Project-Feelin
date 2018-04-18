<?php
session_start();
$bdd= new PDO('mysql:host=127.0.0.1;dbname=feelin_db', 'root', '');
if(isset($_SESSION['id']) AND !empty($_SESSION['id']))
{
    $msg = $bdd->prepare('SELECT * FROM messages WHERE id_destinataire = ?');
    $msg->execute(array($_SESSION['id']));

}
else 
{
        echo "variable session non existante";
}

$destinataire = $bdd->query('SELECT pseudo FROM users ORDER BY pseudo');

if(isset($_POST['btretourprofil']))
{
    header("Location:profil.php?id = ".'"'.$_SESSION['id'].'"');
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Boite de réception </title>
</head>
<body>
    <form method="POST">
        <table>
            <?php 
            while($m = $msg->fetch()) { ?>
            <tr>
                    <td>
                        De:
                     </td>
                    <td> 
                        <?php 
                            $pseudo_exp = $bdd->prepare('SELECT pseudo from users WHERE Id =?');
                            $pseudo_exp->execute(array($m['id_expediteur']));
                            $pseudo_exp = $pseudo_exp->fetch();
                            $pseudo_exp = $pseudo_exp['pseudo'];
                            echo $pseudo_exp;
                        ?>
                    
                    </td>
            </tr>
            <tr>
                <td>
                      Message : 
                </td>
                <td> 
                 <?php echo $m['msg']; ?>
                </td>
            </tr>
            <?php   } ?>

            <tr>
                <td>
                </td>
                <td>
                    <input type = "submit" name="btretourprofil" value="Retour profil"/>
                </td>
            </tr>

        </table>
    </form>
</body>

</html>