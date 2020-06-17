<!DOCTYPE html>

<html lang="fr">

  <head>
    
    <meta charset="utf-8"/>
    <title>Unicode et UTF-8</title>

    <meta name="DC.Title" content="Unicode et UTF-8 : éclaircissements et application en Python"/>
    <meta name="DC.Creator" content="Victor Quemeneur"/>
    <meta name="DC.Subject" content="Unicode UTF-8 Python Python2 Python3"/>
    <meta name="DC.Description" content="Explications sur Unicode, UTF-8 et le traitement des chaînes de caractères par Python (Python2 et Python3)."/>
    <meta name="DC.Date" content="2020-04-18"/>
    <meta name="DC.Type" content="Text"/>
    <meta name="DC.Format" content="text/html"/>
    <meta name="DC.Identifier" content="https://github.com/nena-v/nenavolswiem.com"/>
    <meta name="DC.Language" content="fr"/>
    
    <script type="application/ld+json">
      {
      "@context": "http://schema.org/",
      "@type": "TechArticle",
      "headline": "Unicode et UTF-8 : éclaircissements et application en Python",
      "proficiencyLevel": "Beginner",
      "author": "Victor Quemeneur",
      "dateCreated": "2020-04-18",
      "datePublished": "2020-04-18",
      "dateModified": "2020-04-18",
      "description": "Explications sur Unicode, UTF-8 et le traitement des chaînes de caractères par Python",
      "inLanguage": "fr"
      }
    </script>
    
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="style.css" />
    
  </head>

  <body>

    <div id="main_wrapper">
      
      <nav>

    <div id="gradiant">
    <input type="checkbox" id="menu">
    <label id="website_title" for="menu" onclick="">NenaVolswiem&nbsp;*</label>
      
    <ul id="menu_links">
      <li><a href="../accueil.html">Accueil</a></li>
      <li><a href="../auteur.html">L'auteur</a></li>
      <li><a href="../contact.html">Contact&nbsp;*</a></li>
    </ul>
    </div>

    <div id="burger_menu">
      <div class="burger_line"></div>
      <div class="burger_line"></div>
      <div class="burger_line"></div>
    </div>
      
      </nav>

      
      <section>

    <div id="icon_up">
      <a href="#main_wrapper"><img id="icon_up_img" src="angle-circle-up-ok.png" alt="" /></a>
    </div>
      
    <h1>Unicode et UTF-8 : éclaircissements et application en Python</h1>

    <p>Cet article a pour objectif d'expliquer ce qu'est Unicode, les liens qu'il entretient avec UTF-8 et la manière dont tout cela se traduit en Python. Je ne reviens pas sur ce qu'est un encodage et l'historique des systèmes d'encodage : pour cela, n'hésitez pas à visiter <a class="colored_links" href="http://sdz.tdct.org/sdz/comprendre-les-encodages.html">cette page</a>, très complète et très claire.</p>

    <h2>Unicode, qu'est-ce que c'est ?</h2>

    <p>Unicode est un standard attribuant aux caractères de l'ensemble des langages utilisés dans le monde un identifiant composé d'un nombre et d'un nom. Ce nombre, appelé <em>code point</em>, est généralement écrit en hexadécimal et précédé de "U+" (ce préfixe n'a aucun autre objet que d'indiquer qu'il s'agit d'un code point Unicode).</p>

    <p>A titre d'exemple, la lettre "A" porte le code point U+0041, la lettre "k" le code point U+006B, le symbole Ѩ le code point U+0468.</p>
  
    <p>Le site <a class="colored_links" href="https://unicode-table.com/">unicode-table.com</a> recense l'ensemble des code points existants, correspondant à pas moins de 137 929 caractères !</p>

    <h2>Et UTF-8 ?</h2>

    <p>Pour enregistrer les caractères décrits dans la table Unicode sur un ordinateur, diverses techniques d'encodage sont décrites par le standard Unicode. Parmi elles figure <em>UTF-8</em> (Universal Character Set Transformation Format - 8 bits). Celle-ci consiste à coder les caractères sur 1 à 4 octets. Pour assurer une compatibilité avec ASCII, les caractères présents dans ASCII sont codés sur un octet, de la même manière qu'ils le sont en ASCII. Les caractères dont le point de code est supérieur à 127, non présents dans la table ASCII, se codent quant à eux sur 2 à 4 octets.</p>
      
    <p>L'encodage en mémoire s'effectue en attribuant à chaque caractère une valeur correspondant à leur point de code. Les 127 premiers caractères de la table sont codés sur 1 octet dont le bit de poids fort est nul. Les caractères au delà du 127ème sont, quant à eux, codés sur plusieurs octets. Les bits de poids fort du premier octet de la séquence correspondent à une suite de 1 dont le nombre est équivalent au nombre d'octets de la séquence, suivis d'un 0. Les octets suivants débutent par 10.</p>

    <p>Voici quelques exemples pour illustrer ce principe :</p>

      
    <table id="tb_correspondances_unicode">

      <caption>Exemples de correspondances entre le caractère, son point de code et sa représentation en UTF-8</caption>
    
      <thead>
        <tr>
          <th>Caractère</th>
          <th>Point de code (hexadécimal)</th>
          <th>Point de code (binaire)</th>
          <th>Codage UTF-8</th>
        </tr>
    </thead>

      <tbody>
        <tr>
          <td>A</td>
          <td>U+0041</td>
          <td>01000001</td>
          <td>01000001</td>
        </tr>
        <tr>
          <td>é</td>
          <td>U+00E9</td>
          <td>11101001</td>
          <td>11000011 10101001</td>
        </tr>
        <tr>
          <td>Ѩ</td>
          <td>U+0468</td>
          <td>00000100 01101000</td>
          <td>11010001 10101000</td>
        </tr>
        <tr>
          <td>𝄞</td>
          <td>U+1D11E</td>
          <td>00000001 11010001 00011110</td>
          <td>11110000 10011101 10000100 10011110</td>
        </tr>
      </tbody>

    </table>
      
    <p>UTF-8 est aujourd'hui le système d'encodage le plus utilisé. Il en existe toutefois d'autres. Ainsi, UTF-16 code les caractères sur 2 octets et UTF-32 sur 4 octets.</p>

    <h2>Le traitement des chaînes de caractères par Python.</h2>

    <p>La gestion des chaînes de caractères a évolué entre Python 2 et Python 3. Sous Python 2, il existe deux types de chaînes. La première est de type str, une <em>byte-string</em> qui, comme ce nom anglais l'indique, représente une séquence de bits (d'octets). Chaque élément d'une byte-string est ainsi interprété comme un octet. Une chaîne de type str est créée via la fonction str() ou, plus classiquement, la mise entre guillemets des caractères ("hello", 'hello').</p>

    <p>Le second type de chaîne sous Python 2 est appelée <em>unicode</em>. Les éléments que contient la chaîne unicode ne sont pas interprétés comme des bits isolés, mais comme une succession de "code-point" unicode. Une chaine de type unicode est créée via la fonction unicode() ou en ajoutant le préfixe u lors de la mise entre guillements (u"hello", u'hello').</p>

    <p>Sur une console dont l'encodage est l'utf-8, créons une variable contenant des caractères non ASCII :</p>

    <img src="elephant_python2.png" alt="Création d'une variable en Python2, contenant des caractères non ASCII" />

    <p>Dans ce premier exemple, nous utilisons le format str. Les caractères codés sur plus d'un octet sont affichés par l'interprète sous la forme de séquences d'échappement débutant par \x et représentant chacun un octet. Les éléments qui suivent correspondent à la valeur de l'octet, exprimée en hexadécimal. Ainsi, "é" est codé sur un octet dont la valeur vaut C316 et sur un octet dont la valeur vaut A916. Lorsque l'on convertit ces chiffres en binaire, nous obtenons bien : 11000011 10101001, qui correspond au codage UTF-8 de 11101001, correspondant lui-même au code point de "é" (U+00E9) (v. <a class="colored_links" href="#tb_correspondances_unicode">tableau ci-dessus</a>).

    <p>Python nous propose donc la représentation des bits du mot telle qu'elle est enregistrée en mémoire. Les caractères codés sur un octet sont affichés normalement, ceux codés sur plusieurs octets sont décomposés et l'affichage nous propose la valeur de chacun d'entre eux.</p>
    
    <p>Lorsque l'on interroge Python sur la longueur de la chaîne, il retourne le nombre d'octets que celle-ci contient. De même, si l'on itère la chaîne, les bits sont affichés un à un :</p>

    <img src="elephant_python2_acces.png" alt="Traitement d'une chaîne de type str par Python2" />

    <p>Le type unicode de Python 2 permet de faciliter le traitement des chaînes :</p>

    <img src="elephant_python2_u.png" alt="Traitement d'une chaîne de type unicode par Python2" />

    <p>Ici, nous remarquons que les caractères codé sur plus d'un octet sont également affichés sous la forme de séquences d'échappement débutant par \x. Mais cette fois, la valeur qui suit ne correspond pas à celle d'un octet, mais directement au "code-point" unicode du caractère (en l'occurence U+00E9) (v. <a class="colored_links" href="#tb_correspondances_unicode">tableau ci-dessus</a>). La longueur correspond bien à celle du mot et l'itération nous donne la valeur d'un caractère et non plus d'un bit.</p>

    <p>Pour information, les types str et unicode sont tous deux des sous-classe de la classe basestring.</p>

    <p>En Python 3, il n'existe plus qu'un type de chaîne, appelé str (ce qui peut porter à confusion), mais dont les éléments représentent des "code-point" unicode. Les séquences de bits sont désormais stockées dans un objet de type bytes, qui traite les chaines comme le faisait le type unicode de Python 2 :</p>

    <img src="elephant_python3.png" alt="Traitement d'une chaîne de type str par Python3" />

    <h2>Python lit-il vraiment de l'UTF-8 ?</h2>

    <p>Lorsque Pyhton traite des éléments encodés en UTF-8, il traite en réalité des éléments dont les longueur, en matière de bits, varient. Comment, dès lors, parvient-il à déterminer, que : </p>

    <pre>quoi[1]</pre>

    <p>correspond au caractère "l" du mot "éléphant" et non au contenu du second bit du mot (comme c'est le cas avec le type str de Python 2) ? C'est qu'en réalité, les types unicode (en Python 2) et str (en Python x3) ne traitent pas de l'UTF-8, mais un langage de taille fixe ("fixed-width").</p>

    <p>Lorsqu'il rencontre un objet de type str, Python détermine la valeur du plus haut "code-point" de la chaîne et partant, détermine l'encodage de longueur fixe qui permettra de stocker le texte en utilisant le moins de mémoire possible. L'encodage choisi sera : latin-1 (iso-8859 - codage sur 1 octet), UCS-2 (codage sur 2 octets), UCS-4 (codage sur 3 octets). Après conversion vers l'un de ces langages, la longueur de chaque caractère en mémoire est fixe, Python peut donc aisément itérer ou réaliser d'autres traitement sur le texte.</p>

    <div id="comments_main">

	<h2 id="comments_header"> Laissez un commentaire </h2>

	<form action="saving_comments.php" method="post">
	    <p>
		<label for="pseudo">Pseudo</label> : <br />
		<input type="text" name="pseudo" id="pseudo" maxlength="255"/> <br />
		<label for="comment_txt">Commentaire</label> : <br />
		<textarea name="comment_txt" id="comment_txt" rows="10" cols="60" maxlength="600"></textarea> <br />
		<input type="submit" value="Envoyer" />
	    </p>
	</form>

	<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	?>

	<div id="comments_sub">
	    <?php

	    //Connexion à la BDD via PDO (PHP Data Objects), extension permettant la connexion à une base de données
	    try
	    {
		$db = new PDO('mysql:host=localhost;dbname=comments_nena;charset=utf8', 'root', 'mizollen69', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	    }
	    catch(Exception $Err)
	    {
		die('Error : ' . $Err->getMessage());
	    }

	    //Récupération des données via la méthode query.
	    $data = $db->query('SELECT pseudo, comment_txt, DATE_FORMAT(date, \'%d/%m/%Y - %Hh%imin%ss\') AS date_fr FROM comments_tb ORDER BY date DESC');
	    while($entry = $data->fetch())
	    {
            ?>
		<div class="comment_block">
		    <p class="comments_p">
			<?php echo nl2br(htmlspecialchars($entry['comment_txt']));?><br/>
			<em class="comment_pseudo"><?php echo htmlspecialchars($entry['pseudo']);?></em> - <?php echo $entry['date_fr'];?>
		    </p>
	    </div>
	<?php
	}
	$data->closeCursor();
	?>
		
	</div>
    </div>

      </section>

      <footer>
    
    <ul class="footer_links">
      <li><a href="../mentions_legales.html">Mentions légales</a></li>
      <li><a href="../contact.html">Me contacter</a></li>
    </ul>

      </footer>

    </div>
    
  </body>

</html>

      
