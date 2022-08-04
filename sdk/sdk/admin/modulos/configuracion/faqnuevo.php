
<?php
echo '
<div class="uk-width-auto@m margin-top-20">
	<ul class="uk-breadcrumb uk-text-capitalize">
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Configuración</a></li>
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=faq">FAQ</a></li>
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'" class="color-red">Nueva pregunta</a></li>
	</ul>
</div>';
?>



<div class="uk-width-1-1">
	<div class="uk-container uk-container-small">
		<form action="index.php" class="uk-width-1-1" method="post" name="editar" onsubmit="return checkForm(this);">
			<input type="hidden" name="nuevo" value="1">
			<input type="hidden" name="modulo" value="<?=$modulo?>">
			<input type="hidden" name="archivo" value="faqdetalle">
		
			<div class=" uk-margin">
				<label for="pregunta">Pregunta</label>
				<input type="text" class="uk-input" name="pregunta" autofocus>
			</div>
			<div class=" uk-margin">
				<label for="respuesta">Respuesta</label>
				<textarea class="editor uk-width-1-1" name="respuesta"></textarea>
			</div>
			<div class="uk-width-1-1 uk-text-center uk-margin">
				<button name="send" class="uk-button uk-button-primary uk-button-large">Guardar</button>
			</div>
		</form>
	</div>
</div>

