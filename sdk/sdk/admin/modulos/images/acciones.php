<?php
$modulo='images';
$rutaFinal='../img/contenido/'.$modulo.'/';
$rutaInicial="../library/upload-file/php/uploads/";

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Subir foto     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_FILES["uploadedfile"])){
		include '../../../includes/connection.php';
		$rutaFinal = "../../../img/contenido/images/";
		$ret = array();
		
		$error =$_FILES["uploadedfile"]["error"];
		//You need to handle  both cases
		//If Any browser does not support serializing of multiple files using FormData() 
		if(!is_array($_FILES["uploadedfile"]["name"])) //single file
		{
	 	 	$archivoInicial = $_FILES["uploadedfile"]["name"];
			$i = strrpos($archivoInicial,'.');
			$l = strlen($archivoInicial) - $i;
			$ext = strtolower(substr($archivoInicial,$i+1,$l));

	 	 	$archivoFinal  = date('Ymd').rand(1000000000,9999999999).'.'.$ext;
	 		move_uploaded_file($_FILES["uploadedfile"]["tmp_name"],$rutaFinal.$archivoFinal);
	    	$ret[]= $archivoFinal;
		}
		else  //Multiple files, file[]
		{
		  $fileCount = count($_FILES["uploadedfile"]["name"]);
		  for($i=0; $i < $fileCount; $i++)
		  {
		  	$archivoInicial = $_FILES["uploadedfile"]["name"][$i];
			$i = strrpos($archivoInicial,'.');
			$l = strlen($archivoInicial) - $i;
			$ext = strtolower(substr($archivoInicial,$i+1,$l));

		  	$archivoFinal  = date('Ymd').rand(1000000000,9999999999).'.'.$ext;
			move_uploaded_file($_FILES["uploadedfile"]["tmp_name"][$i],$rutaFinal.$archivoFinal);
		  	$ret[]= $archivoFinal;
		  }
		}
	    echo json_encode($ret);
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar foto     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['borrarfoto'])){
		$rutaFinal='../../../img/contenido/'.$modulo.'/';
		$file=$_POST['file'];
		if(file_exists($rutaFinal.$file)){
			unlink($rutaFinal.$file);
			echo "<div style='color:white;'><i uk-icon='icon: trash;ratio:2;'></i> &nbsp; Borrado</div>";
		}else{
			echo "<div style='color:red;'><i uk-icon='icon: warning;ratio:2;'></i> &nbsp; No se pudo borrar</div>";
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_GET['borrartodo'])){
		$num=0;
		$filehandle = opendir($rutaFinal); // Abrir archivos
		while ($file = readdir($filehandle)) {
			if ($file != "." && $file != ".." && $file != "index.html") {
				if(file_exists($rutaFinal.$file)){
					$num++;
					$exito=1;
					unlink($rutaFinal.$file);
				}
			}
		} 
		$legendSuccess .= '<br>Archivos borrados: '.$num;
		closedir($filehandle);
		$scripts='setTimeout(function(){ window.location = (\'index.php?rand='.rand(1,999).'&modulo='.$modulo.'\'); },1000);';
	}
