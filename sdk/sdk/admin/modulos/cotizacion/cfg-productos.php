<?php 
$num=0;
$disableContinue='disabled="true"';
if (isset($_SESSION['clienteid'])) {
	$clienteid=$_SESSION['clienteid'];
}elseif (isset($_REQUEST['clienteid']) AND strlen($_REQUEST['clienteid'])>0) {
	$_SESSION['clienteid']=$_REQUEST['clienteid'];
	$clienteid=$_SESSION['clienteid'];
}else{
	echo '<div class="uk-height-viewport uk-text-danger text-xl uk-text-center"><div style="padding-top:200px;">Debe definir un cliente</div></div>';
	$scripts.='
		setTimeout(function(){ window.location = ("index.php?rand=20294&modulo=cotizacion&archivo=cfg-cliente"); },1000);';
}

if (isset($clienteid)) {
	$CONSULTA = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $clienteid");
	$row_CONSULTA = $CONSULTA -> fetch_assoc();
	$thisName=html_entity_decode($row_CONSULTA['nombre']);
}

if (isset($_SESSION['carro'])) { unset($_SESSION['carro']); }
if (isset($_SESSION['print'])) { unset($_SESSION['print']); }
if (isset($_SESSION['tablaBody'])) { unset($_SESSION['tablaBody']); }

$productoid=(isset($_POST['productoid']))?$_POST['productoid']:$id;

$CONSULTATC = $CONEXION -> query("SELECT tipocambio FROM configuracion WHERE id = 1");
$rowCONSULTATC = $CONSULTATC -> fetch_assoc();

if (isset($_GET['solicitacotizacion'])) {
	$solicitacotizacion=$_GET['solicitacotizacion'];
	$CONSULTA_A = $CONEXION -> query("SELECT * FROM pedidosdetalle WHERE pedido = $solicitacotizacion");
	$num = $CONSULTA_A->num_rows;
	$disableContinue='';
}

echo '
	<div class="margin-top-20">
		<ul class="uk-breadcrumb">
			<li><a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'">Cotizaciones</a></li>
			<li><a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'&archivo=cfg-cliente">Configurar cliente</a></li>
			<li><a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'&archivo=cfg-productos&clienteid='.$clienteid.'" class="color-red">Configurar productos</a></li>
		</ul>
	</div>

	<div class="uk-text-center margin-v-20">
		Cliente: <b>'.$thisName.'</b>
	</div>';

?>



	<div class="uk-container uk-margin-top">
		<form action="index.php" method="post">
			<input type="hidden" name="modulo" value="<?=$modulo?>">
			<input type="hidden" name="archivo" value="cfg-revisar">
			<input type="hidden" name="addtocart" value="1">
			<input type="hidden" id="num" value="<?=($num+1)?>">

			<div class="uk-container margin-v-20" style="max-width:900px;">
	
				<div class="uk-container margin-v-20">
					<div uk-grid class="uk-child-width-1-4@l uk-child-width-1-2@s">
						<div>
							<label>Formato</label>
							<div>
								<select name="formato" class="uk-select">
									<option value="0">Inveco</option>
									<option value="1">Inveco Centro</option>
								</select>
							</div>
						</div>
						<div>
							<label>IVA</label>
							<div>
								<select name="masiva" class="uk-select">
									<option value="0">Sin IVA</option>
									<option value="1">Más IVA</option>
								</select>
							</div>
						</div>
						<div>
							<label>Moneda</label>
							<div>
								<select name="moneda" class="uk-select">
									<option value="0">MXN</option>
									<option value="1">USD</option>
								</select>
							</div>
						</div>
						<div>
							<label>Tipo de cambio</label>
							<div>
								<input type="text" class="selectortc uk-input" id="tipocambio" data-tabla="configuracion" data-campo="tipocambio" data-id="1" name="tipocambio" value="<?=$rowCONSULTATC['tipocambio']?>">
							</div>
						</div>

					</div>
				</div>

				<h4 class="uk-text-center">AGREGAR PRODUCTO</h4>
				<div class="">
					<select id="producto" data-placeholder="Seleccione un producto" class="chosen-select">
						<option value=""></option>
						<?php 
						$CONSULTA = $CONEXION -> query("SELECT * FROM productos ORDER BY titulo");
						while ($row_CONSULTA = $CONSULTA -> fetch_assoc()) {
							$thisName=html_entity_decode($row_CONSULTA['titulo']);
							echo '
						<option value="'.$row_CONSULTA['id'].'">'.$thisName.'</option>';
						}
						?>

					</select>
				</div>

				<div class="margin-v-20 uk-text-center">
					<a href="index.php?rand=<?=rand(1,1000)?>&modulo=<?=$modulo?>" class="uk-button uk-button-default">Cancelar</a>
					<span id="agregar" class="uk-button uk-button-primary pointer" disabled="true">Agregar</span>
				</div>
			</div>


			<div class="uk-grid uk-form">
				<div class="uk-width-1-1 margin-v-20">
					<h4 class="uk-text-center">PRODUCTOS A COTIZAR</h4>
				</div>
				<div class="uk-width-1-1" id="productos">
					<table class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-middle uk-table-responsive">
						<thead>
							<tr>
								<th width="10px"  rowspan="2"></th>
								<th width="auto"  rowspan="2">Producto</th>
								<th width="100px" rowspan="2" class="uk-text-center">Cantidad</th>
								<th width="200px" colspan="2" class="uk-text-center">Área</th>
								<th width="140px" rowspan="2" class="uk-text-center">unidad</th>
								<th width="100px" rowspan="2" class="uk-text-center">Precio</th>
							</tr>
							<tr>
								<th width="100px" class="uk-text-center">Lado 1</th>
								<th width="100px" class="uk-text-center">Lado 2</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (isset($_GET['solicitacotizacion'])) {
								$solicitacotizacion=$_GET['solicitacotizacion'];
								$CONSULTA_A = $CONEXION -> query("SELECT * FROM pedidosdetalle WHERE pedido = $solicitacotizacion");
								$numItems = $CONSULTA_A->num_rows;
								if ($numItems>0) {
									while($row_CONSULTA_A = $CONSULTA_A -> fetch_assoc()){
										$prodId=$row_CONSULTA_A['producto'];
										$CONSULTA_B = $CONEXION -> query("SELECT * FROM productos WHERE id = $prodId");
										$numItems = $CONSULTA_B->num_rows;
										if ($numItems>0) {
											$row_CONSULTA_B = $CONSULTA_B -> fetch_assoc();
											$thisName=html_entity_decode($row_CONSULTA_B['titulo']);
											//echo '<tr><td colspan="5" class="uk-text-center">id='.$prodId.'</td></tr>';

											echo '
											<tr id="row'.$num.'">
												<td>
													<a href="javascript:elimnarow('.$num.')" class="uk-icon-button uk-button-danger" uk-icon="trash"></a>
												</td>
												<td>
													'.$thisName.'
												</td>
												<td>
													<input type=\'number\' class=\'uk-input\' name=\'cantidad'.$num.'\' value=\'0\' required>
												</td>
												<td>
													<input type=\'hidden\' name=\'id'.$num.'\' value=\''.$prodId.'\'>
													<input type=\'text\' class=\'uk-input\' name=\'ladoa'.$num.'\' value=\'0\' required>
												</td>
												<td>
													<input type=\'text\' class=\'uk-input\' name=\'ladob'.$num.'\' value=\'0\' required>
												</td>
												<td>
													<input type=\'text\' class=\'uk-input\' name=\'unidad'.$num.'\'  placeholder="pza, caja o m2" required>
												</td>
												<td>
													<select class=\'uk-select\' name=\'precio'.$num.'\'>
														<option>'.$row_CONSULTA_B['precio1'].'</option>
														<option>'.$row_CONSULTA_B['precio2'].'</option>
														<option>'.$row_CONSULTA_B['precio3'].'</option>
													</select>
												</td>
											</tr>';
											$num++;
										}
									}
								}
							}
							?>

						</tbody>
					</table>
				</div>
				<div class="uk-width-1-1 uk-text-center margin-v-20">
					<a href="index.php?rand=<?=rand(1,1000)?>&modulo=<?=$modulo?>&archivo=cfg-productos&clienteid=<?=$clienteid?>" class="uk-button uk-button-default" tabindex="10">Vaciar carro</a>
					<input type="submit" name="enviar" value="Siguiente" id="siguiente" class="uk-button uk-button-primary" <?=$disableContinue?>>
				</div>
			</div>
		</form>
	</div>

<?php
$scripts .= '
	$("#producto").change(function(){
		$("#agregar").attr("disabled",false);
	});

	$("#agregar").click(function(){
		num = $("#num").val();
		num++;

		$("#num").val(num);
		$("#siguiente").attr("disabled",false);

		id = $(".chosen-select").val();
		valorName = $(".chosen-single").text();

		$.ajax({
			method: "POST",
			url: "modulos/'.$modulo.'/acciones.php",
			data: { 
				dameproducto: 1,
				num: num,
				id: id
			}
		})
		.done(function( response ) {
			console.log( response )
			datos = JSON.parse(response);
			UIkit.notification.closeAll();
			UIkit.notification(datos.msg);
			$("tbody").append(datos.row);
		});

	});

	// Editar tipo de cambio
	$(".selectortc").change(function() {
		var datos = $(this).data();
		var valor = $(this).val();
		$.ajax({
			method: "POST",
			url: "modulos/varios/acciones.php",
			data: { 
				editarajax: 1,
				id: datos.id,
				tabla: datos.tabla,
				campo: datos.campo,
				valor: valor
			}
		})
		.done(function( response ) {
			console.log( response );
		});
	});

	// Elimina producto de cotizacion
	function elimnarow(num){
		$("#row"+num).fadeOut(500);
		setTimeout(function(){
			$("#row"+num).remove();
		},500);

	}

	';


?>