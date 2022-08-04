<?php
// BREADCRUMB
	echo '
	<div class="uk-width-auto">
		<div class="margin-top-20">
			<ul class="uk-breadcrumb">
				<li><a href="index.php?rand='.rand(1,2000).'&modulo='.$modulo.'">'.$modulo.'</a></li>
				<li><a href="index.php?rand='.rand(1,2000).'&modulo='.$modulo.'&archivo=folder" class="color-red">Archivo</a></li>
			</ul>
		</div>
	</div>';


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

			$Consulta = $CONEXION -> query("SELECT * FROM $modulo WHERE folder = 1 ORDER BY fecha DESC");
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

$scripts='
	$(".folder").click(function() {
		var id = $(this).attr("data-id");
		$.ajax({
			method: "POST",
			url: "modulos/'.$modulo.'/acciones.php",
			data: { 
				archivar: 1,
				folder: 0,
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
