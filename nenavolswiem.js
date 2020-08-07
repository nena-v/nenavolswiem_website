jQuery(function($){

    /*** ANIMATION DU MENU ***/

    /* Animation du menu via un ajout de classe aux balises HTML concernés. */
    $('#menu_banner').click(function(){
	$(this).toggleClass("active");
	$('#menu_links').toggleClass("active");
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
	    obj.childNodes = [] //array comprenant les noeuds enfants
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

