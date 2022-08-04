<?php 
	$modulo='blog';
	$modulopic=$modulo.'pic';
	$rutaFinal='../img/contenido/'.$modulo.'/';

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Artículo Nuevo      %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['nuevo'])){ 
		if(!isset($fallo)){
			$sql = "INSERT INTO $modulo (fecha) VALUES ('$hoy')";
			if($insertar = $CONEXION->query($sql)){
				$exito=1;
				$legendSuccess .= "<br>Nuevo";
				$editarNuevo=1;
				$id=$CONEXION->insert_id;
				$archivo='detalle';
			}else{
				$fallo=1;  
				$legendFail .= "<br>No se pudo agregar a la base de datos";
			}
		}else{
			$legendFail .= "<br>La categoría o marca están vacíos.";
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Artículo Editar      %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['editar']) OR isset($editarNuevo)) {
		// Obtenemos los valores enviados

		$fallo=1;  
		$legendFail .= "<br>No se pudo modificar la base de datos";
		foreach ($_POST as $key => $value) {
			if ($key=='txt') {
				$dato = trim(str_replace("'", "&#039;", $value));
			}else{
				$dato = trim(htmlentities($value, ENT_QUOTES));
			}
			$actualizar = $CONEXION->query("UPDATE $modulo SET $key = '$dato' WHERE id = $id");
			$exito=1;
			unset($fallo);
		}
		if (isset($exito)) {
			header( 'Location: index.php?rand='.rand(1,9999).'&modulo='.$modulo.'&archivo='.$archivo.'&id='.$id.'&showsuccess=1');
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['borrarprod'])){
		$blog = $CONEXION -> query("SELECT * FROM blogpic WHERE item = $id");
		while ($row_blog = $blog -> fetch_assoc()) {
			$picID=$row_blog['id'];
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
					if($imagenID==$picID){
						$pic=$rutaIMG.$file;
						$exito=1;
						unlink($pic);
					}
				}
			}
	    }

		if($borrar = $CONEXION->query("DELETE FROM blog WHERE id = $id")){
			$borrar = $CONEXION->query("DELETE FROM blogpic WHERE item = $id");
			$exito=1;
			$legendSuccess .= "<br>Producto eliminado";
		}else{
			$legendFail .= "<br>No se pudo borrar de la base de datos";
			$fallo=1;  
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar Imagen      	 %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['borrarfoto'])){
		include '../../../includes/connection.php';
		$rutaFinal='../../../img/contenido/'.$modulo.'/';
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

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Subir Imágen     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['imagen'])){

		$xs=0;
		$sm=0;
		$med=0;
		$og=0;
		$nat500=0;
		$nat1000=0;
		$nat2000=0;
		$Otra=0;
		$size500x600=0;
		$nat500=1;
		$nat1000=0;

		// Extra Small
		$anchoXS=100;
		$altoXS =100;
		// Small
		$anchoSM=250;
		$altoSM =250;
		// Mediana
		$anchoMED=400;
		$altoMED =400;
		// OG
		$anchoOG=1000;
		$altoOG =1000;
		// Otra
		$anchoOtra=994;
		$altoOtra =540;
		// 
		$anchosize500x600=500;
		$altosize500x600 =600;

		//Obtenemos la extensión de la imagen
		$rutaInicial="../library/upload-file/php/uploads/";
		$imagenName=$_REQUEST['imagen'];
		$i = strrpos($imagenName,'.');
		$l = strlen($imagenName) - $i;
		$ext = strtolower(substr($imagenName,$i+1,$l));

		// Si no es JPG cancelamos
		if ($ext!='jpg' and $ext!='jpeg') {
			$fallo=1;
			$legendFail='<br>El archivo debe ser JPG';
		}

		// Guardar en la base de datos
		if (!isset($fallo)) {
			if(file_exists($rutaInicial.$imagenName)){
				$sql = "INSERT INTO blogpic (item,orden) VALUES ($id,99)";
				$insertar = $CONEXION->query($sql);
				$pic = $CONEXION->insert_id;
			}else{
				$fallo=1;
				$legendFail='<br>No se permite refrescar la página.';
			}
		}

		if (!isset($fallo)) {

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
				if ($ext=='jpg' or $ext=='jpeg') $original = imagecreatefromjpeg($imgAux);

				// Tomamos las dimensiones de la imagen original
				$ancho  = imagesx($original);
				$alto   = imagesy($original);


				if ($originalPic==1) {
					//  Imagen nat500
					$newName=$pic."-orig.jpg";
					$anchoNuevo = $ancho;
					$altoNuevo  = $alto;

					// Creamos la imagen
					$imagenAux = imagecreatetruecolor($anchoNuevo,$altoNuevo); 
					// Copiamos el inicio de la original para pegarlo en el archivo nuevo
					imagecopyresampled($imagenAux,$original,0,0,0,0,$anchoNuevo,$altoNuevo,$ancho,$alto);
					// Pegamos el inicio de la imagen
					if(imagejpeg($imagenAux,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
						$exito=1;
					}
				}

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
					$newName=$pic."-med.jpg";

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
						//$legendSuccess .= "<br>Imagen OG agregada";
					}
				}

				if ($nat500==1) {
					//  Imagen nat500
					$newName=$pic."-nat500.jpg";
					$anchoNuevo = 500;
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

				if ($nat1000==1) {
					//  Imagen nat1000
					$newName=$pic."-nat1000.jpg";
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

				if ($nat2000==1) {
					//  Imagen nat2000
					$newName=$pic."-nat2000.jpg";
					if ($ancho>$alto) {
						$anchoNuevo = 2000;
						$altoNuevo  = $anchoNuevo*$alto/$ancho;
					}else{
						$altoNuevo  = 2000;
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
						$src_y= $excedente/2;
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
			$legendFail.= '<br>No pudo subirse la imagen';
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


		if (isset($exito)) {
			header( 'Location: index.php?rand='.rand(1,9999).'&modulo='.$modulo.'&archivo='.$archivo.'&id='.$id.'&showsuccess=1');
		}
	}



