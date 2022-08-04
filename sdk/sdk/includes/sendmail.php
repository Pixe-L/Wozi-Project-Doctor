<?php
	$fallo=1;
	$cuerpo = ' 
		<html>
		<head>
			<meta content="text/html;charset=UTF-8" http-equiv="Content-Type">
			<title>'.$asuntoCorreo.'</title>
		</head>
		<body style="margin:0;padding:0;background-color:'.$mailButton.';">

			<div style="
				width:100%;
				margin-top:0;
				margin-bottom:0;
				">
				<img src="'.$ruta.'img/design/email-header.jpg" style="width:100%;">
			</div>

			<div style="
				max-width:700px;
				width:100%;
				margin-top:0;
				margin-bottom:0;
				margin-right:auto;
				margin-left:auto;
				background-color:white;
				position:relative;
				">

				<!-- Asunto correo -->
				<div style="
					position:absolute;
					top:-100px;
					left:0;
					background-color:white;
					box-sizing: border-box;
					width:100%;
					height:100px;
					text-align:center;
					color:#333;
					font-size:25px;
					padding:20px;
					">
					'.$asuntoCorreo.'
				</div><!-- Asunto correo -->

				<!-- Cuerpo del correo -->
				<div style="
					box-sizing: border-box;
					width:100%;
					text-align:center;
					color:#333;
					font-size:18px;
					padding:20px;
					">
					'.$cuerpoCorreo.'
				</div><!-- Cuerpo del correo -->

				<!-- Fecha -->
				<div style="
					position:absolute;
					bottom:-100px;
					left:0;
					background-color:white;
					box-sizing: border-box;
					width:100%;
					height:100px;
					text-align:center;
					color:#333;
					font-size:15px;
					padding:20px;
					">
					'.fechaDisplay($hoy).'
				</div><!-- Fecha -->

			</div>

			<div style="
				width:100%;
				background-color:'.$mailBGcolor.';
				margin-top:0;
				margin-bottom:0;
				">
				<div style="
					padding-top:200px;
					padding-bottom:20px;
					padding-left:20px;
					padding-right:20px;
					text-align:center;
					color:white;
					">
					<a href="'.$ruta.'"><img src="'.$logo.'" style="height: 100px;"></a>
					<br /><br />
					<a href="'.$ruta.'" style="color:white;">www.'.$dominio.'</a>
					<br /><br />
					Tel: '.$telefonoSeparado1.'
					<br /><br/>
					<a href="'.$socialInst.'">
						<img src="https://img.icons8.com/color/64/000000/instagram-new.png">
					</a>
					<a href="'.$socialFace.'">
						<img src="https://img.icons8.com/color/64/000000/facebook.png">
					</a>
				</div>
				<div style="padding:20px;">
					&nbsp;
				</div>
			</div>

		</body>
		</html>
	'; 


	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	if(file_exists('library/phpmailer/src/Exception.php')){
		require 'library/phpmailer/src/Exception.php';
		require 'library/phpmailer/src/PHPMailer.php';
		require 'library/phpmailer/src/SMTP.php';
		$fallo=0;
	}elseif(file_exists('../library/phpmailer/src/Exception.php')){
		require '../library/phpmailer/src/Exception.php';
		require '../library/phpmailer/src/PHPMailer.php';
		require '../library/phpmailer/src/SMTP.php';
		$fallo=0;
	}else{
		$msjTxt.="<br>No se encontro PHPmailer";
	}

	// Envío
	if($fallo==0){
		$fallo=1;
		$mail = new PHPMailer(true);
		try {
			$mail->SMTPDebug  = 0;
			$mail->isSMTP();
			$mail->Host       = $Remitentehost;
			$mail->SMTPAuth   = true;
			$mail->Username   = $RemitenteMail;
			$mail->Password   = $Remitentepass;
			$mail->SMTPSecure = $Remitenteseguridad;
			$mail->Port       = $Remitenteport;

			$mail->setFrom($RemitenteMail, $Brand);

			$mail->isHTML(true);
			$mail->Subject = $asuntoCorreo;
			$mail->Body    = $cuerpo;
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			if ($debug==1) {
				//Set an alternative reply-to address
				$mail->addAddress($efra, 'Efra');
				$xtras=$efra;
				$fallo=0;
			}elseif (isset($send2user) AND $send2user==1) {
				//Set an alternative reply-to address
				$mail->addAddress($email, $nombre);
				$mail->AddBCC($destinatario1, $Brand);
				$xtras=$destinatario1.' y '.$email;
				if (strlen($destinatario2)>0) {
					$mail->AddBCC($destinatario2, $Brand);
					$xtras.=' y '.$destinatario2;
				}
				
				$fallo=0;
			}elseif (isset($send2user) AND $send2user==2) {
				//Set an alternative reply-to address
				$mail->addAddress($email, $nombre);
				$xtras=$email;
				$fallo=0;
			}else{
				//Set an alternative reply-to address
				$mail->addAddress($destinatario1, $Brand);
				$xtras=$destinatario1;
				if (strlen($destinatario2)>0) {
					$mail->AddBCC($destinatario2, $Brand);
					$xtras.='y '.$destinatario2;
				}
				
				$fallo=0;
			}
			if($mail->Send()){
					$fallo=0;
					$msjIcon  = 'check';
					$msjClase = 'success';
					$msjTxt   = 'Enviado';
			}else{
				$msjTxt.="<br>No se pudo enviar<br>Codigo: 12<br>Brand: $Brand <br>Dominio: $dominio <br>Remitente: $RemitenteMail";
			}


		} catch (Exception $e) {
			$msjTxt.= "<br>Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
