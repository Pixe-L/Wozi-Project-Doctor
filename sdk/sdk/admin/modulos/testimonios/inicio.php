

<div class="uk-width-auto margin-top-20 uk-text-left">
	<ul class="uk-breadcrumb">
		<?php 
		echo '
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'" class="color-red">'.$modulo.'</a></li>
		';
		?>
	</ul>
</div>

<div class="uk-width-expand@s margin-top-20 uk-text-right">
	<a href="index.php?rand=<?=rand(1,1000)?>&modulo=<?=$modulo?>&archivo=nuevo" class="uk-button uk-button-success"><i uk-icon="icon: plus;ratio:1.4"></i> &nbsp; Nuevo</a>
</div>

		

<div class="uk-width-medium-1-1 margin-v-20">
	<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle uk-table-responsive">
		<thead>
			<tr>
				<th width="30px"></th>
				<th width="100px">Fecha</th>
				<th>Nombre</th>
				<th width="35%" >Email</th>
				<th width="80px"></th>
			</tr>
		</thead>
		<tbody class="sortable" data-tabla="<?=$modulo?>">
		<?php
		$productos = $CONEXION -> query("SELECT * FROM $modulo ORDER BY orden");
		while ($row_productos = $productos -> fetch_assoc()) {
			$prodID=$row_productos['id'];

			$inicioButton=($row_productos['inicio']==1)?'success':'white';

			$link='index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=detalle&id='.$row_productos['id'];


			$picTxt='';
			$pic='../img/contenido/'.$modulo.'/'.$row_productos['imagen'];
			if(file_exists($pic) AND strlen($row_productos['imagen'])>0){
				$picTxt='
					<div class="uk-inline">
						<i uk-icon="camera"></i>
						<div uk-drop="pos: right-justify">
							<img src="'.$pic.'" class="uk-border-rounded">
						</div>
					</div>';
			}

			echo '
			<tr id="'.$row_productos['id'].'">
				<td>
					'.$picTxt.'
				</td>
				<td>
					'.$row_productos['fecha'].'
				</td>
				<td>
					'.$row_productos['titulo'].'
				</td>
				<td>
					'.$row_productos['email'].'
				</td>
				<td>
					<span data-id="'.$row_productos['id'].'" class="eliminaprod color-red pointer" tabindex="1" uk-icon="icon:trash"></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="'.$link.'" class="uk-text-primary" uk-icon="search"></a>
				</td>
			</tr>';
		}
		?>

		</tbody>
	</table>
</div>


<?php
$scripts='

	// Eliminar producto
	$(".eliminaprod").click(function() {
		var id = $(this).attr(\'data-id\');
		//console.log(id);
		var statusConfirm = confirm("Realmente desea eliminar este Producto?"); 
		if (statusConfirm == true) { 
			window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=inicio&borrarPod&id="+id);
		} 
	});

	';



?>