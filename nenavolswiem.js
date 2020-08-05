jQuery(function($){

    var mediaQ = window.matchMedia('(min-width: 480px)');

    function resizing(e){
	if($('#menu_links').css('display') != "none"){
	  //la condition du media query est vérifiée
	    if(e.matches){
		$('#menu_links').css({
		    "display": "flex",
		    "flex-direction": "row",
		    "justify-content": "space-around"
		});
	    }
	    else{
		$('#menu_links').css({
		    "display": "block",
		    "flex-direction": "",
		    "justify-content": ""
		});
	    }
	}
    };

    mediaQ.addListener(resizing);

    $('#menu_banner').click(function(){
	$('#menu_links').slideToggle({
	    duration: "fast",
	    start: function(){
		if(mediaQ.matches){
		    $(this).css({
		    "display": "flex",
		    "flex-direction": "row",
		    "justify-content": "space-around"
		    });
		}
		else{
		    $(this).css({
		    "display": "block",
		    "flex-direction": "",
		    "justify-content": ""
		    });
		}
	    }
	});
    });

});

for (var i = 0; i < document.childNodes.length; i++) {
    console.log(document.childNodes[i]);
}

