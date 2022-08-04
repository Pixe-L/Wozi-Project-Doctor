<?php 
/* %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% 
						LOGIN USING EMAIL
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  */
	// Modal para logueo
	$fallo			= 0;
	$rutaMiCta		= $ruta.'mi-cuenta';
	$loginButton    = '
		<div>
			<a href="#login" class="uk-button uk-button-personal" uk-toggle>
				<i uk-icon="lock"></i><span class="uk-visible@s"> &nbsp; Inicia sesión</span>
			</a>
		</div>
		<div>
			<a href="registro" class=" uk-button uk-button-personal">
				<i uk-icon="user"></i><span class="uk-visible@s"> &nbsp; Regístrate</span>
			</a>
		</div>';

		
	// Ventana modal de logueo
	$loginModal='
	<div id="login" uk-modal class="modal-login">
		<div class="uk-modal-dialog">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<div class="uk-modal-header">
				<div class="uk-text-center">
					<img src="'.$logo.'" style="max-height:100px;" alt="'.$Brand.'">
				</div>
			</div>
			<div class="padding-20">
				<div class="">
					<form action="'.$rutaEstaPagina.'" method="post">
						<input type="hidden" name="login" value="1">
						<label for="loginemail">*Email:</label>
						<div class="input-container">
							<input name="loginemail" class="uk-input input-personal" type="email" required>
						</div>
						<label for="pass">*Contrase&ntilde;a:</label>
						<div class="input-container">
							<input name="password" class="uk-input input-personal" type="password" required>
						</div>
						<div class="uk-margin-top">
							<button class="uk-button uk-button-personal uk-width-1-1">Entrar</button>
						</div>
					</form>
				</div>
				<div class="uk-text-center margin-v-20">
					<fb:login-button 
						scope="public_profile,email" 
						onlogin="checkLoginState();"
						class="fb-login-button"
						data-size="large"
						data-button-type="continue_with"
						data-show-faces="false"
						>
					</fb:login-button>
					<div class="fbstatus">
					</div>
				</div>
				<div uk-grid class="uk-text-center padding-top-50">
					<div class="uk-width-1-2">
						<div>
							¿Nuevo en el sitio?
						</div>
						<div class="uk-width-1-1">
							<div class="uk-margin-top">
								<a href="Registro" class=" uk-button uk-button-default">Regístrate</a>
							</div>
						</div>
					</div>
					<div class="uk-width-1-2">
						<div>
							¿Olvidaste tu contraseña?
						</div>
						<div class="uk-width-1-1">
							<div class="uk-margin-top">
								<a href="password-recovery" class=" uk-button uk-button-default">Recuperar</a>
							</div>
						</div>
					</div>
				</div>
				<div class="uk-width-1-1">
					<br>
				</div>
			</div>
		</div>
	</div>';


	// Obtener usuario
	$unombre='&nbsp;';
	if (isset($_SESSION['uid'])) {
		$uid  = $_SESSION['uid'];
		$USER = $CONEXION -> query("SELECT * FROM usuarios WHERE id = '$uid'");
		$numUser = $USER->num_rows;
		if ($numUser>0) {
			$row_USER = $USER -> fetch_assoc();
			$unombre  = $row_USER['nombre'];
			$uemail   = $row_USER['email'];
			$ulevel   = $row_USER['nivel'];
			$nombreCortoEspacio=strpos($unombre, ' ');
			$nombreCorto=($nombreCortoEspacio==0)?$unombre:substr($unombre,0,(strpos($unombre, ' ')));
			$loginModal = '';
		}else{
			unset($_SESSION['uid']);
			unset($uid);
		}
	}else{
		if(isset($_POST['login']) and $_POST['login']!='') { $login = $_POST['login']; }
		if(isset($_POST['loginemail']) and $_POST['loginemail']!='') { $email = htmlentities($_POST['loginemail']); }else{ $fallo=1; }
		if(isset($_POST['password']) and $_POST['password']!='') { $password = md5($_POST['password']); }else{ $fallo=1; }
		if(isset($_POST['pass1']) and $_POST['pass1']!='') { $pass1 = md5($_POST['pass1']); }else{ $pass1=''; }
		if(isset($_POST['pass1']) and $_POST['pass1']!='') { $passLen = strlen($_POST['pass1']); }else{ $passLen=0; }

		if ($fallo==0) {
			// Comprobar si el usuario existe
			$USER = $CONEXION -> query("SELECT * FROM usuarios WHERE email = '$email'");
			$numUser=$USER->num_rows;

			// Si no existe, verificamos que no esté registrando
			if ($numUser>0) {
				$row_USER = $USER -> fetch_assoc();
				if ($row_USER['pass']===$password OR $row_USER['pass']=='') {
					$_SESSION['uid'] = $row_USER['id'];
					header('location: '.$rutaEstaPagina );
				}else{
					$mensajeClase='danger';
					$mensaje='Contraseña incorrecta';
				}
			}else{
				$mensajeClase='danger';
				$mensaje='<br>No existe el usuario';
			}
		}
	}


	// Existe el usuraio
	if (isset($uid)) {
		$loginButton='
		<div>
			<a href="'.$rutaMiCta.'" class=" uk-button uk-button-personal uk-text-center">
				<i uk-icon="user"></i><span class="uk-visible@s"> &nbsp;  &nbsp; '.$nombreCorto.'</span>
			</a>
		</div>
		<div>
			<a href="logout" class=" uk-button uk-button-personal uk-text-center">
				<i uk-icon="lock"></i><span class="uk-visible@s"> &nbsp;  &nbsp; Salir</span>
			</a>
		</div>';
		// Ventana modal de logueo
		$loginModal='';
	}
