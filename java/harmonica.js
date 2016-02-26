$(document).ready(function(){
		//.content außer dem ersten Element auswählen, verstecken und dem Elternelement (.beitrag) die Klasse .hide hinzufügen
		 $(".content").not(":first").hide().parent().addClass('hide');
	//}           
	//h1 unterhalb von Beitrag eine Klickfunktion hinzufügen
	$(".beitrag > h1").click(function(){
		//Wenn geklickt wurde dann...
		//das bisher angezeigte Element einfahren und dem Elternelement die Klasse .hide hinzufügen
			$(this).next().toggle(500, function() {
				// this = DOM element which has just finished being animated
				$(this ).parent().removeClass( "hide" );
			});
	}); 
});