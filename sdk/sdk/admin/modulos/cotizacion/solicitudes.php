<?php
	$tableHeadEjecutivo=($univel==2)?'<th width="122px" onclick="sortTable(5)" class="uk-text-center pointer">Ejecutivo</th>':'';
	$archivo=0;
?>
<div uk-grid>
	<div class="uk-width-auto@m margin-top-20">
		<ul class="uk-breadcrumb">
			<?php 
			echo '
			<li><a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'">Cotizaciones</a></li>
			<li><a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'&archivo='.$archivo.'" class="color-red">Solicitudes</a></li>
			';
			?>
		</ul>
	</div>
	<div class="uk-width-expand@m margin-top-20 uk-text-right">
		<?php 
		echo '
			<a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'&archivo=solicitudarchivo" class="uk-button uk-button-white">
				<i uk-icon="icon:folder"></i> &nbsp; Solucitudes archivadas
			</a>';
		?>
	</div>
</div>


<div class="uk-width-1-1 padding-v-50">
	<table class="uk-table uk-table-hover uk-table-striped uk-table-middle uk-table-small" id="ordenar">
		<thead>
			<tr>
				<th width="20px" onclick="sortTable(0)" class="pointer">Id</th>
				<?=$tableHeadEjecutivo?>
				<th width="100px" onclick="sortTable(1)" class="uk-text-center pointer">Fecha</th>
				<th onclick="sortTable(2)" class="pointer">Cliente <?=$univel?></th>
				<th width="100px" onclick="sortTable(3)" class="uk-text-center pointer">Productos</th>
				<th width="10px"></th>
			</tr>
		</thead>
		<tbody>

		<?php 
		if ($univel==2) {
			$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE archivo = $archivo ORDER BY id DESC");
		}else{
			$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE archivo = $archivo AND ejecutivo = $uid ORDER BY id DESC");
		}
		while($row_CONSULTA = $CONSULTA -> fetch_assoc()){
			$thisid=$row_CONSULTA['id'];
			$clienteid=$row_CONSULTA['uid'];
			$ejecutivoId=$row_CONSULTA['ejecutivo'];
			$ejecutivoName='Asignar';
			$ejecutivoButton='white';
			$ejecutivoEstatus=0;
			if ($ejecutivoId>0) {
				$ConsultaEjecutivo = $CONEXION -> query("SELECT * FROM user WHERE id = $ejecutivoId");
				$numEjecutivos=$ConsultaEjecutivo->num_rows;
				if ($numEjecutivos>0) {
					$row_ConsultaEjecutivo = $ConsultaEjecutivo -> fetch_assoc();
					$ejecutivoName=$row_ConsultaEjecutivo['user'];
					$ejecutivoEstatus=1;
					$ejecutivoButton='primary';
				}
			}

			$tableBody=($univel==2)?'<br>'.$row_CONSULTA1['']:'';

			$CONSULTA1 = $CONEXION -> query("SELECT SUM(cantidad) AS cant FROM pedidosdetalle WHERE pedido = $thisid");
			$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
			$numProds=$row_CONSULTA1['cant'];

			// Clientes
			$CONSULTA1 = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $clienteid");
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
			<tr id="tr'.$row_CONSULTA['id'].'">
				<td>
					'.$row_CONSULTA['id'].'
				</td>';
			if ($univel==2) {
				echo '
				<td class="uk-text-center">
					<span class="uk-hidden">Asignado a:</span>
					<a href="#ejecutivomodal" uk-toggle class="ejecutivo uk-button uk-button-'.$ejecutivoButton.'" id="pedidoejecutivo'.$row_CONSULTA['id'].'" data-estatus="'.$ejecutivoEstatus.'" data-id="'.$row_CONSULTA['id'].'" data-ejecutivo="'.$ejecutivoId.'">'.$ejecutivoName.'</a>
				</td>';
			}
			echo '
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
				<td class="uk-text-nowrap">
					<button data-id="'.$row_CONSULTA['id'].'" class="eliminarpedido uk-icon-button uk-button-danger" uk-icon="icon:trash"></button> &nbsp;&nbsp;&nbsp;
					<button class="archivosolicitud uk-icon-button uk-button-white" data-id="'.$row_CONSULTA['id'].'" data-archivo="'.$row_CONSULTA['archivo'].'" uk-icon="icon:folder"></button> &nbsp;&nbsp;&nbsp;
					<a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=cfg-productos&clienteid='.$clienteid.'&solicitacotizacion='.$row_CONSULTA['id'].'" class="uk-icon-button uk-button-primary"><i class="fas fa-dollar-sign"></i></a> &nbsp;&nbsp;&nbsp;
					<a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=solicituddetalle&id='.$row_CONSULTA['id'].'" class="uk-icon-button uk-button-primary" uk-icon="search"></a>
				</td>
			</tr>';
		}
		?>

		</tbody>
	</table>
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
	// Eliminar pedido
	$(".eliminarpedido").click(function() {
		var statusConfirm = confirm("Realmente desea eliminar este pedido?");
		var id=$(this).attr("data-id");
		if (statusConfirm == true) { 
			window.location = ("index.php?rand='.rand(1,9999).'&modulo='.$modulo.'&archivo='.$archivo.'&borrarPedido&id="+id);
		} 
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
	});



	$(".archivosolicitud").click(function(){
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
				archivosolicitud: archivo,
				id: id
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
		});
	});

	';
?>