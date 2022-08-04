<?php
/* %%%%%%%%%%%%%%%%%%%% MENSAJES               */
	if($mensaje!=''){
		$mensajes='
			<div class="uk-container">
				<div uk-grid>
					<div class="uk-width-1-1 margin-v-20">
						<div class="uk-alert-'.$mensajeClase.'" uk-alert>
							<a class="uk-alert-close" uk-close></a>
							'.$mensaje.'
						</div>					
					</div>
				</div>
			</div>';
	}

/* %%%%%%%%%%%%%%%%%%%% RUTAS AMIGABLES        */
		$rutaInicio			=	$ruta;
		$rutaTienda 		=	$ruta.'0_0_0_tienda_wozial';
		$rutaPedido			=	$ruta.rand(1,999999999).'_revisar_orden';
		$rutaPedido2		=	$ruta.'revisar_datos_personales';

/* %%%%%%%%%%%%%%%%%%%% MENU                   */
	$menu='
		<li class="'.$nav1.'"><a class="" href="'.$rutaInicio.'">Inicio</a></li>
		<li class="'.$nav2.'"><a class="" href="'.$rutaTienda.'">Tienda</a></li>
		';

	$menuMovil='
		<li><a class=" '.$nav1.'" href="'.$ruta.'">Inicio</a></li>
		<li><a class=" '.$nav2.'" href="'.$rutaTienda.'">Tienda</a></li>
		';

/* %%%%%%%%%%%%%%%%%%%% HEADER                 */
	$header='
		<div class="uk-offcanvas-content uk-position-relative">

			<header>
				<div class="uk-container">
					<div uk-grid class="uk-grid-match">

						<!-- Botón menú móviles -->
						<div class="uk-width-auto uk-hidden@s">
							<a href="#menu-movil" uk-toggle class="uk-button uk-button-default color-primary"><i class="fa fa-bars" aria-hidden="true"></i> &nbsp; MENÚ</a>
						</div>

						<!-- Menú escritorio -->
						<div class="uk-width-1-2@m uk-visible@s">
							<nav class="uk-navbar-container uk-navbar-transparent" uk-navbar>
								<div class="uk-navbar-center">
									<ul class="uk-navbar-nav">
										'.$menu.'
									</ul>
								</div>
							</nav>
						</div>

						<!-- Botones de Logeo -->
						<div class="uk-width-expand">
							<div uk-grid class="uk-grid-collapse">
								'.$loginButton.'
							</div>
						</div>

					</div>
				</div>
			</header>

			'.$mensajes.'

			<!-- Menú móviles -->
			<div id="menu-movil" uk-offcanvas="mode: push;overlay: true">
				<div class="uk-offcanvas-bar uk-flex uk-flex-column">
					<button class="uk-offcanvas-close" type="button" uk-close></button>
					<ul class="uk-nav uk-nav-primary uk-nav-parent-icon uk-nav-center uk-margin-auto-vertical" uk-nav>
						'.$menuMovil.'
					</ul>
				</div>
			</div>';

/* %%%%%%%%%%%%%%%%%%%% FOOTER                 */
	$whatsIconClass=(isset($_SESSION['whatsappHiden']))?'':'uk-hidden';
	$stickerClass=($carroTotalProds==0 OR $identificador==500 OR $identificador==501 OR $identificador==502)?'uk-hidden':'';
	$footer = '
		<footer>
			<div class="bg-footer" style="z-index: 0;">
				<div class="uk-container uk-position-relative">
					<div class="uk-width-1-1 uk-text-center">
						<div class="padding-v-50">
							'.date('Y').' todos los derechos reservados Diseño por <a href="https://wozial.com/" target="_blank" class="color-negro">Wozial Marketing Lovers</a>
						</div>
					</div>
				</div>
			</div>
		</footer>

		<div id="cotizacion-fixed" class="uk-position-top uk-height-viewport '.$stickerClass.'">
			<div>
				<a class="" href="'.$rutaPedido.'"><img src="img/design/checkout.png" id="cotizacion-fixed-img"></a>
			</div>
		</div>

		'.$loginModal.'

		<div id="whatsapp-plugin" class="uk-hidden">
			<div id="whats-head" class="uk-position-relative">
				<div uk-grid class="uk-grid-small uk-grid-match">
					<div>
						<div class="uk-flex uk-flex-center uk-flex-middle">
							<img class="uk-border-circle padding-10" src="img/design/logo-og.jpg" style="width:70px;">
						</div>
					</div>
					<div>
						<div class="uk-flex uk-flex-center uk-flex-middle color-blanco">
							<div>
								<span class="text-sm">'.$Brand.'</span><br>
								<span class="text-6 uk-text-light">Atención en línea vía chat</span>
							</div>
						</div>
					</div>
				</div>
				<div class="uk-position-right color-blanco text-sm">
					<span class="pointer padding-10" id="whats-close">x</spam>
				</div>
			</div>
			<div id="whats-body-1" class="uk-flex uk-flex-middle">
				<div class="bg-white uk-border-rounded padding-h-10" style="margin-left:20px;">
					<img src="img/design/loading.gif" style="height:40px;">
				</div>
			</div>
			<div id="whats-body-2" class="uk-hidden">
				<span class="uk-text-bold uk-text-muted">'.$Brand.'</span><br>
				Hola 👋<br>
				¿Cómo puedo ayudarte?
			</div>
			<div id="whats-footer" class="uk-flex uk-flex-center uk-flex-middle">
				<a href="'.$socialWhats.'" target="_blank" class="uk-button uk-button-small" id="button-whats"><i class="fab fa-whatsapp fa-lg"></i> <span style="font-weight:400;">Comenzar chat</span></a>
			</div>
		</div>
		<div id="whats-show" class="'.$whatsIconClass.' pointer uk-border-circle color-white uk-box-shadow-large" style="background-color: rgb(9, 94, 84);">
			<i class="fab fa-3x fa-whatsapp"></i>
		</div>
	</div>

	<div id="spinnermodal" class="uk-modal-full" uk-modal>
		<div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle uk-height-viewport">
			<div>
				<div class="claro" uk-spinner="ratio: 5">
				</div>
			</div>
		</div>
   	</div>';

/* %%%%%%%%%%%%%%%%%%%% HEAD GENERAL                */
	$headGNRL='
		<html lang="'.$languaje.'">
		<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">

			<meta charset="utf-8">
			<title>'.$title.'</title>
			<meta name="description" content="'.$description.'" />
			<meta property="fb:app_id" content="'.$appID.'" />
			<link rel="image_src" href="'.$ruta.$logoOg.'" />

			<meta property="og:type" content="website" />
			<meta property="og:title" content="'.$title.'" />
			<meta property="og:description" content="'.$description.'" />
			<meta property="og:url" content="'.$rutaEstaPagina.'" />
			<meta property="og:image" content="'.$ruta.$logoOg.'" />

			<meta itemprop="name" content="'.$title.'" />
			<meta itemprop="description" content="'.$description.'" />
			<meta itemprop="url" content="'.$rutaEstaPagina.'" />
			<meta itemprop="thumbnailUrl" content="'.$ruta.$logoOg.'" />
			<meta itemprop="image" content="'.$ruta.$logoOg.'" />

			<meta name="twitter:title" content="'.$title.'" />
			<meta name="twitter:description" content="'.$description.'" />
			<meta name="twitter:url" content="'.$rutaEstaPagina.'" />
			<meta name="twitter:image" content="'.$ruta.$logoOg.'" />
			<meta name="twitter:card" content="summary" />

			<meta name="viewport"       content="width=device-width, initial-scale=1">

			<link rel="icon"            href="'.$ruta.'img/design/favicon.ico" type="image/x-icon">
			<link rel="shortcut icon"   href="img/design/favicon.ico" type="image/x-icon">
			<link rel="stylesheet"      href="https://cdn.jsdelivr.net/npm/uikit@'.$uikitVersion.'/dist/css/uikit.min.css" />
			<link rel="stylesheet/less" href="css/general.less" >
			<link rel="stylesheet"      href="https://fonts.googleapis.com/css?family=Lato:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
			
			<!-- jQuery is required -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

			<!-- UIkit JS -->
			<script src="https://cdn.jsdelivr.net/npm/uikit@'.$uikitVersion.'/dist/js/uikit.min.js"></script>
			<script src="https://cdn.jsdelivr.net/npm/uikit@'.$uikitVersion.'/dist/js/uikit-icons.min.js"></script>

			<!-- Font Awesome -->
			<script src="https://kit.fontawesome.com/910783a909.js" crossorigin="anonymous"></script>

			<!-- Less -->
			<script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js" ></script>
		</head>';

/* %%%%%%%%%%%%%%%%%%%% SCRIPTS                */
	$scriptGNRL='
		<script src="js/general.js"></script>

		<script src="//code.jivosite.com/widget.js" data-jv-id="R4ZWEOn0XH" async></script>
		
		';

	// Script login Facebook
	$scriptGNRL.=(!isset($_SESSION['uid']) AND $dominio != 'localhost' AND isset($facebookLogin))?'
		<script>
			// Esta es la llamada a facebook FB.getLoginStatus()
			function statusChangeCallback(response) {
				if (response.status === "connected") {
					procesarLogin();
				} else {
					console.log("No se pudo identificar");
				}
			}

			// Verificar el estatus del login
			function checkLoginState() {
				FB.getLoginStatus(function(response) {
					statusChangeCallback(response);
				});
			}

			// Definir características de nuestra app
			window.fbAsyncInit = function() {
				FB.init({
					appId      : "'.$appID.'",
					xfbml      : true,
					version    : "v'.$appVersion.'"
				});
				FB.AppEvents.logPageView();
			};

			// Ejecutar el script
			(function(d, s, id){
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) {return;}
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/es_LA/sdk.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, \'script\', \'facebook-jssdk\'));
			
			// Procesar Login
			function procesarLogin() {
				FB.api(\'/me?fields=id,name,email\', function(response) {
					console.log(response);
					$.ajax({
						method: "POST",
						url: "includes/acciones.php",
						data: { 
							facebooklogin: 1,
							nombre: response.name,
							email: response.email,
							id: response.id
						}
					})
					.done(function( response ) {
						console.log( response );
						datos = JSON.parse( response );
						UIkit.notification.closeAll();
						UIkit.notification(datos.msj);
						if(datos.estatus==0){
							location.reload();
						}
					});
				});
			}
		</script>

		':'';


// Reportar actividad
	$scriptGNRL.=(!isset($_SESSION['uid']))?'':'
		<script>
			var w;
			function startWorker() {
			  if(typeof(Worker) !== "undefined") {
			    if(typeof(w) == "undefined") {
			      w = new Worker("js/activityClientFront.js");
			    }
			    w.onmessage = function(event) {
					//console.log(event.data);
			    };
			  } else {
			    document.getElementById("result").innerHTML = "Por favor, utiliza un navegador moderno";
			  }
			}
			startWorker();
		</script>
		';

/* %%%%%%%%%%%%%%%%%%%% BUSQUEDA               */
	$scriptGNRL.='
		<script>
			$(document).ready(function(){
				$(".search").keyup(function(e){
					if(e.which==13){
						var consulta=$(this).val();
						var l = consulta.length;
						if(l>2){
							window.location = ("'.$ruta.'"+consulta+"_gdl");
						}else{
							UIkit.notification.closeAll();
							UIkit.notification("<div class=\'bg-danger color-blanco\'>Se requiren al menos 3 caracteres</div>");
						}
					}
				});
				$(".search-button").click(function(){
					var consulta=$(".search-bar-input").val();
					var l = consulta.length;
					if(l>2){
						window.location = ("'.$ruta.'"+consulta+"_gdl");
					}else{
						UIkit.notification.closeAll();
						UIkit.notification("<div class=\'bg-danger color-blanco\'>Se requiren al menos 3 caracteres</div>");
					}
				});
			});
		</script>';

/* %%%%%%%%%%%%%%%%%%%% WHATSAPP PLUGIN               */
	$scriptGNRL.=(isset($_SESSION['whatsappHiden']))?'':'
		<script>
			setTimeout(function(){
				$("#whatsapp-plugin").addClass("uk-animation-slide-bottom-small");
				$("#whatsapp-plugin").removeClass("uk-hidden");
			},1000);
			setTimeout(function(){
				$("#whats-body-1").addClass("uk-hidden");
				$("#whats-body-2").removeClass("uk-hidden");
			},6000);
		</script>
			';

	$scriptGNRL.='
		<script>
			$("#whats-close").click(function(){
				$("#whatsapp-plugin").addClass("uk-hidden");
				$("#whats-show").removeClass("uk-hidden");
				$.ajax({
					method: "POST",
					url: "includes/acciones.php",
					data: { 
						whatsappHiden: 1
					}
				})
				.done(function( msg ) {
					console.log(msg);
				});
			});
			$("#whats-show").click(function(){
				$("#whatsapp-plugin").removeClass("uk-hidden");
				$("#whats-show").addClass("uk-hidden");
				$("#whats-body-1").addClass("uk-hidden");
				$("#whats-body-2").removeClass("uk-hidden");
				$.ajax({
					method: "POST",
					url: "includes/acciones.php",
					data: { 
						whatsappShow: 1
					}
				})
				.done(function( msg ) {
					console.log(msg);
				});
			});
		</script>';



