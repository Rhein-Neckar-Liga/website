$(document).ready(function(){
		//.content au�er dem ersten Element ausw�hlen, verstecken und dem Elternelement (.beitrag) die Klasse .hide hinzuf�gen
		 $(".content").not(":first").hide().parent().addClass('hide');
	//}           
	//h1 unterhalb von Beitrag eine Klickfunktion hinzuf�gen
	$(".beitrag > h1").click(function(){
		//Wenn geklickt wurde dann...
		//das bisher angezeigte Element einfahren und dem Elternelement die Klasse .hide hinzuf�gen
			$(this).next().toggle(500, function() {
				// this = DOM element which has just finished being animated
				$(this ).parent().removeClass( "hide" );
			});
	}); 
});