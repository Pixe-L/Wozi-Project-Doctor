<?php                                    
	session_start();
	include 'connection.php';
	include 'widgets.php';
	$msjClase = 'danger';
	$msjIcon  = 'warning';
	$msjTxt   = 'Error';
	$estatus  = '';
	$horario  = '';
	$xtras    = '';
	$fallo    = 1;

//    Contacto                           
	if (isset($_POST['contacto'])) {
		$fallo = 0;
		// Obtener variables
		if(isset($_POST['nombre']) 	and $_POST['nombre']!='' ){ 	$nombre=htmlentities($_POST['nombre']); }else{ $nombre=false; $fallo=1; $msjTxt.='<br>Falta nombre'; }
		if(isset($_POST['telefono']) and $_POST['telefono']!='' ){ 	$telefono=htmlentities($_POST['telefono']); }else{ $telefono=false; $fallo=1; $msjTxt.='<br>Falta telefono'; }
		if(isset($_POST['email']) and $_POST['email']!='' ){ 	$email=htmlentities($_POST['email']); }else{ $email=false; $fallo=1; $msjTxt.='<br>Falta email'; }
		if(isset($_POST['comentarios']) and $_POST['comentarios']!='' ){ 	$comentarios=htmlentities($_POST['comentarios']); }else{ $comentarios=false; $fallo=1; $msjTxt.='<br>Falta comentarios'; }

		if ($fallo==0) {
			$sendMail     = 1;
			$asuntoCorreo = 'Formulario de contacto';
			$cuerpoCorreo = '
			<p>
				Nombre: <b>'.$nombre.'</b><br><br>
				Telefono: <b>'.$telefono.'</b><br><br>
				Email: <b>'.$email.'</b><br><br>
				Comentarios: <b>'.$comentarios.'</b>
				<br><br>
			</p>';
		}
	}

//    Correos de pedido                  
	if (isset($_POST['enviarcorreo'])) {
		$enviarcorreo=$_POST['enviarcorreo'];
		$thisid=$_POST['id'];
		$fallo     = 0;
		$sendMail  = 1;
		$send2user = 2;

		$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE id = $thisid");
		$row_CONSULTA = $CONSULTA -> fetch_assoc();
		$user=$row_CONSULTA['uid'];

		$CONSULTA1 = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $user");
		$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
		$email=$row_CONSULTA1['email'];
		$nombre=$row_CONSULTA1['nombre'];

		switch ($enviarcorreo) {
			case 1:
				$asuntoCorreo = 'Orden No. '.$thisid.' enviada'; 
				$cuerpoCorreo = '
					Estimado <b>'.$row_CONSULTA1['nombre'].'</b><br><br>
					La orden <b>'.$thisid.'</b> ha sido enviada<br><br>
					Su n&uacute;mero de gu&iacute;a es el <b>'.$row_CONSULTA['guia'].'</b><br><br><br><br>
					Puede rastrearlo en el siguiente enlace <br><br><br><br>
					<a href="'.$row_CONSULTA['linkguia'].'" style="background-color:'.$mailButton.';font-weight:700;border-radius:8px;padding-left:30px;padding-right:30px;padding-top:10px;padding-bottom:10px;color:white;text-decoration:none;">Rastrear env&iacute;o</a><br><br><br><br>
					Si desea ver su pedido puede hacerlo en el siguiente enlace:<br><br><br><br>
					<a href="'.$ruta.'mi-cuenta" style="background-color:'.$mailButton.';font-weight:700;border-radius:8px;padding-left:30px;padding-right:30px;padding-top:10px;padding-bottom:10px;color:white;text-decoration:none;">Mi cuenta</a><br><br><br><br>
					o copie y pegue este enlace: <br>
					<a href="'.$ruta.'mi-cuenta">'.$ruta.'mi-cuenta</a><br><br>
					Saludos cordiales.';
				break;
			case 2:
				$asuntoCorreo = 'Orden No. '.$thisid; 
				$cuerpoCorreo = '
					Estimado <b>'.$row_CONSULTA1['nombre'].'</b><br><br>
					Tenemos registrada una orden de compra con el n&uacute;mero <b>'.$thisid.'</b> por un importe de $'.number_format($row_CONSULTA['importe'],2).'<br><br>
					Si ya realiz&oacute; el pago, favor de enviar una notificaci&oacute;n al siguiente correo:<br>
					'.$remitenteMail.'<br><br>
					'.$row_CONSULTA['tabla'].'
					<img src="https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl='.$ruta.md5($thisid).'_revisar.pdf">
					Si desea ver su pedido puede hacerlo en el siguiente enlace:<br><br><br><br>
					<a href="'.$ruta.md5($thisid).'_revisar.pdf" style="background-color:'.$mailButton.';font-weight:700;border-radius:8px;padding-left:30px;padding-right:30px;padding-top:10px;padding-bottom:10px;color:white;text-decoration:none;">Ver pedido</a><br><br><br><br>
					o copie y pegue este enlace: <br>
					<a href="'.$ruta.'mi-cuenta">'.$ruta.md5($thisid).'_revisar.pdf</a><br><br>
					Saludos cordiales.';
				break;
			case 3:
				$asuntoCorreo = 'Orden No. '.$thisid.' cancelada'; 
				$cuerpoCorreo = '
					Estimado <b>'.$row_CONSULTA1['nombre'].'</b><br><br>
					La orden <b>'.$thisid.'</b> ha sido cancelada.<br><br>
					En caso de desear adquirir los productos solicitados deber&aacute; levantar una nueva orden.<br><br>
					Si desea ver sus pedidos puede hacerlo en el siguiente enlace:<br><br><br><br>
					<a href="'.$ruta.'mi-cuenta" style="background-color:'.$mailButton.';font-weight:700;border-radius:8px;padding-left:30px;padding-right:30px;padding-top:10px;padding-bottom:10px;color:white;text-decoration:none;">Mi cuenta</a><br><br><br><br>
					o copie y pegue este enlace: <br>
					<a href="'.$ruta.'mi-cuenta">'.$ruta.'mi-cuenta</a><br><br>
					Saludos cordiales.';
				break;
		}

		
	}

//    Login Facebook                     
	if (isset($_POST['facebooklogin'])) {

		$facebookId = $_POST['id'];
		$nombre     = $_POST['nombre'];
		$email      = $_POST['email'];

		if (strlen($facebookId)>0) {
			// Comprobar si el usuario existe
			$USER = $CONEXION -> query("SELECT * FROM usuarios WHERE email = '$email'");
			$numUser=$USER->num_rows;

			// Si no existe, lo notificamos
			if ($numUser==0) {
				$msjTxt.='<br>No está registrado';
			// Si existe, concedemos acceso
			}else{
				$row_USER = $USER -> fetch_assoc();
				$_SESSION['uid'] = $row_USER['id'];
				$uid    = $_SESSION['uid'];
				$uemail = $row_USER['email'];
				$ulevel = $row_USER['nivel'];
				$unombre= $row_USER['nombre'];
				$nombreCortoEspacio=strpos($unombre, ' ');
				$nombreCorto=($nombreCortoEspacio==0)?$unombre:substr($unombre,0,(strpos($unombre, ' ')));

				$fallo    = 0;
				$msjIcon  = 'check';
				$msjClase = 'success';
				$msjTxt   = 'Bienvenido '.$unombre;
			}
		}else{
			$msjTxt.='<br>No se recibieron datos de Facebook';
		}
	}

//    Cambiar contraseña Mi Cuenta       
	if (isset($_POST['passwordchange']) AND isset($_SESSION['uid'])) {
		$id    = $_SESSION['uid'];
		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];

		if (strlen($pass1)>6) {
			if ($pass1==$pass2) {
				$pass3=md5($pass1);
				if ($actualizar = $CONEXION->query("UPDATE usuarios SET pass = '$pass3' WHERE id = $id")) {
					$fallo    = 0;
					$msjIcon  = 'check';
					$msjClase = 'success';
					$msjTxt   = 'Contraseña cambiada';
				}else{
					$msjTxt.='<br>No se pudo guardar';
				}

			}else{
				$msjTxt.='<br>No coinciden';
			}
		}else{
			$msjTxt.='<br>Contraseña débil';
		}
	}

//    Regenerar contraseña               
	if (isset($_POST['passrecovery'])) {
		$email = $_POST['passrecovery'];
		
		$CONSULTA = $CONEXION -> query("SELECT * FROM usuarios WHERE email = '$email'");
		$numUser=$CONSULTA->num_rows;
		
		if ($numUser>0) {
			$row_CONSULTA = $CONSULTA -> fetch_assoc();
			$nombre   = $row_CONSULTA['nombre'];
			$idmd5    = md5($row_CONSULTA['id']);
			$fallo    = 0;
			$sendMail = 1;
			$send2user= 2;

			$asuntoCorreo = 'Regenerar contrasena';
			$cuerpoCorreo = '
				Estimado '.$nombre.':<br><br>
				Se han solicitado instrucciones para cambiar la contrase&ntilde;a de su cuenta.<br><br>
				Su correo de asociado es: <a href="mailto:'.$email.'" style="color:#333;">'.$email.'</a><br><br><br><br>
				<a href="'.$ruta.$idmd5.'-password_new" style="background-color:'.$mailButton.';color:white;text-decoration:none;border-radius:8px;padding:13px;font-weight:700;">Regenerar contrase&ntilde;a</a><br><br><br><br>
				Si no ha sido usted quien lo solicit&oacute;, haga caso omiso de este correo, sus datos est&aacute;n seguros.';

		}else{
			$msjTxt.="<br>No está registrado el email";
		}
	}

//    Regenerar contraseña               
	if (isset($_POST['passwordrecovery']) AND isset($_POST['uid'])) {

		$id    = $_POST['uid'];
		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];
		
		if (strlen($pass1)>6) {
			if ($pass1==$pass2) {
				$pass3=md5($pass1);
				if ($actualizar = $CONEXION->query("UPDATE usuarios SET pass = '$pass3' WHERE id = $id")) {
					$_SESSION['uid'] = $id;
					$fallo    = 0;
					$msjIcon  = 'check';
					$msjClase = 'success';
					$msjTxt   = 'Contraseña cambiada';
				}else{
					$msjTxt.='<br>No se pudo guardar';
				}

			}else{
				$msjTxt='<br>No coinciden';
			}
		}else{
			$msjTxt='<br>Contraseña demasiado débil';
		}
	}

//    Registro de usuarios               
	if (isset($_POST['registrodeusuarios'])) {

		// Verificar que el email no esté registrado
		$email=$_POST['email'];
		$nombre=$_POST['nombre'];
		$CONSULTA= $CONEXION -> query("SELECT * FROM usuarios WHERE email = '$email'");
		$numUser=$CONSULTA->num_rows;

		// Email nuevo
		if ($numUser==0) {
			$pass=md5($_POST['password']);
			$sql = "INSERT INTO usuarios (pass,alta)".
				"VALUES ('$pass','$hoy')";
			if ($insertar = $CONEXION->query($sql)) {
				$uid = $CONEXION->insert_id;
				foreach ($_POST as $key => $value) {
					$dato=($key=='rfc')?strtoupper($value):$value;
					$actualizar = $CONEXION->query("UPDATE usuarios SET $key = '$dato' WHERE id = $uid");
				}
				$_SESSION['uid'] = $uid;

				$fallo        = 0;
				$sendMail     = 1;
				$send2user    = 2;
				$nombre=$_POST['nombre'];
				$asuntoCorreo = 'Su registro en '.$Brand;
				$cuerpoCorreo = '
					<h3>Bienvenido a '.$Brand.'</h3>
					Sus datos de acceso son los siguientes:</b><br><br>
					Email: <b>'.$email.'</b><br><br>
					Contrase&ntilde;a: <b>'.$_POST['password'].'</b><br><br><br>
					<a href="'.$ruta.'mi-cuenta" style="background-color:'.$mailButton.';font-weight:700;border-radius:8px;padding-left:30px;padding-right:30px;padding-top:10px;padding-bottom:10px;color:white;text-decoration:none;">Mi cuenta</a><br><br><br><br>
					o copie y pegue este enlace: <br>
					<a href="'.$ruta.'mi-cuenta">'.$ruta.'mi-cuenta</a><br><br>
					';
			}else{
				$msjTxt.='<br>No se pudo guardar <br> '.$hoy;
			}
		// Email existente
		}else{
			$msjTxt.='<br>Ya está registrado';
		}
	}

//    Verificar correo no registrado     
	if (isset($_POST['emailverify'])) {
		// Verificar que el email no esté registrado
		$email=$_POST['email'];

		$CONSULTA= $CONEXION -> query("SELECT * FROM usuarios WHERE email = '$email'");
		$numUser=$CONSULTA->num_rows;
		// Email registrado
		if ($numUser==0) {
			$fallo    = 0;
			$msjClase = 'success';
			$msjIcon  = 'check';
			$msjTxt   = 'Correo válido';
		}else{
			$msjTxt .= '<br>Ya registrado';
		}
	}

//    Verificar actividad                
	if (isset($_GET['timeVerify'])) {
		$tabla= $_GET['timeVerify'];

		$consulta = $CONEXION -> query("SELECT * FROM $tabla");
		while($rowConsulta = $consulta -> fetch_assoc()){
			$id=$rowConsulta['id'];

			$horaActive=$rowConsulta['fecha'];
			if (strlen($horaActive)>0) {
				$time=120;
				$horario.=',"horario'.$id.'":"'.soloHora($horaActive).'"';
				$horaSql=strtotime($horaActive);
				$horaActual=strtotime($ahora);
				$lastLog=$horaActual-$horaSql;
				if($lastLog>($time*5)){
					$iconoActivo='&nbsp;&nbsp; <i class=\'fas fa-circle\' style=\'color:rgba(214,15,24,0)\'></i>&nbsp;';
				}elseif($lastLog>$time){
					$opcacidad=((5*$time)-$lastLog)/($time*4);
					$iconoActivo='&nbsp;&nbsp; <i class=\'fas fa-circle\' style=\'color:rgba(214,15,24,'.$opcacidad.')\'></i>&nbsp;';
				}else{
					$iconoActivo='<img src=\'../img/design/ico-dot.gif\' style=\'width:30px;\'>';
				}
				$estatus.=',"uid":"'.$id.'","estatus'.$id.'":"'.$iconoActivo.'"';
			}else{
				$horario.=',"horario'.$id.'":""';
				$iconoActivo='&nbsp;&nbsp; <i class=\'far fa-circle uk-text-muted\'></i>&nbsp;';
				$estatus.=',"uid":"'.$id.'","estatus'.$id.'":"'.$iconoActivo.'"';
			}

			$msjClase = 'success';
			$msjTxt   = 'Éxito';
			$msjIcon  = 'check';
			$fallo    = 0;
		}
	}

//    Reportar actividad                 
	if (isset($_GET['timeReport']) AND isset($_SESSION['uid'])) {
		$id    = $_SESSION['uid'];
		if ($actualizar = $CONEXION->query("UPDATE usuarios SET fecha = '$ahora' WHERE id = $id")) {
			$msjClase = 'success';
			$msjTxt   = 'Éxito';
			$msjIcon  = 'check';
			$xtras    = $ahora.'1';
			$fallo    = 0;
		}
	}

//    Editar información personal        
	if (isset($_POST['editacliente']) AND isset($_SESSION['uid'])) {
	
		$uid   = $_SESSION['uid'];
		$campo = $_POST['campo'];
		$valor = $_POST['valor'];

		$sql="UPDATE usuarios SET $campo = '$valor' WHERE id = $uid";
		$actualizar = $CONEXION->query($sql);
		$fallo    = 0;
		$msjClase = 'success';
		$msjIcon  = 'check';
		$msjTxt   = 'Guardado';
	}

//    Borrar pedido                      
	if (isset($_POST['borrarpedido'])) {
		$id=$_POST['id'];
		if($actualizar = $CONEXION->query("UPDATE pedidos SET invisible = 1 WHERE id = $id")){
			$fallo        = 0;
			$sendMail     = 1;
			$asuntoCorreo = 'Pedido '.$id.' cancelado';
			$cuerpoCorreo = '<p>Se canceló el pedido: <b>'.$id.'</p>';
		}else{
			$msjTxt.='<br>No se pudo guardar '.$id;
		}
	}

//    Plugin de whatsapp                 
	if (isset($_POST['whatsappHiden'])) {
		$_SESSION['whatsappHiden']=1;
	}
	if (isset($_POST['whatsappShow'])) {
		unset($_SESSION['whatsappHiden']);
	}

//    Agregar a favoritos                
	if (isset($_POST['addtofavorites']) AND isset($_SESSION['uid'])) {

		$uid=$_SESSION['uid'];
		$producto=$_POST['producto'];

		$CONSULTA = $CONEXION -> query("SELECT * FROM favoritos WHERE uid = $uid AND producto = $producto");
		$numCONSULTA=$CONSULTA->num_rows;

		// Si no existe, lo registramos
		if ($numCONSULTA==0) {
			$sql = "INSERT INTO favoritos (uid,producto) VALUES ($uid,$producto)";
			if($insertar = $CONEXION->query($sql)){
				$fallo    = 0;
				$msjClase = 'success';
				$msjIcon  = 'check';
				$msjTxt   = 'Guardado';
				$xtras    = '<i class="fas fa-heart color-blanco"></i>';
			}else{
				$msjTxt   .= '<br>No se pudo guardar';
			}
		}else{
			$row_CONSULTA = $CONSULTA -> fetch_assoc();
			$id=$row_CONSULTA['id'];
			if($borrar = $CONEXION->query("DELETE FROM favoritos WHERE id = $id")){
				$fallo    = 0;
				$msjClase = 'success';
				$msjIcon  = 'check';
				$msjTxt   = 'Guardado';
				$xtras    = '<i class="far fa-heart color-blanco"></i>';
			}else{
				$msjTxt .= '<br>No se pudo guardar';
			}
		}

		echo $msj;
	}

//    Domicilio de entrega 2             
	if (isset($_POST['domicilio2']) AND isset($_SESSION['uid']) AND isset($_SESSION['carro'])) {
		$_SESSION['domicilio2']=$_POST['domicilio2'];
		echo '{ "domicilio2":"'.$_SESSION['domicilio2'].'" }';
	}

//    Obtener talla y color              
	if (isset($_POST['tallaycolor'])) {
		$datosArray = $_POST['datos'];
		$id=$datosArray['id'];

		$CONSULTA = $CONEXION -> query("SELECT * FROM productosexistencias WHERE id = $id");
		$numItems=$CONSULTA->num_rows;
		$rowCONSULTA = $CONSULTA -> fetch_assoc();
		$tallaID=$rowCONSULTA['talla'];
		$colorID=$rowCONSULTA['color'];
		$CONSULTA1 = $CONEXION -> query("SELECT * FROM productostalla WHERE id = $tallaID");
		$rowCONSULTA1 = $CONSULTA1 -> fetch_assoc();
		$talla=$rowCONSULTA1['txt'];
		$CONSULTA2 = $CONEXION -> query("SELECT * FROM productoscolor WHERE id = $colorID");
		$rowCONSULTA2 = $CONSULTA2 -> fetch_assoc();
		$color=$rowCONSULTA2['name'];

		$fallo=1;
		if ($numItems>0) {
			$fallo=0;
			$msjIcon='check';
			$msjClase='success';
			$msjTxt=$color.'-'.$talla;
			$xtras='Talla seleccionada: '.$talla.'<br>Color seleccionado: '.$color;
		}
	}

//    Requiere factura                   
	if (isset($_POST['requierefactura'])) {
		$_SESSION['requierefactura']=$_POST['requierefactura'];
		$xtras=$_SESSION['requierefactura'];
	}

//    Cupones de descuento               
	if (isset($_POST['cuponaplicar'])) {
		$cupon = htmlentities($_POST['cuponaplicar'], ENT_QUOTES);
		$bandera = 0;

		// Comprobar si existe
			$CONSULTA= $CONEXION -> query("SELECT * FROM cupones WHERE codigo = '$cupon'");
			$numCupones=$CONSULTA->num_rows;
			if ($numCupones>0) {
				$bandera = 1;
			}else{
				$msjTxt .= '<br>No existe el cupón';
			}

		// Comprobar vigencia
			if ($bandera==1){
				$rowCONSULTA = $CONSULTA -> fetch_assoc();
				if (strtotime($rowCONSULTA['vigencia'])<strtotime($hoy)){
					$msjTxt .= '<br>No está vigente';
				}else{
					$bandera++;
				}
			}

		// Comprobar estatus
			if ($bandera==2){
				if ($rowCONSULTA['estatus']==0){
					$msjTxt .= '<br>Inactivo';
				}else{
					$bandera++;
					$fallo=0;
				}
			}
		
		// El cupón es válido
			if ($fallo==0) {
				$_SESSION['cupon'] = $cupon;

				$msjClase = 'success';
				$msjIcon  = 'check';
				$msjTxt   = $rowCONSULTA['txt'];
				$xtras    = $rowCONSULTA['descuento'];
			}
	}

//    Subir comprobante                  
	if(isset($_POST['comprobantefile'])){
		$id=$_POST['id'];
		$imagenName=$_POST['comprobantefile'][0];

		$rutaInicial="../library/upload-file/php/uploads/";
		$rutaFinal  ="../img/contenido/comprobantes/";

		// Obtenemos el nombre del archivo
		$i = strrpos($imagenName,'.');
		$l = strlen($imagenName) - $i;
		$ext = strtolower(substr($imagenName,$i+1,$l));

		// Guardar en la base de datos
		// nombre del nevo archivo
		$rand=date('Ymd').rand(111,999);
		$imgFinal=$rand.'.'.$ext;

		// Obtener su imagen anterior
		$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE id = $id");
		$row_CONSULTA = $CONSULTA -> fetch_assoc();
		$imagenSQL=$rutaFinal.$row_CONSULTA['comprobante'];

		// Si la imagen existe, la eliminamos
		if (file_exists($imagenSQL) AND strlen($row_CONSULTA['comprobante'])>0) {
			unlink($imagenSQL);
		}
	
		// Actualizar la base de datos
		if($actualizar = $CONEXION->query("UPDATE pedidos SET comprobante = '$imgFinal' WHERE id = $id")){

			// Comprobamos que el archivo realmente se haya subido
			if(file_exists($rutaInicial.$imagenName)){

				// Lo movemos al directorio final
				$imgAux=$rutaFinal.$imgFinal;
				copy($rutaInicial.$imagenName, $imgAux);
				unlink($rutaInicial.$imagenName);

				$fallo = 0;
			}else{
				$fallo = 3;
			}
		}
	}

//    Cambiar foto de perfil             
	if(isset($_GET['profilepicchange'])){
		$fallo = 0;

		$uid=$_SESSION['uid'];
		$imagenName=$_GET['profilepicchange'];

		$rutaInicial="../library/upload-file/php/uploads/";
		$rutaFinal  ="../img/contenido/profile/";

		// Obtenemos el nombre del archivo
		$i = strrpos($imagenName,'.');
		$l = strlen($imagenName) - $i;
		$ext = strtolower(substr($imagenName,$i+1,$l));

		// Si no es JPG cancelamos
		if ($ext!='jpg' and $ext!='jpeg') {
			$msjTxt= '<br>El archivo debe ser JPG';
			$fallo = 1;
			$ext   = 'jpg';
		}


		// Guardar en la base de datos
		if ($fallo==0) {
			// Guardar en la base de datos
			// nombre del nevo archivo
			$newName=date('Ymd').rand(111,9999999);
			$imgFinal=$newName.'.'.$ext;

			// Obtener su imagen anterior
			$CONSULTA = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $uid");
			$row_CONSULTA = $CONSULTA -> fetch_assoc();
			$imagenSQL=$rutaFinal.$row_CONSULTA['imagen'].'.jpg';

			// Si la imagen existe, la eliminamos
			if (file_exists($imagenSQL) AND strlen($row_CONSULTA['imagen'])>0) {
				unlink($imagenSQL);
			}
		
			// Actualizar la base de datos
			if($actualizar = $CONEXION->query("UPDATE usuarios SET imagen = '$newName' WHERE id = $uid")){
				$estatus='?estatus=Ok';
			}else{
				$estatus='?estatus=Fail';
			}

			// Comprobamos que el archivo realmente se haya subido
			if(file_exists($rutaInicial.$imagenName)){

				// Lo movemos al directorio final
				$imgAux=$rutaFinal.$imgFinal;
				copy($rutaInicial.$imagenName, $imgAux);
				unlink($rutaInicial.$imagenName);


				// Leer el archivo para hacer la nueva imagen
				$original = imagecreatefromjpeg($imgAux);

				// Tomamos las dimensiones de la imagen original
				$ancho  = imagesx($original);
				$alto   = imagesy($original);

				// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
				//  Imagen Final
				// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
				$anchoNew=200;
				$altoNew =200;

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

				// Copiamos el contenido de la original para pegarlo en el archivo New
				$New = imagecreatetruecolor($anchoNew,$altoNew); 

				if(isset($xinicial)){
					imagecopyresampled($New,$original,$xinicial,0,0,0,$anchoProporcional,$altoNew,$ancho,$alto);
				}else{
					imagecopyresampled($New,$original,0,$yinicial,0,0,$anchoNew,$altoProporcional,$ancho,$alto);
				}

				imagejpeg($New,$rutaFinal.$imgFinal,90);

				header('location: ../mi-cuenta'.$estatus);
			}else{
				$msjTxt.='<br>No pudo subirse la imagen';
				$fallo = 1;
			}
		}
	}

//    Envío de correos                   
	if (isset($sendMail) AND $fallo==0) {
		$msjTxt    .= '<br>Entra';
		include 'sendmail.php';
	}

//    Mostrar mensaje                    
	echo '{ "msj":"<div class=\'uk-text-center color-blanco bg-'.$msjClase.' padding-10 text-lg\'><i uk-icon=\'icon:'.$msjIcon.';ratio:2;\'></i> &nbsp; '.$msjTxt.'</div>", "estatus":"'.$fallo.'", "xtras":"'.$xtras.'" '.$estatus.''.$horario.'}';

//    Cerrar conexión y Borrar Error_log         
	mysqli_close($CONEXION);
	if (file_exists('error_log')) {
		unlink('error_log');
	}
