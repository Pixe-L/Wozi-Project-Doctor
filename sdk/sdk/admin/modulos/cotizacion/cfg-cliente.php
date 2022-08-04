<?php
unset($_SESSION['clienteid']);
echo '
	<div class="margin-top-20">
		<ul class="uk-breadcrumb">
			<li><a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'">Cotizaciones</a></li>
			<li><a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'&archivo='.$archivo.'" class="color-red">Configurar cliente</a></li>
		</ul>
	</div>
	';
?>


	<div class="uk-container margin-v-20" style="max-width: 500px;">
		<form action="index.php" method="post">
			<input type="hidden" name="modulo" value="<?=$modulo?>">
			<input type="hidden" name="archivo" value="cfg-productos">
			<h4>CLIENTE EXISTENTE</h4>
			<div class="uk-margin">
				<select name="clienteid" data-placeholder="Seleccione un cliente" class="chosen-select">
					<option></option>
					<?php 
					$CONSULTA = $CONEXION -> query("SELECT * FROM usuarios ORDER BY empresa");
					while ($row_CONSULTA = $CONSULTA -> fetch_assoc()) {
						$thisName=html_entity_decode($row_CONSULTA['empresa'].' - '.$row_CONSULTA['nombre']);
						echo '
					<option value="'.$row_CONSULTA['id'].'">'.$thisName.'</option>';
					}
					?>

				</select>
			</div>
			<div class="uk-margin uk-text-center">
				<a href="index.php?rand=<?=rand(1,1000)?>&modulo=<?=$modulo?>" class="uk-button uk-button-white">Cancelar</a>
				<input type="submit" name="enviar" value="Siguiente" class="uk-button uk-button-primary">
			</div>
		</form>
	</div>


	<div class="uk-container padding-v-50">
		<form action="index.php" method="post" name="form"  onsubmit="return checkForm(this);">
			<input type="hidden" name="modulo" value="<?=$modulo?>">
			<input type="hidden" name="archivo" value="cfg-productos">
			<input type="hidden" name="clientes_nuevo" value="1">
			<div uk-grid class="uk-child-width-1-2@s">
				<div class="uk-width-1-1 padding-v-20">
					<h4 class="uk-text-center">CLIENTE NUEVO</h4>
				</div>
				<div>
					<label>Empresa</label>
					<input type="text" class="uk-input" name="empresa" required autofocus>
				</div>
				<div>
					<label>RFC</label>
					<input type="text" class="uk-input uk-text-uppercase" name="rfc" required>
				</div>
				<div>
					<label>Nombre</label>
					<input type="text" class="uk-input" name="nombre" required>
				</div>
				<div>
					<label>Email</label>
					<input type="text" class="uk-input" name="email" required>
				</div>
				<div>
					<label>Celular</label>
					<input type="text" class="uk-input" name="telefono" required>
				</div>
				<div>
					<label>Teléfono</label>
					<input type="text" class="uk-input" name="telefono2" required>
				</div>
				<div>
					<label>Dirección</label>
					<input type="text" class="uk-input" name="domicilio" required>
				</div>
				<div>
					<label>Entrega</label>
					<input type="text" class="uk-input" name="entrega">
				</div>
				<div class="uk-width-1-1">
					<div class="uk-margin uk-text-center">
						<a href="index.php?rand=<?=rand(1,1000)?>&modulo=<?=$modulo?>&archivo=clientes" class="uk-button uk-button-white uk-button-large" tabindex="10">Cancelar</a>
						<input type="submit" name="enviar" value="Guardar" class="uk-button uk-button-primary uk-button-large">
					</div>
				</div>
			</div>
		</form>
	</div>




