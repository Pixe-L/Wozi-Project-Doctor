<?php
$CONSULTA = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 1");
$rowCONSULTA = $CONSULTA -> fetch_assoc();

echo '
<div class="uk-width-auto@m margin-top-20">
	<ul class="uk-breadcrumb uk-text-capitalize">
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Configuración</a></li>
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'" class="color-red">'.$archivo.'</a></li>
	</ul>
</div>




<div class="uk-width-1-1">
	<div class="uk-container">
		<div uk-grid>

			<div class="uk-width-1-2@s margin-v-50 uk-text-left">
				<input value="'.$rowCONSULTA['tyct1'].'" data-tabla="configuracion" data-campo="tyct1" data-id="1" class="editarajax uk-input uk-form-blank">
				<form action="index.php" method="post">
					<input type="hidden" name="modulo" value="'.$modulo.'">
					<input type="hidden" name="editartextosconformato" value="1">
					<input type="hidden" name="archivo" value="politicas">
					<textarea class="editor min-height-150" name="tyc1">'.$rowCONSULTA['tyc1'].'</textarea>
					<br>
					<div class="uk-text-center">
						<button class="uk-button uk-button-primary">Guardar</button>
					</div>
				</form>
			</div>

			<div class="uk-width-1-2@s margin-v-50 uk-text-left">
				<input value="'.$rowCONSULTA['tyct2'].'" data-tabla="configuracion" data-campo="tyct2" data-id="1" class="editarajax uk-input uk-form-blank">
				<form action="index.php" method="post">
					<input type="hidden" name="modulo" value="'.$modulo.'">
					<input type="hidden" name="editartextosconformato" value="1">
					<input type="hidden" name="archivo" value="politicas">
					<textarea class="editor min-height-150" name="tyc2">'.$rowCONSULTA['tyc2'].'</textarea>
					<br>
					<div class="uk-text-center">
						<button class="uk-button uk-button-primary">Guardar</button>
					</div>
				</form>
			</div>

			<div class="uk-width-1-2@s margin-v-50 uk-text-left">
				<input value="'.$rowCONSULTA['tyct3'].'" data-tabla="configuracion" data-campo="tyct3" data-id="1" class="editarajax uk-input uk-form-blank">
				<form action="index.php" method="post">
					<input type="hidden" name="modulo" value="'.$modulo.'">
					<input type="hidden" name="editartextosconformato" value="1">
					<input type="hidden" name="archivo" value="politicas">
					<textarea class="editor min-height-150" name="tyc3">'.$rowCONSULTA['tyc3'].'</textarea>
					<br>
					<div class="uk-text-center">
						<button class="uk-button uk-button-primary">Guardar</button>
					</div>
				</form>
			</div>

			<div class="uk-width-1-2@s margin-v-50 uk-text-left">
				<input value="'.$rowCONSULTA['tyct4'].'" data-tabla="configuracion" data-campo="tyct4" data-id="1" class="editarajax uk-input uk-form-blank">
				<form action="index.php" method="post">
					<input type="hidden" name="modulo" value="'.$modulo.'">
					<input type="hidden" name="editartextosconformato" value="1">
					<input type="hidden" name="archivo" value="politicas">
					<textarea class="editor min-height-150" name="tyc4">'.$rowCONSULTA['tyc4'].'</textarea>
					<br>
					<div class="uk-text-center">
						<button class="uk-button uk-button-primary">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>';