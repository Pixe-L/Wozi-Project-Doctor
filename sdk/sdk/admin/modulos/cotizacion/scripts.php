<?php
$scripts .='
$(function(){

	$(".nivel").click(function(){
		var id = $(this).data("id");
		var nivel = $(this).html();
		switch(nivel) {
			case "1":
				nivel=2;
				$(this).removeClass("uk-button-white");
				$(this).addClass("uk-button-primary");
				$(this).html(nivel);
				break;
			case "2":
				nivel=3;
				$(this).removeClass("uk-button-primary");
				$(this).addClass("uk-button-warning");
				$(this).html(nivel);
				break;
			case "3":
				nivel=4;
				$(this).removeClass("uk-button-warning");
				$(this).addClass("uk-button-success");
				$(this).html(nivel);
				break;
			default:
				nivel=1;
				$(this).removeClass("uk-button-success");
				$(this).html(nivel);
				break;
		}
		$.ajax({
			method: "POST",
			url: "modulos/cotizacion/acciones.php",
			data: { 
				nivelestatus: nivel,
				id: id 
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
		});
		console.log(nivel+\' - \'+id);
	});

	$(".archivo").click(function(){
		var id = $(this).attr("data-id");
		var archivo = $(this).attr("data-archivo");
		switch(archivo) {
			case \'0\':
				archivo=1;
				$(this).attr(\'data-archivo\',archivo);
				$(this).html(\'<i uk-icon="folder"></i>\');
				break;
			case \'1\':
				archivo=0;
				$(this).html(\'<i uk-icon="folder"></i>\');
				$(this).attr(\'data-archivo\',archivo);
				break;
		}
		$(\'#tr\'+id).fadeOut( "slow" );
		$.ajax({
			method: "POST",
			url: "modulos/cotizacion/acciones.php",
			data: { 
				archivo: archivo,
				id: id
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
		});
	});
	
	$(".guia").keypress(function(e) {
		if(e.which == 13) {
			var id = $(this).data("id");
			var guia = $(this).val();
			$.ajax({
				method: "POST",
				url: "modulos/cotizacion/acciones.php",
				data: { 
					ajaxsend: 1,
					sendType: 3,
					guia: guia,
					id: id
				}
			})
			.done(function( msg ) {
				UIkit.notification.closeAll();
			UIkit.notification(msg);
				$(this).addClass("uk-form-success");
			});
		}
	});

	// Envío de correo
	// Asignar id a todos los botones
	$(".send").click(function(){
		var id = $(this).data("id");
		$(".enviarcorreo").attr("data-id",id);
	});
	// envío de correos
	$(".enviarcorreo").click(function(){
		var id = $(this).attr("data-id");
		UIkit.notification("<div class=\'uk-text-center padding-10 text-lg color-white bg-primary\'>Procesando...</span>");
		$.ajax({
			method: "POST",
			url: "../includes/acciones.php",
			data: { 
				enviarcorreoadmin: 2,
				id: id
			}
		})
		.done(function( response ) {
			console.log( response );
			datos = JSON.parse( response );
			UIkit.notification.closeAll();
			UIkit.notification(datos.msj);
		});
	});

})





// Activamos la selección de fecha UI
$(function() {
	$( ".fecha" ).datepicker({ dateFormat: \'yy-mm-dd\' });
});

// Eliminar definitivamente
function eliminarCotizacion (){ 
	var statusConfirm = confirm("¿Eliminar esto permanentemente?"); 
	if (statusConfirm == true) 
	{ 
		window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&cotizacion_borrar=1&id="+id)
	} 
} 

// Eliminar definitivamente
function eliminarCliente (){ 
	var statusConfirm = confirm("¿Eliminar esto permanentemente?"); 
	if (statusConfirm == true) 
	{ 
		window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&clientes_borrar=1&id="+id)
	} 
} 




';

