<?php
$modulo='empresas';
$modulopic=$modulo.'pic';

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar Foto     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['borrarPic'])){
		if($borrar = $CONEXION->query("DELETE FROM $modulo WHERE id = $id")){
			// Borramos el archivo de imagen
			$rutaIMG="../img/contenido/".$modulo."/";
			$filehandle = opendir($rutaIMG); // Abrir archivos
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
						$pic=$rutaIMG.$file;
						$exito=1;
						unlink($pic);
					}
				}
			}
		}
	}
	
//%%%%%%%%%%%%%%%%%%%%%%%%%%    Subir Imágen     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	if(isset($_REQUEST['imagen'])){
		$position=$_GET['position'];
		$xs=1;
		$sm=1;
		$lg=1;


		//Obtenemos la extensión de la imagen
		$rutaInicial="../library/upload-file/php/uploads/";
		$imagenName=$_REQUEST['imagen'];
		$i = strrpos($imagenName,'.');
		$l = strlen($imagenName) - $i;
		$ext = strtolower(substr($imagenName,$i+1,$l));


		// Guardar en la base de datos
		
		if(file_exists($rutaInicial.$imagenName)){
			if ($position=='gallery') {
				$rutaFinal='../img/contenido/'.$modulo.'/';
				$sql = "INSERT INTO $modulo (orden) VALUES (99)";
				$insertar = $CONEXION->query($sql);
				$pic=$CONEXION->insert_id;
				$imgFinal=$pic.'.'.$ext;
				copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
			}else{
				$rutaFinal='../img/contenido/'.$modulo.'/';
				$imgFinal=rand(111111111,999999999).'.'.$ext;
				if(file_exists($rutaFinal.$imgFinal)){
					$imgFinal=rand(111111111,999999999).'.'.$ext;
				}
				$CONSULTA = $CONEXION -> query("SELECT imagen1 FROM configuracion WHERE id = $id");
				$row_CONSULTA = $CONSULTA -> fetch_assoc();
				if ($row_CONSULTA['imagen1']!='' AND file_exists($rutaFinal.$row_CONSULTA['imagen1'])) {
					unlink($rutaFinal.$row_CONSULTA['imagen1']);
				}
				copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
				$actualizar = $CONEXION->query("UPDATE configuracion SET imagen1 = '$imgFinal' WHERE id = $id");
			}
		}else{
			$fallo=1;
			$legendFail='<br>No se permite refrescar la página.';
		}

		


		// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		// Borramos las imágenes que estén remanentes en el directorio files
		// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		$filehandle = opendir($rutaInicial); // Abrir archivos
		while ($file = readdir($filehandle)) {
			if ($file != "." && $file != ".." && $file != ".gitignore" && $file != ".htaccess" && $file != "thumbnail") {
				if(file_exists($rutaInicial.$file)){
					//echo $ruta.$file.'<br>';
					unlink($rutaInicial.$file);
				}
			}
		} 
		closedir($filehandle); 
	}



