<?php
$navegacion[] = array(
	  'title' => 'pedidos',
	 'modulo' => 'pedidos',
	   'icon' => 'file-invoice-dollar');

$navegacion[] = array(
	  'title' => 'clientes',
	 'modulo' => 'clientes',
	   'icon' => 'users');

$navegacion[] = array(
	  'title' => 'productos',
	 'modulo' => 'productos',
	   'icon' => 'box-open');

$navegacion[] = array(
	  'title' => 'blog',
	 'modulo' => 'blog',
	   'icon' => 'blog');

$navegacion[] = array(
	  'title' => 'calendario',
	 'modulo' => 'calendario',
	   'icon' => 'calendar-alt');

$navegacion[] = array(
	  'title' => 'configuración',
	 'modulo' => 'configuracion',
	   'icon' => 'cog');

$navegacion[] = array(
	  'title' => 'empresas',
	 'modulo' => 'empresas',
	   'icon' => 'copyright');

$navegacion[] = array(
	  'title' => 'galerías',
	 'modulo' => 'galerias',
	   'icon' => 'border-all');

$navegacion[] = array(
	  'title' => 'Imágenes',
	 'modulo' => 'images',
	   'icon' => 'images');

$navegacion[] = array(
	  'title' => 'sucursales',
	 'modulo' => 'sucursales',
	   'icon' => 'store-alt');

$navegacion[] = array(
	  'title' => 'testimonios',
	 'modulo' => 'testimonios',
	   'icon' => 'quote-right');




////////////////////////////////////////////////////////////
////////////////  NO CAMBIAR LO DE ABAJO  //////////////////
////////////////////////////////////////////////////////////

$menu = '';
$menuMovil = '';
foreach ($navegacion as $key => $value) {
	$menu .= ($modulo==$value['modulo'])? '
		<li class="uk-inline uk-active"><a href="index.php?rand='.rand(1,1000).'&modulo='.$value['modulo'].'"><i class="fa fa-2x fa-'.$value['icon'].'"></i></a><div class="bg-gold" uk-drop="pos: right"><span class="uk-h3 color-white uk-text-capitalize">'.$value['title'].'</span></div></li>':'
		<li class="uk-inline          "><a href="index.php?rand='.rand(1,1000).'&modulo='.$value['modulo'].'"><i class="fa fa-2x fa-'.$value['icon'].'"></i></a><div class="bg-gold" uk-drop="pos: right"><span class="uk-h3 color-white uk-text-capitalize">'.$value['title'].'</span></div></li>';

	$menuMovil .= '<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$value['modulo'].'">'.$value['title'].'</a></li>';
}

$menuBig='
	<div class="uk-visible@l">
		<div>
			<div class="padding-10">
				<a href="../" target="_blank"><img src="../img/design/logo-wozial.png"></a>
			</div>
		</div>
		<div>
			<nav>
				<ul class="uk-nav-default uk-nav-parent-icon uk-text-uppercase" id="menu-large" uk-nav>
					'.$menu.'
				</ul>
			</nav>
		</div>
	</div>';

$menuSmall='
	<div id="menu-movil" uk-offcanvas="mode: push; overlay: true">
		<div class="uk-offcanvas-bar uk-flex uk-flex-column">
			<button class="uk-offcanvas-close" type="button" uk-close></button>
			<ul class="uk-nav uk-nav-primary uk-nav-parent-icon uk-nav-center uk-margin-auto-vertical menu-movil uk-text-uppercase" uk-nav>
				'.$menuMovil.'
			</ul>
			<div class="uk-text-center">
				<a href="index.php?logout=1" class="uk-icon-button uk-button-danger" uk-icon="icon:unlock;"></a>
			</div>
		</div>
	</div>';

$head='
	<!DOCTYPE html>
	<html lang="es">
		<head>
			<meta charset="utf-8">

			<title>Administración</title>

			<meta name="viewport" content="width=device-width, initial-scale=1.0">

			<link rel="shortcut icon" href="../img/design/logo-wozial.ico">

			<!-- Font Awsome -->
			<script src="https://kit.fontawesome.com/910783a909.js" crossorigin="anonymous"></script>

			<!-- UIkit CSS -->
			<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@'.$uikitVersion.'/dist/css/uikit.min.css" />

			<!-- jQuery es neceario -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

			<!-- UIkit JS -->
			<script src="https://cdn.jsdelivr.net/npm/uikit@'.$uikitVersion.'/dist/js/uikit.min.js"></script>
			<script src="https://cdn.jsdelivr.net/npm/uikit@'.$uikitVersion.'/dist/js/uikit-icons.min.js"></script>

			
			<!-- CSS Personalizados -->
			<link rel="stylesheet" href="../css/admin.css">

		</head>';

$jquery='
	<!-- JQUERY UI -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<!-- Upload Image -->
	<link href="../library/upload-file/css/uploadfile.css" rel="stylesheet">
	<script src="../library/upload-file/js/jquery.uploadfile.js"></script>

	<!-- Editor de texto -->
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

	<!-- Chosen -->
	<link  href="../library/chosen/chosen.admin.css"    rel="stylesheet">
	<script src="../library/chosen/chosen.jquery.js"    type="text/javascript"></script>
	<script src="../library/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>

	<!-- Scripts Personalizados -->
	<script src="../js/admin.js"></script>

	<!-- Scripts específicos del archivo activo -->
	<script>';

$header='
		<body>
			<div id="admin" class="uk-offcanvas-content">
				<div id="adminmenu">
					<div id="menudisplay" class="uk-height-viewport" uk-sticky>
						'.$menuBig.'
						<div class="uk-position-bottom uk-text-muted">
							<div class="text-v" id="user-bar">
								'.$uName.'
							</div>
							<div style="padding:20px 0 10px 15px;">
								<i uk-icon="icon:user;ratio:1.2;"></i>
							</div>
							<div style="padding:0 0 30px 7px;">
								<a href="index.php?logout=1" class="uk-icon-button uk-button-danger" uk-icon="icon:unlock;"></a>
							</div>
						</div>
					</div>
					'.$menuSmall.'
				</div>
				<div id="admincuerpo">
					<div class="uk-container uk-container-expand">
						<div class="uk-width-1-1 uk-hidden@l">
							<a href="#menu-movil" uk-toggle class="uk-button uk-button-white"><i uk-icon="icon:menu;ratio:1.4;"></i> &nbsp; MENÚ</a>
							<span class="uk-float-right uk-text-muted"><i uk-icon="icon:user;ratio:1.1;"></i> &nbsp; '.$uName.'<span>
						</div>
						<div uk-grid>
						<!-- /////////////  COMIENZA  CONTENIDO   //////////// -->';

$footer='
						</script><!-- Terminan scripts específicos del archivo activo -->
						<!-- /////////////   TERMINA  CONTENIDO   //////////// -->
						</div>
					</div>
				</div>
			</div>
		</body>
	</html>';

