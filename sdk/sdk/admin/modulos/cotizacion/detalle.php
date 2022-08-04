<?php
	$CONSULTA = $CONEXION -> query("SELECT * FROM cotizacion WHERE id = $id");
	$row_CONSULTA = $CONSULTA -> fetch_assoc();
	foreach ($row_CONSULTA as $key => $value) {
		if ($key!='id' AND $key!='estatus') {
			${$key}=$value;
		}
	}

	$CONSULTA0 = $CONEXION -> query("SELECT * FROM user WHERE id = $ejecutivo");
	$row_CONSULTA0 = $CONSULTA0 -> fetch_assoc();
	$ejecutivoName = $row_CONSULTA0['user'];

	$CONSULTA1 = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $cliente");
	$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
	$email=$row_CONSULTA1['email'];
	$nombre=$row_CONSULTA1['nombre'];

	$level=$row_CONSULTA['estatus']+1;
	switch ($level) {
		case 2:
			$clase='uk-button-primary';
			$estatus='Pagado';
			break;
		case 3:
			$clase='uk-button-warning';
			$estatus='Enviado';
			break;
		case 4:
			$clase='uk-button-success';
			$estatus='Entregado';
			break;
		default:
			$clase='uk-button-white';
			$estatus='Registrado';
			break;
	}

echo '
	<div uk-grid>
		<div class="margin-top-20">
			<ul class="uk-breadcrumb">
				<li><a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'">Cotizaciones</a></li>
				<li><a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'&archivo='.$archivo.'" class="color-red">Detalle</a></li>
			</ul>
		</div>

		<div class="uk-width-expand@m uk-text-right uk-margin">
			<a class="uk-button uk-button-white uk-button-large" href="../'.$row_CONSULTA['id'].'_revisar.pdf" target="_blank"><i class="far fa-2x fa-file-pdf"></i> &nbsp; Ver PDF</a>
			<button class="estatus '.$clase.' uk-button-large text-gnrl uk-text-uppercase" data-estatus="'.$level.'" data-id="'.$row_CONSULTA['id'].'">'.$estatus.'</button>&nbsp;';
		if (strlen($comprobante)>0 and file_exists('../img/contenido/comprobantes/'.$row_CONSULTA['comprobante'])) {
			echo '
			<a href="../img/contenido/comprobantes/'.$comprobante.'" class="uk-button uk-button-large uk-button-white" target="_blank">Comprobante de pago</a>';
		}
		echo'
		</div>
	</div>

	';


echo '
	<div class="uk-container uk-container-small">
		<!-- Encabezado -->
		    <table style="width:100%" cellspacing="0" cellpadding="5px" border="0">
		        <tr>
		            <td style="width:25%;" valign="middle">
		                <img src="../img/design/logo'.$formato.'.jpg" style="width:180px;">
		            </td>
		            <td style="width:75%;text-align:center;" valign="middle">
		                <span style="font-size:17px;font-weight:900;">'.$razonSocial.'</span><br>
		                '.nl2br($encabezado).'
		            </td>
		            <td style="width:180px">
		            </td>
		        </tr>
		    </table>
		    
		    <div style="height:50px;">
		    </div>

		<!-- Datos del cliente -->
		    <table style="width:100%;" cellspacing="0" cellpadding="5px" border="0">
		        <tr>
		            <td style="width:75%;background-color:#99FF99;">
		                <div style="padding:5px;">
		                    <span style="font-size:15px;font-weight:700;">Para:</span>
		                </div>
		            </td>
		            <td style="width:25%;background-color:#99FF99;">
		                <div style="padding:5px;">
		                    <span style="font-size:15px;font-weight:700;">Cotización:</span>
		                </div>
		            </td>
		        </tr>
		    </table>

		    <table style="width:100%;border-color:grey;" cellspacing="0" cellpadding="5px" border="1">
		        <tr>
		            <td style="width:478px;">
		                &nbsp;'.$cliente.' - '.$empresa.'<br>
		                &nbsp;<span style="text-transform: uppercase;">'.$rfc.'</span>
		            </td>
		            <td style="width:180px;" rowspan="4">
		                <table class="uk-table uk-table-small" style="width:100%;" cellspacing="0" cellpadding="0" border="0">

		                    <tr>
		                        <td style="width:100%;text-align:center;" colspan="2">
		                            <span style="color:#666;">No. de cliente:</span>
		                            <span style="font-weight:700">'.$cliente.'</span>
		                        </td>
		                    </tr>
		                    <tr>
		                        <td style="width:100%;text-align:center;color:#666;" colspan="2">
		                            Condiciones de pago
		                        </td>
		                    </tr>
		                    <tr>
		                        <td style="width:180px;text-align:center;" colspan="2">
		                            '.$condiciones_pago.'
		                        </td>
		                    </tr>
		                    <tr>
		                        <td style="width:70px;color:#666;text-align:right;">
		                            Folio:
		                        </td>
		                        <td style="width:110px">
		                            <span style="font-weight:700">'.$id.'/'.fechaYear($fecha).'</span>
		                        </td>
		                    </tr>
		                    <tr>
		                        <td style="width:70px;color:#666;text-align:right;">
		                            Fecha:
		                        </td>
		                        <td style="width:110px">
		                            <span style="font-weight:700">'.fechaCorta($fecha).'</span>
		                        </td>
		                    </tr>
		                    <tr>
		                        <td style="width:70px;color:#666;text-align:right;">
		                            Plazo:
		                        </td>
		                        <td style="width:110px">
		                            '.$plazo.'
		                        </td>
		                    </tr>
		                    <tr>
		                        <td style="width:70px;color:#666;text-align:right;">
		                            Vigencia:
		                        </td>
		                        <td style="width:110px">
		                            '.$vigencia.'
		                        </td>
		                    </tr>
		                    <tr>
		                        <td style="width:70px;color:#666;text-align:right;">
		                            Agente:
		                        </td>
		                        <td style="width:110px">
		                            <span style="font-weight:700">'.$ejecutivoName.'</span>
		                        </td>
		                    </tr>

		                </table>
		            </td>
		        </tr>
		        <tr>
		            <td>
		                <table style="width:100%;">
		                    <tr>
		                        <td colspan="2">
		                            '.$domicilio.'
		                        </td>
		                    </tr>
		                    <tr>
		                        <td style="">
		                            Atención: <span style="font-weight:700;">'.$nombre.'</span>
		                        </td>
		                        <td style="text-align:right;">
		                            Teléfono: <span style="font-weight:700;">'.$telefono.' / '.$telefono2.'</span>
		                        </td>
		                    </tr>
		                </table>
		            </td>
		        </tr>
		        <tr>
		            <td style="background-color:#99FF99;">
		                <span style="font-size:15px;font-weight:700;">Entregar en:</span>
		            </td>
		        </tr>
		        <tr>
		            <td>
		                '.$entrega.'
		            </td>
		        </tr>
		    </table>

		<!-- Información de productos -->
		    <div style="padding-bottom:50px;padding-top:50px;">
		        '.$tablabody.'
		    </div>

		    <div style="background-color:#99FF99;border: solid grey 2px;font-weight:700;width:100%;">
		    	<div class="padding-10">
		        	Observaciones
		        </div>
		    </div>
		    <div style="border-left: solid grey 2px;border-right: solid grey 2px;border-bottom: solid grey 2px;width:100%;padding-top:10px;padding-bottom:10px;">
		    	<div class="padding-10">
		        	'.nl2br($txt1).'
		        </div>
		    </div>
		    <div style="height:20px;">
		    	<div class="padding-10">
		    	</div>
		    </div>
		    <div style="border-top: solid grey 2px;border-bottom: solid grey 2px;width:100%;padding-top:10px;padding-bottom:10px;">
		    	<div class="padding-10">
		        	'.nl2br($txt2).'
		        </div>
		    </div>
		    <div style="border-bottom: solid grey 2px;width:100%;padding-top:10px;padding-bottom:10px;font-weight:700;">
		    	<div class="padding-10">
		        	'.nl2br($txt3).'
		        </div>
		    </div>
		    <div style="border-bottom: solid grey 2px;width:100%;padding-top:10px;padding-bottom:10px;">
		    	<div class="padding-10">
		        	'.nl2br($txt4).'
		        </div>
		    </div>
		    <div style="border-bottom: solid grey 2px;width:100%;padding-top:10px;padding-bottom:10px;">
		    	<div class="padding-10">
		        	'.nl2br($txt5).'
		        </div>
		    </div>
	</div>';



$scripts='
$(function(){
	$(".estatus").click(function(){

		var id = $(this).data("id");
		var estatus = $(this).attr("data-estatus");

		switch(estatus) {
			case "1":
				estatus=2;
				$(this).removeClass("uk-button-white");
				$(this).addClass("uk-button-primary");
				$(this).text("Pagado");
				break;
			case "2":
				estatus=3;
				$(this).removeClass("uk-button-primary");
				$(this).addClass("uk-button-warning");
				$(this).text("Enviado");
				break;
			case "3":
				estatus=4;
				$(this).removeClass("uk-button-warning");
				$(this).addClass("uk-button-success");
				$(this).text("Entregado");
				break;
			default:
				estatus=1;
				$(this).removeClass("uk-button-success");
				$(this).text("Registrado");
				break;
		}

		$(this).attr("data-estatus",estatus);

		$.ajax({
			method: "POST",
			url: "modulos/cotizacion/acciones.php",
			data: { 
				nivelestatus: (estatus),
				id: id 
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
		});
		console.log(estatus+\' - \'+id);

	});
})
';
