<?php
echo'
<div class="uk-width-1-3@m margin-top-20">
	<ul class="uk-breadcrumb">
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">'.$modulo.'</a></li>
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=nuevo" class="color-red">Nuevo</a></li>
	</ul>
</div>';
?>

<form action="index.php" class="uk-width-1-1" method="post" name="editar" onsubmit="return checkForm(this);">

	<div class="uk-container uk-container-small">

		<input type="hidden" name="nuevo" value="1">
		<input type="hidden" name="modulo" value="<?=$modulo?>">
		<input type="hidden" name="archivo" value="detalle">
	
		<div class="uk-margin">
			<label for="titulo">Título</label>
			<input type="text" class="uk-input" name="titulo" required autofocus>
		</div>
		<div class="uk-margin">
			<label for="video">video de youtube</label>
			<input type="text" class="uk-input" name="video">
		</div>
		<div class="uk-margin">
			<label for="txt">Descripción</label>
			<textarea class="editor" name="txt"></textarea>
		</div>
		<div class="uk-width-1-1 uk-text-center margin-top-20">
			<a href="index.php?rand=<?=rand(1,1000)?>&modulo=<?=$modulo?>" class="uk-button uk-button-white uk-button-large" tabindex="10">Cancelar</a>
			<input type="submit" name="send" value="Agregar" class="uk-button uk-button-primary uk-button-large">
		</div>
	</div>
</form>
