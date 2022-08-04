<?php
	$tableHeadEjecutivo=($univel==2)?'<th width="122px" onclick="sortTable(5)" class="uk-text-center pointer">Ejecutivo</th>':'';
?>

<div class="uk-width-1-1 margin-top-20 uk-text-left">
	<ul class="uk-breadcrumb">
		<?php 
		echo '
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'" class="color-red">Cotizaciones</a></li>
		';
		?>
	</ul>
</div>

<div class="uk-width-1-1">
	<table class="uk-table uk-table-hover uk-table-striped uk-table-middle uk-table-small" id="ordenar">
		<thead>
			<tr>
				<th width="20px" onclick="sortTable(0)" class="pointer">Id</th>
				<th width="100px" onclick="sortTable(1)" class="uk-text-center pointer">Fecha</th>
				<th onclick="sortTable(2)" class="pointer">Cliente</th>
				<th width="100px" onclick="sortTable(3)" class="uk-text-center pointer">Productos</th>
				<th width="100px" onclick="sortTable(4)" class="uk-text-center pointer">Importe</th>
				<?=$tableHeadEjecutivo?>
				<th width="70px" onclick="sortTable(6)" class="uk-text-center pointer">Estatus</th>
				<th width="135px;"></th>
			</tr>
		</thead>
		<tbody>

		<?php 
		if ($univel==2) {
			$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos ORDER BY id DESC");
		}else{
			$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE ejecutivo = $uid ORDER BY id DESC");
		}
		while($row_CONSULTA = $CONSULTA -> fetch_assoc()){
			$thisid=$row_CONSULTA['id'];
			$user=$row_CONSULTA['uid'];
			$ejecutivoId=$row_CONSULTA['ejecutivo'];
			$ejecutivoName='Asignar';
			$ejecutivoButton='white';
			$ejecutivoEstatus=0;
			if ($ejecutivoId>0) {
				$ConsultaEjecutivo = $CONEXION -> query("SELECT * FROM user WHERE id = $ejecutivoId");
				$row_ConsultaEjecutivo = $ConsultaEjecutivo -> fetch_assoc();
				$ejecutivoName=$row_ConsultaEjecutivo['user'];
				$ejecutivoEstatus=1;
				$ejecutivoButton='primary';
			}

			$tableBody=($univel==2)?'<br>'.$row_CONSULTA1['']:'';

			$CONSULTA1 = $CONEXION -> query("SELECT SUM(cantidad) AS cant FROM pedidosdetalle WHERE pedido = $thisid");
			$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
			$numProds=$row_CONSULTA1['cant'];

			$CONSULTA1 = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $user");
			$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();


			$segundos=strtotime($row_CONSULTA['fecha']);
			$fecha=date('d-m-Y',$segundos);

			$level=$row_CONSULTA['estatus']+1;

			switch ($level) {
				case 2:
					$clase='uk-button-primary';
					break;
				case 3:
					$clase='uk-button-warning';
					break;
				case 4:
					$clase='uk-button-success';
					break;
				default:
					$clase='uk-button-white';
					break;
			}


			$pagoFile  ='../img/contenido/comprobantes/'.$thisid.'.'.$row_CONSULTA['comprobante'];
			$pagoHTML  = (file_exists($pagoFile)) ? '<a href="'.$pagoFile.'" class="uk-button uk-button-small" target="_blank">Pago</a>':'';
			$printFile ='../img/contenido/print/'.$row_CONSULTA['imagen'];
			$printHTML = ($row_CONSULTA['imagen']!='' AND file_exists($printFile)) ? '<a href="'.$printFile.'" class="uk-button uk-button-small uk-button-primary" download>Print</a>':'';

			echo '
			<tr>
				<td>
					'.$row_CONSULTA['id'].'
				</td>
				<td class="uk-text-center">
					<span class="uk-hidden">'.$row_CONSULTA['fecha'].'</span>
					'.$fecha.'
				</td>
				<td>
					'.$row_CONSULTA1['nombre'].'<br>
					'.$row_CONSULTA1['email'].'
				</td>
				<td class="uk-text-center">
					<span class="uk-hidden">'.($numProds+1000000000).'</span>
					'.$numProds.'
				</td>
				<td class="uk-text-center">
					<span class="uk-hidden">'.($row_CONSULTA['importe']+1000000000).'</span>
					$'.number_format($row_CONSULTA['importe'],2).'
				</td>';
			if ($univel==2) {
				echo '
				<td class="uk-text-center">
					<span class="uk-hidden">'.$ejecutivoName.'</span>
					<a href="#ejecutivomodal" uk-toggle class="ejecutivo uk-button uk-button-'.$ejecutivoButton.'" id="pedidoejecutivo'.$row_CONSULTA['id'].'" data-estatus="'.$ejecutivoEstatus.'" data-id="'.$row_CONSULTA['id'].'" data-ejecutivo="'.$ejecutivoId.'">'.$ejecutivoName.'</a>
				</td>';
			}
			echo '
				<td class="uk-text-center">
					<span class="uk-hidden">'.$level.'</span>
					<button class="estatus '.$clase.' uk-icon-button text-gnrl" data-id="'.$row_CONSULTA['id'].'">'.$level.'</button> &nbsp;
				</td>
				<td class="">
					<a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=detalle&id='.$row_CONSULTA['id'].'" class="uk-icon-button uk-button-primary" uk-icon="search"></a>  &nbsp;
					<a href="#envios" uk-toggle class="send uk-icon-button uk-button-primary" data-id="'.$row_CONSULTA['id'].'"><i class="fa fa-envelope"></i></a> &nbsp;
					<button data-id="'.$row_CONSULTA['id'].'" class="eliminarpedido uk-icon-button uk-button-danger" uk-icon="icon:trash"></button>
				</td>
			</tr>';
		}
		?>

		</tbody>
	</table>
	<div class="uk-grid">
		<div class="uk-width-1-4">
			<button class="uk-button uk-button-white">1</button> Registrado
		</div>
		<div class="uk-width-1-4">
			<button class="uk-button uk-button-primary">2</button> Cotizado
		</div>
		<div class="uk-width-1-4">
			<button class="uk-button uk-button-warning">3</button> Pagado
		</div>
		<div class="uk-width-1-4">
			<button class="uk-button uk-button-success">4</button> Entregado
		</div>
	</div>
</div>



<div id="envios" uk-modal class="modal">
	<div class="uk-modal-dialog">
		<div class="uk-modal-header">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<h3>Envío de notificaciones</h3>
		</div>
		<div class="uk-modal-body">
			<div class="uk-width-1-1 uk-margin">
				<div class="uk-container" style="width:300px;">
					<div class="uk-width-1-1 uk-margin">
						<button data-id="0" data-enviarcorreo="2" class="enviarcorreo uk-width-1-1 uk-button uk-button-large uk-button-primary uk-margin">Enviar cotización</button>
					</div>
				</div>
			</div>
		</div>
		<div class="uk-modal-footer uk-text-center">
			<button class="uk-button uk-button-white uk-modal-close uk-button-large">Cerrar</button>
		</div>
	</div>
</div>



<div id="ejecutivomodal" uk-modal class="modal">
	<div class="uk-modal-dialog">
		<div class="uk-modal-header">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<h3>Asignar a ejecutivo</h3>
		</div>
		<div class="uk-modal-body uk-text-center">
		<?php
		$CONSULTA = $CONEXION -> query("SELECT * FROM user WHERE nivel = 1 ORDER BY user DESC");
		while($row_CONSULTA = $CONSULTA -> fetch_assoc()){
			echo '
			<div class="uk-width-1-1 uk-margin">
				<button id="ejecutivo'.$row_CONSULTA['id'].'" class="asignar uk-button uk-button-white" data-ejecutivo="'.$row_CONSULTA['id'].'" data-pedido="0">'.$row_CONSULTA['user'].'</button>
			</div>';
		}
		?>

		</div>
		<div class="uk-modal-footer uk-text-center">
			<button class="uk-button uk-button-white uk-modal-close uk-button-large">Cerrar</button>
		</div>
	</div>
</div>




<?php
$scripts='
$(function(){

	$(".estatus").click(function(){
		var id = $(this).data("id");
		var estatus = $(this).html();
		switch(estatus) {
			case "1":
				estatus=2;
				$(this).removeClass("uk-button-white");
				$(this).addClass("uk-button-primary");
				$(this).html(estatus);
				break;
			case "2":
				estatus=3;
				$(this).removeClass("uk-button-primary");
				$(this).addClass("uk-button-warning");
				$(this).html(estatus);
				break;
			case "3":
				estatus=4;
				$(this).removeClass("uk-button-warning");
				$(this).addClass("uk-button-success");
				$(this).html(estatus);
				break;
			default:
				estatus=1;
				$(this).removeClass("uk-button-success");
				$(this).html(estatus);
				break;
		}
		$.ajax({
			method: "POST",
			url: "modulos/'.$modulo.'/acciones.php",
			data: { 
				estatuschange: 1,
				estatus: (estatus-1),
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
				url: "modulos/'.$modulo.'/acciones.php",
				data: { 
					guia: guia,
					id: id
				}
			})
			.done(function( msg ) {
				UIkit.notification.closeAll();
				UIkit.notification(msg);
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
			var id = $(this).data("id");
			var enviarcorreo = $(this).attr("data-enviarcorreo");
			UIkit.notification("<div class=\'bg-primary color-white\'>Procesando...</span>");
			$.ajax({
				method: "POST",
				url: "modulos/'.$modulo.'/acciones.php",
				data: { 
					enviarcorreo: enviarcorreo,
					id: id
				}
			})
			.done(function( msg ) {
				UIkit.notification.closeAll();
				UIkit.notification(msg);
			});
		});

	// Asignar ejecutivo
		// Asignar los valores del pedido seleccionado a los botones de la modal
		$(".ejecutivo").click(function(){
			var pedido    = $(this).attr("data-id");
			var ejecutivo = $(this).attr("data-ejecutivo");
			var estatus   = $(this).attr("data-estatus");
			console.log(pedido+" - "+ejecutivo+" - "+estatus);

			$(".asignar").attr("data-pedido",pedido);
			$(".asignar").attr("data-estatus",0);
			$(".asignar").addClass("uk-button-white");
			$(".asignar").removeClass("uk-button-primary");
			$("#ejecutivo"+ejecutivo).attr("data-estatus",estatus);

			$("#ejecutivo"+ejecutivo).addClass("uk-button-primary");
			$("#ejecutivo"+ejecutivo).removeClass("uk-button-white");
		});

		// Asignar pedido al ejecutivo seleccionado en la modal
		$(".asignar").click(function(){
			var pedido = $(this).attr("data-pedido");
			var ejecutivo = $(this).attr("data-ejecutivo");
			var estatus = $(this).attr("data-estatus");
			var ejecutivoName="Asignar";

			UIkit.modal("#ejecutivomodal").hide();

			console.log(pedido+" - "+ejecutivo+" - "+estatus);

			if(estatus==0){
				$(this).addClass("uk-button-primary");
				$(this).removeClass("uk-button-white");
				ejecutivoName=$(this).text();
				$("#pedidoejecutivo"+pedido).addClass("uk-button-primary");
				$("#pedidoejecutivo"+pedido).removeClass("uk-button-white");
				$("#pedidoejecutivo"+pedido).attr("data-estatus",1);
				$("#pedidoejecutivo"+pedido).attr("data-ejecutivo",ejecutivo);
			}else{
				ejecutivo=0;
				$(this).removeClass("uk-button-primary");
				$(this).addClass("uk-button-white");
				$("#pedidoejecutivo"+pedido).removeClass("uk-button-primary");
				$("#pedidoejecutivo"+pedido).addClass("uk-button-white");
				$("#pedidoejecutivo"+pedido).attr("data-estatus",0);
				$("#pedidoejecutivo"+pedido).attr("data-ejecutivo",ejecutivo);
			}

			$("#pedidoejecutivo"+pedido).text(ejecutivoName);

			$.ajax({
				method: "POST",
				url: "modulos/varios/acciones.php",
				data: { 
					editarajax: 1,
					id: pedido,
					tabla: "pedidos",
					campo: "ejecutivo",
					valor: ejecutivo
				}
			}).done(function( msg ) {
				UIkit.notification.closeAll();
				UIkit.notification(msg);
			});
		});
})
';
?>