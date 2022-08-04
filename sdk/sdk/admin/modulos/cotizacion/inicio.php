<?php
	$tableHeadEjecutivo=($univel==2)?'<th width="122px" onclick="sortTable(5)" class="uk-text-center pointer">Ejecutivo</th>':'';

	if ($univel==2) {
		$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE archivo = 0 ORDER BY id DESC");
	}else{
		$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE archivo = 0 AND ejecutivo = $uid ORDER BY id DESC");
	}
	$numSolic=$CONSULTA->num_rows;
	echo '
		<div uk-grid>

			<div class="uk-width-auto@m margin-top-20">
				<ul class="uk-breadcrumb">
					<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'" class="color-red">Cotizaciones</a></li>
				</ul>
			</div>

			<div class="uk-width-expand@m margin-top-20 uk-text-right">
				<div uk-grid class="uk-grid-small uk-flex-right">
					<div>
						<a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'&archivo=textos" class="uk-button uk-button-white">
							<i uk-icon="icon:cog"></i>
						</a>
					</div>
					<div>
						<a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'&archivo=archivo" class="uk-button uk-button-white">
							<i uk-icon="icon:folder"></i>
						</a>
					</div>
					<div class="uk-position-relative">
						<a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'&archivo=solicitudes" class="uk-button uk-button-primary">
							Solicitudes de cotización
						</a>
						<div class="uk-position-bottom-right">
							<a class="uk-badge bg-danger" href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'&archivo=solicitudes">
								'.$numSolic.'
							</a>
						</div>
					</div>
					<div>
						<a href="index.php?rand='.rand(1,999999).'&modulo='.$modulo.'&archivo=cfg-cliente" class="uk-button uk-button-primary">
							Nueva cotización
						</a>
					</div>
				</div>
			</div>

		</div>';

// Tabla de información
	echo '		
		<div class="uk-width-1-1 uk-margin">
			<table class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-middle uk-table-responsive">
				<thead>
					<tr>
						<th width="10px" >Id</th>
						'.$tableHeadEjecutivo.'
						<th width="100px" class="uk-text-center">Fecha</th>
						<th width="auto" >Nombre/Email/Empresa</th>
						<th width="10px" class="uk-text-right">Productos Importe</th>
						<th width="180px">Guía</th>
						<th width="10px" ></th>
					</tr>
				</thead>
				<tbody>';

				if ($univel==2) {
					$CONSULTA = $CONEXION -> query("SELECT * FROM cotizacion WHERE archivo = 0 ORDER BY id DESC");
				}else{
					$CONSULTA = $CONEXION -> query("SELECT * FROM cotizacion WHERE archivo = 0 AND ejecutivo = $uid ORDER BY id DESC");
				}
				$numRows = $CONSULTA ->num_rows;
				while($row_CONSULTA = $CONSULTA -> fetch_assoc()){

					$thisid=$row_CONSULTA['id'];
					$user=$row_CONSULTA['uid'];
					$ejecutivoName='Asignar';
					$ejecutivoButton='white';
					$ejecutivoEstatus=0;
					$ejecutivoId=$row_CONSULTA['ejecutivo'];
					if ($ejecutivoId>0) {
						$ConsultaEjecutivo = $CONEXION -> query("SELECT * FROM user WHERE id = $ejecutivoId");
						$numEjecutivos=$ConsultaEjecutivo->num_rows;
						if ($numEjecutivos>0) {
							$row_ConsultaEjecutivo = $ConsultaEjecutivo -> fetch_assoc();
							$ejecutivoName=$row_ConsultaEjecutivo['user'];
							$ejecutivoEstatus=1;
							$ejecutivoButton='primary';
						}
					}

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

					echo '
					<tr id="tr'.$row_CONSULTA['id'].'">
						<td>
							'.$row_CONSULTA['id'].'
						</td>';
					if ($univel==2) {
						echo '
						<td class="uk-text-center">
							<span class="uk-hidden">'.$ejecutivoName.'</span>
							<a href="#ejecutivomodal" uk-toggle class="ejecutivo uk-button uk-button-'.$ejecutivoButton.'" id="pedidoejecutivo'.$row_CONSULTA['id'].'" data-estatus="'.$ejecutivoEstatus.'" data-id="'.$row_CONSULTA['id'].'" data-ejecutivo="'.$ejecutivoId.'">'.$ejecutivoName.'</a>
						</td>';
					}
					echo '
						<td class="uk-text-center@m">
							'.$fecha.'
						</td>
						<td>
							'.$row_CONSULTA['nombre'].'<br>
							'.$row_CONSULTA['email'].'<br>
							'.$row_CONSULTA['empresa'].'
						</td>
						<td class="uk-text-right@m">
							<div class="uk-text-nowrap">
								Productos: '.$row_CONSULTA['cantidad'].'
							</div>
							<div class="uk-text-nowrap">
								$'.number_format($row_CONSULTA['importe'],2).'
							</div>
						</td>
						<td>
							<input tyle="text" class="selector uk-input" data-id="'.$row_CONSULTA['id'].'" data-tabla="cotizacion" data-campo="guia" value="'.$row_CONSULTA['guia'].'" placeholder="Guía">
						</td>
						<td class="uk-text-nowrap">
							<a href="javascript:eliminarCotizacion(id='.$row_CONSULTA['id'].')" class="uk-icon-button uk-button-danger margin-h-5" uk-icon="icon:trash"></a> &nbsp;&nbsp;&nbsp;
							<button class="archivo uk-icon-button uk-button-white" data-id="'.$row_CONSULTA['id'].'" data-archivo="'.$row_CONSULTA['archivo'].'" uk-icon="icon:folder"></button> &nbsp;&nbsp;&nbsp;
							<button class="nivel uk-icon-button '.$clase.'" data-id="'.$row_CONSULTA['id'].'">'.$level.'</button> &nbsp;&nbsp;&nbsp;
							<span class="enviarcorreo uk-icon-button uk-button-primary pointer" data-id="'.$row_CONSULTA['id'].'"><i class="fas fa-envelope"></i></span> &nbsp;&nbsp;&nbsp;
							<a href="../'.$row_CONSULTA['id'].'_revisar.pdf" class="uk-icon-button uk-button-white" target="_blank" uk-icon="icon:file-pdf"></a> &nbsp;&nbsp;&nbsp;
							<a href="index.php?rand='.rand(1,9999).'&modulo='.$modulo.'&archivo=detalle&id='.$row_CONSULTA['id'].'" class="uk-icon-button uk-button-primary" uk-icon="icon:search"></a>
						</td>
					</tr>';
				}
				?>

				</tbody>
			</table>
		</div>

		<div uk-grid>
			<div class="uk-width-1-4">
				<button class="uk-button uk-button-white">1</button> Registrado
			</div>
			<div class="uk-width-1-4">
				<button class="uk-button uk-button-primary">2</button> Pagado
			</div>
			<div class="uk-width-1-4">
				<button class="uk-button uk-button-warning">3</button> Enviado
			</div>
			<div class="uk-width-1-4">
				<button class="uk-button uk-button-success">4</button> Entregado
			</div>
		</div>


<!-- Modal Asignar ejecutivo -->
	<div id="ejecutivomodal" uk-modal class="modal">
		<div class="uk-modal-dialog">
			<div class="uk-modal-header">
				<button class="uk-modal-close-default" type="button" uk-close></button>
				<h3>Asignar a ejecutivo</h3>
			</div>
			<div class="uk-modal-body uk-text-center">
			<?php
			$CONSULTA = $CONEXION -> query("SELECT * FROM user WHERE nivel = 1 ORDER BY user DESC");
			while($row_CONSULTA = $CONSULTA -> fetch_assoc()){
				echo '
				<div class="uk-width-1-1 uk-margin">
					<button id="ejecutivo'.$row_CONSULTA['id'].'" class="asignar uk-button uk-button-white" data-ejecutivo="'.$row_CONSULTA['id'].'" data-pedido="0">'.$row_CONSULTA['user'].'</button>
				</div>';
			}
			?>

			</div>
			<div class="uk-modal-footer uk-text-center">
				<button class="uk-button uk-button-white uk-modal-close uk-button-large">Cerrar</button>
			</div>
		</div>
	</div>



<?php 
	include 'modulos/cotizacion/scripts.php';

$scripts.='
	// Asignar ejecutivo
		// Asignar los valores del pedido seleccionado a los botones de la modal
		$(".ejecutivo").click(function(){
			var pedido    = $(this).attr("data-id");
			var ejecutivo = $(this).attr("data-ejecutivo");
			var estatus   = $(this).attr("data-estatus");
			console.log(pedido+" - "+ejecutivo+" - "+estatus);

			$(".asignar").attr("data-pedido",pedido);
			$(".asignar").attr("data-estatus",0);
			$(".asignar").addClass("uk-button-white");
			$(".asignar").removeClass("uk-button-primary");
			$("#ejecutivo"+ejecutivo).attr("data-estatus",estatus);

			$("#ejecutivo"+ejecutivo).addClass("uk-button-primary");
			$("#ejecutivo"+ejecutivo).removeClass("uk-button-white");
		});

		// Asignar pedido al ejecutivo seleccionado en la modal
		$(".asignar").click(function(){
			var pedido = $(this).attr("data-pedido");
			var ejecutivo = $(this).attr("data-ejecutivo");
			var estatus = $(this).attr("data-estatus");
			var ejecutivoName="Asignar";

			UIkit.modal("#ejecutivomodal").hide();

			console.log(pedido+" - "+ejecutivo+" - "+estatus);

			if(estatus==0){
				$(this).addClass("uk-button-primary");
				$(this).removeClass("uk-button-white");
				ejecutivoName=$(this).text();
				$("#pedidoejecutivo"+pedido).addClass("uk-button-primary");
				$("#pedidoejecutivo"+pedido).removeClass("uk-button-white");
				$("#pedidoejecutivo"+pedido).attr("data-estatus",1);
				$("#pedidoejecutivo"+pedido).attr("data-ejecutivo",ejecutivo);
			}else{
				ejecutivo=0;
				$(this).removeClass("uk-button-primary");
				$(this).addClass("uk-button-white");
				$("#pedidoejecutivo"+pedido).removeClass("uk-button-primary");
				$("#pedidoejecutivo"+pedido).addClass("uk-button-white");
				$("#pedidoejecutivo"+pedido).attr("data-estatus",0);
				$("#pedidoejecutivo"+pedido).attr("data-ejecutivo",ejecutivo);
			}

			$("#pedidoejecutivo"+pedido).text(ejecutivoName);

			$.ajax({
				method: "POST",
				url: "modulos/varios/acciones.php",
				data: { 
					editarajax: 1,
					id: pedido,
					tabla: "cotizacion",
					campo: "ejecutivo",
					valor: ejecutivo
				}
			}).done(function( msg ) {
				UIkit.notification.closeAll();
				UIkit.notification(msg);
			});
		});




		';
?>
