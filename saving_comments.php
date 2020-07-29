<?php

//empty() permet de déterminer si une variable est vide, cad, pour ce qui nous concerne, s'il s'agit d'une chaîne vide ou si elle n'existe pas
if(!empty($_POST['pseudo']) && !empty($_POST['comment_txt']))
{
    //Connexion à la BDD via PDO (PHP Data Objects), extension permettant la connexion à une base de données
    try
    {
        $db = new PDO('mysql:host=localhost;dbname=comments;charset=utf8', 'root', 'mizollen69');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(Exception $Err)
    {
        die('Error : ' . $Err->getMessage());
    }

//La méthode "prepare" permet de préparer la requête, les points d'interrogation étant substitués par des variables par la méthode "execute".
$ins = $db->prepare('INSERT INTO comments_tb(pseudo, comment_txt, date) VALUES(?, ?, NOW())');
$ins->execute(array($_POST['pseudo'],$_POST['comment_txt']));

//Redirection vers index.php, au niveau du div dont l'id est "comments_main"
header('Location: index.php#comments_main');
}
elseif(empty($_POST['pseudo']) || empty($_POST['comment_txt']))
{
//Indication d'une erreur puis redirection vers index.php, au niveau du div dont l'id est "comments_main" (une alerte sur la page initiale pourra être mise en place en Javascript)
header('refresh:1;url=index.php#comments_main');
echo 'Merci d\'indiquer un pseudo et un commentaire - redirection en cours.';
}
else
{
//Indication d'une erreur puis redirection vers index.php, au niveau du div dont l'id est "comments_main"
header('refresh:1;url=index.php#comments_main');
echo 'Erreur lors de l\'envoi du commentaire - redirection en cours.';
}

?>
