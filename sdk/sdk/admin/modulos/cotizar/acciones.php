<?php 
	date_default_timezone_set('America/Mexico_City');
	$fecha=date('Y-m-d');


//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar pedido 
	if(isset($_REQUEST['borrarPedido'])){
		if($borrar = $CONEXION->query("DELETE FROM pedidos WHERE id = $id"))
		{
			$exito='success';
			$legendSuccess.="<br>Pedido eliminado";
		}else{
			$fallo='danger';  
			$legendFail.="<br>No se pudo eliminar";
		}
	} 

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Estatus 
	if (isset($_POST['estatuschange'])) {
		include '../../../includes/connection.php';

		$id = $_POST['id'];
		$estatus = $_POST['estatus'];

		if($actualizar = $CONEXION->query("UPDATE pedidos SET estatus = $estatus WHERE id = $id")){
			echo '<div class="uk-text-center uk-text-success"><span uk-icon="icon:check;ratio:1.5;"></span> Guardado</div>';
		}else{
			echo '<div class="uk-text-center uk-text-danger"><span uk-icon="icon:ban;ratio:1.5;"></span> Error<br>'.$id.'<br>'.$nivel.'</div>';
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Guia 
	if (isset($_POST['guia'])) {
		include '../../../includes/connection.php';

		$id = $_POST['id'];
		$guia = $_POST['guia'];

		if($actualizar = $CONEXION->query("UPDATE pedidos SET guia = '$guia' WHERE id = $id")){
			echo '<div class="uk-text-center uk-text-success"><span uk-icon="icon:check;ratio:1.5;"></span> Guardado</div>';
		}else{
			echo '<div class="uk-text-center uk-text-danger"><span uk-icon="icon:ban;ratio:1.5;"></span> Error<br>'.$id.'<br>'.$guia.'</div>';
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Reenvio de orden
	if (isset($_POST['enviarcorreo'])) {
		$enviarcorreo=$_POST['enviarcorreo'];
		$thisid=$_POST['id'];

		$mensaje='<div class="uk-text-center uk-text-danger padding-10 text-lg">';

		$rutaConnection	= "../../../includes/connection.php";
		require $rutaConnection;

		$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE id = $thisid");
		$row_CONSULTA = $CONSULTA -> fetch_assoc();

		$userId=$row_CONSULTA['uid'];
		$ejecutivo=$row_CONSULTA['ejecutivo'];

		$CONSULTACLIENTE = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $userId");
		$row_CONSULTACLIENTE = $CONSULTACLIENTE -> fetch_assoc();

		$CONSULTAEJECUTIVO = $CONEXION -> query("SELECT * FROM user WHERE id = $ejecutivo");
		$row_CONSULTAEJECUTIVO = $CONSULTAEJECUTIVO -> fetch_assoc();

		switch ($enviarcorreo) {
			case 1:
				$asunto = 'Orden No. '.$thisid.' enviada'; 
				$comentarios = '
					Estimado <b>'.$row_CONSULTA1['nombre'].'</b><br><br>
					La orden <b>'.$thisid.'</b> ha sido enviada<br><br>
					Su n&uacute;mero de gu&iacute;a es el <b>'.$row_CONSULTA['guia'].'</b><br><br>
					Si desea ver su pedido puede hacerlo en el suiguiente enlace:<br><br><br><br><br>
					<a href="'.$ruta.'../../../mi-cuenta" style="background-color:'.$mailButton.';font-weight:700;border-radius:8px;padding-left:30px;padding-right:30px;padding-top:10px;padding-bottom:10px;color:white;text-decoration:none;">Mi cuenta</a><br><br><br><br>
					o copie y pegue este enlace: <br>
					<a href="'.$ruta.'../../../mi-cuenta">'.$ruta.'../../../mi-cuenta</a><br><br>
					Saludos cordiales.';
				break;
			case 2:
				$asunto = 'Cotizacion No. '.$thisid; 
				$num=1;
				$style[0]='style="background-color:#EEEEEE;"';
				$style[1]='style="background-color:#FFF;"';

				$CONSULTA0 = $CONEXION -> query("SELECT * FROM pedidos WHERE id = $thisid");
				$row_CONSULTA0 = $CONSULTA0 -> fetch_assoc();
				$total=$row_CONSULTA0['importe'];
				$subtotal=$total/1.16;
				$iva=$total-$subtotal;
				mysqli_free_result($CONSULTA0);

				$comentarios = '
					<p><b>'.$row_CONSULTA1['nombre'].'</b></p>
					<p>Tenemos registrada una solicitud de cotizaci&oacute;n para usted.</p>
					<p>El resultado de nuestro an&aacute;lisis de costos nos arroja un importe de <b>$'.number_format($row_CONSULTA['importe'],2).'</b></p>
					
					<table style="width:100%" cellspacing="0" border="0">
					  <tr '.$style[0].'>
					    <td style="padding:8px;width:40%">Producto</td>
					    <td style="padding:8px;width:20%;text-align:center;">Cantidad</td>
					    <td style="padding:8px;width:20%;text-align:right;">Precio</td>
					    <td style="padding:8px;width:20%;text-align:right;">Importe</td>
					  </tr>';

					$CONSULTA1 = $CONEXION -> query("SELECT * FROM pedidosdetalle WHERE pedido = $thisid");
					while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){

						$comentarios .= '
					  <tr '.$style[$num].'>
					    <td style="padding: 8px; text-align: left; ">
					      '.$row_CONSULTA1['productotxt'].'
					    </td>
					    <td style="padding: 8px;text-align:center">
					      '.$row_CONSULTA1['cantidad'].'
					    </td>
					    <td style="padding: 8px;text-align:right">
					      '.number_format($row_CONSULTA1['precio'],2).'
					    </td>
					    <td style="padding: 8px;text-align:right">
					      '.number_format($row_CONSULTA1['importe'],2).'
					    </td>
					  </tr>';
					  $num=($num==0)?1:0;
					}
					
					mysqli_free_result($CONSULTA1);

				    $comentarios.='
					  <tr '.$style[$num].'>
						<td colspan="3" style="padding: 8px;text-align:right;">
						  Subtotal
						</td>
						<td style="padding: 8px;text-align:right;">
						  '.number_format($subtotal,2).'
						</td>
					  </tr>';
				    $num=($num==0)?1:0;
				    $comentarios.='
					  <tr '.$style[$num].'>
						<td colspan="3" style="padding: 8px;text-align:right;">
						  IVA
						</td>
						<td style="padding: 8px;text-align:right;">
						  '.number_format($iva,2).'
						</td>
					  </tr>';
				    $num=($num==0)?1:0;
				    $comentarios.='
					  <tr '.$style[$num].'>
						<td colspan="3" style="padding: 8px;text-align:right;">
						  Total
						</td>
						<td style="padding: 8px;text-align:right;">
						  '.number_format($total,2).'
						</td>
					  </tr>
					</table>';
				$comentarios .= '
					<p><br>Si desea ver la versi&oacute;n PDF puede hacerlo en el suiguiente enlace:</p>
					<p><a href="'.$ruta.'../../../mi-cuenta" style="background-color:'.$mailButton.';font-weight:700;border-radius:8px;padding-left:30px;padding-right:30px;padding-top:10px;padding-bottom:10px;color:white;text-decoration:none;">Mi cuenta</a></p>
					<p>o copie y pegue este enlace:</p>
					<p><a href="'.$ruta.'../../../mi-cuenta">'.$ruta.'../../../mi-cuenta</a></p>
					<p>Saludos cordiales.</p>';
				break;
			case 3:
				$asunto = 'Orden No. '.$thisid.' cancelada'; 
				$comentarios = '
					Estimado <b>'.$row_CONSULTA1['nombre'].'</b><br><br>
					La orden <b>'.$thisid.'</b> ha sido cancelada.<br><br>
					En caso de desear adquirir los productos solicitados deber&aacute; levantar una nueva orden.<br><br>
					Si desea ver sus pedidos puede hacerlo en el suiguiente enlace:<br><br><br><br>
					<a href="'.$ruta.'../../../mi-cuenta" style="background-color:'.$mailButton.';font-weight:700;border-radius:8px;padding-left:30px;padding-right:30px;padding-top:10px;padding-bottom:10px;color:white;text-decoration:none;">Mi cuenta</a><br><br><br><br>
					o copie y pegue este enlace: <br>
					<a href="'.$ruta.'../../../mi-cuenta">'.$ruta.'../../../mi-cuenta</a><br><br>
					Saludos cordiales.';
				break;
		}

	//%%%%%%%%%%%%%%%%%%%%%%%%%%    Cuerpo del correo
	$logoMail=$ruta.'../../../img/design/logo-mail.png';
	$cuerpo = ' 
		<html> 
			<head> 
				<meta content="text/html;charset=UTF-8" http-equiv="Content-Type">
				<title>'.$asunto.'</title> 
			</head> 
			<body> 
				<div style="background-color:'.$mailBGcolor.';width:100%;padding-top:40px;padding-bottom:40px;">
					<div style="background-color:white;color:#333;width:730px;margin-left:auto;margin-right:auto;padding-top:30px;padding-bottom:30px;padding-left:30px;">
						<div style="padding:20px;font-size:20px;font-weight:700;">
							'.$asunto.'
						</div>
						<div style="padding:20px;">
							'.$comentarios.'
						</div>
					</div>
					<div style="padding:20px;text-align:center;">
						<img src="'.$logoMail.'" style="width:100px;">
						<br><br>
					</div>
				</div>
			</body> 
		</html> 
		';


	// Envío con PHPMailer
		if(file_exists('../../../library/phpmailer/class.phpmailer.php')){
			require '../../../library/phpmailer/class.phpmailer.php';
			require '../../../library/phpmailer/class.smtp.php';
		}elseif(file_exists('../library/phpmailer/class.phpmailer.php')){
			require '../../../../library/phpmailer/class.phpmailer.php';
			require '../../../../library/phpmailer/class.smtp.php';
		}else{
			$fallo=1;
			$mensaje.="<br>Code 00 - No se encontro PHPmailer - :(";
		}

		// Envío
		if($fallo==0){
			//Create a new PHPMailer instance
			$mail = new PHPMailer;
			//Debug SMTP
			$mail->SMTPDebug = 0;
			//SMTP SECURE
			$mail->SMTPSecure = 'ssl';
			//Set who the message is to be sent from
			$mail->setFrom($row_CONSULTAEJECUTIVO['email'], $Brand);
			//Set an alternative reply-to address
			//$mail->addReplyTo($destinatario1, $Brand);
			//$mail->addReplyTo($email, $nombre);

			$mail->AddAddress($row_CONSULTACLIENTE['email'],$row_CONSULTACLIENTE['nombre']);
			$mail->AddAddress($row_CONSULTAEJECUTIVO['email'],$row_CONSULTAEJECUTIVO['user']);

			//CONTENT HTML & UTF-8
			$mail->IsHTML(true);
			$mail->CharSet = 'UTF-8';
			//Set the subject line
			$mail->Subject = $asunto;
			//CONTENT BODY
			$body = $cuerpo;
			//CONVER HTML BODY
			$mail->MsgHTML($body);
			//BODY MAIL
			$mail->Body = $body;
			//send the message, check for errors
			if($mail->Send()){
				$mensaje="<div class='bg-success colo-blanco'><i class='fa fa-check'></i> Correo enviado";
			}else{
				$mensaje.="<br>No se pudo enviar<br>Codigo: 12<br>Brand: $Brand <br>Dominio: $dominio <br>Remitente: $RemitenteMail <br>Cliente: $nombre";
			}
		}
		$mensaje.='</div>';

		echo $mensaje;
	}


	if (file_exists('error_log')) {
		unlink('error_log');
	}

