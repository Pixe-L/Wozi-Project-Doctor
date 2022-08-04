<?php
$CONSULTA = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 1");
$rowCONSULTA = $CONSULTA -> fetch_assoc();

	$pic=$rutaFinal.$rowCONSULTA['pdf1'];
	if(strlen($rowCONSULTA['pdf1'])>0 AND file_exists($pic)){
		$pdf='
		<div class="uk-panel uk-text-center">
			<a class="uk-button uk-button-primary uk-button-large" href="'.$pic.'" target="_blank">
				<span uk-icon="download"></span>
				Descargar PDF
			</a><br><br>
			<button class="uk-button uk-button-danger uk-button-large borrarpic"><i uk-icon="icon:trash"></i> Eliminar pdf</button>
		</div>';
	}else{
		$pdf='
		<div class="uk-panel uk-text-center">
			<p class="uk-scrollable-box"><i uk-icon="icon:warning;ratio:5;"></i><br><br>
				Falta catálogo<br><br>
			</p>
		</div>';
	}

echo '
<div class="uk-width-auto@m margin-top-20">
	<ul class="uk-breadcrumb uk-text-capitalize">
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Configuración</a></li>
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'" class="color-red">Catálogo</a></li>
	</ul>
</div>




<div class="uk-width-1-1">
	<div class="uk-container">

		<div class="uk-width-1-1">
			<div class="margin-top-50 uk-text-center uk-container uk-container-xsmall">
				Archivos tipo: PDF<br><br>
				<div uk-grid>
					<div class="uk-width-1-2@s">
						<div id="fileuploader">
							Cargar
						</div>
					</div>
					<div class="uk-width-1-2@s uk-text-center margin-v-20">
						'.$pdf.'
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
';



$scripts.='
	$(document).ready(function() {
		$("#fileuploader").uploadFile({
			url:"../library/upload-file/php/upload.php",
			fileName:"myfile",
			maxFileCount:1,
			showDelete: \'false\',
			allowedTypes: "pdf",
			maxFileSize: 6291456,
			showFileCounter: false,
			showPreview:false,
			returnType:\'json\',
			onSuccess:function(data){ 
				window.location = (\'index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&tabla='.$modulo.'&campo=pdf1&id=1&fileuploaded=\'+data);
			}
		});
	});	




	// Borrar imagen
	$(".borrarpic").click(function() {
		var statusConfirm = confirm("Realmente desea borrar esto?"); 
		if (statusConfirm == true) { 
			window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&campo=pdf1&borrarpic=1");
		} 
	});

';