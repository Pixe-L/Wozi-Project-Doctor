<?php
$modulo='galerias';
$modulopic=$modulo.'pic';
$rutaFinal='../img/contenido/'.$modulo.'/';

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Nuevo galería    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['nuevocatalogo']) AND isset($_POST['titulo'])){
		$titulo	= trim(htmlentities($_POST['titulo']));

		$sql = "INSERT INTO $modulo (titulo) VALUES ('$titulo')";
		if($insertar = $CONEXION->query($sql)){
			$id = $CONEXION->insert_id;
			header( 'Location: index.php?rand='.rand(1,9999).'&modulo='.$modulo.'&archivo='.$archivo.'&id='.$id.'&showsuccess=1');
		}else{
			$legendFail .= "<br>No se pudo borrar de la base de datos";
			$fallo='danger';  
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar galería     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['borrararticulo'])){
		include '../../../includes/connection.php';
		$rutaFinal='../../'.$rutaFinal;
		$id=$_POST['id'];

		if($borrar = $CONEXION->query("DELETE FROM $modulo WHERE id = $id")){
			$exito=1;
		}

		$CONSULTA = $CONEXION -> query("SELECT * FROM $modulopic WHERE producto = $id");
		while($row_CONSULTA = $CONSULTA -> fetch_assoc()){
			$id=$row_CONSULTA['id'];

			// Borramos el archivo de imagen
			$filehandle = opendir($rutaFinal); // Abrir archivos
			while ($file = readdir($filehandle)) {
				if ($file != "." && $file != "..") {
					// Id de la imagen
					if (strpos($file,'-')===false) {
						$imagenID = strstr($file,'.',TRUE);
					}else{
						$imagenID = strstr($file,'-',TRUE);
					}
					// Comprobamos que sean iguales
					if($imagenID==$id){
						$pic=$rutaFinal.$file;
						$exito=1;
						unlink($pic);
					}
				}
			}

			$borrar = $CONEXION->query("DELETE FROM $modulopic WHERE id = $id");
		}

		if(isset($exito)){
			echo "<div class='bg-success color-blanco'><i uk-icon='icon: trash;ratio:2;'></i> &nbsp; Borrado</div>";
		}else{
			echo "<div class='bg-danger color-blanco'><i uk-icon='icon: warning;ratio:2;'></i> &nbsp; No se pudo borrar</div>";
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar Imagen     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['borrarfoto'])){
		include '../../../includes/connection.php';
		$rutaFinal='../../'.$rutaFinal;
		$mensajeClase  = 'danger';
		$mensajeIcon   = 'ban';
		$mensaje       = 'No se pudo borrar';

		$file = $_POST['file'];
		
		$id = strstr($file, '.', true);		

		// Borramos de la base de datos
		if($borrar = $CONEXION->query("DELETE FROM $modulopic WHERE id = $id")){
			$legendSuccess.= "<br>galería eliminado";
			$exito='success';
		}else{
			$legendFail .= "<br>No se pudo borrar de la base de datos";
			$fallo='danger';  
		}
		// Borramos el archivo de imagen
		$filehandle = opendir($rutaFinal); // Abrir archivos
		while ($file = readdir($filehandle)) {
			if ($file != "." && $file != "..") {
				// Id de la imagen
				if (strpos($file,'-')===false) {
					$imagenID = strstr($file,'.',TRUE);
				}else{
					$imagenID = strstr($file,'-',TRUE);
				}
				// Comprobamos que sean iguales
				if($imagenID==$id){
					$pic=$rutaFinal.$file;
					unlink($pic);
					$mensajeClase = 'success';
					$mensajeIcon  = 'check';
					$mensaje      = 'Borrado';
				}
			}
		}
		closedir($filehandle);
		echo '<div class="uk-text-center color-white bg-'.$mensajeClase.' padding-10 text-lg"><i class="fa fa-'.$mensajeIcon.'"></i> &nbsp; '.$mensaje.'</div>';		
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Subir foto     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_FILES["uploadedfile"])){
		include '../../../includes/connection.php';
		$rutaFinal = '../../../img/contenido/'.$modulo.'/';
		$id=$_GET['id'];

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

			if ($ext=='jpg' OR $ext=='jpeg') {
				$sql = "INSERT INTO $modulopic (producto) VALUES ('$id')";
				if($insertar = $CONEXION->query($sql)){
					$idPic = $CONEXION->insert_id;
			 	 	$archivoFinal = $idPic.'.'.$ext;
			 		move_uploaded_file($_FILES["uploadedfile"]["tmp_name"],$rutaFinal.$archivoFinal);
			    	$ret[]= $archivoFinal;
			    }
			}
		}
		else  //Multiple files, file[]
		{
			$fileCount = count($_FILES["uploadedfile"]["name"]);
			for($i=0; $i < $fileCount; $i++){
				$archivoInicial = $_FILES["uploadedfile"]["name"][$i];
				$i = strrpos($archivoInicial,'.');
				$l = strlen($archivoInicial) - $i;
				$ext = strtolower(substr($archivoInicial,$i+1,$l));

				if ($ext=='jpg' OR $ext=='jpeg') {
					$sql = "INSERT INTO $modulopic (producto) VALUES ('$id')";
					if($insertar = $CONEXION->query($sql)){
						$idPic = $CONEXION->insert_id;
						$archivoFinal = $idPic.'.'.$ext;
						move_uploaded_file($_FILES["uploadedfile"]["tmp_name"][$i],$rutaFinal.$archivoFinal);
						$ret[]= $archivoFinal;
					}
				}
			}
		}
	    echo json_encode($ret);
	}









