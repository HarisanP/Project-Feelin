<?php
session_start();
$bdd= new PDO('mysql:host=127.0.0.1;dbname=feelin_db', 'root', '');
if(isset($_SESSION['id']) AND !empty($_SESSION['id']))
{
    if(isset($_POST['btenvoi']))
    {
        if(isset($_POST['destinataire'],$_POST['message']) AND !empty($_POST['destinataire']) AND !empty($_POST['message']))
        {   
        
            $destinataire = htmlspecialchars($_POST['destinataire']);
            $message =  htmlspecialchars($_POST['message']);

            $req_id = $bdd->prepare('SELECT Id FROM users WHERE pseudo = ?');
            $req_id->execute(array($destinataire));
            $req_id = $req_id->fetch();
            //var_dump($req_id);
            $req_id = $req_id['Id'];
            //var_dump($req_id);

            $insert = $bdd->prepare('INSERT INTO messages(id_expediteur,id_destinataire,msg) VALUES(?,?,?)');
            $insert->execute(array($_SESSION['id'],$req_id,$message));
            $error = "message envoyé";

        }
        else
        {
            $error = "Veuillez compléter tous les champs!" ; 
        }
    }

}else 
{
        echo "variable session non existante";
}

$destinataire = $bdd->query('SELECT pseudo FROM users ORDER BY pseudo');

if(isset($_POST['btretourprofil']))
{
    header("Location: profil.php?id=".'"'.$_SESSION['id'].'"');
}

?>

<!DOCTYPE html>
<html>
<head>
    <title> Envoi de message </title>
</head>
<body>

<form method="POST">
<label> Destinataire: </label>
    <select name="destinataire">
    <?php while($d = $destinataire->fetch())  { ?>
        <option> <?= $d['pseudo'];?></option>
    <?php } ?>   
    </select>
    <br /><br />
    <textarea placeholder="votre message" name="message"></textarea><br />
    <input type="submit" name="btenvoi" value="Envoyer"/>
    <br /><br />
    <?php if(isset($error))
    {
        echo '<span style="color:red">'.$error.'</span><br /><br />';
    }
    ?>
    <input type = "submit" name="btretourprofil" value="Retour au profil"/>
</form>

</body>

</html>