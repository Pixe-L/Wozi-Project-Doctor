<?php
$fecha=date('m/d/Y');
?>

<form action="index.php" class="uk-width-1-1" method="post" name="editar" onsubmit="return checkForm(this);">

	<div uk-grid>
		<div class="uk-width-1-1 margin-v-20 uk-text-left">
			<ul class="uk-breadcrumb">
				<?php
				echo '
				<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=inicio">'.$modulo.'</a></li>
				<li class="color-red">Nuevo</li>
';
				?>
			</ul>
		</div>

		<input type="hidden" name="nuevo" value="1">
		<input type="hidden" name="modulo" value="<?=$modulo?>">
		
		<div class="uk-width-1-2">
			<div class="uk-margin-top">
				<label for="titulo">Nombre</label>
				<input type="text" class="uk-input" name="titulo" value="" autofocus required>
			</div>
			<div class="uk-margin-top">
				<label for="email">Email</label>
				<input type="text" class="uk-input" name="email" value="" required>
			</div>
			<div class="uk-margin-top">
				<label for="fecha">Fecha</label>
				<input type="date" name="fecha" class="uk-input" value="<?=$fecha?>">
			</div>
		</div>
		<div class="uk-width-1-2">
			<div class="uk-margin-top">
				<label for="txt">Testimonio</label>
				<textarea class="editor" name="txt"></textarea>
			</div>
		</div>
		<div class="uk-width-1-1 uk-margin-top uk-text-center">
			<a href="index.php?rand=<?=rand(1,1000)?>&modulo=<?=$modulo?>&archivo=inicio" class="uk-button uk-button-white uk-button-large" tabindex="10">Cancelar</a>					
			<button name="send" class="uk-button uk-button-primary uk-button-large">Guardar</button>
		</div>
	</div>
</form>

