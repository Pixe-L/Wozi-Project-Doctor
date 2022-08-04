<?php 
	$modulo='calendario';
	$modulopic=$modulo.'pic';
	$rutaFinal='../img/contenido/'.$modulo.'/';

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Eventos    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_POST['nuevoevento'])) {
		$curso = $_POST['curso'];
		$fecha = $_POST['fecha'];
		$txt   = htmlentities($_POST['txt']);

		$sql = "INSERT INTO $modulo (fecha,txt,folder) VALUES ('$fecha','$txt',0)";
		if($insertar = $CONEXION->query($sql)){
			$id=$CONEXION->insert_id;
			$archivo='detalle';
			header( 'Location: index.php?rand='.rand(1,9999).'&modulo='.$modulo.'&archivo='.$archivo.'&id='.$id.'&showsuccess=1');
		}else{
			$legendFail .= "<br>No se pudo modificar la base de datos <br> $curso <br> $fecha <br> $txt";
			$fallo = 1;
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Artículo Editar      %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['editarevento'])) {
		// Obtenemos los valores enviados
		$fallo=1;
		$legendFail .= "<br>No se pudo modificar la base de datos";
		foreach ($_POST as $key => $value) {
			$dato = trim(htmlentities($value, ENT_QUOTES));
			$actualizar = $CONEXION->query("UPDATE $modulo SET $key = '$dato' WHERE id = $id");
			$exito=1;
			unset($fallo);
			//$legendSuccess.='<br>'.$dato;
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    archivar    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_POST['archivar'])) {
		include '../../../includes/connection.php';

		$id=$_POST['id'];
		$folder=$_POST['folder'];

		$actualizar = $CONEXION->query("UPDATE $modulo SET folder = '$folder' WHERE id = $id");

		echo "<div class='bg-success color-blanco'><i uk-icon='icon: folder;ratio:2;'></i> &nbsp; Movido</div>";
	}


//%%%%%%%%%%%%%%%%%%%%%%%%%%    borrar evento    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_POST['borrarevento'])) {
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

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar Imagen      	 %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['borrarfoto'])){
		include '../../../includes/connection.php';
		$rutaFinal='../../'.$rutaFinal;
		$id=$_POST['id'];

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
		if(isset($exito)){
			echo "<div class='bg-success color-blanco'><i uk-icon='icon: trash;ratio:2;'></i> &nbsp; Borrado</div>";
		}else{
			echo "<div class='bg-danger color-blanco'><i uk-icon='icon: warning;ratio:2;'></i> &nbsp; No se pudo borrar</div>";
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Subir Imagen     	 %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_GET['imageupload'])){
		$imagenName=$_GET['imageupload'];

		// Imagenes a crear
		$orig=0;
		$xs=0;
		$sm=0;
		$med=0;
		$og=0;
		$nat400=1;
		$nat800=0;
		$nat1500=0;
		$Otra=0;

		// Dimensiones
		// Small
		$anchoXS=100;
		$altoXS =100;
		// Small
		$anchoSM=250;
		$altoSM =250;
		// Mediana
		$anchoMED=500;
		$altoMED =500;
		// OG
		$anchoOG=1000;
		$altoOG =700;
		// Otra
		$anchoOtra=1920;
		$altoOtra =780;


		//Obtenemos la extensión de la imagen
		$i = strrpos($imagenName,'.');
		$l = strlen($imagenName) - $i;
		$ext = strtolower(substr($imagenName,$i+1,$l));

		// Si no es JPG cancelamos
		if ($ext!='jpg' and $ext!='jpeg') {
			$fallo=1;
			$legendFail='<br>El archivo debe ser JPG';
		}

		$rutaInicial="../library/upload-file/php/uploads/";
		if(!file_exists($rutaInicial.$imagenName)){
			$fallo=1;
			$legendFail='<br>No se permite refrescar la página.';
		}

		if (!isset($fallo)) {
			$sql = "INSERT INTO $modulopic (producto,orden) VALUES ('$id','99')";
			if($insertar = $CONEXION->query($sql)){

				$pic = $CONEXION->insert_id;

				$imgAux=$rutaFinal.$pic."-aux.jpg";

				//check extension of the file
				$i   = strrpos($imagenName,'.');
				$l   = strlen($imagenName) - $i;
				$ext = strtolower(substr($imagenName,$i+1,$l));

				// Comprobamos que el archivo realmente se haya subido
				if(file_exists($rutaInicial.$imagenName)){

					// Lo movemos al directorio final
					copy($rutaInicial.$imagenName, $imgAux);    

					$original = imagecreatefromjpeg($imgAux);
					$ancho    = imagesx($original);
					$alto     = imagesy($original);

					if ($xs==1) {
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
						//  Imagen Pequeña
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
						$newName=$pic."-xs.jpg";

						$anchoNew=$anchoXS;
						$altoNew =$altoXS;

						// Proporcionalmente, la imagen es más ancha que la de destino
						if($ancho/$alto>$anchoNew/$altoNew){
							// Ancho proporcional
							$anchoProporcional=$ancho/$alto*$altoNew;
							// Excedente 
							$excedente=$anchoProporcional-$anchoNew;
							// Posición inicial de la coordenada x
							$xinicial= -$excedente/2;
						}else{
							// Alto proporcional
							$altoProporcional=$alto/$ancho*$anchoNew;
							// Excedente
							$excedente=$altoProporcional-$altoNew;
							// Posición inicial de la coordenada y
							$yinicial= -$excedente/2;
						}

						// Copiamos el inicio de la original para pegarlo en el archivo New
						$New = imagecreatetruecolor($anchoNew,$altoNew); 

						if(isset($xinicial)){
							imagecopyresampled($New,$original,$xinicial,0,0,0,$anchoProporcional,$altoNew,$ancho,$alto);
						}else{
							imagecopyresampled($New,$original,0,$yinicial,0,0,$anchoNew,$altoProporcional,$ancho,$alto);
						}

						// Pegamos el inicio de la imagen
						if(imagejpeg($New,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
							$exito=1;
							//$legendSuccess .= "<br>Imagen pequeña agregada";
						}
					}

					if ($sm==1) {
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
						//  Imagen Pequeña
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
						$newName=$pic."-sm.jpg";

						$anchoNew=$anchoSM;
						$altoNew =$altoSM;

						// Proporcionalmente, la imagen es más ancha que la de destino
						if($ancho/$alto>$anchoNew/$altoNew){
							// Ancho proporcional
							$anchoProporcional=$ancho/$alto*$altoNew;
							// Excedente 
							$excedente=$anchoProporcional-$anchoNew;
							// Posición inicial de la coordenada x
							$xinicial= -$excedente/2;
						}else{
							// Alto proporcional
							$altoProporcional=$alto/$ancho*$anchoNew;
							// Excedente
							$excedente=$altoProporcional-$altoNew;
							// Posición inicial de la coordenada y
							$yinicial= -$excedente/2;
						}

						// Copiamos el inicio de la original para pegarlo en el archivo New
						$New = imagecreatetruecolor($anchoNew,$altoNew); 

						if(isset($xinicial)){
							imagecopyresampled($New,$original,$xinicial,0,0,0,$anchoProporcional,$altoNew,$ancho,$alto);
						}else{
							imagecopyresampled($New,$original,0,$yinicial,0,0,$anchoNew,$altoProporcional,$ancho,$alto);
						}

						// Pegamos el inicio de la imagen
						if(imagejpeg($New,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
							$exito=1;
							//$legendSuccess .= "<br>Imagen pequeña agregada";
						}
					}

					if ($med==1) {
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
						//  Imagen Mediana
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
						$newName=$pic."-crop.jpg";

						$anchoNew=$anchoMED;
						$altoNew =$altoMED;

						// Proporcionalmente, la imagen es más ancha que la de destino
						if($ancho/$alto>$anchoNew/$altoNew){
							// Ancho proporcional
							$anchoProporcional=$ancho/$alto*$altoNew;
							// Excedente 
							$excedente=$anchoProporcional-$anchoNew;
							// Posición inicial de la coordenada x
							$xinicial= -$excedente/2;
						}else{
							// Alto proporcional
							$altoProporcional=$alto/$ancho*$anchoNew;
							// Excedente
							$excedente=$altoProporcional-$altoNew;
							// Posición inicial de la coordenada y
							$yinicial= -$excedente/2;
						}

						// Copiamos el inicio de la original para pegarlo en el archivo New
						$New = imagecreatetruecolor($anchoNew,$altoNew); 

						if(isset($xinicial)){
							imagecopyresampled($New,$original,$xinicial,0,0,0,$anchoProporcional,$altoNew,$ancho,$alto);
						}else{
							imagecopyresampled($New,$original,0,$yinicial,0,0,$anchoNew,$altoProporcional,$ancho,$alto);
						}

						// Pegamos el inicio de la imagen
						if(imagejpeg($New,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
							$exito=1;
							//$legendSuccess .= "<br>Imagen pequeña agregada";
						}
					}

					if ($og==1) {
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
						//  Imagen OG
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
						$newName=$pic."-og.jpg";

						$anchoNew=$anchoOG;
						$altoNew =$altoOG;

						// Proporcionalmente, la imagen es más ancha que la de destino
						if($alto/$ancho>(.7)){
							// Ancho proporcional
							$anchoProporcional=$ancho/$alto*$altoNew;
							// Excedente 
							$excedente=$anchoProporcional-$anchoNew;
							// Posición inicial de la coordenada x
							$xinicial= -$excedente/2;
						}else{
							// Alto proporcional
							$altoProporcional=$alto/$ancho*$anchoNew;
							// Excedente
							$excedente=$altoProporcional-$altoNew;
							// Posición inicial de la coordenada y
							$yinicial= -$excedente/2;
						}

						// Copiamos el inicio de la original para pegarlo en el archivo New
						$New = imagecreatetruecolor($anchoNew,$altoNew); 

						if(isset($xinicial)){
							imagecopyresampled($New,$original,$xinicial,0,0,0,$anchoProporcional,$altoNew,$ancho,$alto);
						}else{
							imagecopyresampled($New,$original,0,$yinicial,0,0,$anchoNew,$altoProporcional,$ancho,$alto);
						}

						// Pegamos el inicio de la imagen
						if(imagejpeg($New,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
							$exito=1;
							//$legendSuccess .= "<br>Imagen OG agregada";
						}
					}

					if ($nat400==1) {
						//  Imagen nat400
						$newName=$pic.".jpg";
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

					if ($nat800==1) {
						//  Imagen nat1000
						$newName    = $pic."-nat800.jpg";
						$anchoNuevo = 800;
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

					if ($nat1500==1) {
						//  Imagen nat1500
						$newName=$pic."-nat500.jpg";
						if ($ancho>$alto) {
							$anchoNuevo = 1500;
							$altoNuevo  = $anchoNuevo*$alto/$ancho;
						}else{
							$altoNuevo  = 1500;
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

					if ($Otra==1) {
						//  Imagen Otra
						$newName=$pic."-otra.jpg";
						$anchoNew=$anchoOtra;
						$altoNew =$altoOtra;
						$dst_x=0;
						$dst_y=0;
						$src_x=0;
						$src_y=0;
						$dst_w=$ancho;
						$dst_h=$alto;
						$src_w=$ancho;
						$src_h=$alto;

						// Proporcionalmente, la imagen es más ancha que la de destino
						if($ancho/$alto>$anchoNew/$altoNew){
							// Ancho proporcional
							$anchoProporcional=$ancho/$alto*$altoNew;
							// Corregimos el ancho
							$dst_w=$anchoProporcional;
							// Corregimos el ancho
							$dst_h=$altoNew;
							// Excedente 
							$excedente=$anchoProporcional-$anchoNew;
							// Posición inicial de la coordenada x
							$src_x= $excedente/2;
							//$legendSuccess.='<br>Opt 2';
						}else{
							// Ancho proporcional
							$altoProporcional=$alto/$ancho*$anchoNew;
							// Corregimos el alto
							$dst_h=$altoProporcional;
							// Corregimos el ancho
							$dst_w=$anchoNew;
							// Excedente
							$excedente=$altoProporcional-$altoNew;
							// Posición inicial de la coordenada y
							$src_y= $excedente/4;
							//$legendSuccess.='<br>Opt 2';
							//$legendSuccess.='<br>Alto Original: '.$alto;
							//$legendSuccess.='<br>Alto Nuevo: '.$altoNew;
							//$legendSuccess.='<br>Alto Proporcional: '.$altoProporcional;
							//$legendSuccess.='<br>Excedente: '.$excedente;
							//$legendSuccess.='<br>Src Y: '.$src_y;
						}

						// Copiamos el inicio de la original para pegarlo en el archivo New
						$New = imagecreatetruecolor($anchoNew,$altoNew); 

						imagecopyresampled($New,$original,$dst_x,$dst_y,$src_x,$src_y,$dst_w,$dst_h,$src_w,$src_h);

						// Pegamos el inicio de la imagen
						if(imagejpeg($New,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
							$exito=1;
							//$legendSuccess .= "<br>Imagen Otra agregada";
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
				$legendFail='<br>No se pudo agregar a la base de datos';
			}
		}else{
			$legendFail.= '
			<br>No pudo subirse la imagen';
		}


		// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		// Borramos las imágenes que estén remanentes en el directorio de carga
		// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		$filehandle = opendir($rutaInicial); // Abrir archivos
		while ($file = readdir($filehandle)) {
			if ($file != "." && $file != ".." && $file != ".gitignore" && $file != ".htaccess" && $file != "thumbnail") {
				if(file_exists($rutaInicial.$file)){
					//echo $rutaInicial.$file.'<br>';
			unlink($rutaInicial.$file);
				}
			}
		} 
		closedir($filehandle); 

		if (isset($exito)) {
			header( 'Location: index.php?rand='.rand(1,9999).'&modulo='.$modulo.'&archivo='.$archivo.'&id='.$id.'&showsuccess=1');
		}
	}








