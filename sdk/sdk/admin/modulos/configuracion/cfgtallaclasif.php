<?php
echo '
	<div class="uk-width-1-1 margin-top-20 uk-text-left">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Configuración</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=cfgtallaclasif" class="color-red">Tipos de talla</a></li>
		</ul>
	</div>

	<div class="uk-width-1-1 margin-v-20">
		<div class="uk-container uk-container-small">
			<div class="uk-card uk-card-default uk-card-body uk-border-rounded">
				
				<div class="uk-text-right uk-margin">
					<a href="#add" uk-toggle class="uk-button uk-button-success"><i uk-icon="plus"></i> &nbsp; Nuevo tipo de talla</a>
				</div>

				<div>
					<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle uk-table-responsive">
						<thead>
							<tr>
								<th >Tipo de talla</th>
								<th width="80px"></th>
							</tr>
						</thead>
						<tbody data-tabla="productosclasif">';
						// Obtener tipos
						$sql="SELECT * FROM productostallaclasif ORDER BY txt";
						$CONSULTA = $CONEXION -> query($sql);
						while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
							$thisID=$rowCONSULTA['id'];

							$sql="SELECT * FROM productostalla WHERE tipo = '$thisID'";
							$CONSULTA1 = $CONEXION -> query($sql);
							$numTallas=$CONSULTA1->num_rows;

							$buttonBorrar=($numTallas>0)?'
							<span uk-tooltip="Elimine su inicio" class="uk-text-mutted" uk-icon="trash"></span>':'
							<a href="javascript:eliminargeneral('.$thisID.',\'productostallaclasif\')" class="borrar color-red" uk-icon="trash"></a>';

							echo '
							<tr id="row'.$thisID.'">
								<td class="uk-text-left">
									<input class="editarajax uk-input uk-form-small uk-form-blank" type="text" data-tabla="productostallaclasif" data-campo="txt" data-id="'.$rowCONSULTA['id'].'" value="'.$rowCONSULTA['txt'].'" tabindex="8">
								</td>
								<td class="uk-text-nowrap">
									'.$buttonBorrar.'
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=cfgtallas&id='.$thisID.'" class="uk-text-primary" uk-icon="search"></a>
								</td>
							</tr>';
						}

						echo '
						</tbody>
					</table>';
					if (!isset($thisID)) {
						echo '
						<tr>
							<td colspan="2">
								<div class="uk-alert uk-alert-danger">
									No hay tipos de talla definidos
								</div>
							</td>
						</tr>';
					}
				echo '
				</div>
			</div>
		</div>
	</div><!-- end contenedor -->';


// VENTANAS MODALES
	echo '
		<div id="add" uk-modal class="modal">
			<div class="uk-modal-dialog uk-modal-body">
				<button class="uk-modal-close-default" type="button" uk-close></button>
				<h4>Nuevo tipo de talla</h4>
				<form action="index.php" method="post">
					<input type="hidden" name="nuevtipodetalla" value="1">
					<input type="hidden" name="modulo" value="'.$modulo.'">
					<input type="hidden" name="archivo" value="'.$archivo.'">

					<div uk-grid class="uk-grid-collapse">
						<div class="uk-width-1-1">
							<input type="text" name="txt" class="uk-input" placeholder="Nuevo tipo de talla" required><br><br>
						</div>
						<div class="uk-width-1-1 uk-text-center">
							<a href="#" class="uk-button uk-button-white uk-button-large uk-modal-close">Cancelar</a>
							<button class="uk-button uk-button-primary uk-button-large" type="submit" tabindex="10">Agregar</button>
						</div>
					</div>
				</form>
			</div>
		</div>


		';


$scripts='
	// Elimina general
	function eliminargeneral (id,tabla) { 
		UIkit.modal.confirm("Realmente desea borrar esto?").then(function() {
			$.ajax({
				method: "POST",
				url: "modulos/'.$modulo.'/acciones.php",
				data: { 
					eliminargeneral: 1,
					id: id,
					tabla: tabla
				}
			})
			.done(function( response ) {
				console.log( response );
				UIkit.notification.closeAll();
				datos = JSON.parse( response );
				UIkit.notification(datos.msj,{pos:"bottom-right"});
				if(datos.estatus==1){
					$("#row"+id).fadeOut();
				}
			});
		}, function () {
			console.log("Rechazado")
		});
	}

	';










