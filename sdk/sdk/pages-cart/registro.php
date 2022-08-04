<!DOCTYPE html>
<?=$headGNRL?>
<body>
  
<?=$header?>

<div class="uk-container">
	<div class="uk-width-1-1 margin-top-20 color-blanco text-xl padding-10 bg-primary" >
		¿Ya has comprado antes?
		<a href="password-recovery" class="uk-button uk-button-default color-blanco uk-visible@m" style="float:right;">Recuperar contraseña</a>
	</div>
	<div class="uk-width-1-1">
		<form action="" method="post">
			<input type="hidden" name="login" value="1">
			<div uk-grid class="uk-grid-small">
				<div class="uk-width-1-3@s">
					<label for="email" class="uk-form-label">Email</label>
					<input name="loginemail" class="uk-input input-personal" id="login-email1" type="email" tabindex="5" value="" required autofocus>
				</div>
				<div class="uk-width-1-3@s">
					<label for="pass" class="uk-form-label">Contraseña</label>
					<input name="password" class="uk-input input-personal" id="login-pass1" type="password" tabindex="5" value="" required>
				</div>
				<div class="uk-width-1-3@s uk-margin uk-text-center">
					<button class="uk-button uk-button-personal" value="Entrar" id="" name="enviar" tabindex="5">Entrar</button>
				</div>
			</div>
		</form>
		<div class="uk-hidden@m padding-v-20">
			<a href="password-recovery" class="uk-button uk-button-default">Recuperar contraseña</a>
		</div>
		<div class="uk-width-1-1 uk-text-center">
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
	</div>
	<div class="uk-width-1-1 margin-top-20 color-blanco text-xl padding-10 bg-primary" >
		Nuevo en el sitio
	</div>
	<div class="uk-width-1-1">
		<div class="uk-grid-small uk-child-width-1-3@m margin-bottom-50 margin-top-20" uk-grid>
				
			<!-- DATOS PERSONALES -->
			<div>
				<!-- Inputs para evitar el autocompletar -->
				<div style="opacity:0;width:0;overflow:hidden;height:0;">
					<input type="text" name="user">
					<input type="password" name="password">
					<input type="email" name="email">
					<input type="password" name="pass">
				</div>
				<label class="uk-form-label" for="nombre1">*Nombre</label>
				<input type="text" id="nombre1" class="uk-input input-personal">
			</div>
			<div>
				<label class="uk-form-label" for="email1">*Email</label>
				<input type="text" id="email1" class="uk-input input-personal">
			</div>
			<div>
				<label class="uk-form-label" for="password">*Contraseña deseada &nbsp <i class="fas fa-eye-slash uk-float-right pointer" data-estatus="0"></i></label>
				<input type="password" id="password" class="uk-input input-personal">
			</div>
			<div>
				<label class="uk-form-label" for="telefono1">*Telefono</label>
				<input type="text" id="telefono1" class="uk-input input-personal">
			</div>
			<div>
				<label class="uk-form-label" for="empresa">Empresa</label>
				<input type="text" id="empresa" class="uk-input input-personal">
			</div>
			<div>
				<label class="uk-form-label" for="rfc">RFC</label>
				<input type="text" id="rfc" class="uk-input input-personal uk-text-uppercase">
			</div>
			<!-- DOMICILIO 1 -->
			<div>
				<label class="uk-form-label" for="calle">*Calle</label>
				<input type="text" id="calle" class="uk-input input-personal">
			</div>
			<div>
				<label class="uk-form-label" for="noexterior">*No. Exterior</label>
				<input type="text" id="noexterior" class="uk-input input-personal">
			</div>
			<div>
				<label class="uk-form-label" for="nointerior">No. Interior</label>
				<input type="text" id="nointerior" class="uk-input input-personal" >
			</div>
			<div>
				<label class="uk-form-label" for="entrecalles">*Entre calles</label>
				<input type="text" id="entrecalles" class="uk-input input-personal" >
			</div>
			<div>
				<label class="uk-form-label" for="pais">Pais</label>
				<input type="text" id="pais" class="uk-input input-personal" value="México" readonly>
			</div>
			<div>
				<label class="uk-form-label" for="estado">*Estado</label>
				<input type="text" id="estado" class="uk-input input-personal">
			</div>
			<div>
				<label class="uk-form-label" for="municipio">*Municipio</label>
				<input type="text" id="municipio" class="uk-input input-personal">
			</div>
			<div>
				<label class="uk-form-label" for="colonia">*Colonia</label>
				<input type="text" id="colonia" class="uk-input input-personal">
			</div>
			<div>
				<label class="uk-form-label" for="cp">*Código postal</label>
				<input type="text" id="cp" class="uk-input input-personal">
			</div>
			<div class="uk-width-1-1">
				* Campos obligatorios
			</div>
			<div class="uk-width-1-1 uk-text-center">
				<button id="send-registro" class="uk-button uk-button-large uk-button-personal border-orange uk-margin-top uk-text-nowrap">CONTINUAR &nbsp; <i uk-icon="icon:arrow-right;ratio:1.5;"></i></button>
			</div>
		</div>
	</div>
</div>

<?=$footer?>
 
<?=$scriptGNRL?>

<script>
	$("#send-registro").click(function(){
		var nombre = $("#nombre1").val();
		var telefono = $("#telefono1").val();
		var email = $("#email1").val();
		var password = $("#password").val();
		var empresa = $("#empresa").val();
		var rfc = $("#rfc").val();

		var calle = $("#calle").val();
		var noexterior = $("#noexterior").val();
		var nointerior = $("#nointerior").val();
		var entrecalles = $("#entrecalles").val();
		var pais = $("#pais").val();
		var estado = $("#estado").val();
		var municipio = $("#municipio").val();
		var colonia = $("#colonia").val();
		var cp = $("#cp").val();

		var fallo = 0;
		var alerta = '';
		$('input').removeClass('uk-form-danger');

		if (telefono=='') { fallo=1; alerta='Falta telefono'; id='telefono1'; }

		// Contraseña
		var l = password.length;
		if (l<6) { 
			fallo=1; alerta='Contraseña demasiado débil'; id='password';
		}

		// Correo
		if (email=='') { 
			fallo=1; alerta='Falta email'; id='email1';
		}else{
			var n = email.indexOf('@')
			var o = email.indexOf('.')
			if ((n*o)<6) {
				fallo=1; alerta='Proporcione un email válido'; id='email1';
			}
		}
		if (nombre=='') { fallo=1; alerta='Falta nombre'; id='nombre1'; }



		if (fallo == 0) {
			$('#send-registro').html("<div uk-spinner></div>");
			$('#send-registro').prop("disabled",true);
			$('#send-registro').disabled = true;
			UIkit.notification.closeAll();
			UIkit.notification("<div class='uk-text-center color-blanco bg-blue padding-10 text-lg'><i  uk-spinner></i> Espere...</div>");

			$.post("includes/acciones.php",{
				"registrodeusuarios" : 1,
				"nombre" : nombre,
				"email" : email,
				"password" : password,
				"empresa" : empresa,
				"rfc" : rfc,
				"telefono" : telefono,
				"calle" : calle,
				"noexterior" : noexterior,
				"nointerior" : nointerior,
				"entrecalles" : entrecalles,
				"pais" : pais,
				"estado" : estado,
				"municipio" : municipio,
				"colonia" : colonia,
				"cp" : cp
			},function(response){
				console.log(response);
				datos = JSON.parse(response);
				UIkit.notification.closeAll();
				UIkit.notification(datos.msj);
				if(datos.estatus==1){
					$('#send-registro').html("Volver a intentar");
					$('#send-registro').disabled = false;
					$('#send-registro').prop("disabled",false);
				}else{
					setTimeout(function(){
						<?php
						if ($carroTotalProds==0) {
							echo "window.location = ('mi-cuenta');";
						}else{
							echo "window.location = ('$rutaPedido2');";
						}
						?>

					},2000);
				}
			});
		}else{
			UIkit.notification.closeAll();
			UIkit.notification("<div class='bg-danger color-blanco padding-20 text-lg'><i class='fa fa-ban'></i> "+alerta+"</div>");
			$('#'+id).focus();
			$('#'+id).addClass('uk-form-danger');
		}
	});

	$("#email1").focusout(function() {
		var email  = $("#email1").val();
		var n = email.indexOf('@')
		var o = email.indexOf('.')

		if ((n*o)>6) {
			$.post("includes/acciones.php",{
				emailverify: 1,
				email: email
			},function(response){
				console.log(response);
				UIkit.notification.closeAll();
				datos = JSON.parse(response);
				if(datos.estatus==1){
					UIkit.notification(datos.msj);
					$('#email1').removeClass("uk-form-success");
					$("#email1").addClass("uk-form-danger");
				}else{
					$('#email1').removeClass("uk-form-danger");
					$("#email1").addClass("uk-form-success");
				}
			});
		}
	});

	$("#password").keyup(function() {
		var pass  = $("#password").val();
		var len   = (pass).length;

		if(len>6){
			$('#password').removeClass("uk-form-danger");
			$('#password').addClass("uk-form-success");
		}else{
			$('#password').removeClass("uk-form-success");
			$('#password').addClass("uk-form-danger");
		}
	});

	$(".fa-eye-slash").click(function(){
		var estatus = $(this).attr("data-estatus");
		if (estatus==0) {
			$("#password").prop("type","text");
			$(this).attr("data-estatus",1);
		}else{
			$("#password").prop("type","password");
			$(this).attr("data-estatus",0);
		};
	})

</script>

</body>
</html>