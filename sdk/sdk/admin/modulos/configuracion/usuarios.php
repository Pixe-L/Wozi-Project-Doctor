<?php
echo '
	<div class="uk-width-auto@m margin-top-20">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Configuración</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'" class="color-red">'.$archivo.'</a></li>
		</ul>
	</div>';


echo '
	<div class="uk-width-1-1">
		<div class="uk-container">
			<div class="uk-flex uk-flex-right">
				<a href="#add" uk-toggle  class="uk-button uk-button-success"><i uk-icon="icon:plus;ratio:1.4;"></i> &nbsp; Nuevo</a>
			</div>
			<div class="uk-container" style="max-width:600px;">
				<table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-small uk-table-responsive">
					<thead>
						<tr>
							<th>Nombre de usuario</th>
							<th width="80px"></th>
						</tr>
					</thead>
					<tbody>';
						$USER = $CONEXION -> query("SELECT * FROM user WHERE id != 1 ORDER BY user");
						$numRows = $USER ->num_rows;
						while($row_USER = $USER -> fetch_assoc()){

							$nivel=$row_USER['nivel'];
							switch ($nivel) {
								case 2:
									$clase='primary';
									$txt='Control total';
									break;
								
								default:
									$clase='';
									$txt='Restringido';
									break;
							}

							$nivelTable='
								<th class="uk-text-center">Nivel</th>
								<td class="uk-text-center">
									<button data-nivel="'.$nivel.'" data-id="'.$row_USER['id'].'" class="nivel uk-button uk-button-small uk-button-'.$clase.'">'.$txt.'</button>
								</td>
								';

							echo '
							<tr>
								<td>
									'.$row_USER['user'].'
								</td>
								<td class="uk-text-nowrap">
									<button data-id="'.$row_USER['id'].'" class="eliminar color-red" uk-icon="icon:trash;"></button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<a href="#editar" data-id="'.$row_USER['id'].'"  data-user="'.$row_USER['user'].'"  class="password uk-text-muted"  uk-toggle uk-icon="icon:lock;"></a>
								</td>
							</tr>';
						}

						echo '
					</tbody>
				</table>
			</div>
		</div>
	</div>
	';
?>

 
<div id="add" class="modal" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<button class="uk-modal-close-outside" type="button" uk-close></button>
		<form action="index.php" class="uk-form" method="post">
			<input type="hidden" name="modulo" value="<?=$modulo?>">
			<input type="hidden" name="archivo" value="<?=$archivo?>">
			<input type="hidden" name="new-user" value="1">
			
			<div class="uk-width-1-1 margin-bottom-20">
				<label class="uk-width-1-1">Usuario</label>
				<input type="text" class="uk-width-1-1 uk-input username" id="user" name="user">
			</div>

			<div class="uk-width-1-1 margin-bottom-20">
				<label class="uk-width-1-1">Contraseña</label>
				<input type="password" id="pass" name="pass" class="pass uk-width-1-1 uk-input" placeholder="Contraseña">
				<div id="mensaje" class="display-none">
					<div class="uk-alert uk-alert-danger" data-uk-alert>
						Debe tener al menos 6 caracteres
					</div>
				</div>
			</div>

			<div class="uk-width-1-1 margin-bottom-20">
				<label class="uk-width-1-1">Contraseña</label>
				<input type="password" id="passc" name="pass1" class="pass uk-width-1-1 uk-input" placeholder="Contraseña">
				<div id="mensajec" class="display-none">
					<div class="uk-alert uk-alert-danger" data-uk-alert>
						Las contraseñas no coinciden
					</div>
				</div>
			</div>

			<div class="uk-width-1-1 margin-bottom-20">
				<span class="password-revelar uk-margin uk-text-muted">Revelar contraseña</span>
				<span class="password-ocultar uk-hidden uk-margin uk-text-muted">Ocultar contraseña</span>
			</div>

			<div class="uk-width-1-1 uk-text-center">
				<a class="uk-button uk-button-default uk-button-large uk-modal-close">Cerrar</a>
				<button id="save" class="save uk-button uk-button-large uk-button-primary" disabled="true">Guardar</button>
			</div>
		</form>
	</div>
</div>


<div id="editar" class="modal" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<a class="uk-modal-close uk-close"></a>
		<form action="index.php" class="uk-form" method="post" onsubmit="return checkForm(this);">
			<input type="hidden" name="guardar" value="1">
			<input type="hidden" name="modulo" value="<?=$modulo?>">
			<input type="hidden" name="archivo" value="<?=$archivo?>">

			<input type="hidden" name="edit-user" value="1">
			<input type="hidden" name="id" id="password" value="0">

			<label class="uk-width-1-1">Usuario</label>
			<input type="text" class="uk-input uk-width-1-1 margin-bottom-20 editarusername" name="user" id="user1" value="" placeholder="Usuario">
			
			<label class="uk-width-1-1">Contraseña</label>
			<input type="password" id="pass1" class="uk-input uk-width-1-1 margin-bottom-20" name="pass">
			<div id="mensaje1" class="display-none">
				<div class="uk-alert uk-alert-danger" data-uk-alert>
					Debe tener al menos 6 caracteres
				</div>
			</div>
			
			<label class="uk-width-1-1">Confirmar contraseña</label>
			<input type="password" id="passc1" class="uk-input uk-width-1-1 margin-bottom-20" name="pass1">
			<div id="mensajec1" class="display-none">
				<div class="uk-alert uk-alert-danger" data-uk-alert>
					Las contraseñas no coinciden
				</div>
			</div>
			
			<div class="uk-width-1-1 uk-text-center uk-margin-top">
				<a class="uk-button uk-button-default uk-button-large uk-modal-close">Cerrar</a>
				<button id="save1" class="save uk-button uk-button-primary uk-button-small uk-button-large" disabled="true">Guardar</button>
			</div>
		
		</form>
	</div>
</div>



<?php
$scripts='
	// Eliminar usuario
	$(".eliminar").click(function() {
		var id = $(this).attr(\'data-id\');
		UIkit.modal.confirm("Desea eliminar esto?").then(function() {
			window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&borrarUser&id="+id);
		});
	});

	$(".password").click(function(){
		var id=$(this).attr("data-id");
		var user=$(this).attr("data-user");
		console.log(id);
		$("#password").val(id);
		$("#user1").val(user);
	});

	$("#passc").keyup(function() {
		var pass  = $("#pass").val();
		var passc = $(this).val();
		var len  = (pass).length;
		if(len<6){
			$("#mensaje").css("display","block");
		}else{
			$("#mensaje").css("display","none");
			if(pass!=passc){
				$("#mensajec").css("display","block");
			}else{
				$("#save").prop("disabled",false);
				$("#mensajec").css("display","none");
			}
		}
	});

	$("#passc1").keyup(function() {
		var pass  = $("#pass1").val();
		var passc = $(this).val();
		var len  = (pass).length;
		if(len<6){
			$("#mensaje1").css("display","block");
		}else{
			$("#mensaje1").css("display","none");
			if(pass!=passc){
				$("#mensajec1").css("display","block");
			}else{
				$("#save1").prop("disabled",false);
				$("#mensajec1").css("display","none");
			}
		}
	});

	$(".nivel").click(function(){
		var id = $(this).attr("data-id");
		var nivel = $(this).attr("data-nivel");
		if (nivel==1) {
			nivel=2;
			$(this).html("Control total");
			$(this).addClass("uk-button-primary");
		}else{
			nivel=1;
			$(this).html("Restringido");
			$(this).removeClass("uk-button-primary");
		}
		$(this).attr("data-nivel",nivel);
		$.post("modulos/'.$modulo.'/acciones.php", {
			editanivel: 1,
			nivel: (nivel),
			id: id
		})
	});
';

?>