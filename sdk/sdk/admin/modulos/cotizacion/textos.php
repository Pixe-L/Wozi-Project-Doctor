<?php 
	$CONSULTA = $CONEXION -> query("SELECT * FROM cotizacion_config WHERE id = 1");
	$row_CONSULTA = $CONSULTA -> fetch_assoc();

// Breadcrumb
	echo '
	<div class="margin-top-20">
		<ul class="uk-breadcrumb">
			<li><a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'">Cotizaciones</a></li>
			<li><a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'&archivo='.$archivo.'" class="color-red">'.$archivo.'</a></li>
		</ul>
	</div>


	<div class="uk-card uk-card-default uk-card-body">
		<form action="index.php" method="post" name="form"  onsubmit="return checkForm(this);">
			<input type="hidden" name="modulo" value="'.$modulo.'">
			<input type="hidden" name="archivo" value="'.$archivo.'">
			<input type="hidden" name="id" value="1">
			<input type="hidden" name="action" value="textos_editar">

			<div uk-grid class="uk-child-width-1-2@s">

				<div>
					<label for="encabezado">Encabezado</label>
					<textarea class="uk-textarea min-height-150" name="encabezado">'.$row_CONSULTA['encabezado'].'</textarea>
				</div>
				<div>
					<label for="txt1">Observaciones</label>
					<textarea class="uk-textarea min-height-150" name="txt1">'.$row_CONSULTA['txt1'].'</textarea>
				</div>
				<div>
					<label for="cuentas0">Cuentas Inveco</label>
					<textarea class="uk-textarea min-height-150" name="cuentas0">'.$row_CONSULTA['cuentas0'].'</textarea>
				</div>
				<div>
					<label for="cuentas1">Cuentas Inveco Centro</label>
					<textarea class="uk-textarea min-height-150" name="cuentas1">'.$row_CONSULTA['cuentas1'].'</textarea>
				</div>
				<div>
					<label for="txt3">Notas</label>
					<textarea class="uk-textarea min-height-150" name="txt3">'.$row_CONSULTA['txt3'].'</textarea>
				</div>
				<div>
					<label for="txt4">Nota importante</label>
					<textarea class="uk-textarea min-height-150" name="txt4">'.$row_CONSULTA['txt4'].'</textarea>
				</div>
				<div class="uk-width-1-1">
					<label for="txt5">Aviso de privacidad</label>
					<textarea class="uk-textarea min-height-150" name="txt5">'.$row_CONSULTA['txt5'].'</textarea>
				</div>
				<div class="uk-width-1-1 uk-text-center">
					<a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=inicio" class="uk-button uk-button-large uk-button-default" tabindex="10">Cancelar</a>
					<input type="submit" name="enviar" value="Guardar" class="uk-button uk-button-large uk-button-primary">
				</div>

			</div>
		</form>
	</div>';




