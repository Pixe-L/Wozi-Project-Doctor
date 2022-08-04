<?php
$faq = $CONEXION -> query("SELECT * FROM faq WHERE id = $id");
$row_catalogo = $faq -> fetch_assoc();

echo '
<div class="uk-width-auto@m margin-top-20">
	<ul class="uk-breadcrumb uk-text-capitalize">
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Configuración</a></li>
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=faq">FAQ</a></li>
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&id='.$id.'" class="color-red">Editar pregunta</a></li>
	</ul>
</div>

<div class="uk-width-1-1">
	<div class="uk-container uk-container-small">
		<div class="padding-v-20 uk-text-right">
			<a href="index.php?rand='.rand(1,99999).'&modulo='.$modulo.'&archivo=faqnuevo" id="add-button" class="uk-button uk-button-success"><i uk-icon="icon: plus;ratio:1.4"></i> &nbsp; Nuevo</a>
		</div>
		<form action="index.php" method="post">
			<input type="hidden" name="faqeditar" value="1">
			<input type="hidden" name="modulo" value="'.$modulo.'">
			<input type="hidden" name="archivo" value="'.$archivo.'">
			<input type="hidden" name="id" value="'.$id.'">

			<div class="uk-margin">
				<label for="pregunta">Pregunta</label>
				<input type="text" class="uk-input" name="pregunta" value="'.$row_catalogo['pregunta'].'" autofocus>
			</div>
			<div class="uk-margin">
				<label for="respuesta">Respuesta</label>
				<textarea class="editor" name="respuesta">'.$row_catalogo['respuesta'].'</textarea>
			</div>
			<div class="uk-margin uk-text-center">
				<button name="send" class="uk-button uk-button-primary uk-button-large">Guardar</button>
			</div>

		</form>
	</div>
</div>


';
