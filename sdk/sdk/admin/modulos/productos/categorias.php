<?php
// BREADCRUMB
	echo '
	<div class="uk-width-auto margin-top-20 uk-text-left">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Productos</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=categorias" class="color-red">Categorías</a></li>
		</ul>
	</div>';


// BOTONES SUPERIORES
	echo '
	<div class="uk-width-expand@m margin-v-20">
		<div uk-grid class="uk-grid-small uk-flex-right">
			<div>
				<a href="#add" uk-toggle class="uk-button uk-button-success"><i uk-icon="plus"></i> &nbsp; Nuevo</a>
			</div>
		</div>
	</div>';


// TABLA DE CATEGORÍAS
	echo '
	<div class="uk-width-1-1 margin-v-20">
		<div class="uk-container">
			<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle" id="ordenar">
				<thead>
					<tr>
						<th onclick="sortTable(0)" class="pointer uk-text-left">Categoría</th>
						<th width="120px" onclick="sortTable(1)" class="pointer uk-text-center">Imagen frontal</th>
						<th width="120px" onclick="sortTable(1)" class="pointer uk-text-center">Imagen hover</th>
						<th width="120px" onclick="sortTable(1)" class="pointer uk-text-center">SubCategorías</th>
						<th width="100px" ></th>
					</tr>
				</thead>
				<tbody class="sortable" data-tabla="'.$modulocat.'">';

					// Obtener subcategorías
					$numeroProds=0;
					$subcatsNum=0;
					$Consulta = $CONEXION -> query("SELECT * FROM $modulocat WHERE parent = 0 ORDER BY orden,txt");
					$numeroSubcats = $Consulta->num_rows;
					while ($row_Consulta = $Consulta -> fetch_assoc()) {

						$catId = $row_Consulta['id'];
						$filas = $CONEXION -> query("SELECT * FROM $modulocat WHERE parent = '$catId'");
						$numeroCats = $filas->num_rows;

						$link='index.php?rand='.rand(1,90000).'&modulo='.$modulo.'&archivo=catdetalle&cat='.$catId;

						$pic=$rutaFinal.$row_Consulta['imagen'];
						$fichaIcon='<i class="fa-lg far fa-square uk-text-muted pointer"></i>';
						if(file_exists($pic) AND strlen($row_Consulta['imagen'])>0){
							$fichaIcon='
								<div class="uk-inline">
									<i class="fa-lg fas fa-check-square uk-text-primary pointer"></i>
									<div uk-drop="pos: right-justify">
										<img uk-img data-src="'.$pic.'" class="uk-border-rounded">
									</div>
								</div>';
						}
						$pic=$rutaFinal.$row_Consulta['imagenhover'];
						$fichaIcon2='<i class="fa-lg far fa-square uk-text-muted pointer"></i>';
						if(file_exists($pic) AND strlen($row_Consulta['imagenhover'])>0){
							$fichaIcon2='
								<div class="uk-inline">
									<i class="fa-lg fas fa-check-square uk-text-primary pointer"></i>
									<div uk-drop="pos: right-justify">
										<img uk-img data-src="'.$pic.'" class="uk-border-rounded">
									</div>
								</div>';
						}

						$borrarSubcat='<a href="javascript:eliminaCat(id='.$catId.')" class="color-red" uk-icon="icon:trash"></a>';
						if ($numeroCats>0) {
							$borrarSubcat='<a class="uk-text-muted" uk-tooltip title="No puede eliminar<br>elimine antes su contenido" uk-icon="icon:trash"></a>';
						}
						echo '
								<tr id="'.$row_Consulta['id'].'">
									<td class="uk-text-left">
										<input type="text" value="'.$row_Consulta['txt'].'" class="editarajax uk-input uk-form-small uk-form-blank" data-tabla="'.$modulocat.'" data-campo="txt" data-id="'.$row_Consulta['id'].'" tabindex="10" >
									</td>
									<td class="uk-text-center">
										<a href="#ficha" uk-toggle data-id="'.$row_Consulta['id'].'" data-campo="cat" class="fichalink">'.$fichaIcon.'</a>
									</td>
									<td class="uk-text-center">
										<a href="#ficha" uk-toggle data-id="'.$row_Consulta['id'].'" data-campo="cathover" class="fichalink">'.$fichaIcon2.'</a>
									</td>
									<td class="uk-text-center">
										'.$numeroCats.'
									</td>
									<td class="uk-text-nowrap">
										'.$borrarSubcat.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<a href="'.$link.'" class="uk-text-primary" uk-icon="search"></a>
									</td>
								</tr>';
					}

			echo '
				</tbody>
			</table>
		</div>
	</div>
	';


// MODAL SUBIR ARCHIVO
	echo '
	<div id="ficha" uk-modal>
		<div class="uk-modal-dialog uk-modal-body">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<input type="hidden" id="fichaid">
			<input type="hidden" id="fichacampo">
			<p>JPG 220 x 270 px</p>
			<div id="fileupload">
				Cargar
			</div>
		</div>
	</div>';


// MODAL NUEVA CATEGORÍA
	echo '
	<div id="add" uk-modal="center: true" class="modal">
		<div class="uk-modal-dialog uk-modal-body">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<form action="index.php" class="uk-width-1-1 uk-text-center uk-form" method="post" name="editar" onsubmit="return checkForm(this);">

				<input type="hidden" name="nuevacategoria" value="1">
				<input type="hidden" name="modulo" value="'.$modulo.'">
				<input type="hidden" name="archivo" value="'.$archivo.'">
				<input type="hidden" name="cat" value="0">

				<label for="categoria">Nombre de la Categoría</label><br><br>
				<input type="text" name="categoria" class="uk-input" required><br><br>
				<a class="uk-button uk-button-white uk-modal-close">Cerrar</a>
				<input type="submit" name="send" value="Agregar" class="uk-button uk-button-primary">
			</form>
		</div>
	</div>
	';


$scripts='
	// Eliminar
		function eliminaCat () { 
			var statusConfirm = confirm("Realmente desea eliminar esta categoria?"); 
			if (statusConfirm == true) { 
				window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&eliminarCat&cat='.$cat.'&id="+id);
			} 
		};

	// Asignar id seleccionado al input para subir imagen
		$(".fichalink").click(function(){
			var id = $(this).attr("data-id");
			$("#fichaid").val(id);
			var campo = $(this).attr("data-campo");
			$("#fichacampo").val(campo);
		})

	// Subir imagen
		$("#fileupload").uploadFile({
			url: "../library/upload-file/php/upload.php",
			fileName: "myfile",
			maxFileCount: 1,
			showDelete: \'false\',
			allowedTypes: "jpg,jpeg,png,gif",
			maxFileSize: 10000000,
			showFileCounter: false,
			showPreview: false,
			returnType: \'json\',
			onSuccess:function(data){
				var id = $("#fichaid").val();
				var campo = $("#fichacampo").val();
				window.location = (\'index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&position=\'+campo+\'&cat=\'+id+\'&filename=\'+data);
			}
		});';

