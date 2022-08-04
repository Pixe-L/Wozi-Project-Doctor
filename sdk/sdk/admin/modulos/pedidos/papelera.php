<?php 
	$pag=(isset($_GET['pag']))?$_GET['pag']:0;
	$prodspagina=(isset($_GET['prodspagina']))?$_GET['prodspagina']:20;
	$consulta = $CONEXION -> query("SELECT * FROM pedidos WHERE papelera = 0");

	$numItems=$consulta->num_rows;
	$prodInicial=$pag*$prodspagina;

// BREADCRUMB
	echo '
	<div class="uk-width-auto margin-top-20">
		<ul class="uk-breadcrumb">
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Pedidos</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'" class="color-red">Cancelados</a></li>
		</ul>
	</div>
	';

// TABLA DE PEDIDOS
	echo '
	<div class="uk-width-1-1">
		<table class="uk-table uk-table-hover uk-table-striped uk-table-middle uk-table-responsive">
			<thead>
				<tr>
					<th width="10px">Id</th>
					<th width="10px" class="uk-text-center">Fecha</th>
					<th>Nombre/Email</th>
					<th width="10px" class="uk-text-center">Productos</th>
					<th width="10px" class="uk-text-center">Importe</th>
					<th width="20px;"></th>
				</tr>
			</thead>
			<tbody class="uk-text-muted">';

			$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE papelera = 1 ORDER BY id DESC LIMIT $prodInicial,$prodspagina");
			while($row_CONSULTA = $CONSULTA -> fetch_assoc()){
				$thisid=$row_CONSULTA['id'];
				$user=$row_CONSULTA['uid'];


				$CONSULTA1 = $CONEXION -> query("SELECT SUM(cantidad) AS cant FROM pedidosdetalle WHERE pedido = $thisid");
				$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
				$numProds=$row_CONSULTA1['cant'];

				$segundos=strtotime($row_CONSULTA['fecha']);
				$fecha=date('d-m-Y',$segundos);

				$level=$row_CONSULTA['estatus']+1;

				switch ($level) {
					case 2:
						$clase='uk-button-primary';
						break;
					case 3:
						$clase='uk-button-warning';
						break;
					case 4:
						$clase='uk-button-success';
						break;
					default:
						$clase='uk-button-white';
						break;
				}

				$pagoFile  ='../img/contenido/comprobantes/'.$thisid.'.'.$row_CONSULTA['comprobante'];
				$pagoHTML  = (file_exists($pagoFile)) ? '<a href="'.$pagoFile.'" class="uk-button uk-button-small" target="_blank">Pago</a>':'';
				$printFile ='../img/contenido/print/'.$row_CONSULTA['imagen'];
				$printHTML = ($row_CONSULTA['imagen']!='' AND file_exists($printFile)) ? '<a href="'.$printFile.'" class="uk-button uk-button-small uk-button-primary" download>Print</a>':'';

				echo '
				<tr id="row'.$row_CONSULTA['id'].'">
					<td class="bg'.$level.' uk-text-nowrap">
						'.$row_CONSULTA['id'].'
					</td>
					<td class="bg'.$level.' uk-text-nowrap">
						<span class="uk-hidden">'.$row_CONSULTA['fecha'].'</span>
						'.$fecha.'
					</td>
					<td class="bg'.$level.'">
						'.$row_CONSULTA['nombre'].'<br>
						'.$row_CONSULTA['email'].'
					</td>
					<td class="bg'.$level.' uk-text-nowrap uk-text-center@m">
						'.$numProds.'
					</td>
					<td class="bg'.$level.' uk-text-nowrap uk-text-right@m">
						<span class="uk-hidden">'.($row_CONSULTA['importe']+1000000000).'</span>
						$'.number_format($row_CONSULTA['importe'],2).'
					</td>
					<td class="bg'.$level.' uk-text-nowrap">
						<button class="'.$clase.' uk-icon-button" data-id="'.$row_CONSULTA['id'].'">'.$level.'</button> &nbsp;&nbsp;&nbsp;&nbsp;
						<a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=detalle&id='.$row_CONSULTA['id'].'" class="uk-icon-button uk-button-primary" uk-icon="search"></a>
					</td>
				</tr>';
			}
			echo '
			</tbody>
		</table>
	</div>';

// PAGINATION
	echo '
	<div class="uk-width-1-1">
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


// Auxiliar para leer el id que se desea editar
	echo '
	<input type="hidden" id="fichaid">';

$scripts='
	// PRODUCTOS POR PÁGINA
		$("#prodspagina").change(function(){
			var prodspagina = $(this).val();
			window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&prodspagina="+prodspagina);
		});

	';
