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
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'" class="color-red">Pedidos</a></li>
		</ul>
	</div>
	';

// PAPELERA
	echo '
	<div class="uk-width-expand@s margin-top-20">
		<div uk-grid class="uk-flex-right">
			<a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=papelera" class="uk-button uk-button-default color-red"><i uk-icon="trash"></i> &nbsp; Cancelados</a>
		</div>
	</div>
	';

// NOMENCLATURA
	echo '
	<div class="uk-width-1-1">
		<div uk-grid class="uk-child-width-1-4@s uk-text-center">
			<div>
				<button class="uk-icon-button uk-button-white">1</button> Registrado
			</div>
			<div>
				<button class="uk-icon-button uk-button-primary">2</button> Pagado
			</div>
			<div>
				<button class="uk-icon-button uk-button-warning">3</button> Enviado
			</div>
			<div>
				<button class="uk-icon-button uk-button-success">4</button> Entregado
			</div>
		</div>
	</div>
	';

// TABLA DE PEDIDOS
	echo '
	<div class="uk-width-1-1">
		<table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-small uk-table-responsive">
			<thead>
				<tr>
					<th width="10px">Id</th>
					<th width="10px" class="uk-text-center">Fecha</th>
					<th>Nombre/Email</th>
					<th width="10px" class="uk-text-center">Cupón</th>
					<th width="10px" class="uk-text-center">Productos</th>
					<th width="10px" class="uk-text-center">Importe</th>
					<th width="20px;"></th>
				</tr>
			</thead>
			<tbody>';

			$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE papelera = 0 ORDER BY id DESC LIMIT $prodInicial,$prodspagina");
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
					<td class="bg'.$level.' uk-text-nowrap uk-text-center">
						'.$row_CONSULTA['cupon'].'
					</td>
					<td class="bg'.$level.' uk-text-nowrap uk-text-center@m">
						'.$numProds.'
					</td>
					<td class="bg'.$level.' uk-text-nowrap uk-text-right@m">
						<span class="uk-hidden">'.($row_CONSULTA['importe']+1000000000).'</span>
						$'.number_format($row_CONSULTA['importe'],2).'
					</td>
					<td class="bg'.$level.' uk-text-nowrap">
						<a class="uk-icon-button uk-button-white" href="../'.$row_CONSULTA['idmd5'].'_revisar.pdf" target="_blank"><i class="far fa-file-pdf"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;
						<button class="estatus '.$clase.' uk-icon-button" data-id="'.$row_CONSULTA['id'].'">'.$level.'</button> &nbsp;&nbsp;&nbsp;&nbsp;
						<a href="#envios" uk-toggle class="fichalink uk-icon-button uk-button-primary" data-id="'.$row_CONSULTA['id'].'"><i class="fa fa-envelope"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;
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
					$link='index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&pag='.($pag-1).'&prodspagina='.$prodspagina;
					echo'
					<li><a href="'.$link.'"><i class="fa fa-lg fa-angle-left"></i> &nbsp;&nbsp; Anterior</a></li>';
				}
				$pagTotal=intval($numItems/$prodspagina);
				$sobrante=$numItems % $prodspagina;
				if (($sobrante) == 0){
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

// VENTANAS MODALES
	echo '
	<div id="envios" uk-modal class="modal">
		<div class="uk-modal-dialog">
			<div class="uk-modal-header">
				<button class="uk-modal-close-default" type="button" uk-close></button>
				<h3>Envío de notificaciones</h3>
			</div>
			<div class="uk-modal-body">
				<div class="uk-width-1-1 uk-margin">
					<div class="uk-container" style="width:300px;">
						<div class="uk-width-1-1 uk-margin">
							<button data-id="0" data-enviarcorreo="1" class="enviarcorreo uk-width-1-1 uk-button uk-button-large uk-button-primary uk-margin">Número de guía</button>
						</div>
						<div class="uk-width-1-1 uk-margin">
							<button data-id="0" data-enviarcorreo="2" class="enviarcorreo uk-width-1-1 uk-button uk-button-large uk-button-white uk-margin">Reenvío de orden</button>
						</div>
						<div class="uk-width-1-1 uk-margin">
							<button data-id="0" data-enviarcorreo="3" class="enviarcorreo uk-width-1-1 uk-button uk-button-large uk-button-danger uk-margin">Cancelación de orden</button>
						</div>
					</div>
				</div>
			</div>
			<div class="uk-modal-footer uk-text-center">
				<button class="uk-button uk-button-white uk-modal-close uk-button-large">Cerrar</button>
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

	// ESTATUS
		$(".estatus").click(function(){
			var id = $(this).data("id");
			var estatus = $(this).html();
			switch(estatus) {
				case "1":
					estatus=2;
					$(this).removeClass("uk-button-white");
					$(this).addClass("uk-button-primary");
					$(this).html(estatus);
					break;
				case "2":
					estatus=3;
					$(this).removeClass("uk-button-primary");
					$(this).addClass("uk-button-warning");
					$(this).html(estatus);
					break;
				case "3":
					estatus=4;
					$(this).removeClass("uk-button-warning");
					$(this).addClass("uk-button-success");
					$(this).html(estatus);
					break;
				default:
					estatus=1;
					$(this).removeClass("uk-button-success");
					$(this).html(estatus);
					break;
			}
			$.ajax({
				method: "POST",
				url: "modulos/'.$modulo.'/acciones.php",
				data: { 
					estatuschange: 1,
					estatus: (estatus-1),
					id: id
				}
			})
			.done(function( msg ) {
				UIkit.notification.closeAll();
				UIkit.notification(msg);
			});
		});

	// ASIGNAR ID AUXILIAR
		$(".fichalink").click(function(){
			var id = $(this).attr("data-id");
			$("#fichaid").val(id);
		});

	// ENVÍO DE CORREO
		$(".enviarcorreo").click(function(){
			var id = $("#fichaid").val();
			var enviarcorreo = $(this).attr("data-enviarcorreo");
			UIkit.notification("<div class=\'uk-text-center padding-10 text-lg color-white bg-primary\'>Procesando...</span>");
			$.ajax({
				method: "POST",
				url: "../includes/acciones.php",
				data: { 
					enviarcorreo: enviarcorreo,
					id: id
				}
			})
			.done(function( response ) {
				UIkit.notification.closeAll();
				console.log( response );
				datos = JSON.parse( response );
				UIkit.notification(datos.msj);
			});
		});

	';
