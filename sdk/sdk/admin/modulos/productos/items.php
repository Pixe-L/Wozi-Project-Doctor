<?php
	$CATEGORIAS = $CONEXION -> query("SELECT * FROM $modulocat WHERE id = $cat");
	$row_CATEGORIAS = $CATEGORIAS -> fetch_assoc();
	$catNAME=$row_CATEGORIAS['txt'];
	$parent=$row_CATEGORIAS['parent'];
	$CATPARENT = $CONEXION -> query("SELECT * FROM $modulocat WHERE id = $parent");
	$row_CATPARENT = $CATPARENT -> fetch_assoc();
	$catParentName=$row_CATPARENT['txt'];

// BREADCRUMB
	echo '
	<div class="uk-width-auto margin-top-20 uk-text-left">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Productos</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=categorias">Categorías</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=catdetalle&cat='.$parent.'">'.$catParentName.'</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=items&cat='.$cat.'" class="color-red">'.$catNAME.'</a></li>
		</ul>
	</div>
	';


// BOTONES SUPERIORES
	echo '
	<div class="uk-width-expand@m margin-v-20">
		<div uk-grid class="uk-grid-small uk-flex-right">
			<div>
				<a href="index.php?rand='.rand(1,9999).'&modulo='.$modulo.'&archivo=nuevo&cat='.$cat.'"" class="uk-button uk-button-success"><i uk-icon="plus"></i> &nbsp; Nuevo</a>
			</div>
		</div>
	</div>';


// TABLA DE INFORMACIÓN
	echo '
	<div class="uk-width-1-1 margin-v-50">
		<div class="uk-container">
			<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle uk-table-responsive" id="ordenar">
				<thead>
					<tr>
						<th width="40px"></th>
						<th class="pointer" onclick="sortTable(1)" width="10px">SKU</th>
						<th class="pointer" onclick="sortTable(2)" width="auto">Modelo</th>
						<th class="pointer" onclick="sortTable(3)" width="100px">Precio</th>
						<th class="pointer" onclick="sortTable(4)" width="100px">Descuento</th>
						<th width="80px"></th>
					</tr>
				</thead>
				<tbody>';
				$CONSULTA = $CONEXION -> query("SELECT * FROM $modulo WHERE categoria = $cat ORDER BY orden");
				while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
					$prodID=$rowCONSULTA['id'];

					$CONSULTA1 = $CONEXION -> query("SELECT * FROM $modulopic WHERE producto = $prodID ORDER BY orden");
					$rowCONSULTA1 = $CONSULTA1 -> fetch_assoc();
					$picId=$rowCONSULTA1['id'];
					$picROW='';
					$pic=$rutaFinal.$picId.'-sm.jpg';
					if(file_exists($pic)){
						$picROW='
							<div class="uk-inline">
								<i uk-icon="camera"></i>
								<div uk-drop="pos: right-justify">
									<img uk-img data-src="'.$pic.'" class="uk-border-rounded">
								</div>
							</div>';
					}
					$link='index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=detalle&id='.$rowCONSULTA['id'];

					$estatusIcon=($rowCONSULTA['estatus']==1)?'off uk-text-muted':'on uk-text-primary';

					$clasePrecio='';
					$claseDescuento='';
					if ($rowCONSULTA['precio']==0) {
						$clasePrecio='bg-grey';
						$claseDescuento='bg-grey';
					}

					echo '
					<tr id="'.$rowCONSULTA['id'].'">
						<td class="uk-text-nowrap">
							'.$picROW.'
						</td>
						<td class="uk-text-nowrap">
							'.$rowCONSULTA['sku'].'
						</td>
						<td class="uk-text-truncate">
							'.$rowCONSULTA['titulo'].'
						</td>
						<td>
							<span class="uk-hidden">'.(10000+(1*($rowCONSULTA['precio']))).'</span>
							<input type="number" class="editarajax uk-input uk-form-small uk-text-right '.$clasePrecio.'" data-tabla="'.$modulo.'" data-campo="precio" data-id="'.$prodID.'" value="'.$rowCONSULTA['precio'].'" tabindex="8">
						</td>
						<td>
							<span class="uk-hidden">'.(10000+(1*($rowCONSULTA['descuento']))).'</span>
							<input type="number" class="editarajax uk-input uk-form-small uk-text-right '.$claseDescuento.'" data-tabla="'.$modulo.'" data-campo="descuento" data-id="'.$prodID.'" value="'.$rowCONSULTA['descuento'].'" tabindex="9">
						</td>
						<td >
							<button data-id="'.$rowCONSULTA['id'].'" class="eliminaprod color-red" tabindex="1" uk-icon="icon:trash"></button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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


$scripts='
	// Eliminar producto
		$(".eliminaprod").click(function() {
			var id = $(this).attr(\'data-id\');
			//console.log(id);
			var statusConfirm = confirm("Realmente desea eliminar este Producto?"); 
			if (statusConfirm == true) { 
				window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=items&borrarPod&cat='.$cat.'&id="+id);
			} 
		});

	// Subir imagen 1
		$(document).ready(function() {
			$("#fileuploader").uploadFile({
				url:"../library/upload-file/php/upload.php",
				fileName:"myfile",
				maxFileCount:1,
				showDelete: \'false\',
				allowedTypes: "png,svg",
				maxFileSize: 6291456,
				showFileCounter: false,
				showPreview:false,
				returnType:\'json\',
				onSuccess:function(data){ 
					window.location = (\'index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&cat='.$cat.'&position=cat&imagen=\'+data);
				}
			});

	// Subir imagen 2
			$("#fileuploaderhover").uploadFile({
				url:"../library/upload-file/php/upload.php",
				fileName:"myfile",
				maxFileCount:1,
				showDelete: \'false\',
				allowedTypes: "jpg,jpeg",
				maxFileSize: 6291456,
				showFileCounter: false,
				showPreview:false,
				returnType:\'json\',
				onSuccess:function(data){ 
					window.location = (\'index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&cat='.$cat.'&position=cathover&imagen=\'+data);
				}
			});
		});

		';



