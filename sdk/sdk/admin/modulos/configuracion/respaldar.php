<?php 
echo '
	<div class="uk-width-auto margin-top-20">
		<ul class="uk-breadcrumb margen-v-20">
			<li><a href="index.php?modulo='.$modulo.'">Configuración</a></li>
			<li><a href="index.php?modulo='.$modulo.'&archivo='.$archivo.'" class="color-red">Respaldos</a></li>
		</ul>
	</div>';

echo '
	<div class="uk-width-expand margin-top-20">
		<div uk-grid class="uk-flex-right">
			<div>
				<button id="crearrespaldo" class="uk-button uk-button-primary">Crear respaldo</button>
			</div>
		</div>
	</div>';



echo '
	<div class="uk-width-1-1">
		<div class="uk-container" style="max-width:600px;">
			<h3 class="uk-text-center">Respaldos disponibles</h3>

			<div class="uk-width-1-1">
				<table class="uk-table uk-table-hover uk-table-striped uk-table-middle uk-table-small uk-table-responsive">
					<thead>
						<tr>
							<th>Archivo</th>
							<th width="100px"></th>
						</tr>
					</thead>
					<tbody>';
					$rutaRespaldo='../backup';
					$filehandle = opendir($rutaRespaldo); // Abrir archivos
					while ($file = readdir($filehandle)) {
						$fallo=1;
						if ($file != "." && $file != ".." && $file != ".DS_Store" ) {
							$entra = 1;
							echo '
							<tr>
								<td class="uk-text-center uk-text-left@m">
									'.$file.'
								</td>
								<td class="uk-text-center uk-text-nowrap">
									<button class="borrararchivo color-red" uk-icon="trash" data-file="'.$file.'"></button> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
									<a href="'.$rutaRespaldo.$file.'" download class="uk-text-primary" uk-icon="download"></a> 
								</td>
							</tr>';
					    }
					}
					// Fin lectura archivos
					closedir($filehandle);

					echo '
					</tbody>
				</table>
				';

			if (!isset($entra)) {
				echo '
				<div class="uk-text-center uk-alert uk-alert-danger">
					No existen respaldos
				</div>';
		    }

			    echo '
			</div>
		</div>
	</div>';


echo '
	<div>
		<div id="buttons">
			<a href="#menu-movil" class="uk-icon-button uk-button-primary uk-box-shadow-large uk-hidden@l" uk-icon="icon:menu;ratio:1.4;" uk-toggle></a>
		</div>
	</div>';


$scripts='
	// Crear respaldo
	$("#crearrespaldo").click(function(){
		UIkit.notification.closeAll();
		$.ajax({
			method: "POST",
			url: "modulos/'.$modulo.'/acciones.php",
			data: { 
				respaldarbasededatos: 1
			}
		})
		.done(function( response ) {
			console.log(response);
			datos=JSON.parse(response);
			UIkit.notification(datos.msj,{pos:"bottom-right"});
			if(datos.estatus==0){
				setTimeout(function(){
					location.reload();
				},2000)
			}
		});

	});


	// Borrar archivo
	$(".borrararchivo").click(function() {
		var file = $(this).attr("data-file");
		var statusConfirm = confirm("Realmente desea borrar esto?");
		if (statusConfirm == true) {
			UIkit.notification.closeAll();
			$.ajax({
				method: "POST",
				url: "modulos/'.$modulo.'/acciones.php",
				data: {
					borrarrespaldo: 1,
					file: file
				}
			})
			.done(function( response ) {
				console.log( response );
				var datos = JSON.parse(response);
				UIkit.notification(datos.msj,{pos:"bottom-right"});
				if(datos.estatus==0){
					location.reload();
				}
			});
		}
	});


';
