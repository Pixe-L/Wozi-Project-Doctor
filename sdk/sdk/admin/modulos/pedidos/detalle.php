<?php
	$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE id = $id");
	$row_CONSULTA = $CONSULTA -> fetch_assoc();
	$user=$row_CONSULTA['uid'];
	$dom=$row_CONSULTA['dom'];
	$comprobante=$row_CONSULTA['comprobante'];
	$papelera=$row_CONSULTA['papelera'];
	$factura=($row_CONSULTA['factura']==0)?'No':'Sí';

	$CONSULTA1 = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $user");
	$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();


	$level=$row_CONSULTA['estatus']+1;
	switch ($level) {
		case 2:
			$clase='uk-button-primary';
			$estatus='Pagado';
			break;
		case 3:
			$clase='uk-button-warning';
			$estatus='Enviado';
			break;
		case 4:
			$clase='uk-button-success';
			$estatus='Entregado';
			break;
		default:
			$clase='uk-button-white';
			$estatus='Registrado';
			break;
	}

	$tabla = str_replace('<table', '<table class="uk-table uk-table-striped uk-table-hover uk-table-middle"', $row_CONSULTA['tabla']);
	$tabla = str_replace('color: white;', 'color: white; background-color: #999;', $tabla);


// BREADCRUMB
	echo '
	<div class="uk-width-auto margin-top-20">
		<ul class="uk-breadcrumb">
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Pedidos</a></li>';
		if ($papelera==1) {
			echo '
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=papelera">Cancelados</a></li>
			';
		}
		echo '
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=detalle&id='.$id.'" class="color-red">Pedido '.$id.'</a></li>
		</ul>
	</div>';

// RESTABLECER
	echo '
	<div class="uk-width-expand@s margin-top-20">
		<div uk-grid class="uk-flex-right">';
		if ($papelera==1) {
			echo '
			<div>
				<button class="restablecerpedido uk-button uk-button-default color-red"><i uk-icon="icon:refresh;"></i> &nbsp; Restablecer</button>
			</div>
			';
		}else{
			echo '
			<div>
				<a href="#eliminarpedidosmodal" uk-toggle data-id="'.$row_CONSULTA['id'].'" class="eliminarpedidosrow uk-button uk-button-default color-red"><i uk-icon="icon:trash;"></i> &nbsp; Cancelar</a>
			</div>';
		}
		echo '
		</div>
	</div>
		';

// ESTATUS CANCELADO
	if ($papelera==1) {
		echo '
		<div class="uk-width-1-1 uk-text-center">
			<div class="uk-alert uk-alert-danger text-xl">
				CANCELADO
			</div>
		</div>
		';
	}

// ACCIONES
	if ($papelera==0) {
		$clasecambiarestatus = 'estatus';
	}
	echo '
	<div class="uk-width-1-1">
		<div uk-grid class="uk-grid-small">
			<div>
				<a class="uk-button uk-button-white uk-button-large" href="../'.$row_CONSULTA['idmd5'].'_revisar.pdf" target="_blank"><i class="far fa-2x fa-file-pdf"></i> &nbsp; Ver PDF</a>
			</div>
			<div>
				<button class="'.$clasecambiarestatus.' '.$clase.' uk-button-large text-gnrl uk-text-uppercase" data-estatus="'.$level.'" data-id="'.$row_CONSULTA['id'].'">'.$estatus.'</button>
			</div>';
		if (strlen($comprobante)>0 and file_exists('../img/contenido/comprobantes/'.$comprobante)) {
			echo '
			<div>
				<a href="../img/contenido/comprobantes/'.$comprobante.'" class="uk-button uk-button-large uk-button-white" target="_blank">Comprobante de pago</a>
			</div>';
		}
		echo'
		</div>
	</div>';

// DATOS DEL CLIENTE
	echo '
	<div class="uk-width-1-1">
		<div uk-grid class="uk-grid-small uk-child-width-1-2@m">
			<div class="uk-width-1-3@s">
				<h2>Datos generales</h2>
				<span class="uk-text-muted">Nombre:</span> '.$row_CONSULTA1['nombre'].'<br>
				<span class="uk-text-muted">Email:</span> '.$row_CONSULTA1['email'].'<br>
				<span class="uk-text-muted">Telefono:</span> '.$row_CONSULTA1['telefono'].'<br>
				<span class="uk-text-uppercase"><span class="uk-text-muted">rfc:</span> '.$row_CONSULTA1['rfc'].'</span><br>
				<span class="uk-text-muted">Empresa:</span> '.$row_CONSULTA1['empresa'].'<br>
				<span class="uk-text-muted">Fecha de registro:</span> '.date('d-m-Y',strtotime($row_CONSULTA1['alta'])).'
			</div>
			<div class="uk-width-1-3@s">
				<h2>Domicilio</h2>
				<span class="uk-text-muted uk-text-capitalize">calle:</span> '.$row_CONSULTA1['calle'].' #'.$row_CONSULTA1['noexterior'].' &nbsp; '.$row_CONSULTA1['nointerior'].'<br>
				<span class="uk-text-muted uk-text-capitalize">entrecalles:</span> '.$row_CONSULTA1['entrecalles'].'<br>
				<span class="uk-text-muted uk-text-capitalize">colonia:</span> '.$row_CONSULTA1['colonia'].'<br>
				<span class="uk-text-muted uk-text-uppercase">cp:</span> '.$row_CONSULTA1['cp'].'<br>
				'.$row_CONSULTA1['pais'].', '.$row_CONSULTA1['estado'].', '.$row_CONSULTA1['municipio'].'
			</div>
		</div>
	</div>';

// GUÍA DE ENVÍO
	echo '
	<div class="uk-width-1-1">
		<div uk-grid>
			<div>
				Número de guía<br>
				<input type="text" class="editarajax uk-input uk-form-width-small" data-tabla="'.$modulo.'" data-campo="guia" data-id="'.$row_CONSULTA['id'].'" value="'.$row_CONSULTA['guia'].'">
			</div>
			<div class="uk-width-expand@s">
				Link de rastreo de guía<br>
				<input type="text" class="editarajax uk-input uk-form-width-large" data-tabla="'.$modulo.'" data-campo="linkguia" data-id="'.$row_CONSULTA['id'].'" value="'.$row_CONSULTA['linkguia'].'">
			</div>
		</div>
	</div>';

// TABLA DE PEDIDO
	echo '
	<div class="uk-width-1-1 margin-v-50">
		'.$tabla.'
	</div>';

// CADENA DE PAYPAL
	$CONSULTA2 = $CONEXION -> query("SELECT * FROM ipn WHERE pedido = $id");
	while($row_CONSULTA2 = $CONSULTA2 -> fetch_assoc()){
		if (strlen($row_CONSULTA2['ipn'])>0) {
			echo '
			<div class="uk-width-1-1 padding-v-100">
				<span class="uk-text-large">Cadena de pago PayPal</span><br>
				'.str_replace('&', '<br>', $row_CONSULTA2['ipn']).'
			</div>';
		}
	}

// VENTANAS MODALES
	echo '
	<div id="eliminarpedidosmodal" uk-modal class="modal">
		<div class="uk-modal-dialog">
			<div class="uk-modal-header">
				<button class="uk-modal-close-default" type="button" uk-close></button>
				<h3 class="color-red">Eliminar pedido <span id="pedidoeliminarspan"></span></h3>
			</div>
			<div class="uk-modal-body">
				<div class="uk-width-1-1 uk-margin">
					<div class="uk-container">
						<div uk-grid class="uk-child-width-1-2">
							<div>
								<button data-id="" data-incorporar="0" class="eliminarpedido-confirmar uk-button uk-button-white">No incorporar existencias</button>
							</div>
							<div>
								<button data-id="" data-incorporar="1" class="eliminarpedido-confirmar uk-button uk-button-primary">Incorporar existencias</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="uk-modal-footer uk-text-center">
				<button class="uk-button uk-button-white uk-modal-close uk-button-large">Cancelar</button>
			</div>
		</div>
	</div>';


$scripts='
	// CAMBIAR ESTATUS
		$(".estatus").click(function(){
			var id = $(this).data("id");
			var estatus = $(this).attr("data-estatus");

			switch(estatus) {
				case "1":
					estatus=2;
					$(this).removeClass("uk-button-white");
					$(this).addClass("uk-button-primary");
					$(this).text("Pagado");
					break;
				case "2":
					estatus=3;
					$(this).removeClass("uk-button-primary");
					$(this).addClass("uk-button-warning");
					$(this).text("Enviado");
					break;
				case "3":
					estatus=4;
					$(this).removeClass("uk-button-warning");
					$(this).addClass("uk-button-success");
					$(this).text("Entregado");
					break;
				default:
					estatus=1;
					$(this).removeClass("uk-button-success");
					$(this).text("Registrado");
					break;
			}

			$(this).attr("data-estatus",estatus);

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

	// Eliminar pedido
		$(".eliminarpedido-confirmar").click(function() {
			var incorporar=$(this).attr("data-incorporar");
			var statusConfirm = confirm("Realmente desea eliminar este pedido?");
			if (statusConfirm == true) { 
				window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&cancelarpedido&id='.$id.'&incorporar="+incorporar);
			} 
		});

	// Restablecer pedido
		$(".restablecerpedido").click(function() {
			window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&id='.$id.'&restablecerpedido=1");
		});


	';

mysqli_free_result($CONSULTA);
mysqli_free_result($CONSULTA1);
