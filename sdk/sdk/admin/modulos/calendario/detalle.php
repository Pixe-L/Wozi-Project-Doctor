<?php 
$CONSULTA = $CONEXION -> query("SELECT * FROM $modulo WHERE id = $id");
$row_CONSULTA = $CONSULTA -> fetch_assoc();

echo '
	<div class="uk-width-auto">
		<div>
			<div class="uk-width-1-1">
				<ul class="uk-breadcrumb margin-v-20">
					<li><a href="index.php?rand='.rand(1,10000).'&modulo='.$modulo.'">'.$modulo.'</a></li>
					<li><a href="index.php?rand='.rand(1,10000).'&modulo='.$modulo.'&archivo=detalle&id='.$id.'" class="color-red">'.$row_CONSULTA['txt'].'</a></li>
				</ul>
			</div>
		</div>
	</div>';


echo '
	<div class="uk-width-expand@s uk-text-right uk-margin">
		<button id="borrarprod" class="uk-button uk-button-danger"><i uk-icon="icon:trash"></i> &nbsp; Eliminar</button>
	</div>
	<div class="uk-width-1-1">
	</div>
	';

// Fotografías
	echo '
	<div class="uk-width-auto@l">
		<div style="max-width:100%;width:400px;">
			<div id="fileuploader">
				Cargar
			</div>
		</div>
	</div>
	<div class="uk-width-expand@l">
		<div uk-grid class="uk-grid-small sortable" data-tabla="'.$modulopic.'">';

			$consultaPIC = $CONEXION -> query("SELECT * FROM $modulopic WHERE producto = $id ORDER BY orden,id");
			$numProds=$consultaPIC->num_rows;
			while ($row_consultaPIC = $consultaPIC -> fetch_assoc()) {

				$pic='../img/contenido/'.$modulo.'/'.$row_consultaPIC['id'].'.jpg';

				if(file_exists($pic)){
					echo '
					<div uk-margin-bottom" id="'.$row_consultaPIC['id'].'" style="max-width:200px;">
						<div class="uk-card uk-card-default uk-card-body uk-text-center">
							<button data-id="'.$row_consultaPIC['id'].'" class="eliminapic uk-icon-button uk-button-danger" tabindex="1" uk-icon="icon:trash"></button>
							<br>
							<img src="'.$pic.'" class="img-responsive uk-border-rounded margin-top-20"><br>
							'.$row_consultaPIC['titulo'].'
						</div>
					</div>';
				}else{
					echo '
					<div uk-margin-bottom" id="'.$row_consultaPIC['id'].'" style="max-width:200px;">
						<div class="uk-card uk-card-default uk-card-body uk-text-center">
							<button data-id="'.$row_consultaPIC['id'].'" class="eliminapic uk-icon-button uk-button-danger" tabindex="1" uk-icon="icon:trash"></button>
							<br><br><br>
							Imagen rota<br><br><br>
							<i uk-icon="icon:warning;ratio:5;"></i>
						</div>
					</div>';
				}
			}

			echo '
		</div>
	</div>';


echo '
	<div class="uk-width-1-1 padding-v-50">
		<div class="uk-card uk-card-default uk-card-body">
			<div class="uk-container">
				<form action="index.php" method="post">
					<h3>Descripción del evento</h3>
					<input type="hidden" name="modulo" value="'.$modulo.'">
					<input type="hidden" name="archivo" value="detalle">
					<input type="hidden" name="editarevento" value="1">
					<input type="hidden" name="id" value="'.$id.'">

					<div class="uk-margin">
						<label>Nombre del evento</label>
						<input type="text" class="uk-input" name="txt" value="'.$row_CONSULTA['txt'].'">
					</div>

					<div class="uk-margin">
						<label>Descripción del evento</label>
						<textarea class="editor min-height-150" name="txt1">'.$row_CONSULTA['txt1'].'</textarea>
					</div>
					
					<div class="uk-margin uk-text-center">
						<button class="uk-button uk-button-primary uk-button-large">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>';



$scripts='
	$("#borrarprod").click(function() {
		var id = $(this).attr("data-id");
		UIkit.modal.confirm("Realmente desea borrar este evento?").then(function() {
			$.ajax({
				method: "POST",
				url: "modulos/'.$modulo.'/acciones.php",
				data: { 
					borrarevento: 1,
					id: '.$id.'
				}
			})
			.done(function( msg ) {
				window.location = (\'index.php?rand='.rand(1,1000).'&modulo='.$modulo.'\');
			});
		}, function () {
			console.log("Rechazado");
		});
	});


	$(document).ready(function() {
		$("#fileuploader").uploadFile({
			url:"../library/upload-file/php/upload.php",
			fileName:"myfile",
			maxFileCount:1,
			showDelete: \'false\',
			allowedTypes: "jpeg,jpg",
			maxFileSize: 6291456,
			showFileCounter: false,
			showPreview:false,
			returnType:\'json\',
			onSuccess:function(data){ 
				window.location = (\'index.php?rand='.rand(1,10000).'&modulo='.$modulo.'&archivo=detalle&id='.$id.'&position=gallery&imageupload=\'+data);
			}
		});
	});	

	// Eliminar foto
	$(".eliminapic").click(function() {
		var id = $(this).attr(\'data-id\');
		var statusConfirm = confirm("Realmente desea eliminar esto?"); 
		if (statusConfirm == true) { 
			$.ajax({
				method: "POST",
				url: "modulos/'.$modulo.'/acciones.php",
				data: { 
					borrarfoto: 1,
					id: id
				}
			})
			.done(function( msg ) {
				UIkit.notification.closeAll();
				UIkit.notification(msg);
				$("#"+id).addClass( "uk-invisible" );
			});
		}
	});

';
