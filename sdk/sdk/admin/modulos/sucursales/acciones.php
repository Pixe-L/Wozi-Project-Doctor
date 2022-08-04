<?php
	$modulo='sucursales';
	$rutaFinal='../img/contenido/'.$modulo.'/';
//%%%%%%%%%%%%%%%%%%%%%%%%%%    Nuevo Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['nuevo'])){ 
		// Obtenemos los valores enviados
			$lat='20.667703809107746';
			$lon='-103.34699871873852';

		// Actualizamos la base de datos
		if(!isset($fallo)){
			$sql = "INSERT INTO $modulo (fecha, lat, lon)".
				"VALUES ('$hoy', '$lat', '$lon')";
			if($insertar = $CONEXION->query($sql)){
				$exito=1;
				$legendSuccess .= "<br>Nuevo";
				$editarNuevo=1;
				$id=$CONEXION->insert_id;
				$archivo='detalle';
			}else{
				$fallo=1;  
				$legendFail .= "<br>No se pudo agregar a la base de datos - $cat";
			}
		}else{
			$legendFail .= "<br>La categoría o marca están vacíos.";
		}
	}
//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['editar']) OR isset($editarNuevo)) {
		// Obtenemos los valores enviados

		$fallo=1;  
		$legendFail .= "<br>No se pudo modificar la base de datos";
		foreach ($_POST as $key => $value) {

				$dato = str_replace("'", "&#039;", $value);
			
			$actualizar = $CONEXION->query("UPDATE $modulo SET $key = '$dato' WHERE id = $id");
			$exito=1;
			unset($fallo);
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar mapa   %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_POST['editarmapa'])) {
		include '../../../includes/connection.php';

		$id    = $_POST['id'];
		$valor = $_POST['valor'];
		$valor = str_replace('(', '', $valor);
		$valor = str_replace(')', '', $valor);
		$array = explode(',', $valor);
		$lat   = trim($array[0]);
		$lon   = trim($array[1]);

		if ($actualizar = $CONEXION->query("UPDATE $modulo SET lat = '$lat', lon = '$lon' WHERE id = $id")) {
			$mensajeClase='success';
			$mensajeIcon='check';
			$mensaje='Guardado -'.$id;
		}else{
			$mensajeClase='danger';
			$mensajeIcon='ban';
			$mensaje='No se pudo guardar';
		}
		echo '<div class="uk-text-center color-white bg-'.$mensajeClase.' padding-10 text-lg"><i class="fa fa-'.$mensajeIcon.'"></i> &nbsp; '.$mensaje.'</div>';		
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['borrarProd'])){
		if($borrar = $CONEXION->query("DELETE FROM $modulo WHERE id = $id")){
			$exito=1;
			$legendSuccess .= "<br>Producto eliminado";
		}else{
			$legendFail .= "<br>No se pudo borrar de la base de datos";
			$fallo=1;  
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar Foto     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['borrarpic'])){
		$CONSULTA = $CONEXION -> query("SELECT * FROM $modulo WHERE id = $id");
		$row_CONSULTA = $CONSULTA -> fetch_assoc();
		if (strlen($row_CONSULTA['imagen'])>0) {
			unlink($rutaFinal.$row_CONSULTA['imagen']);
			$actualizar = $CONEXION->query("UPDATE $modulo SET imagen = '' WHERE id = $id");
			$exito=1;
			$legendSuccess.='<br>Foto eliminada';
		}else{
			$legendFail .= "<br>No se encontró la imagen en la base de datos";
			$fallo=1;
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Subir Imágen     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['imagen'])){
		$position='main';

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
		if (!isset($fallo)) {
			if(file_exists($rutaInicial.$imagenName)){
				$pic=$id;
				if ($position=='gallery') {
					$sql = "INSERT INTO $modulopic (producto) VALUES ($id)";
					$insertar = $CONEXION->query($sql);
					$pic=$CONEXION->insert_id;
					$crear=1;
				}elseif($position=='categoria'){
					$imgFinal=rand(111111111,999999999).'.'.$ext;
					if(file_exists($rutaFinal.$imgFinal)){
						$imgFinal=rand(111111111,999999999).'.'.$ext;
					}
					$CONSULTA = $CONEXION -> query("SELECT * FROM $modulocat WHERE id = $cat");
					$row_CONSULTA = $CONSULTA -> fetch_assoc();
					if ($row_CONSULTA['imagen']!='' AND file_exists($rutaFinal.$row_CONSULTA['imagen'])) {
						unlink($rutaFinal.$row_CONSULTA['imagen']);
					}
					copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
					$actualizar = $CONEXION->query("UPDATE $modulocat SET imagen = '$imgFinal' WHERE id = $cat");
					$crear=0;
				}elseif($position=='categoriahover'){
					$imgFinal=rand(111111111,999999999).'.'.$ext;
					if(file_exists($rutaFinal.$imgFinal)){
						$imgFinal=rand(111111111,999999999).'.'.$ext;
					}
					$CONSULTA = $CONEXION -> query("SELECT * FROM $modulocat WHERE id = $cat");
					$row_CONSULTA = $CONSULTA -> fetch_assoc();
					if ($row_CONSULTA['imagenhover']!='' AND file_exists($rutaFinal.$row_CONSULTA['imagenhover'])) {
						unlink($rutaFinal.$row_CONSULTA['imagenhover']);
					}
					copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
					$actualizar = $CONEXION->query("UPDATE $modulocat SET imagenhover = '$imgFinal' WHERE id = $cat");
					$crear=0;
				}elseif($position=='main'){
					$imgFinal=rand(111111111,999999999).'.'.$ext;
					if(file_exists($rutaFinal.$imgFinal)){
						$imgFinal=rand(111111111,999999999).'.'.$ext;
					}
					$CONSULTA = $CONEXION -> query("SELECT * FROM $modulo WHERE id = $id");
					$row_CONSULTA = $CONSULTA -> fetch_assoc();
					if ($row_CONSULTA['imagen']!='' AND file_exists($rutaFinal.$row_CONSULTA['imagen'])) {
						unlink($rutaFinal.$row_CONSULTA['imagen']);
					}
					$legendFail.='<br>Fail - '.$position;
					copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
					$actualizar = $CONEXION->query("UPDATE $modulo SET imagen = '$imgFinal' WHERE id = $id");
					$crear=0;
				}elseif($position=='logo'){
					$pic=rand(111111111,999999999);
					$imgFinal=$pic.'.'.$ext;
					if(file_exists($rutaFinal.$imgFinal)){
						$pic=rand(111111111,999999999);
						$imgFinal=$pic.'.'.$ext;
					}
					$CONSULTA = $CONEXION -> query("SELECT * FROM $modulo WHERE id = $id");
					$row_CONSULTA = $CONSULTA -> fetch_assoc();
					if ($row_CONSULTA['logo']!='' AND file_exists($rutaFinal.$row_CONSULTA['logo'].'.jpg')) {
						$array = array(0=>'', 1=>'-xs', 2=>'-sm', 3=>'-orig',4=>'-lg');
						foreach ($array as $key => $value) {
							unlink($rutaFinal.$row_CONSULTA['logo'].$value.'.jpg');
						}
					}
					$legendFail.='<br>Fail - '.$position;
					copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
					$actualizar = $CONEXION->query("UPDATE $modulo SET logo = $pic WHERE id = $id");
					$crear=1;
				}elseif($position=='ficha'){
					$pic=rand(111111111,999999999);
					$imgFinal=$pic.'.'.$ext;
					if(file_exists($rutaFinal.$imgFinal)){
						$pic=rand(111111111,999999999);
						$imgFinal=$pic.'.'.$ext;
					}
					$CONSULTA = $CONEXION -> query("SELECT * FROM $modulo WHERE id = $id");
					$row_CONSULTA = $CONSULTA -> fetch_assoc();
					if ($row_CONSULTA['pdf']!='' AND file_exists($rutaFinal.$row_CONSULTA['pdf'].'.pdf')) {
						unlink($rutaFinal.$row_CONSULTA['pdf'].'.pdf');
					}
					$legendFail.='<br>Fail - '.$position;
					copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
					$actualizar = $CONEXION->query("UPDATE $modulo SET pdf = $pic WHERE id = $id");
					$crear=0;
				}
			}else{
				$fallo=1;
				$legendFail='<br>No se permite refrescar la página.';
			}
		}

		if (!isset($fallo) and $crear==1) {

			$imagenName=$_REQUEST['imagen'];

			$imgAux=$rutaFinal.$pic."-aux.jpg";

			//check extension of the file
			$i = strrpos($imagenName,'.');
			$l = strlen($imagenName) - $i;
			$ext = strtolower(substr($imagenName,$i+1,$l));

			// Comprobamos que el archivo realmente se haya subido
			if(file_exists($rutaInicial.$imagenName)){

				// Lo movemos al directorio final
				copy($rutaInicial.$imagenName, $imgAux);    

				// Leer el archivo para hacer la nueva imagen
				$original = imagecreatefromjpeg($imgAux);

				// Tomamos las dimensiones de la imagen original
				$ancho  = imagesx($original);
				$alto   = imagesy($original);


				if ($xs==1) {
					//  Imagen xs
					$newName=$pic."-xs.jpg";
					$anchoNuevo = 80;
					$altoNuevo  = $anchoNuevo*$alto/$ancho;

					// Creamos la imagen
					$imagenAux = imagecreatetruecolor($anchoNuevo,$altoNuevo); 
					// Copiamos el inicio de la original para pegarlo en el archivo nuevo
					imagecopyresampled($imagenAux,$original,0,0,0,0,$anchoNuevo,$altoNuevo,$ancho,$alto);
					// Pegamos el inicio de la imagen
					if(imagejpeg($imagenAux,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
						$exito=1;
					}
				}

				if ($sm==1) {
					//  Imagen sm
					$newName=$pic."-sm.jpg";
					$anchoNuevo = 400;
					$altoNuevo  = $anchoNuevo*$alto/$ancho;

					// Creamos la imagen
					$imagenAux = imagecreatetruecolor($anchoNuevo,$altoNuevo); 
					// Copiamos el inicio de la original para pegarlo en el archivo nuevo
					imagecopyresampled($imagenAux,$original,0,0,0,0,$anchoNuevo,$altoNuevo,$ancho,$alto);
					// Pegamos el inicio de la imagen
					if(imagejpeg($imagenAux,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
						$exito=1;
					}
				}

				if ($lg==1) {
					//  Imagen lg
					$newName=$pic."-lg.jpg";
					if ($ancho>$alto) {
						$anchoNuevo = 1000;
						$altoNuevo  = $anchoNuevo*$alto/$ancho;
					}else{
						$altoNuevo  = 1000;
						$anchoNuevo = $altoNuevo*$ancho/$alto;
					}

					// Creamos la imagen
					$imagenAux = imagecreatetruecolor($anchoNuevo,$altoNuevo); 
					// Copiamos el inicio de la original para pegarlo en el archivo nuevo
					imagecopyresampled($imagenAux,$original,0,0,0,0,$anchoNuevo,$altoNuevo,$ancho,$alto);
					// Pegamos el inicio de la imagen
					if(imagejpeg($imagenAux,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
						$exito=1;
					}
				}

				if ($originalPic==0) {
					unlink($imgAux);
				}else{
					rename ($imgAux, $rutaFinal.$pic."-orig.jpg");
				}

				if($exito=1){
					$legendSuccess .= "<br>Imagen actualizada";
				}
			}
		}else{
			$fallo=1;
			$legendFail.= '<br>No pudo subirse la imagen';
		}

		if($position=='main' or $position=='categoria' or $position=='categoriahover' or $position=='itinerario'){
			$exito=1;
			$legendSuccess .= "<br>Imagen actualizada";
			unset($fallo);
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

