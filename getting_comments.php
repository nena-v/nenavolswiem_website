<?php

function nettoyer($x){
    if($x){
	$x=trim($x);
	$x=stripslashes($x);
	$x=htmlspecialchars($x);
    }
    return $x;
}

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

//Récupération des données.
$data = $db->query('SELECT pseudo, comment_txt, DATE_FORMAT(date, \'%d/%m/%Y - %Hh%imin%ss\') AS date_fr FROM comments_tb ORDER BY date DESC');

//Les données sont intégrées dans un tableau. L'argument "PDO::FETCH_ASSOC" permet de n'avoir que des clés textuelles dans le tableau (les index ne sont pas récupérés).
$data_arr = $data->fetchAll(PDO::FETCH_ASSOC);

$data->closeCursor();

//Nettoyage des données.
for($i = 0; $i < sizeof($data_arr); $i++)
{
    foreach($data_arr[$i] as $key => $elt)
    {
        $data_arr[$i][$key] = nettoyer($elt);
    }
}

//Les données sont envoyées après avoir été converties en JSON.
echo json_encode($data_arr);

?>
