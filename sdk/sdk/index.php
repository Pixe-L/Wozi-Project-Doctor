<?php
	session_start();
	require_once 'includes/connection.php';
	require_once 'includes/login.php';
	require_once 'includes/widgets.php';
	
	// obtenemos el identificador
	if(isset($_GET['identificador'])){ $identificador=$_GET['identificador']; }else{ $identificador=0; }
	//echo $identificador;

	$nav1='';
	$nav2='';
	$nav3='';
	$nav4='';
	$nav5='';
	$nav6='';
	$nav7='';
	$nav8='';
	$nav9='';


// %%%%%%%%%%%%%%      IMPORTANTE      %%%%%%%%%%%%%%%% //
//                                                      //
//       PONER EL DETALLE EN EL IDENTIFICADOR 15        //
//                                                      //
// %%%%%%%%%%%%%%      IMPORTANTE      %%%%%%%%%%%%%%%% //
	
switch ($identificador) {
	// Inicio en default
	case 2:
		$nav4='uk-active';
		$ano=(isset($_GET['ano']))?$_GET['ano']:date('Y');
		$mes=(isset($_GET['mes']))?$_GET['mes']:date('m');
		include 'includes/calendario.php';
		include 'includes/includes.php';
		include 'pages/eventos.php';
		break;

	case 3:
		$id=$_GET['id'];
		$nav4='uk-active';
		include 'includes/includes.php';
		include 'pages/eventodetalle.php';
		break;

	case 4:
		$nav2='uk-active';
		include 'includes/includes.php';
		include 'pages/about.php';
		break;

	case 5:
		$nav5='uk-active';
		include 'includes/includes.php';
		include 'pages/contacto.php';
		break;

	case 6:
		$id=$_GET['id'];
		include 'includes/includes.php';
		include 'pages/mapas.php';
		break;




	// TIENDA
	case 10:
		$nav2='uk-active';
		$cat=$_GET['cat'];
		$marca=$_GET['marca'];
		$pag=$_GET['pag'];
		
		$sqlProd="SELECT id FROM productos WHERE estatus = 1 ";

		if ($cat!=0 OR $marca!=0) {
			$title='';
			$description='';
		}

		if ($marca>0) {
			$consultaY = $CONEXION -> query("SELECT * FROM productosmarcas WHERE id = $marca");
			$row_consultaY = $consultaY -> fetch_assoc();
			$title.=html_entity_decode($row_consultaY['txt']);
			$description.=$title.'. '.$description;
			$linkMarca=$row_consultaY['id'].'_'.urlencode(str_replace($caracteres_no_validos,$caracteres_si_validos,html_entity_decode(strtolower($row_consultaY['txt'])))).'_marca';
			$linkPrveedor=$row_consultaY['url'];
			$pic='img/contenido/marcas/'.$row_consultaY['imagen'];
			$logoMarca=(strlen($row_consultaY['imagen'])>0 AND file_exists($pic))?$pic:$noPic;

			$sqlProd .= " AND marca = $marca";
		}

		if ($cat>0) {
			$consultaX = $CONEXION -> query("SELECT * FROM productoscat WHERE id = $cat");
			$row_consultaX = $consultaX -> fetch_assoc();
			$title.=($marca!=0)?' - ':'';
			$title.=html_entity_decode($row_consultaX['txt']);
			$description.=$title.'. '.$description;
			$sqlProd .= " AND categoria = $cat";
		}

		$Consulta = $CONEXION -> query($sqlProd);
		$numItems = $Consulta->num_rows;
		$pag = (!isset($pag))?0:$pag;
		$prodInicial = $prodsPagina*$pag;

		require_once 'includes/includes.php';
		require_once 'pages/tienda.php';
		break;		

	case 11:
		$nav2='uk-active';
		$pag=$_GET['pag'];
		require_once 'includes/includes.php';
		require_once 'pages/tienda-ofertas.php';
		break;


	case 14:
		$nav2='uk-active';
		$consulta =$_GET['consulta'];
		$title=$consulta;
		$description.=' - '.$consulta;
		include 'includes/includes.php';
		include 'pages/tienda-search.php';
		break;


	// Detalle de producto
	case 15:
		// Importante poner los valores del SEO
		// title, description y picOg 
		$nav2='uk-active';
		$id=$_GET['id'];
		$CONSULTA = $CONEXION -> query("SELECT *,marca as marcaId FROM productos WHERE id = $id");
		$numProds=$CONSULTA->num_rows;
		$rowCONSULTA = $CONSULTA -> fetch_assoc();
		foreach ($rowCONSULTA as $key => $value) {
			${$key}=$value;
		}
		$titulo=html_entity_decode($rowCONSULTA['titulo']);
		$title=(strlen($rowCONSULTA['title'])>0)?html_entity_decode($rowCONSULTA['title']):html_entity_decode($rowCONSULTA['titulo']);
		$description=(strlen($rowCONSULTA['metadescription'])>0)?html_entity_decode($rowCONSULTA['metadescription']):$description;

		$linkTwitter='<a href="https://twitter.com/intent/tweet?button_hashtag='.$Brand.'&ref_src='.$rutaEstaPagina.'" class="uk-icon-button uk-button-default" data-text="'.$titulo.'" data-url="'.$rutaEstaPagina.'" data-related="#'.$Brand.'" data-lang="es" data-show-count="false" uk-icon="twitter"></a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';

		$picOg='img/design/logo-og.jpg';

		$consultaPIC = $CONEXION -> query("SELECT * FROM productospic WHERE producto = $id ORDER BY orden LIMIT 1");
		$numPics=$consultaPIC->num_rows;
		if ($numPics>0) {
			$row_consultaPIC = $consultaPIC -> fetch_assoc();
			$picOgRuta='img/contenido/productos/';
			$picOg=$picOgRuta.$row_consultaPIC['id'].'.jpg';
		}
		include 'includes/includes.php';
		include 'pages/tienda-detalle.php';
		break;



	case 21:
		$id=$_GET['id'];
		$nav1='uk-active';
		
		$CONSULTA = $CONEXION -> query("SELECT *,marca as marcaId FROM productos WHERE id = $id");
		$rowCONSULTA = $CONSULTA -> fetch_assoc();
		foreach ($rowCONSULTA as $key => $value) {
			${$key}=$value;
		}
		$title=''.html_entity_decode($rowCONSULTA['title']);
		$description=html_entity_decode($rowCONSULTA['metadescription']);

		$pic='img/contenido/productosmain/'.$rowCONSULTA['imagen'];
		$noPic='img/design/logo-og.jpg';

		$picOg=(file_exists($pic) AND strlen($rowCONSULTA['imagen'])>0)?$pic:$noPic;
		$picOg=(strpos($pic, 'ttp')>0)?$rowCONSULTA['imagen']:$picOg;

		require_once 'includes/includes.php';
		require_once 'pages/productos-detalle.php';
		break;






	// Procesar carrito ajax
		case 200:
			break;




	// Procesar compra
		case 500:
			include "includes/includes.php";
			include 'pages-cart/pedido-1-revisar.php';
			break;

		case 501:
			include "includes/includes.php";
			if (isset($uid)) {
				if(isset($_SESSION['carro'])){
					include 'pages-cart/pedido-2-datos.php';
				}else{
					include 'pages/inicio.php';
				}
			}else{
				include 'pages-cart/registro.php';
			}
			break;

		case 502:
			include "includes/includes.php";
			if (isset($uid)) {
				include 'pages-cart/pedido-3-procesar.php';
			}else{
				header('location: revisar_datos_personales');
			}
			break;


		case 505:
			include "includes/includes.php";
			if (isset($uid)) {
				include 'pages-cart/pedido-4-pagar.php';
			}else{
				include 'pages-cart/pedido-2-datos.php';
			}
			break;

		case 506:
				if (isset($uid)) {
				$idmd5=$_GET['idmd5'];
				$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE idmd5 = '$idmd5'");
				$row_CONSULTA = $CONSULTA -> fetch_assoc();
				if($uid==$row_CONSULTA['uid']){
					include "includes/includes.php";
					include 'pages-cart/pedido-5-detalle.php';
				}else{
					include "includes/includes.php";
					include 'pages/inicio.php';
				}
			}else{
				include "includes/includes.php";
				include 'pages-cart/registro.php';
			}
			break;

		case 507:
				if (isset($uid)) {
				$idmd5=$_GET['idmd5'];
				$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE idmd5 = '$idmd5'");
				$row_CONSULTA = $CONSULTA -> fetch_assoc();
				if($uid==$row_CONSULTA['uid']){
					include "includes/includes.php";
					include 'pages-cart/pdf-show.php';
				}else{
					include "includes/includes.php";
					include 'pages/inicio.php';
				}
			}else{
				include "includes/includes.php";
				include 'pages-cart/registro.php';
			}
			break;

		case 508:
				$idmd5=$_GET['idmd5'];
				$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE idmd5 = '$idmd5'");
				$row_CONSULTA = $CONSULTA -> fetch_assoc();
				include "includes/includes.php";
				include 'pages-cart/pdf-show.php';
			break;

		case 509:
			$mensaje='Pedido no encontrado';
			$mensajeClase='danger';
			include "includes/includes.php";
			include 'pages/inicio.php';
			break;

		case 511:
			include "includes/includes.php";
			include 'pages-cart/pedido-6-success.php';
			break;

		case 512:
			$idmd5=$_GET['idmd5'];
			include "includes/includes.php";
			include 'pages-cart/pedido-7-ipn.php';
			break;

	case 900:
		include "includes/includes.php";
		if (isset($uid)) {
				include 'pages-cart/myaccount.php';
		}else{
			include 'pages-cart/registro.php';
		}
		break;


	// Recuperar contraseña
	case 901:
		include "includes/includes.php";
		include 'pages-cart/password-recovery-1.php';
		break;

	case 902:
		$id=$_GET['id'];
		include "includes/includes.php";
		if (isset($uid)) {
				include 'pages-cart/myaccount.php';
		}else{
			include 'pages-cart/password-recovery-2.php';
		}
		break;
	// Recuperar contraseña



	// Buscar
	case 910:
		if(isset($_GET['consulta'])){ $consulta=$_GET['consulta']; }else{ header('Location: '.$ruta); }
		include "includes/includes.php";
		include 'pages/search.php';
		break;


	case 990:
		session_destroy();
		include "includes/includes.php";
		header('location: salir');
		break;

	case 991:
		$nav1='uk-active';
		$mensaje='Hasta pronto';
		$mensajeClase='success';
		include "includes/includes.php";
		$scriptGNRL.='<script> setTimeout(function(){ window.location = ("'.$ruta.'"); },2000); </script>';
		include 'pages/inicio.php';
		break;

	case 994:
		include "includes/includes.php";
		include 'includes/humans.php';
		break;

	case 995:
		include "includes/includes.php";
		include 'includes/google-verify.php';
		break;

	case 996:
		include "includes/includes.php";
		include 'includes/robots.php';
		break;

	case 997:
		include "includes/includes.php";
		include 'includes/sitemap.php';
		break;

	case 998:
		include "includes/includes.php";
		include 'pages-cart/faq.php';
		break;

	case 999:
		$id=$_GET['id'];
		include "includes/includes.php";
		include 'pages-cart/politicas.php';
		break;

	default:
		$nav1='uk-active';
		include "includes/includes.php";	
		include 'pages/inicio.php';
		break;
}


mysqli_close($CONEXION);
if (file_exists('error_log')) {
	unlink('error_log');
}

