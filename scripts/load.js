
/* Esto significa que el script se activa cuando la pagina se loadea*/
$(document).ready(function() {
	setTimeout(function() {
        $("#home").trigger('click');
	$(".triangle").toggleClass("selected");
    },1000);


	$(".clickable").click(function() { /* Esta funcion se ejecuta cuando se hace click en un li que tiene la clase clickable */
		
		if( !$(this).hasClass("selected") ){ /* Se ejecuta la accion si y solo si this NO tiene la clase selected*/

			var width = $(this).css("width");
			var widthInt= 0.5*parseInt(width.replace("px",""));
			var posx = $(this).offset().left;
			var posxInt= parseInt(posx);
			var pos = posxInt + widthInt -10;
			$(".triangle").offset({left: pos});
			//$(".triangle").animate({left: pos},500);
			


			$(this).toggleClass("selected"); /*Se le da la clase selected */
			$(".clickable").not(this).each( function(index) { /*A todos los demas que no son this*/
				if($(this).hasClass("selected")){ /* y que estan selected, */
					$(this).toggleClass("selected"); /*se les quita la clase selected*/
				}
			});	
			var page = $(this).attr("id"); /* Esta variable es un string que tiene el atributo id del elemento que se clickeo*/
			/*alert(page); *//*Este comando crea un popup, que muestra la variable page*/
		
			$("#centercontent").fadeOut('normal', function() { /* El div center se manda un fade out lento*/
				$("#centercontent").html(""); /* El contenido html del div center se hace nulo*/
				$("#centercontent").load("blocks/"+page+".php",' ', function(responde, status, xhr) { /*Loadea la pagina page.php y ejecuta el callback*/
					if (status == 'error') { /*Esto es el callback, sirve para dar un mensaje si hubo un error*/
					    var msg = "Lo lamento, hubo un error: ";
					    $("#centercontent").html(msg + xhr.status + " " + xhr.statusText);
					} 
											
	
				}).ready().fadeIn('normal', function() {
					$('#load').fadeOut('normal');
				});
			
			});
			$('#load').remove();
			$('#waiting').append("<img id=\"load\" src=\"images/loading.gif\" alt=\"Loading\" />");
			$('#load').fadeIn('normal');
		}
		
		
	});
	
	
			
});	

	
	
	
		
