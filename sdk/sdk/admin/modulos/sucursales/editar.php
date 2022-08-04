<?php 
$CONSULTA = $CONEXION -> query("SELECT * FROM $modulo WHERE id = $id");
$rowCONSULTA = $CONSULTA -> fetch_assoc();

echo '
<div class="uk-width-1-1 margin-v-20">
	<ul class="uk-breadcrumb uk-text-capitalize">
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Planteles</a></li>
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=detalle&id='.$id.'">'.$rowCONSULTA['titulo'].'</a></li>
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=editar&id='.$id.'" class="color-red">Editar</a></li>
	</ul>
</div>

<div class="uk-width-1-1 margin-top-20">
	<div class="uk-container uk-container-small">
		<form action="index.php" method="post" enctype="multipart/form-data" name="datos" onsubmit="return checkForm(this);">
			<input type="hidden" name="editar" value="1">
			<input type="hidden" name="modulo" value="'.$modulo.'">
			<input type="hidden" name="archivo" value="detalle">
			<input type="hidden" name="id" value="'.$id.'">
			<div class="uk-margin">
				<label class="uk-text-capitalize" for="titulo">Título:</label>
				<input type="text" class="uk-input" name="titulo" value="'.$rowCONSULTA['titulo'].'" autofocus required>
			</div>
			<div class="uk-margin">
				<label for="txt">Aplicaciones</label>
				<textarea class="editor" name="txt">'.$rowCONSULTA['txt'].'</textarea>
			</div>
			<div class="uk-margin uk-text-center">
				<a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=detalle&id='.$id.'" class="uk-button uk-button-default uk-button-large" tabindex="10">Cancelar</a>					
				<button name="send" class="uk-button uk-button-primary uk-button-large">Guardar</button>
			</div>
		</form>
	</div>
</div>


';