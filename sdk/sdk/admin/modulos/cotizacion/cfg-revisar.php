<?php
$num2words='../library/numerosaletras/DeNumero_a_Letras.php';
if (file_exists($num2words)) {
	require $num2words;
}elseif ('../'.$num2words) {
	require '../'.$num2words;
}

$consultaEjecutivo = $CONEXION->query("SELECT * FROM user WHERE id = '$uid'");
$row_consultaEjecutivo = $consultaEjecutivo->fetch_assoc();
$uName=$row_consultaEjecutivo['user'];

if (isset($_SESSION['clienteid'])) {
	$clienteid=$_SESSION['clienteid'];
}else{
	echo '<div class="uk-height-viewport uk-text-danger text-xl uk-text-center"><div style="padding-top:200px;">Debe definir un cliente</div></div>';
	$scripts.='
		setTimeout(function(){ window.location = ("index.php?rand=20294&modulo=cotizacion&archivo=cfg-cliente"); },1000);';
}

if(!isset($_POST['formato'])){
	$scripts.='
		setTimeout(function(){ window.location = ("index.php?rand='.rand(1,99999).'&modulo=cotizacion&archivo=cfg-cliente"); },1000);';
}

if(isset($_POST['formato'])){      $formato   = ($_POST['formato']);      }else{  $formato   = false; }
if(isset($_POST['masiva'])){       $masiva    = ($_POST['masiva']);       }else{  $masiva    = false; }
if(isset($_POST['tipocambio'])){   $tipocambio= ($_POST['tipocambio']);   }else{  $tipocambio= 0; }
if(isset($_POST['moneda']) AND $_POST['moneda']==0){
	$moneda = $_POST['moneda'];
	$monedaTxt = 'MXN';
}else{
	$moneda = 1;
	$monedaTxt = 'USD';
}

$total=0;
$granTotal=0;
$num=0;
$numprods=0;



//var_dump($_SESSION['carro']);
if(isset($_SESSION['carro'])){
$_SESSION['tablaBody']='
	<table style="width:100%;" cellspacing="0" cellpadding="5px" >
		<tr>
			<td style="width:40%;background-color:#99FF99;font-weight:700;border-bottom: solid grey 3px;">Producto</td>
			<td style="width:15%;background-color:#99FF99;font-weight:700;border-bottom: solid grey 3px;text-align:center;white-space: nowrap;">Dimensiones / Cantidad</td>
			<td style="width:15%;background-color:#99FF99;font-weight:700;border-bottom: solid grey 3px;text-align:center;">Unidad</td>
			<td style="width:15%;background-color:#99FF99;font-weight:700;border-bottom: solid grey 3px;text-align:right;">Precio</td>
			<td style="width:15%;background-color:#99FF99;font-weight:700;border-bottom: solid grey 3px;text-align:right;">Importe</td>
		</tr>';

	$datos=$_SESSION['carro'];
	foreach ($arreglo as $key1) {
		foreach ($key1 as $key2) {
			$precio=($monedaTxt=='USD')?$key2['Precio']/$tipocambio:$key2['Precio'];
			$numprods++;

			if (isset($fotosStr)) {
				$fotosStr.=','.$key2['Id'];
			}else{
				$fotosStr=$key2['Id'];
			}

			$len=strlen($key2['Nombre']);
			if ($len>20) {
				$cadena1=substr(html_entity_decode($key2['Nombre']), 0,20);
			}else{
				$cadena1=$key2['Nombre'];
			}
			$bgTable=($num==0)?'background:#fff;':'background:#eee;';

			if ($key2['Cantidad']!=0) {
				$importe=$key2['Cantidad']*$precio;
				$total+=$importe;
				$_SESSION['tablaBody'].='
				<tr style="'.$bgTable.'">
					<td >'.$key2['Nombre'].'</td>
					<td style="width:100px; text-align:center;">'.$key2['Cantidad'].'</td>
					<td style="width:100px; text-align:center;">'.$key2['Unidad'].'</td>
					<td style="width:100px; text-align:right;">'.number_format($precio,2).'</td>
					<td style="width:100px; text-align:right;">'.number_format($importe,2).'</td>
				</tr>';
			}else{
				$importe=($key2['Ladoa']*$key2['Ladob'])*$precio;
				$total+=$importe;
				$_SESSION['tablaBody'].='
				<tr style="'.$bgTable.'">
					<td >'.$key2['Nombre'].'</td>
					<td style="width:100px; text-align:center;">'.$key2['Ladoa'].' x '.$key2['Ladob'].' = '.($key2['Ladoa']*$key2['Ladob']).'</td>
					<td style="width:100px; text-align:center;">'.$key2['Unidad'].'</td>
					<td style="width:100px; text-align:right;">'.number_format($precio,2).'</td>
					<td style="width:100px; text-align:right;">'.number_format($importe,2).'</td>
				</tr>';
			}
			$num++;
			if ($num==2) {
				$num=0;
			}
		}
	}

	if ($masiva==1) {
		$iva=$total*$taxIVA;
		$granTotal=$total*($taxIVA+1);
		$granTotalEntero=intval($granTotal);
		$decimales=number_format((100*($granTotal-$granTotalEntero)),0);

		$_SESSION['tablaBody'] .= '
		<tr>
			<td style=""></td>
			<td style="" class="uk-text-center"></td>
			<td style="" class="uk-text-center"></td>
			<td style="text-align:right;">Subtotal:</td>
			<td style="text-align:right;">'.number_format($total,2).'</td>
		</tr>
		<tr>
			<td style=""></td>
			<td style="" class="uk-text-center"></td>
			<td style="" class="uk-text-center"></td>
			<td style="text-align:right;">IVA:</td>
			<td style="text-align:right;">'.number_format($iva,2).'</td>
		</tr>
		<tr>
			<td style="background-color:#99FF99;border-bottom: solid grey 2px;font-weight:700;font-style:italic;" colspan="2">Importe con letra</td>
			<td style="" class="uk-text-center"></td>
			<td style="text-align:right;">Total:</td>
			<td style="text-align:right;">'.number_format($granTotal,2).'</td>
		</tr>
		<tr>
			<td colspan="5">
				'.num2letras($granTotalEntero).' '.$decimales.'/100 '.$monedaTxt.'
			</td>
		</tr>
		';
	}else{
		$iva=0;
		$granTotal=$total;
		$granTotalEntero=intval($granTotal);
		$decimales=number_format((100*($granTotal-$granTotalEntero)),0);

		$_SESSION['tablaBody'] .= '
		<tr>
			<td style="background-color:#99FF99;border-bottom: solid grey 2px;font-weight:700;font-style:italic;" colspan="2">Importe con letra</td>
			<td style="" class="uk-text-center"></td>
			<td style="text-align:right;">Total:</td>
			<td style="text-align:right;">'.number_format($total,2).'</td>
		</tr>
		<tr>
			<td colspan="5">
				'.num2letras($granTotalEntero).' '.$decimales.'/100 '.$monedaTxt.'
			</td>
		</tr>
		';
	}
	$_SESSION['tablaBody'] .= '
	</table>';


}else{
	$scripts.='
		setTimeout(function(){ window.location = ("index.php?rand=20294&modulo=cotizacion&archivo=cfg-cliente"); },1000);';
}

$fecha=date('Y-m-d');
$fechaY=date('Y');
$fechaM=date('m')*1;
$fechaD=date('d');

switch ($fechaM) {
	case 1:
	$mes='enero';
	break;
	
	case 2:
	$mes='febrero';
	break;
	
	case 3:
	$mes='marzo';
	break;
	
	case 4:
	$mes='abril';
	break;
	
	case 5:
	$mes='mayo';
	break;
	
	case 6:
	$mes='junio';
	break;
	
	case 7:
	$mes='julio';
	break;
	
	case 8:
	$mes='agosto';
	break;
	
	case 9:
	$mes='septiembre';
	break;
	
	case 10:
	$mes='octubre';
	break;
	
	case 11:
	$mes='noviembre';
	break;
	
	default:
	$mes='diciembre';
	break;
}

$fechaDisplay=$fechaD.' de '.$mes.' de '.$fechaY;


$CONSULTA0 = $CONEXION -> query("SELECT * FROM cotizacion ORDER BY id DESC");
$row_CONSULTA0 = $CONSULTA0 -> fetch_assoc();
$numCot=($row_CONSULTA0['id']<9)?'0'.($row_CONSULTA0['id']+1):$row_CONSULTA0['id']+1;

$CONSULTA1 = $CONEXION -> query("SELECT * FROM cotizacion_config WHERE id = 1");
$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();

$CONSULTA2 = $CONEXION -> query("SELECT * FROM usuarios WHERE id = '$clienteid'");
$row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();


$razonSocial=($formato==0)?'INVECO S.A. DE C.V.':'INVECO CENTRO SA DE CV';
$header1=($formato==0)?'':'';
$header2=($formato==0)?'':'';


echo '
	<div class="margin-top-20">
		<ul class="uk-breadcrumb">
			<li><a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'">Cotizaciones</a></li>
			<li><a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'&archivo=cfg-cliente">Configurar cliente</a></li>
			<li><a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'&archivo=cfg-productos">Configurar productos</a></li>
			<li><a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'&archivo=cfg-revisar" class="color-red">Revisar</a></li>
		</ul>
	</div>
	<div class="margin-top-20 uk-text-center">
		<h6 class="text-center margin-bottom-50">Revise con cuidado la información mostrada a continuación.</h6>
	</div>

	<div class="uk-container uk-container-small">
		<div class="uk-width-1-1">
			<form action="index.php" method="post" name="form" onsubmit="return checkForm(this);">
				<input type="hidden" name="modulo" value="'.$modulo.'">
				<input type="hidden" name="archivo" value="inicio">
				<input type="hidden" name="nuevacotizacion" value="1">
				<input type="hidden" name="clienteid" value="'.$clienteid.'">
				<input type="hidden" name="formato" value="'.$formato.'">
				<input type="hidden" name="masiva"  value="'.$masiva.'">
				<input type="hidden" name="moneda"  value="'.$moneda.'">
				<input type="hidden" name="numprods"  value="'.$numprods.'">
				<input type="hidden" name="importe"  value="'.$granTotal.'">
				
				<!-- Encabezado -->
				<table style="width:100%;" cellspacing="0" cellpadding="5px" border="0">
					<tr>
						<td style="width:20%" valign="middle">
							<img src="../img/design/logo'.$formato.'.jpg" style="width:100%">
						</td>
						<td style="width:60%;text-align:center;" valign="middle">
							<span style="font-size:25px;font-weight:700;">'.$razonSocial.'</span>
							<textarea class="uk-textarea uk-text-center" style="height:150px;" name="encabezado">'.$row_CONSULTA1['encabezado'].'</textarea>
						</td>
						<td style="width:20%">
						</td>
					</tr>
				</table>

				<!-- Datos del cliente -->
				<table style="width:100%;" cellspacing="0" cellpadding="5px" border="0">
					<tr>
						<td style="width:75%;background-color:#99FF99;">
							<span style="font-size:20px;font-weight:700;">Para:</span>
						</td>
						<td style="width:25%;background-color:#99FF99;">
							<span style="font-size:20px;font-weight:700;">Cotización:</span>
						</td>
					</tr>
				</table>
				<table style="width:100%;border-color:grey;" cellspacing="0" cellpadding="5px" border="1">
					<tr>
						<td style="width:75%;">
							<span>'.$clienteid.' - '.$row_CONSULTA2['empresa'].'</span><br>
							<span style="text-transform: uppercase;">'.$row_CONSULTA2['rfc'].'</span>
						</td>
						<td style="width:25%;" rowspan="4">
							<table style="width:100%;" cellspacing="0" cellpadding="0" border="0">
								<tr>
									<td style="width:40%">
										Folio:
									</td>
									<td style="width:60%">
										<span style="font-weight:700">'.$numCot.'/'.$fechaY.'</span>
									</td>
								</tr>
								<tr>
									<td style="width:40%">
										Fecha:
									</td>
									<td style="width:60%">
										<span style="font-weight:700">'.$fecha.'</span>
									</td>
								</tr>
								<tr>
									<td style="width:40%">
										No. de cliente:
									</td>
									<td style="width:60%">
										<span style="font-weight:700">'.$clienteid.'</span>
									</td>
								</tr>
								<tr>
									<td style="width:40%">
										Plazo:
									</td>
									<td style="width:60%">
										<input type="text" class="uk-input uk-form-small" name="plazo" autofocus>
									</td>
								</tr>
								<tr>
									<td style="width:40%">
										Vigencia:
									</td>
									<td style="width:60%">
										<input type="text" class="uk-input uk-form-small" name="vigencia">
									</td>
								</tr>
								<tr>
									<td style="width:40%" colspan="2">
										Condiciones de pago
									</td>
								</tr>
								<tr>
									<td style="width:40%" colspan="2">
										<input type="text" class="uk-input uk-form-small" name="condiciones_pago">
									</td>
								</tr>
								<tr>
									<td style="width:40%">
										Agente:
									</td>
									<td style="width:60%">
										<span style="font-weight:700">'.$uName.'</span>
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
										'.$row_CONSULTA2['domicilio'].'
									</td>
								</tr>
								<tr>
									<td style="width:50%;">
										Atención: <span style="font-weight:700;">'.$row_CONSULTA2['nombre'].'</span>
									</td>
									<td style="width:50%;text-align:right;">
										Teléfono: <span style="font-weight:700;">'.$row_CONSULTA2['telefono'].' / '.$row_CONSULTA2['telefono2'].'</span>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="background-color:#99FF99;">
							<span style="font-size:20px;font-weight:700;">Entregar en:</span>
						</td>
					</tr>
					<tr>
						<td>
							'.$row_CONSULTA2['entrega'].'
						</td>
					</tr>
				</table>

				<div style="min-height:50px;">
					&nbsp;
				</div>

				<div>
					'.$_SESSION['tablaBody'].'
				</div>

				<div style="background-color:#99FF99;border: solid grey 2px;font-weight:700;padding:3px;" >
					Observaciones
				</div>
				<div style="border-left: solid grey 2px;border-right: solid grey 2px;border-bottom: solid grey 2px;">
					<textarea name="txt1" id="txt1" class="uk-textarea" style="height:150px;">'.$row_CONSULTA1['txt1'].'</textarea>
				</div>
				<div style="height:20px;">
				</div>
				<div style="border-top: solid grey 2px;border-bottom: solid grey 2px;">
					<textarea name="txt2" id="txt2" class="uk-textarea" style="height:150px;">'.$row_CONSULTA1['cuentas'.$formato.''].'</textarea>
				</div>
				<div style="border-bottom: solid grey 2px;">
					<textarea name="txt3" id="txt3" class="uk-textarea" style="height:150px;">'.$row_CONSULTA1['txt3'].'</textarea>
				</div>
				<div style="border-bottom: solid grey 2px;">
					<textarea name="txt4" id="txt4" class="uk-textarea" style="height:150px;">'.$row_CONSULTA1['txt4'].'</textarea>
				</div>
				<div style="border-bottom: solid grey 2px;">
					<textarea name="txt5" id="txt5" class="uk-textarea" style="height:150px;">'.$row_CONSULTA1['txt5'].'</textarea>
				</div>

				<div class="uk-width-1-1 margin-v-50 uk-text-center">
					<a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'" class="uk-button uk-button-default">Cancelar</a>
					<input type="submit" name="enviar" value="Guardar" class="uk-button uk-button-primary" tabindex="10">
				</div>

			</form>
		</div>
	</div>
</div>
';


$scripts.='
	$(".foto").click(function(){
		var prodId = $(this).data("prod");
		var pic = $(this).data("pic");
		var num = $(this).data("num");
		$(".foto-"+num+"-"+prodId).removeClass("fotoseleccionada");
		$(this).addClass("fotoseleccionada");
		$("#foto-"+num+"-"+prodId).val(pic);
	})
	';









