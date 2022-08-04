<?php 
	$pag=(isset($_GET['pag']))?$_GET['pag']:0;
	$prodspagina=(isset($_GET['prodspagina']))?$_GET['prodspagina']:20;
	$consulta = $CONEXION -> query("SELECT * FROM $modulo");

	$numItems=$consulta->num_rows;
	$prodInicial=$pag*$prodspagina;

	$sql="SELECT * FROM productostalla WHERE id = '$id'";
	//echo '<br>'.$sql;
	$CONSULTA = $CONEXION -> query($sql);
	$rowCONSULTA = $CONSULTA -> fetch_assoc();

echo '
	<div class="uk-width-1-3@s margin-top-20">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Productos</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&id='.$id.'" class="color-red">Talla '.$rowCONSULTA['txt'].'</a></li>
		</ul>
	</div>';

echo '
	<div class="uk-width-1-1">
		<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle uk-table-responsive" id="ordenar">
			<thead>
				<tr>
					<th width="40px"></th>
					<th width="100px" class="pointer" onclick="sortTable(1)">SKU</th>
					<th width="auto"  class="pointer" onclick="sortTable(2)">Modelo</th>
					<th width="100px" class="pointer" onclick="sortTable(3)">Material</th>
					<th width="100px" class="pointer" onclick="sortTable(5)">Precio</th>
					<th width="90px"  class="pointer" onclick="sortTable(6)">Descuento</th>
					<th width="50px"  class="pointer" onclick="sortTable(7)">En inicio</th>
					<th width="50px"  class="pointer" onclick="sortTable(8)">Activo</th>
					<th width="90px"></th>
				</tr>
			</thead>
			<tbody>';

			$sql="SELECT DISTINCT producto FROM productosexistencias WHERE talla = '$id' AND estatus = 1";
			//echo '<tr><td colspan="10">'.$sql.'</td></tr>';
			$CONSULTA2 = $CONEXION -> query($sql);
			while ($rowCONSULTA2 = $CONSULTA2 -> fetch_assoc()) {
				$prodID=$rowCONSULTA2['producto'];

				$sql="SELECT * FROM productos WHERE id = '$prodID'";
				//echo '<tr><td colspan="10">'.$sql.'</td></tr>';
				$CONSULTA = $CONEXION -> query($sql);
				$numProds = $CONSULTA->num_rows;
				if ($numProds>0) {
					$rowCONSULTA = $CONSULTA -> fetch_assoc();

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

					$inicioIcon=($rowCONSULTA['inicio']==0)?'off uk-text-muted':'on uk-text-primary';
					$estatusIcon=($rowCONSULTA['estatus']==0)?'off uk-text-muted':'on uk-text-primary';

					echo '
					<tr id="'.$prodID.'">
						<td class="uk-text-center">
							'.$picROW.'
						</td>
						<td>
							<input value="'.$rowCONSULTA['sku'].'" type="text" class="editarajax uk-input uk-form-small uk-form-blank" data-tabla="'.$modulo.'" data-campo="sku" data-id="'.$prodID.'" tabindex="6">
						</td>
						<td>
							<input value="'.$rowCONSULTA['titulo'].'" type="text" class="editarajax uk-input uk-form-small uk-form-blank" data-tabla="'.$modulo.'" data-campo="titulo" data-id="'.$prodID.'" tabindex="7">
						</td>
						<td>
							<input value="'.$rowCONSULTA['material'].'" type="text" class="editarajax uk-input uk-form-small uk-form-blank" data-tabla="'.$modulo.'" data-campo="material" data-id="'.$prodID.'" tabindex="7">
						</td>
						<td>
							<span class="uk-hidden">'.(10000+(1*($rowCONSULTA['precio']))).'</span>
							<input type="text" class="editarajax uk-input input-number uk-form-small uk-text-right '.$clasePrecio.'" data-tabla="'.$modulo.'" data-campo="precio" data-id="'.$prodID.'" value="'.$rowCONSULTA['precio'].'" tabindex="8">
						</td>
						<td>
							<span class="uk-hidden">'.(10000+(1*($rowCONSULTA['descuento']))).'</span>
							<input type="text" class="editarajax uk-input input-number uk-form-small uk-text-right descuento '.$claseDescuento.'" data-tabla="'.$modulo.'" data-campo="descuento" data-id="'.$prodID.'" value="'.$rowCONSULTA['descuento'].'" tabindex="9">
						</td>
						<td class="uk-text-center">
							<i class="estatuschange pointer fas fa-lg fa-toggle-'.$inicioIcon.'" data-tabla="'.$modulo.'" data-campo="inicio" data-id="'.$rowCONSULTA['id'].'" data-valor="'.$rowCONSULTA['inicio'].'"></i> &nbsp;&nbsp;
						</td>
						<td class="uk-text-center">
							<i class="estatuschange pointer fas fa-lg fa-toggle-'.$estatusIcon.'" data-tabla="'.$modulo.'" data-campo="estatus" data-id="'.$rowCONSULTA['id'].'" data-valor="'.$rowCONSULTA['estatus'].'"></i> &nbsp;&nbsp;
						</td>
						<td class="uk-text-nowrap">
							<span data-id="'.$rowCONSULTA['id'].'" class="eliminaprod color-red" tabindex="1" uk-icon="icon:trash"></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="'.$link.'" class="uk-text-primary" uk-icon="search"></a>
						</td>
					</tr>';
				}else{
					$sql="DELETE FROM productosexistencias WHERE producto = $prodID";
					//echo '<tr><td colspan="10">'.$sql.'</td></tr>';
					$borrarlosquenoexisten = $CONEXION->query($sql);
				}
			}

	echo ' 
			</tbody>
		</table>
	</div>';

?>




	<div id="nuevacat" uk-modal="center: true">
		<div class="uk-modal-dialog uk-modal-body">
			<a class="uk-modal-close uk-close"></a>
			<form action="index.php" class="uk-width-1-1 uk-text-center uk-form" method="post" name="editar" onsubmit="return checkForm(this);">

				<input type="hidden" name="nuevacategoria" value="1">
				<input type="hidden" name="modulo" value="<?=$modulo?>">
				<input type="hidden" name="archivo" value="categorias">

				<label for="categoria">Nombre de la nueva categoría</label><br><br>
				<input type="text" class="uk-input" name="categoria" tabindex="10" required><br><br>
				<input type="submit" name="send" value="Agregar" tabindex="10" class="uk-button uk-button-primary">
			</form>
		</div>
	</div>

<?php 
$scripts='
	// Eliminar producto
	$(".eliminaprod").click(function() {
		var id = $(this).attr(\'data-id\');
		//console.log(id);
		var statusConfirm = confirm("Realmente desea eliminar este Producto?"); 
		if (statusConfirm == true) { 
			//window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&campo='.$campo.'&valor='.$valor.'&borrarPod&id="+id);
		} 
	});

	$(".search").keypress(function(e) {
		if(e.which == 13) {
			var campo = $(this).attr("data-campo");
			var valor = $(this).val();
			window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=search&campo="+campo+"&valor="+valor);
		}
	});
	';
?>

