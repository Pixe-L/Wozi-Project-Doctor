<?php 
echo '
<div class="uk-width-1-1">
	<ul class="uk-breadcrumb margin-v-20">
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'" class="color-red">Empresas</a></li>
	</ul>
</div>


<div class="uk-width-auto@xl">
	<div style="max-width:100%;width:300px;">
		<div id="fileuploader">
			Cargar
		</div>
	</div>
</div>
<div class="uk-width-expand@xl uk-text-center">
	<div uk-grid class="uk-grid-small uk-grid-match sortable" data-tabla="'.$modulo.'">';

$consulta1 = $CONEXION -> query("SELECT * FROM $modulo ORDER BY orden");
while ($row_Consulta1 = $consulta1 -> fetch_assoc()) {

	$prodID=$row_Consulta1['id'];
	$estatusIcon=($row_Consulta1['estatus']==0)?'off uk-text-muted':'on uk-text-primary';

	$pic='../img/contenido/'.$modulo.'/'.$prodID.'.png';
	if(file_exists($pic)){
		echo '
		<div class="uk-margin-bottom" id="'.$prodID.'" style="max-width:220px;">
			<div class="uk-card uk-card-default uk-card-body uk-text-center">
				<i class="estatuschange fa fa-lg fa-toggle-'.$estatusIcon.' uk-text-muted pointer" data-tabla="'.$modulo.'" data-campo="estatus" data-id="'.$prodID.'" data-valor="'.$row_Consulta1['estatus'].'"></i> &nbsp;&nbsp;
				<a href="'.$pic.'" class="uk-icon-button uk-button-default" target="_blank" uk-icon="icon:image"></a> &nbsp;&nbsp;
				<a href="javascript:eliminaPic(picID='.$prodID.')" class="uk-icon-button uk-button-danger" tabindex="1" uk-icon="icon:trash"></a>
				<br>
				<img src="'.$pic.'" class="img-responsive uk-border-rounded margin-top-20"><br>
			</div>
		</div>';
	}else{
		echo '
		<div class="uk-margin-bottom" id="'.$prodID.'" style="max-width:200px;">
			<div class="uk-card uk-card-default uk-card-body uk-text-center">
				<a href="javascript:eliminaPic(picID='.$prodID.')" class="uk-icon-button uk-button-danger" tabindex="1" uk-icon="icon:trash"></a>
				<br>
				Imagen rota<br>
				<i uk-icon="icon:ban;ratio:2;"></i>
			</div>
		</div>';
	}
}


echo '	
	</div>
</div>


';


$scripts='
	$(document).ready(function() {
		$("#fileuploader").uploadFile({
			url:"../library/upload-file/php/upload.php",
			fileName:"myfile",
			maxFileCount:1,
			showDelete: \'false\',
			allowedTypes: "png",
			maxFileSize: 6291456,
			showFileCounter: false,
			showPreview:false,
			returnType:\'json\',
			onSuccess:function(data){ 
				window.location = (\'index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&position=gallery&imagen=\'+data);
			}
		});
	});

	function eliminaPic () { 
		var statusConfirm = confirm("Realmente desea eliminar esta foto?"); 
		if (statusConfirm == true) { 
			window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&borrarPic&id="+picID);
		} 
	};

	';

