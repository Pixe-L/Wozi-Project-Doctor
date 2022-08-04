<?php 
	$pag=(isset($_GET['pag']))?$_GET['pag']:0;
	$prodspagina=(isset($_GET['prodspagina']))?$_GET['prodspagina']:20;
	$consulta = $CONEXION -> query("SELECT * FROM $modulo");

	$numItems=$consulta->num_rows;
	$prodInicial=$pag*$prodspagina;

// BREADCRUMB
	echo '
	<div class="uk-width-auto margin-top-20">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'" class="color-red">Productos &nbsp; <span class="uk-text-muted uk-text-lowercase"> &nbsp; <b>'.$numItems.'</b> productos</span></a></li>
		</ul>
	</div>';


// BOTONES SUPERIORES
	echo '
	<div class="uk-width-expand@m margin-v-20">
		<div uk-grid class="uk-grid-small uk-flex-right">
			<div>
				<!-- Categorías -->
					<a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=categorias" class="uk-button uk-button-primary"><i uk-icon="folder"></i> &nbsp; Categorías</a>
					<div uk-dropdown>
						<ul class="uk-nav uk-dropdown-nav uk-text-left">';
						// Obtener Categorías
						$CONSULTA = $CONEXION -> query("SELECT * FROM productoscat WHERE parent = 0 ORDER BY orden");
						while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
							echo '
							<li><a href="index.php?rand='.rand(1,999).'&modulo='.$modulo.'&archivo=catdetalle&cat='.$rowCONSULTA['id'].'">'.$rowCONSULTA['txt'].'</a></li>';
						}
						echo '
						</ul>
					</div>
			</div>
			<div>
				<a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=importar" class="uk-button uk-button-primary">Importar</a>
			</div>
			<div>
				<a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=existencias" class="uk-button uk-button-primary">Existencias</a>
			</div>
			<div>
				<a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=nuevo" class="uk-button uk-button-success"><i uk-icon="plus"></i> &nbsp; Nuevo</a>
			</div>
		</div>
	</div>';


// CAMPOS DE BÚSQUEDA 
	echo '
	<div class="uk-width-1-1">
		<div uk-grid class="uk-grid-small uk-child-width-expand@m uk-child-width-1-2">
			<div><label class="pointer"><i uk-icon="search"></i> SKU<br><input type="text" class="uk-input search" data-campo="sku"></label></div>
			<div><label class="pointer"><i uk-icon="search"></i> Modelo<br><input type="text" class="uk-input search" data-campo="titulo"></label></div>
			<div><label class="pointer"><i uk-icon="search"></i> Material<br><input type="text" class="uk-input search" data-campo="material"></label></div>
			<div><label class="pointer"><i uk-icon="search"></i> Precio<br><input type="text" class="uk-input search" data-campo="precio"></label></div>
			<div><label class="pointer"><i uk-icon="search"></i> Descuento<br><input type="text" class="uk-input search" data-campo="descuento"></label></div>
		</div>
	</div>';


// TABLA DE PRODUCTOS 
	echo '
	<div class="uk-width-1-1 margin-v-50">
		<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle uk-table-responsive">
			<thead>
				<tr>
					<th width="40px" ></th>
					<th width="10px" >SKU</th>
					<th width="auto" >Modelo</th>
					<th width="100px">Precio</th>
					<th width="90px" >Descuento</th>
					<th width="50px" >En inicio</th>
					<th width="50px" >Activo</th>
					<th width="80px"></th>
				</tr>
			</thead>
			<tbody>';

			$CONSULTA = $CONEXION -> query("SELECT * FROM $modulo ORDER BY categoria LIMIT $prodInicial,$prodspagina");
			while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
				$prodID=$rowCONSULTA['id'];
				$catId=$rowCONSULTA['categoria'];
				$clasifId=$rowCONSULTA['clasif'];

				$link='index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=detalle&id='.$rowCONSULTA['id'];

				$clasePrecio='';
				$claseDescuento='';
				// Si el precio es 0 pintamos gris
				if ($rowCONSULTA['precio']==0) {
					$clasePrecio='bg-grey';
					$claseDescuento='bg-grey';
				}

				$inicioIcon=($rowCONSULTA['inicio']==0)?'off uk-text-muted':'on uk-text-primary';
				$estatusIcon=($rowCONSULTA['estatus']==0)?'off uk-text-muted':'on uk-text-primary';

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

				$CONSULTA1 = $CONEXION -> query("SELECT * FROM $modulocat WHERE id = $catId");
				$rowCONSULTA1 = $CONSULTA1 -> fetch_assoc();
				$categoriaTxt=$rowCONSULTA1['txt'];
				$parent=$rowCONSULTA1['parent'];

				echo '
				<tr id="'.$prodID.'">
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
						<input type="text" class="editarajax uk-input input-number uk-form-small uk-text-right '.$clasePrecio.'" data-tabla="'.$modulo.'" data-campo="precio" data-id="'.$prodID.'" value="'.$rowCONSULTA['precio'].'" tabindex="8">
					</td>
					<td>
						<input type="text" class="editarajax uk-input input-number uk-form-small uk-text-right descuento '.$claseDescuento.'" data-tabla="'.$modulo.'" data-campo="descuento" data-id="'.$prodID.'" value="'.$rowCONSULTA['descuento'].'" tabindex="9">
					</td>
					<td class="uk-text-center@m">
						<i class="estatuschange pointer fas fa-lg fa-toggle-'.$inicioIcon.'" data-tabla="'.$modulo.'" data-campo="inicio" data-id="'.$rowCONSULTA['id'].'" data-valor="'.$rowCONSULTA['inicio'].'"></i>
					</td>
					<td class="uk-text-center@m">
						<i class="estatuschange pointer fas fa-lg fa-toggle-'.$estatusIcon.'" data-tabla="'.$modulo.'" data-campo="estatus" data-id="'.$rowCONSULTA['id'].'" data-valor="'.$rowCONSULTA['estatus'].'"></i>
					</td>
					<td class="uk-text-nowrap">
						<button data-id="'.$rowCONSULTA['id'].'" class="eliminaprod color-red" tabindex="1" uk-icon="icon:trash"></button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="'.$link.'" class="uk-text-primary" uk-icon="search"></a>
					</td>
				</tr>';
			}
			echo '
			</tbody>
		</table>
	</div>';


// PAGINATION 
	echo '
	<div class="uk-width-1-1 padding-top-50">
		<div class="uk-flex uk-flex-center">
			<ul class="uk-pagination uk-flex-center uk-text-center">';
				if ($pag!=0) {
					$link='index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&pag='.($pag-1).'&prodspagina='.$prodspagina;
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
					$link='index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&pag='.($i).'&prodspagina='.$prodspagina;
					echo '<li><a href="'.$link.'" class="'.$clase.'">'.($i+1).'</a></li>';
				}
				if ($pag!=$pagTotal AND $numItems!=0) {
					$link='index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&pag='.($pag+1).'&prodspagina='.$prodspagina;
					echo'
					<li><a href="'.$link.'">Siguiente &nbsp;&nbsp; <i class="fa fa-lg fa-angle-right"></i></a></li>';
				}
				echo '
			</ul>
		</div>
		<div class="uk-flex uk-flex-center">
			<div style="max-width: 100%;width: 120px;">
				<select name="prodspagina" data-placeholder="Productos por página" id="prodspagina" class="uk-select">';
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
	// Productos por página
		$("#prodspagina").change(function(){
			var prodspagina = $(this).val();
			window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&prodspagina="+prodspagina);
		})

	// Búsqueda
		$(".search").keypress(function(e) {
			if(e.which == 13) {
				var campo = $(this).attr("data-campo");
				var valor = $(this).val();
				window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=search&campo="+campo+"&valor="+valor);
			}
		});

	// Eliminar producto
		$(".eliminaprod").click(function() {
			var id = $(this).attr(\'data-id\');
			//console.log(id);
			var statusConfirm = confirm("Realmente desea eliminar este Producto?"); 
			if (statusConfirm == true) {
				$.ajax({
					method: "POST",
					url: "modulos/'.$modulo.'/acciones.php",
					data: { 
						borrarPod: 1,
						id: id
					}
				})
				.done(function( msg ) {
					UIkit.notification.closeAll();
					UIkit.notification(msg,{pos:"bottom-right"});
					$("#"+id).addClass( "uk-invisible" );
				});
			} 
		});

	';

