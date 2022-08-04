<?php
// BREADCRUMB
	echo '
	<div class="uk-width-auto">
		<div class="margin-top-20">
			<ul class="uk-breadcrumb">
				<li><a href="index.php?rand='.rand(1,2000).'&modulo='.$modulo.'" class="color-red">Calendario</a></li>
			</ul>
		</div>
	</div>';



// ACCIONES
	echo '
	<div class="uk-width-expand">
		<div class="margin-top-20">
			<div uk-grid class="uk-grid-small uk-flex-right">
				<div>
					<a href="index.php?rand='.rand(1,2000).'&modulo='.$modulo.'&archivo=folder" class="uk-button uk-button-primary"><i uk-icon="folder"></i> &nbsp; Archivo</a>
				</div>
				<div>
					<a href="#add" uk-toggle class="uk-button uk-button-success"><i uk-icon="plus"></i> &nbsp; Nuevo</a>
				</div>
			</div>
		</div>
	</div>
	';


// TABLA DE INFORMACIÓN
	echo '
	<div class="uk-width-1-1">
		<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle uk-table-responsive">
			<thead>
				<tr>
					<th width="10px;">Fecha</th>
					<th >Evento</th>
					<th width="80px"></th>
				</tr>
			</thead>
			<tbody>';

			$Consulta = $CONEXION -> query("SELECT * FROM $modulo WHERE folder = 0 ORDER BY fecha DESC");
			while ($row_Consulta = $Consulta -> fetch_assoc()) {
				$curso=$row_Consulta['curso'];
				$clase=(strtotime($row_Consulta['fecha'])>strtotime($hoy))?'':'uk-text-muted';
				echo '
					<tr id="row'.$row_Consulta['id'].'" class="'.$clase.'">
						<td class="uk-text-nowrap">
							'.fechaCorta($row_Consulta['fecha']).'
						</td>
						<td>
							'.$row_Consulta['txt'].'
						</td>
						<td class="uk-text-nowrap">
							<button data-id="'.$row_Consulta['id'].'" class="folder uk-text-muted" uk-icon="folder"></button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="index.php?rand='.rand(1,10000).'&modulo='.$modulo.'&archivo=detalle&id='.$row_Consulta['id'].'" class="uk-text-primary" uk-icon="search"></a>
						</td>
					</tr>';
			}

			echo '
			</tbody>
		</table>
	</div>
	';


// MODAL NUEVO
	echo '
	<div id="add" uk-modal class="modal">
		<div class="uk-modal-dialog uk-modal-body">
			<p><b class="uk-modal-title">Nueva fecha</b></p>
			<form action="index.php" method="post">
				<input type="hidden" name="modulo" value="'.$modulo.'" >
				<input type="hidden" name="archivo" value="'.$archivo.'" >
				<input type="hidden" name="nuevoevento" value="1" >

				<div class="uk-margin">
					<label>Fecha inicio:</label>
					<input type="date" name="fecha" class="uk-input" value="'.$hoy.'">
				</div>
				<div class="uk-margin">
					<label>Evento</label>
					<input name="txt" type="text" class="uk-input">
				</div>
				<div class="uk-margin uk-text-center">
					<span class="uk-button uk-button-white uk-button-large uk-modal-close pointer">Cancelar</span>
					<button class="uk-button uk-button-primary uk-button-large">Guardar</button>
				</div>
		</div>
	</div>';

$scripts='
	$(".folder").click(function() {
		var id = $(this).attr("data-id");
		$.ajax({
			method: "POST",
			url: "modulos/'.$modulo.'/acciones.php",
			data: { 
				archivar: 1,
				folder: 1,
				id: id
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
			$("#row"+id).fadeOut( "slow" );
		});
	});
	';
