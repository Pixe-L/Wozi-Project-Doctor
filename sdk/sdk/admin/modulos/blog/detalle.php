<?php
$catalogo = $CONEXION -> query("SELECT * FROM blog WHERE id = $id");
$row_catalogo = $catalogo -> fetch_assoc();

echo '
	<div class="uk-width-auto margin-top-20">
		<ul class="uk-breadcrumb">
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">'.$modulo.'</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=detalle&id='.$id.'" class="color-red">'.$row_catalogo['titulo'].'</a></li>
		</ul>
	</div>';

echo '
	<div class="uk-width-expand@s uk-text-right uk-margin">
		<button id="borrarprod" class="uk-button uk-button-danger"><i uk-icon="icon:trash"></i> &nbsp; Eliminar</button>
	</div>
	<div class="uk-width-1-1">
	</div>
	';

	$videoexiste=1;
	if (strlen($row_catalogo['video'])>0) {
		$videoexiste=2;
		$videoUrl=$row_catalogo['video'];
		$videoPic=$videoUrl;
		if (strpos($videoPic, 'youtube')) {
			$pos=strpos($videoPic, 'v');
			$videoPic=substr($videoPic, ($pos+2));
		}elseif (strpos($videoPic, 'youtu.be')) {
			$pos=strrpos($videoPic, '/');
			$videoPic=substr($videoPic, ($pos+1));
		}
		$pic='https://img.youtube.com/vi/'.$videoPic.'/0.jpg';
		$play='<img src="../img/design/play.png" class="uk-width-1-1 uk-position-absolute" style="top:0;left:0;margin-top:-25%;">';
		echo '
		<div class="uk-width-1-2@s">
			<div uk-grid class="uk-flex-center">
				<div>
					<div class="margin-v-20">
						<a href="'.$videoUrl.'" target="_blank" class="uk-position-relative">
							<img src="'.$pic.'" class=" max-height-300px">
							'.$play.'
						</a>
					</div>
				</div>
			</div>
		</div>';
	}


echo '
	<div class="uk-width-1-'.$videoexiste.'@s margin-top-50">
		<span class="uk-text-muted">
			Para ordenar fotos arrastre y suelte.<br>
		</span>
		<div id="fileuploader">
			Cargar
		</div>
		<br><span id="msg" class="color-red">&nbsp;</span>
	</div>

	<div class="uk-width-1-1">
		<div uk-grid class="sortable uk-grid-match uk-grid-small" data-tabla="blogpic">';
	$num=1;
	$picTXT='';
	$productosPIC = $CONEXION -> query("SELECT * FROM blogpic WHERE item = $id ORDER BY orden,id");
	while ($row_productosPIC = $productosPIC -> fetch_assoc()) {

		$pic='../img/contenido/'.$modulo.'/'.$row_productosPIC['id'].'-nat500.jpg';
		if(file_exists($pic)){
			echo '
			<div id="'.$row_productosPIC['id'].'" style="width:200px;">
				<div class="uk-card uk-card-default uk-card-body uk-text-center">
					<span uk-lightbox><a href="'.$pic.'" class="uk-icon-button uk-button-white" target="_blank" uk-icon="icon:image"></a></span> &nbsp;
					<a href="javascript:eliminaPic('.$row_productosPIC['id'].')" class="uk-icon-button uk-button-danger" uk-icon="icon:trash;"></a>
					<br><br>
					<img src="'.$pic.'" class="uk-border-rounded margin-bottom-20">
				</div>
			</div>';
		}else{
			echo '
			<div class="uk-text-center" id="'.$row_productosPIC['id'].'" style="width:200px;">
				<p class="uk-scrollable-box"><i uk-icon="icon:chain-broken uk-icon-large"></i><br><br>
					Imagen rota<br><br>
					<a href="javascript:eliminaPic('.$row_productosPIC['id'].')" class="uk-icon-button uk-button-danger" tabindex="1" uk-icon="trash"></a>
				</p>
			</div>';
		}
	}

	echo '
		</div>
	</div>
	';


echo '
	<div class="uk-width-1-1 margin-v-20">
		<div class="uk-container">
			<form action="index.php" method="post" name="datos" onsubmit="return checkForm(this);">
				<input type="hidden" name="editar" value="1">
				<input type="hidden" name="modulo" value="'.$modulo.'">
				<input type="hidden" name="archivo" value="detalle">
				<input type="hidden" name="id" value="'.$id.'">
				<div class="uk-margin margin-top-20 uk-width-1-1">
					<label for="titulo">Título</label>
					<input type="text" class="uk-input" name="titulo" value="'.$row_catalogo['titulo'].'" required>
				</div>
				<div class="uk-margin margin-top-20 uk-width-1-1">
					<label for="video">video de youtube</label>
					<input type="text" class="uk-input" name="video" value="'.$row_catalogo['video'].'" >
				</div>
				<div class="uk-margin margin-top-20 uk-width-1-1">
					<label for="txt">Descripción</label>
					<textarea class="editor" name="txt">'.$row_catalogo['txt'].'</textarea>
				</div>
				<div class="uk-width-1-1 uk-text-center margin-top-20">
					<input type="submit" name="send" value="Guardar" class="uk-button uk-button-primary uk-button-large">
				</div>
			</form>
		</div>
	</div>
	';



$scripts='
	// Eliminar producto
		$("#borrarprod").click(function(){
			var statusConfirm = confirm("Realmente desea eliminar esto?"); 
			if (statusConfirm == true) { 
				window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&borrarprod&id='.$id.'");
			} 
		});

	// Subir imágenes
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
					window.location = (\'index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&id='.$id.'&imagen=\'+data);
				}
			});
		});

	// Eliminar foto
		function eliminaPic (id) { 
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
		};

';

