<?php

//empty() permet de déterminer si une variable est vide, cad, pour ce qui nous concerne, s'il s'agit d'une chaîne vide ou si elle n'existe pas
if(!empty($_POST['pseudo']) && !empty($_POST['comment_txt']))
{
    //Connexion à la BDD via PDO (PHP Data Objects), extension permettant la connexion à une base de données
    try
    {
        $db = new PDO('mysql:host=localhost;dbname=nenajqpn_comments;charset=utf8', 'nenajqpn_comments_user', 'bbZQ?F1g^NK./0oL!G');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(Exception $Err)
    {
        die('Error : ' . $Err->getMessage());
    }

//La méthode "prepare" permet de préparer la requête, les points d'interrogation étant substitués par des variables par la méthode "execute".
$ins = $db->prepare('INSERT INTO comments_tb(pseudo, comment_txt, date) VALUES(?, ?, NOW())');
$ins->execute(array($_POST['pseudo'],$_POST['comment_txt']));
}

?>
