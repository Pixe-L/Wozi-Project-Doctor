<?php 
/* %%%%%%%%%%%%%%%%% CONFIGURACIÓN   */
	$logo 			= 'img/design/logo.png';
	$mailBGcolor 	= '#DDD';
	$mailButton 	= '#ff8b00';
	$uikitVersion	= '3.5.5';
	$languaje		= 'es';
	$appID			= '298662384195873'; // Facebook
	$appVersion     = '7.0'; // Facebook
	$googleMaps		= 'AIzaSyAA_lgquFXipMbdNCXe5EFDxbUdoHZBBlg';
	$efra			= 'info@efra.biz';

	$database 		= '';
	$username 		= '';
	$password		= '';

	$databaseLocal 	= 'sdk';
	$usernameLocal 	= 'root';
	$passwordLocal 	= 'kilo';

	$previewDomain  = 'eshot.mx';
	$databasePreview= 'eshotmx_';
	$usernamePreview= 'eshotmx_eshotmx';
	$passwordPreview= '1WnXgx$Y$N4&';

/* %%%%%%%%%%%%%%%%% OTRAS VARIABLES   */
	global $ruta;
	global $rutaEstaPagina;
	global $CONEXION;
    global $uid;
	global $caracteres_si_validos;
	global $caracteres_no_validos;
	global $linkToShare;
	global $es_movil;


	$caracteres_si_validos  = array('',' ','','','','','','','','','a','A','e','E','i','I','o','O','u','U','n','N');
	$caracteres_no_validos  = array('%','  ',',','_','|','/','®','¿','"',':','á','Á','é','É','í','Í','ó','Ó','ú','Ú','ñ','Ñ');
	$noPic='img/design/camara.jpg';

	$mensajeClase='';
	$mensajes='';
	$mensaje='';

	$legendSuccess='';
	$legendFail='';
	$scripts='';
	
	date_default_timezone_set('America/Mexico_City');
	$hoy=date('Y-m-d');
	$ahora=date('Y-m-d H:i:s');

	$dominio=str_replace('www.', '', $_SERVER["SERVER_NAME"]);
	$ip=substr($dominio,0,-2);
	$debug=($dominio=='localhost')?1:0;
	$protocolo=($debug==1)?'http://':'https://';
	$raiz=$protocolo.$dominio;
	$urlSufijo=$_SERVER["REQUEST_URI"];
	$slash=(strrpos($urlSufijo,'/'))+1;
	$ruta=$raiz.substr($urlSufijo,0,$slash);
	$ruta = (str_replace('admin/', '', $ruta));
	$ruta = (str_replace('includes/', '', $ruta));
	$ruta = (str_replace('pages-cart/', '', $ruta));
	$rutaEstaPagina=$raiz.$_SERVER["REQUEST_URI"];
	$linkToShare=str_replace('+', '%2B', $rutaEstaPagina);
	$linkToShare=str_replace(':', '%3A', $linkToShare);
	$logo=$ruta.$logo;

	$hostname = 'localhost';
	if($dominio=='localhost' or $ip=='192.168.100'){
		$database 	= $databaseLocal;
		$username 	= $usernameLocal;
		$password 	= $passwordLocal;
	}elseif($dominio==$previewDomain){
		$database 	= $databasePreview;
		$username 	= $usernamePreview;
		$password 	= $passwordPreview;
	}


	$CONEXION = mysqli_init();
	mysqli_real_connect($CONEXION, $hostname, $username, $password, $database) or die("Error: " . mysqli_connect_error($CONEXION)); 
	mysqli_set_charset($CONEXION,'utf8');


	// Metadatos
		$CONSULTA          = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 1");
		$row_CONSULTA      = $CONSULTA -> fetch_assoc();

		$title		       = $row_CONSULTA['title'];
		$description       = $row_CONSULTA['description'];
		$Brand			   = $title;
		$logoOg		       = 'img/contenido/varios/'.$row_CONSULTA['imagen1'];
		$logoOg 	       = (file_exists($logoOg) AND strlen($row_CONSULTA['imagen1'])>0) ? $logoOg:'img/design/logo-og.jpg';

		$taxIVA            = (isset($_SESSION['requierefactura']) AND $_SESSION['requierefactura']==1)?$row_CONSULTA['iva']/100:0;
		$prodsPagina       = $row_CONSULTA['prodspag'];
		$shipping          = $row_CONSULTA['envio']*1;
		$shippingGlobal    = $row_CONSULTA['envioglobal']*1;
		$payPalCliente     = $row_CONSULTA['paypalemail'];
		$sandbox           = ($payPalCliente=='business@wozial.com') ? 'sandbox.':'';

		$tyct1             = $row_CONSULTA['tyct1'];
		$tyct2             = $row_CONSULTA['tyct2'];
		$tyct3             = $row_CONSULTA['tyct3'];
		$tyct4             = $row_CONSULTA['tyct4'];

		$telefono          = $row_CONSULTA['telefono'];
		$telefonoSeparado  = substr($telefono, 0,2).' '.substr($telefono, 2,4).' '.substr($telefono, 6,4);

		$telefono1         = $row_CONSULTA['telefono1'];
		$telefonoSeparado1 = substr($telefono1, 0,2).' '.substr($telefono1, 2,4).' '.substr($telefono1, 6,4);

		$socialFace        = $row_CONSULTA['facebook'];
		$socialInst        = $row_CONSULTA['instagram'];
		$socialYou         = $row_CONSULTA['youtube'];
		$socialWhats       = 'https://wa.me/521'.$telefono1.'?text=Me%20gustaría%20saber%20...';

		$destinatario1 	   = $row_CONSULTA['destinatario1'];
		$destinatario2 	   = $row_CONSULTA['destinatario2'];

		$RemitenteMail 	   = $row_CONSULTA['remitente'];
		$Remitentepass 	   = $row_CONSULTA['remitentepass'];
		$Remitentehost 	   = $row_CONSULTA['remitentehost'];
		$Remitenteport 	   = $row_CONSULTA['remitenteport'];
		$Remitenteseguridad= strtolower($row_CONSULTA['remitenteseguridad']);

	mysqli_free_result($CONSULTA);
	unset($row_CONSULTA);

/* %%%%%%%%%%%%%%%%%%%% MÓVIL O ESCRITORIO     */
	// Detectamos si es móvil o escritorio
	$navegadorUser = $_SERVER['HTTP_USER_AGENT'];		// Info del navegador
	// Lista de navegadores móviles
	$navegadores_moviles = "Android, AvantGo, Blackberry, Blazer, Cellphone, Danger, DoCoMo, EPOC, EudoraWeb, Handspring, HTC, Kyocera, LG, MMEF20, MMP, MOT-V, Mot, Motorola, NetFront, Newt, Nokia, Opera Mini, Palm, Palm, PalmOS, PlayStation Portable, ProxiNet, Proxinet, SHARP-TQ-GX10, Samsung, Small, Smartphone, SonyEricsson, SonyEricsson, Symbian, SymbianOS, TS21i-10, UP.Browser, UP.Link, WAP, webOS, Windows CE, hiptop, iPhone, iPod, portalmmm, Elaine, OPWV";
	// Almacenar como array
	$navegadores_moviles_array = explode(',',$navegadores_moviles);
	// Ciclo comparativo
	$es_movil=FALSE;
	foreach($navegadores_moviles_array AS $navegadorList){
		if ($es_movil===FALSE) {
			$es_movil=(preg_match("/".trim($navegadorList)."/i",$navegadorUser))?TRUE:FALSE;
		}
	}

	$socialWhats = ($es_movil===FALSE) ? 'https://web.whatsapp.com/521'.$telefono1.'?text=Me%20gustaría%20saber%20...':$socialWhats;

/* %%%%%%%%%%%%%%%%%%%% Explorer < 8           */
	if(preg_match('/(?i)msie [1-8]/',$navegadorUser)){
		$mensaje='Este sitio está diseñado para navegadores modernos.<br>Vuelva a visitarnos desde Google Chrome, Firefox o su Dispositivo Movil.';
		$mensajeClase='danger';
	}

