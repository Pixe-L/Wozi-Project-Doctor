<?php 
$rutaPics='../img/contenido/profile/';
$USER = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $id");
$row_USER = $USER -> fetch_assoc();
$pic=(strlen($row_USER['imagen'])>1 AND file_exists($rutaPics.$row_USER['imagen'].'.jpg'))?'<img src="'.$rutaPics.$row_USER['imagen'].'.jpg" class="uk-border-rounded" style="max-height:200px;"><br><br><a href="#" data-id="'.$id.'" class="borrar uk-icon-button uk-button-danger uk-box-shadow-large" data-foto="'.$row_USER['imagen'].'" uk-icon="icon:trash;"></a>':'';

echo '
	<div class="uk-width-1-1 margin-v-20">
		<ul class="uk-breadcrumb">
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Clientes</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=detalle&id='.$id.'" class="color-red">Detalle de cliente</a></li>
		</ul>
	</div>
	<div class="uk-width-1-3@m">
		<h2>Datos generales</h2>
		<p><span class="uk-text-muted">Nombre:</span> '.$row_USER['nombre'].'</p>
		<p><span class="uk-text-muted">Número de cliente:</span> '.$id.'</p>
		<p><span class="uk-text-muted">Email:</span> '.$row_USER['email'].'</p>
		<p><span class="uk-text-muted">Telefono:</span> '.$row_USER['telefono'].'</p>
		<p class="uk-text-uppercase"><span class="uk-text-muted">rfc:</span> '.$row_USER['rfc'].'</p>
		<p><span class="uk-text-muted">Empresa:</span> '.$row_USER['empresa'].'</p>
		<p><span class="uk-text-muted">Fecha de registro:</span> '.date('d-m-Y',strtotime($row_USER['alta'])).'</p>
		<div class="uk-text-center" id="piccliente" style="max-width:200px;">
			'.$pic.'
		</div>
	</div>
	<div class="uk-width-2-3@m">
		<h2>Domicilios</h2>
		<div uk-grid>
			<div class="uk-width-1-2@s">
				<h3>Fiscal</h3>
				<p><span class="uk-text-muted uk-text-capitalize">calle:</span> '.$row_USER['calle'].'</p>
				<p><span class="uk-text-muted uk-text-capitalize">no. exterior:</span> '.$row_USER['noexterior'].'</p>
				<p><span class="uk-text-muted uk-text-capitalize">no. interior:</span> '.$row_USER['nointerior'].'</p>
				<p><span class="uk-text-muted uk-text-capitalize">entrecalles:</span> '.$row_USER['entrecalles'].'</p>
				<p><span class="uk-text-muted uk-text-capitalize">pais:</span> '.$row_USER['pais'].'</p>
				<p><span class="uk-text-muted uk-text-capitalize">estado:</span> '.$row_USER['estado'].'</p>
				<p><span class="uk-text-muted uk-text-capitalize">municipio:</span> '.$row_USER['municipio'].'</p>
				<p><span class="uk-text-muted uk-text-capitalize">colonia:</span> '.$row_USER['colonia'].'</p>
				<p><span class="uk-text-muted uk-text-uppercase">cp:</span> '.$row_USER['cp'].'</p>
			</div>
			<div class="uk-width-1-2@s">
				<h3>De entrega</h3>
				<p><span class="uk-text-muted uk-text-capitalize">calle:</span> '.$row_USER['calle2'].'</p>
				<p><span class="uk-text-muted uk-text-capitalize">no. exterior:</span> '.$row_USER['noexterior2'].'</p>
				<p><span class="uk-text-muted uk-text-capitalize">no. interior:</span> '.$row_USER['nointerior2'].'</p>
				<p><span class="uk-text-muted uk-text-capitalize">entrecalles:</span> '.$row_USER['entrecalles2'].'</p>
				<p><span class="uk-text-muted uk-text-capitalize">pais:</span> '.$row_USER['pais2'].'</p>
				<p><span class="uk-text-muted uk-text-capitalize">estado:</span> '.$row_USER['estado2'].'</p>
				<p><span class="uk-text-muted uk-text-capitalize">municipio:</span> '.$row_USER['municipio2'].'</p>
				<p><span class="uk-text-muted uk-text-capitalize">colonia:</span> '.$row_USER['colonia2'].'</p>
				<p><span class="uk-text-muted uk-text-uppercase">cp:</span> '.$row_USER['cp2'].'</p>
			</div>
		</div>
	</div>
';

$CONSULTA1 = $CONEXION -> query("SELECT * FROM pedidos WHERE uid = $id");
$numPedidos=$CONSULTA1->num_rows;
echo '
	<div class="uk-width-1-1 margin-v-20">
		<h3>Pedidos realizados: '.$numPedidos.'</h3>
		<table class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-responsive" id="tablaproductos">
			<thead>
				<tr>
					<th onclick="sortTable(0)" width="60px">No. de orden</th>
					<th onclick="sortTable(1)" width="120px">Fecha</th>
					<th onclick="sortTable(2)">Estatus</th>
					<th onclick="sortTable(3)" width="150px" class="uk-text-center">PDF</th>
					<th onclick="sortTable(4)" width="120px" class="uk-text-right">Importe</th>
					<th width="50px"></th>
				</tr>
			</thead>
			<tbody>';

	while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){
		//echo 'Importe: <br>';
		switch ($row_CONSULTA1['estatus']) {
			case 0:
				$estatus = '<button class="uk-button uk-button-small uk-button-default">Registrado</button>';
				break;
			case 1:
				$estatus = '<button class="uk-button uk-button-small uk-button-warning">Pagado</button>';
				break;
			case 2:
				$estatus = '<button class="uk-button uk-button-small uk-button-primary">Enviado</button>';
				break;
			case 3:
				$estatus = '<button class="uk-button uk-button-small uk-button-success">Entregado</button>';
				break;
		}
		$link='index.php?rand='.rand(1,1000).'&modulo=pedidos&archivo=detalle&id='.$row_CONSULTA1['id'];
		echo '
				<tr>
					<td>
						'.$row_CONSULTA1['id'].'
					</td>
					<td>
						<span class="uk-hidden">'.$row_CONSULTA1['fecha'].'</span>'.date('d-m-Y',strtotime($row_CONSULTA1['fecha'])).'
					</td>
					<td>
						'.$estatus.'
					</td>
					<td class="uk-text-center@m">
						<a href="../'.$row_CONSULTA1['idmd5'].'_revisar.pdf" target="_blank" class="uk-button uk-button-default"><i class="fa fa-file-pdf-o"></i> Ver pdf</a>
					</td>
					<td class="uk-text-right@m">
						$'.number_format($row_CONSULTA1['importe'],2).'
					</td>
					<td class="uk-text-right@m">
						<a href="'.$link.'" class="uk-text-primary" uk-icon="search"></a>
					</td>
				</tr>';
	}
	

echo'
			</tbody>
		</table>
	</div>




';


$scripts='
		$(document).ready(function(){
			$(".borrar").on("click", function (e) {
				var foto = $(this).attr("data-foto");

				UIkit.modal.confirm("Desea borrar esta foto?").then(function() {
					$.ajax({
						method: "POST",
						url: "modulos/'.$modulo.'/acciones.php",
						data: { 
							picdelete: 1,
							foto: foto,
							id: '.$id.'
						}
					})
					.done(function( msg ) {
						UIkit.notification.closeAll();
						UIkit.notification(msg);
						$("#piccliente").fadeOut();
					});
				}, function () {
					console.log("Rechazado")
				});
			});
		});


';