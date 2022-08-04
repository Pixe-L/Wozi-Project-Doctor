<?php
	$CONSULTA = $CONEXION -> query("SELECT * FROM productostallaclasif WHERE id = $id");
	$rowCONSULTA = $CONSULTA -> fetch_assoc();
	$tipo=$rowCONSULTA['id'];
	$tipotxt=$rowCONSULTA['txt'];

// BREADCRUMB
	echo '
	<div class="uk-width-auto margin-top-20 uk-text-left">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Configuración</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=cfgtallaclasif">Tipos de talla</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=cfgtallas&id='.$id.'" class="color-red">'.$tipotxt.'</a></li>
		</ul>
	</div>';

// TABLA DE TALLAS
	echo '
		<div class="uk-width-1-1 margin-v-20">
			<div class="uk-container uk-container-xsmall">
	
				<div class="uk-margin uk-text-right">
					<a href="#add" uk-toggle class="uk-button uk-button-success"><i uk-icon="plus"></i> &nbsp; Nueva talla</a>
				</div>
	
				<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle uk-table-responsive">
					<thead>
						<tr>
							<th width="auto">Talla</th>
							<th width="10px">Productos</th>
							<th width="100px"></th>
						</tr>
					</thead>
					<tbody class="sortable" data-tabla="productostalla">';
					// Obtener tipos
					$sql="SELECT * FROM productostalla WHERE tipo = '$tipo' ORDER BY orden";
					//echo '<br>'.$sql;
					$CONSULTA = $CONEXION -> query($sql);
					while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
						$thisID=$rowCONSULTA['id'];

						$sql="SELECT DISTINCT producto FROM productosexistencias WHERE talla = '$thisID' AND estatus = 1";
						//echo '<br>'.$sql;
						$CONSULTA1 = $CONEXION -> query($sql);
						$numProds=$CONSULTA1->num_rows;

						echo '
						<tr id="'.$thisID.'">
							<td>
								<input class="editarajax uk-input uk-form-blank uk-form-small" type="text" data-tabla="productostalla" data-campo="txt" data-id="'.$thisID.'" value="'.$rowCONSULTA['txt'].'">
							</td>
							<td class="uk-text-nowrap uk-text-center@m">
								'.$numProds.'
							</td>
							<td class="uk-text-nowrap">
								<a href="#modaleliminaexistencias" uk-toggle data-id="'.$thisID.'" class="fichalink color-red" uk-icon="trash"></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="index.php?rand='.rand(1,1000).'&modulo=productos&archivo=tallas&id='.$thisID.'" class="uk-text-primary" uk-icon="search"></a>
							</td>
						</tr>';
					}
					echo '
					</tbody>
				</table>
			</div>
		</div>';

// AUXILIAR PARA LEER EL ID QUE SE DESEA EDITAR
	echo '
	<input type="hidden" id="fichaid">';

// VENTANAS MODALES 
	// NUEVO
		echo '
		<div id="add" uk-modal class="modal">
			<div class="uk-modal-dialog uk-modal-body">
				<button class="uk-modal-close-default" type="button" uk-close></button>
				<h4>Nueva talla</h4>
				<form action="index.php" method="get">
					<input type="hidden" name="nuevatalla" value="1">
					<input type="hidden" name="modulo" value="'.$modulo.'">
					<input type="hidden" name="archivo" value="'.$archivo.'">
					<input type="hidden" name="id" value="'.$id.'">
					<input type="hidden" name="tipo" value="'.$tipo.'">

					<div class="uk-margin ">
						<input type="text" name="txt" class="uk-input" required>
					</div>
					<div class="uk-margin uk-text-center">
						<a class="uk-button uk-button-white uk-modal-close uk-button-large">Cerrar</a>
						<button class="uk-button uk-button-primary uk-button-large">Agregar</button>
					</div>
				</form>
			</div>
		</div>';


// MODAL ELIMINA EXISTENCIAS
	echo '
	<div id="modaleliminaexistencias" uk-modal>
		<div class="uk-modal-dialog uk-modal-body bg-danger">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<div class="uk-margin uk-text-center color-white text-xxl">ATENCIÓN</div>
			<div class="uk-margin uk-text-center color-white text-xl">Se eliminarán las existencias</div>
			<div class="uk-margin uk-text-center">
				<button id="borrarexistencias" class="uk-button uk-button-white uk-button-large" tabindex="10">Eliminar</button>
				<a href="#" class="uk-button uk-button-primary uk-button-large uk-modal-close">Cancelar</a>
			</div>
		</div>
	</div>';


$scripts='
	// PONER ID AUXILIAR
		$(".fichalink").click(function(){
			var id = $(this).attr("data-id");
			$("#fichaid").val(id);
		})	

	// ELIMINAR
		$("#borrarexistencias").click(function(){
			var id = $("#fichaid").val();
			UIkit.modal.confirm("Esta acción no se puede deshacer").then(function() {
				$.ajax({
					method: "POST",
					url: "modulos/'.$modulo.'/acciones.php",
					data: { 
						eliminarexistencias: 1,
						tabla: "productostalla",
						campo: "talla",
						id: id
					}
				})
				.done(function( response ) {
					console.log( response );
					UIkit.notification.closeAll();
					datos = JSON.parse( response );
					UIkit.notification(datos.msj,{pos:"bottom-right"});
					if(datos.estatus==1){
						$("#"+id).fadeOut();
					}
				});
			}, function () {
				UIkit.notification(\'<div class="uk-text-center color-white bg-primary padding-10 text-lg">Cancelado</div>\',{pos:"bottom-right"});
			});
		});
	
	';










