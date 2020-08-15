jQuery(function($){
    
    /*** ANIMATION DU MENU ***/

    /* Animation du menu via un ajout de classe aux balises HTML concernées. */
    $('#menu_banner').click(function(){
	$(this).toggleClass("active");
	$('#menu_links').toggleClass("active");
    });

    /*** TRAITEMENT DES COMMENTAIRES ***/

    /* Fonction permettant de récupérer les commentaires. */
    function get_comments(){
	$.ajax({
	    url: 'getting_comments.php',
	    method: 'GET',
	    //type de données attendues du serveur : JSON
	    dataType: 'json',
	    timeout: 2000,
	    error: function(jqXHR, textStatus, errorThrown){
		$('#comments_errors_display').html("Les commentaires n'ont pas pu être récupérés.<br/>Rapport d'erreur : " + textStatus + ". Erreur HTTP : " + errorThrown + ".")
	    },
	    success: function(data){
		display_comments(data); //les commentaires sont affichés grâce à la fonction "display_comments()"
		$('#comments_errors_display').html("");
	    }
	});
    };

    /* Fonction permettant l'affichage des commentaires. Arg: données en format JSON. */
    function display_comments(commentsJson){
	$('#comments_sub').empty();
	for(var i = 0 ; i < commentsJson.length ; i++){
	    var cPs = commentsJson[i].pseudo;
	    var cTxt = commentsJson[i].comment_txt;
	    var cDate = commentsJson[i].date_fr;
	    $('#comments_sub').append("<div class=\"comment_block\"><p class=\"comments_p\">" + cTxt + "<br/><em class=\"comment_pseudo\">" + cPs + "</em> - " + cDate + "</p></div>"); //les " entourant les attributs sont échappés afin qu'ils soient pris en compte
	}
    };

    //les commentaires sont récupérées et affichées au chargement de la page
    get_comments();
    
    /* Lorsque l'utilisateur clique sur le bouton "Envoyer", les données sont transmises grâce à AJAX à 'saving_comments.php', qui l'enregistre en base de données. */
    $('#send_comment_btn').click(function(){
	//récupération des données entrées par l'utilisateur
	var pseudo = $('#pseudo').val(); 
	var comment_txt = $('#comment_txt').val();
	if(pseudo  && comment_txt){
	    $.ajax({
		url: 'saving_comments.php',
		method: 'POST',
		//données transmises via la méthode 'POST'
		data: {
		    pseudo: pseudo,
		    comment_txt: comment_txt
		},
		//temps (en ms) au delà duquel la requête sera considérée comme n'ayant pu aboutir
		timeout: 2000,
		//fonction appelée en cas d'erreur
		error: function(jqXHR, textStatus, errorThrown){
		    $('#comments_errors_form').html("Votre commentaire n'a pas pu être envoyé.<br/>Rapport d'erreur : " + textStatus + ". Erreur HTTP : " + errorThrown + ".");
		},
		//fonction appelée en cas de succès
		success: function(){
		    get_comments(); //récupération et affichage des commentaires
		    $('#comments_errors_form').html("");
		    $('#comment_txt').val("");
		}
	    });
	}
	else{
	    $('#comments_errors_form').html("Merci d'entrer un pseudo et un commentaire.");
	}
    });

    /*** STRUCTURE DU DOM EN JSON ***/

    /* Array permettant d'obtenir la représentation textuelle du type de noeud. */
    var nodeTypesDef = {
    1: "Node.ELEMENT_NODE",
    3: "Node.TEXT_NODE",
    7: "Node.PROCESSING_INSTRUCTION_NODE",
    8: "Node.COMMENT_NODE",
    9: "Node.DOCUMENT_NODE",
    10: "Node.DOCUMENT_TYPE_NODE",
    11: "Node.DOCUMENT_FRAGMENT_NODE"
    };

    /* Fonction parcourant de manière récursive les noeuds enfants de "parent" et agrémentant l'objet "obj" avec certaines de leurs propriétés. */ 
    function domToObject(parent, obj){
	var obj = {
	    nodeName: parent.nodeName,
	    nodeType: nodeTypesDef[parent.nodeType], //type de noeud
	    childNodesNumber: parent.childNodes.length //nombre de noeuds enfants
	};
	if(parent.childNodes.length){
	    obj.childNodes = [] //tableau comprenant les noeuds enfants
	    for(var i = 0 ; i < parent.childNodes.length ; i++){
		obj.childNodes[i] = domToObject(parent.childNodes[i], obj.childNodes);
	    }
	}
	return obj;
    };

    /* Fonction retournant la représentation en JSON de la structure du DOM du document. */
    function getDocDomToJson(){
	return JSON.stringify(domToObject(document, {}), null, 2);
    };

    /* En cas de clic sur "DOM to JSON" dans "index.php", les données retournées par getDocDomToJson() sont données en valeur de l'input caché du formulaire '#dom_to_json_form', qui est ensuite envoyé. */ 
    $('#dom_to_json').click(function(){
	var dom_json = getDocDomToJson();
	$('#dom_input').val(dom_json);
	$('#dom_to_json_form').submit();
    });

});

