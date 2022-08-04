<?php
$CONSULTA = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 1");
$rowCONSULTA = $CONSULTA -> fetch_assoc();

$seguridad1='';
$seguridad2='';
$seguridad3='';
switch ($rowCONSULTA['remitenteseguridad']) {
	case 'SSL':
		$seguridad1='selected';
		break;
	case 'TLS':
		$seguridad1='selected';
		break;
	case 'STARTTLS':
		$seguridad1='selected';
		break;
}


echo'
	<div class="uk-width-1-1 margin-top-20 uk-text-left">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Configuración</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'" class="color-red">'.$archivo.'</a></li>
		</ul>
	</div>


	<div class="uk-width-1-1">
		<div class="uk-container uk-container-xsmall">
			<div>

				<div class="margin-v-50">
					<h3>Teléfonos</h3>
				</div>

				<div class="uk-margin">
					<div uk-grid>
						<div>
							<label class="uk-form-label">Teléfono fijo</label>
						</div>
						<div class="uk-width-expand">
							<input type="number" class="input-number editarajax uk-input" data-tabla="'.$modulo.'" data-campo="telefono" data-id="1" value="'.$rowCONSULTA['telefono'].'">
						</div>
					</div>
				</div>
				<div class="uk-margin">
					<div uk-grid>
						<div>
							<label class="uk-form-label">Whatsapp</label>
						</div>
						<div class="uk-width-expand">
							<input type="number" class="input-number editarajax uk-input" data-tabla="'.$modulo.'" data-campo="telefono1" data-id="1" value="'.$rowCONSULTA['telefono1'].'">
						</div>
					</div>
				</div>

				<div class="margin-v-50">
					<h3>Redes sociales</h3>
				</div>

				<div class="uk-margin">
					<div uk-grid>
						<div>
							<label for="facebook" class="uk-form-label">Facebook</label>
						</div>
						<div class="uk-width-expand">
							<input type="text" class="editarajax uk-input" data-tabla="'.$modulo.'" data-campo="facebook" data-id="1" value="'.$rowCONSULTA['facebook'].'">
						</div>
					</div>
				</div>

				<div class="uk-margin">
					<div uk-grid>
						<div>
							<label for="instagram" class="uk-form-label">Instagram</label>
						</div>
						<div class="uk-width-expand">
							<input type="text" class="editarajax uk-input" data-tabla="'.$modulo.'" data-campo="instagram" data-id="1" value="'.$rowCONSULTA['instagram'].'">
						</div>
					</div>
				</div>

				<div class="uk-margin">
					<div uk-grid>
						<div>
							<label for="youtube" class="uk-form-label">YouTube</label>
						</div>
						<div class="uk-width-expand">
							<input type="text" class="editarajax uk-input" data-tabla="'.$modulo.'" data-campo="youtube" data-id="1" value="'.$rowCONSULTA['youtube'].'">
						</div>
					</div>
				</div>

			</div>
			<div>

				<div class="margin-v-50">
					<h3>Envío de correo</h3>
				</div>

				<div class="uk-margin">
					<div uk-grid>
						<div>
							<label for="destinatario1" class="uk-form-label">Destinatario 1</label>
						</div>
						<div class="uk-width-expand">
							<input type="text" class="editarajax uk-input" data-tabla="'.$modulo.'" data-campo="destinatario1" data-id="1" value="'.$rowCONSULTA['destinatario1'].'" placeholder="Obligatorio">
						</div>
					</div>
				</div>
				<div class="uk-margin">
					<div uk-grid>
						<div>
							<label for="destinatario2" class="uk-form-label">Destinatario 2</label>
						</div>
						<div class="uk-width-expand">
							<input type="text" class="editarajax uk-input" data-tabla="'.$modulo.'" data-campo="destinatario2" data-id="1" value="'.$rowCONSULTA['destinatario2'].'" placeholder="Opcional">
						</div>
					</div>
				</div>


				<div class="margin-v-50">
					<h3>Autentificación</h3>
				</div>

				<div class="uk-width-1-1@m uk-margin">
					<div uk-grid>
						<div>
							<label for="remitente" class="uk-form-label">Remitente</label>
						</div>
						<div class="uk-width-expand">
							<input type="text" class="editarajax uk-input" data-tabla="'.$modulo.'" data-campo="remitente" data-id="1" value="'.$rowCONSULTA['remitente'].'">
						</div>
					</div>
				</div>

				<div class="uk-width-1-1@m uk-margin">
					<div uk-grid>
						<div>
							<label for="remitentepass" class="uk-form-label">Contraseña</label>
						</div>
						<div class="uk-width-expand">
							<input type="text" class="editarajax uk-input" data-tabla="'.$modulo.'" data-campo="remitentepass" data-id="1" value="'.$rowCONSULTA['remitentepass'].'">
						</div>
					</div>
				</div>

				<div class="uk-width-1-1@m uk-margin">
					<div uk-grid>
						<div>
							<label for="remitentehost" class="uk-form-label">Servidor</label>
						</div>
						<div class="uk-width-expand">
							<input type="text" class="editarajax uk-input" data-tabla="'.$modulo.'" data-campo="remitentehost" data-id="1" value="'.$rowCONSULTA['remitentehost'].'">
						</div>
					</div>
				</div>

				<div class="uk-width-1-1@m uk-margin">
					<div uk-grid>
						<div>
							<label for="remitenteport" class="uk-form-label">Puerto</label>
						</div>
						<div class="uk-width-expand">
							<input type="text" class="editarajax uk-input" data-tabla="'.$modulo.'" data-campo="remitenteport" data-id="1" value="'.$rowCONSULTA['remitenteport'].'">
						</div>
					</div>
				</div>

				<div class="uk-width-1-1@m uk-margin">
					<div uk-grid>
						<div>
							<label for="remitenteseguridad" class="uk-form-label">Seguridad</label>
						</div>
						<div class="uk-width-expand">
							<select class="editarajax uk-input" data-tabla="'.$modulo.'" data-campo="remitenteseguridad" data-id="1">
								<option></option>
								<option '.$seguridad1.'>SSL</option>
								<option '.$seguridad2.'>TLS</option>
								<option '.$seguridad3.'>STARTTLS</option>
							</select>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>

	';


		