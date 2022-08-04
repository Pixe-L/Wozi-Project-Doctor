// Chosen
	var config = {
		".chosen-select": {disable_search_threshold:10,width:"100%",no_results_text:"¡Nada encontrado!"}
	}
	for (var selector in config) {
		$(selector).chosen(config[selector]);
	}
	
// Editor ajax
	$(".editarajax").change(function(e) {
		var id = $(this).attr("data-id");
		var tabla = $(this).attr("data-tabla");
		var campo = $(this).attr("data-campo");
		var valor = $(this).val();

		$.ajax({
			method: "POST",
			url: "modulos/varios/acciones.php",
			data: { 
				editarajax: 1,
				id: id,
				tabla: tabla,
				campo: campo,
				valor: valor
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg,{pos:'bottom-right'});
		});
	});

// Relacionar con ajax
	$(".relajax").click(function() {
		var id      = $(this).attr("data-id");
		var tabla   = $(this).attr("data-tabla");
		var valor   = $(this).attr("data-valor");
		var estatus = $(this).attr("data-estatus");
		console.log(tabla+" - "+id+" - "+valor+" - "+estatus);

		if(estatus==1) {
			estatus=0;
			$(this).addClass("fa-toggle-off");
			$(this).addClass("uk-text-muted");
			$(this).removeClass("fa-toggle-on");
			$(this).removeClass("uk-text-primary");
		}else{
			estatus=1;
			$(this).addClass("fa-toggle-on");
			$(this).addClass("uk-text-primary");
			$(this).removeClass("fa-toggle-off");
			$(this).removeClass("uk-text-muted");
		}
		$(this).attr("data-estatus",estatus);

		$.ajax({
			method: "POST",
			url: "modulos/varios/acciones.php",
			data: { 
				relajax: 1,
				id: id,
				tabla: tabla,
				valor: valor
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg,{pos:'bottom-right'});
		});
	});

// Selector ajax
	$(".selector").change(function() {
		var datos = $(this).data();
		var valor = $(this).val();
		$.ajax({
			method: "POST",
			url: "modulos/varios/acciones.php",
			data: { 
				editarajax: 1,
				id: datos.id,
				tabla: datos.tabla,
				campo: datos.campo,
				valor: valor
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg,{pos:'bottom-right'});
		});
	});

// Comprobar descuentos
	$(".descuento").change(function(e) {
		var valor = $(this).val();
		if(valor>100 || valor<0){
			$(this).val(0);
			alert("El descuento no es válido");
		}
	});

// Remover autocompletar
	$("input").attr("autocomplete","off");

// Campos numéricos
	$(".input-number").keypress("keypress", function (e) {
		var keyCode = e.which ? e.which : e.keyCode
		if (!(keyCode >= 48 && keyCode <= 57)) {
			if (keyCode!=46) {
				e.preventDefault();
			}
		}
	});	

// Campo UserName
	$(".username").keyup(function(e) {
		var novalidos = [" ","´","á","é","í","ó","ú","`","à","è","ì","ò","ù"];
		novalidos.forEach(usernamevalidate);
	});
	function usernamevalidate(item, index) {
		var str = $(".username").val();
		str=str.toLowerCase();
		if (str.indexOf(item) != -1) {
			str=str.replace(item,"");
			var msg = '<div class="uk-text-center bg-grey padding-10 text-lg"><i uk-icon="icon:warning;ratio:2;"></i> &nbsp; caracter no permitido</div>';
			UIkit.notification.closeAll();
			UIkit.notification(msg,{pos:'bottom-right'});
		}
		$(".username").val(str);
	}

	$(".editarusername").keyup(function(e) {
		var novalidos = [" ","´","á","é","í","ó","ú","`","à","è","ì","ò","ù"];
		novalidos.forEach(editarusernamevalidate);
	});
	function editarusernamevalidate(item, index) {
		var str = $(".editarusername").val();
		str=str.toLowerCase();
		if (str.indexOf(item) != -1) {
			str=str.replace(item,"");
			var msg = '<div class="uk-text-center bg-grey padding-10 text-lg"><i uk-icon="icon:warning;ratio:2;"></i> &nbsp; caracter no permitido</div>';
			UIkit.notification.closeAll();
			UIkit.notification(msg,{pos:'bottom-right'});
		}
		$(".editarusername").val(str);
	}

// Eliminar una fila de la base de datos
	$(".elimina-single").click(function() {
		var id=$(this).attr("data-id");
		var tabla=$(this).attr("data-tabla");
		UIkit.modal.confirm("Desea eliminar esto?").then(function() {
			$.ajax({
				method: "POST",
				url: "modulos/varios/acciones.php",
				data: {
					eliminafila: 1,
					tabla: tabla,
					id: id
				}
			})
			.done(function( msg ) {
				UIkit.notification.closeAll();
				UIkit.notification(msg,{pos:'bottom-right'});
			});
		});
	});

// Cambiar estatus
	$(".estatuschange").click(function(){
		var tabla = $(this).attr("data-tabla");
		var campo = $(this).attr("data-campo");
		var id = $(this).attr("data-id");
		var valor = $(this).attr("data-valor");

		if(valor==1) {
			valor=0;
			$(this).addClass("fa-toggle-off");
			$(this).addClass("uk-text-muted");
			$(this).removeClass("fa-toggle-on");
			$(this).removeClass("uk-text-primary");
		}else{
			valor=1;
			$(this).addClass("fa-toggle-on");
			$(this).addClass("uk-text-primary");
			$(this).removeClass("fa-toggle-off");
			$(this).removeClass("uk-text-muted");
		}

		$(this).attr("data-valor",valor);

		$.ajax({
			method: "POST",
			url: "modulos/varios/acciones.php",
			data: {
				editarajax: 1,
				tabla: tabla,
				id: id,
				campo: campo,
				valor: valor
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg,{pos:'bottom-right'});
		});
	});

// Activar todo
	$(".changeall").click(function() {
		var tabla=$(this).attr("data-tabla");
		var campo=$(this).attr("data-campo");
		var valor=$(this).attr("data-valor");
		$.ajax({
			method: "POST",
			url: "modulos/varios/acciones.php",
			data: { 
				changeall: 1,
				tabla: tabla,
				campo: campo,
				valor: valor
			}
		})
		.done(function( msg ) {
			if(valor==1) {
				$(".fa-toggle-off").addClass("uk-text-primary");
				$(".fa-toggle-off").addClass("fa-toggle-on");
				$(".fa-toggle-off").removeClass("fa-toggle-off");
				$(".fa-toggle-on").attr("data-valor",valor);
				$(".apagado").removeClass("uk-text-primary");
				$(".apagado").removeClass("fa-toggle-on");
				$(".apagado").addClass("fa-toggle-off");
				$(".apagado").attr("data-valor",0);
			}else{
				$(".fa-toggle-on").addClass("fa-toggle-off");
				$(".fa-toggle-on").removeClass("uk-text-primary");
				$(".fa-toggle-on").removeClass("fa-toggle-on");
				$(".fa-toggle-off").attr("data-valor",valor);
				$(".encendido").addClass("uk-text-primary");
				$(".encendido").removeClass("fa-toggle-off");
				$(".encendido").addClass("fa-toggle-on");
				$(".encendido").attr("data-valor",1);
			}
			UIkit.notification.closeAll();
			UIkit.notification(msg,{pos:'bottom-right'});
		});
	});

// Enfocar la primer campo de una modal
	$('.modal').on('shown', function () {
		$('.modal  input:visible:first').focus();
	});

// Contraseñas
	$('.password-revelar').click(function(){
		$('.pass').attr('type','text');
		$('.password-revelar').addClass('uk-hidden');
		$('.password-ocultar').removeClass('uk-hidden');
	});
	$('.password-ocultar').click(function(){
		$('.pass').attr('type','password');
		$('.password-ocultar').addClass('uk-hidden');
		$('.password-revelar').removeClass('uk-hidden');
	});

// Ordenar arrastrando
	$(".sortable").sortable({
		update: function( event, ui ) {
			var tabla = $(this).attr("data-tabla");
			var orden = $(this).sortable( "toArray");
			$.ajax({
				method: "POST",
				url: "modulos/varios/acciones.php",
				data: { 
					orderanarjax: 1,
					tabla: tabla,
					orden: orden
				}
			})
			.done(function(msg) {
				UIkit.notification.closeAll();
				UIkit.notification(msg,{pos:'bottom-right'});
			});
		}
	});

// Editor de texto
	tinymce.init({
		selector: '.editor',
		height: 300,
		heme: 'modern',
		plugins: [
			'advlist autolink lists link image charmap print preview anchor wordcount',
			'searchreplace visualblocks code fullscreen table visualblocks',
			'insertdatetime media table contextmenu paste code imagetools',
			'textcolor colorpicker'
		],
		toolbar: 'forecolor backcolor | insert table | undo redo | removeformat styleselect |  bold italic underline |  alignleft aligncenter alignright alignjustify |  bullist numlist | outdent indent | link image | code visualblocks',
		content_css: '//www.tinymce.com/css/codepen.min.css',
		color_picker_callback: function(callback, value) {
			callback('#00a7d9');
			callback('#05af06');
			callback('#f5e42b');
		}
	});

// Ordenar tabla
	function sortTable(n) {
	  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
	  table = document.getElementById("ordenar");
	  switching = true;
	  // Set the sorting direction to ascending:
	  dir = "asc"; 
	  /* Make a loop that will continue until
	  no switching has been done: */
	  while (switching) {
	    // Start by saying: no switching is done:
	    switching = false;
	    rows = table.getElementsByTagName("TR");
	    /* Loop through all table rows (except the
	    first, which contains table headers): */
	    for (i = 1; i < (rows.length - 1); i++) {
	      // Start by saying there should be no switching:
	      shouldSwitch = false;
	      /* Get the two elements you want to compare,
	      one from current row and one from the next: */
	      x = rows[i].getElementsByTagName("TD")[n];
	      y = rows[i + 1].getElementsByTagName("TD")[n];
	      /* Check if the two rows should switch place,
	      based on the direction, asc or desc: */
	      if (dir == "asc") {
	        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
	          // If so, mark as a switch and break the loop:
	          shouldSwitch= true;
	          break;
	        }
	      } else if (dir == "desc") {
	        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
	          // If so, mark as a switch and break the loop:
	          shouldSwitch= true;
	          break;
	        }
	      }
	    }
	    if (shouldSwitch) {
	      /* If a switch has been marked, make the switch
	      and mark that a switch has been done: */
	      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
	      switching = true;
	      // Each time a switch is done, increase this count by 1:
	      switchcount ++; 
	    } else {
	      /* If no switching has been done AND the direction is "asc",
	      set the direction to "desc" and run the while loop again. */
	      if (switchcount == 0 && dir == "asc") {
	        dir = "desc";
	        switching = true;
	      }
	    }
	  }
	}

	$("th.pointer").click(function(){
		$("th.pointer").children().addClass("uk-hidden");
		$(this).children().removeClass("uk-hidden");
	})






