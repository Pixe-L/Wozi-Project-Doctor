<?php 
	$pag=(isset($_GET['pag']))?$_GET['pag']:0;
	$prodspagina=(isset($_GET['prodspagina']))?$_GET['prodspagina']:20;


	$sql="SELECT 
		productos.id as prod,
		productos.sku,
		productos.titulo,
		productosexistencias.id,
		productosexistencias.existencias,
		productostalla.txt,
		productoscolor.name
		FROM productos
		INNER JOIN productosexistencias ON productos.id = productosexistencias.producto
		INNER JOIN productostalla ON productostalla.id = productosexistencias.talla
		INNER JOIN productoscolor ON productoscolor.id = productosexistencias.color
		WHERE productosexistencias.estatus = 1";
	$consulta = $CONEXION -> query($sql);

	$numItems=$consulta->num_rows;
	$prodInicial=$pag*$prodspagina;

// BREADCRUMB
	echo '
	<div class="uk-width-auto margin-top-20">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Productos</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'" class="color-red">Existencias</a></li>
		</ul>
	</div>';

// INFO
	echo '
	<div class="uk-width-1-1 margin-v-50">
		<div class="uk-container">
			<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle uk-table-responsive" id="ordenar">
				<thead>
					<tr>
						<th width="40px"></th>
						<th width="100px">SKU</th>
						<th width="auto" >Modelo</th>
						<th width="10px" >Talla</th>
						<th width="10px" >Color</th>
						<th width="100px">Existencias</th>
					</tr>
				</thead>
				<tbody>';
				$sql.=" ORDER BY productos.titulo, productostalla.txt, productoscolor.name LIMIT $prodInicial,$prodspagina";
				//echo $sql;
				$CONSULTA = $CONEXION -> query($sql);
				while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
					$id=$rowCONSULTA['id'];
					$prod=$rowCONSULTA['prod'];
					$link='index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=detalle&id='.$prod;

					$CONSULTA1 = $CONEXION -> query("SELECT * FROM $modulopic WHERE producto = $prod ORDER BY orden");
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

					echo '
					<tr>
						<td class="uk-text-center@m">
							'.$picROW.'
						</td>
						<td>
							'.$rowCONSULTA['sku'].'
						</td>
						<td>
							<a href="'.$link.'">'.$rowCONSULTA['titulo'].'</a>
						</td>
						<td>
							'.$rowCONSULTA['txt'].'
						</td>
						<td>
							'.$rowCONSULTA['name'].'
						</td>
						<td>
							<span class="uk-hidden">'.(10000+(1*($rowCONSULTA['existencias']))).'</span>
							<input type="text" class="editarajax uk-input input-number uk-form-small uk-text-right@m '.$claseexistencias.'" data-tabla="productosexistencias" data-campo="existencias" data-id="'.$id.'" value="'.$rowCONSULTA['existencias'].'" tabindex="8">
						</td>
					</tr>';
				}

				echo '
				</tbody>
			</table>
		</div>
	</div>
	';


// PAGINATION
	echo '
		<div class="uk-width-1-1 padding-top-50">
			<div uk-grid class="uk-flex-center">
				<div>
					<ul class="uk-pagination uk-flex-center uk-text-center">';
					if ($pag!=0) {
						$link='index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&pag='.($pag-1).'&prodspagina='.$prodspagina;
						echo'
						<li><a href="'.$link.'"><i class="fa fa-lg fa-angle-left"></i> &nbsp;&nbsp; Anterior</a></li>';
					}
					$pagTotal=intval($numItems/$prodspagina);
					$resto=$numItems % $prodspagina;
					if (($resto) == 0){
						$pagTotal=($numItems/$prodspagina)-1;
					}
					for ($i=0; $i <= $pagTotal; $i++) { 
						$clase='';
						if ($pag==$i) {
							$clase='uk-badge bg-primary color-white';
						}
						$link='index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&pag='.($i).'&prodspagina='.$prodspagina;
						echo '<li><a href="'.$link.'" class="'.$clase.'">'.($i+1).'</a></li>';
					}
					if ($pag!=$pagTotal AND $numItems!=0) {
						$link='index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&pag='.($pag+1).'&prodspagina='.$prodspagina;
						echo'
						<li><a href="'.$link.'">Siguiente &nbsp;&nbsp; <i class="fa fa-lg fa-angle-right"></i></a></li>';
					}
					
					echo '
					</ul>
				</div>
			</div>
			<div uk-grid class="uk-flex-center">
				<div class="uk-text-right" style="margin-top: -10px;">
					<select name="prodspagina" id="prodspagina" class="uk-select" style="width:120px;">';
						$arreglo = array(5=>5,20=>20,50=>50,100=>100,500=>500,9999=>"Todos");
						foreach ($arreglo as $key => $value) {
							$checked='';
							if ($key==$prodspagina) {
								$checked='selected';
							}
							echo '
							<option value="'.$key.'" '.$checked.'>'.$value.'</option>';
						}
						echo '
					</select>
				</div>
			</div>
		</div>';


$scripts='
		$("#prodspagina").change(function(){
			var prodspagina = $(this).val();
			window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&prodspagina="+prodspagina);
		})

	';
