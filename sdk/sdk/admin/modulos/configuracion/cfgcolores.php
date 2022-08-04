<?php
// BREADCRUMB
	echo '
	<div class="uk-width-1-1 margin-top-20 uk-text-left">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Configuración</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=cfgcolores" class="color-red">Colores</a></li>
		</ul>
	</div>';

// AGREGAR COLOR
	echo '
	<div class="uk-width-1-2@s margin-v-20">
		<div class="uk-card uk-card-default uk-card-body uk-border-rounded" style="min-height:150px;">
			<form action="index.php" method="post">
				<div uk-grid>
					<div class="uk-width-expand">
						<input type="hidden" name="nuevocolor" value="1">
						<input type="hidden" name="modulo" value="'.$modulo.'">
						<input type="hidden" name="archivo" value="'.$archivo.'">
						<input type="color"  name="txt" class="uk-input" value="#ffffff" required><br><br>
					</div>
					<div class="uk-width-auto">
						<button type="submit" name="send" class="uk-button uk-button-primary"><i uk-icon="plus"></i> &nbsp; Agregar</button>
					</div>
				</div>
			</form>
		</div>
	</div>';

// AGREGAR TEXTURA
	echo '
	<div class="uk-width-1-2@s margin-v-20 uk-text-center">
		<div class="uk-card uk-card-default uk-card-body uk-border-rounded" style="min-height:150px;">
			<a href="#colorpic" uk-toggle class="uk-button uk-button-primary"><i uk-icon="plus"></i> &nbsp; Nueva textura</a>
		</div>
	</div>';

// COLORES
	echo '
	<div class="uk-width-1-1">
		<div uk-grid class="uk-flex-center">';

			// Obtener colores
			$CONSULTA = $CONEXION -> query("SELECT * FROM productoscolor ORDER BY name");
			while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
				$thisID   = $rowCONSULTA['id'];
				$imagen   = $rutaFinal.$rowCONSULTA['imagen'];
				$colorTxt = (strlen($rowCONSULTA['imagen'])>0 AND file_exists($imagen))?'<div class="uk-border-circle uk-container" style="background:url('.$imagen.');background-size:cover;width:70px;height:70px;border:solid 1px #999;">&nbsp;</div>':'<input type="color" class="editarajax uk-input uk-form-width-xsmall" data-tabla="productoscolor" data-campo="txt" data-id="'.$rowCONSULTA['id'].'" placeholder="Color" value="'.$rowCONSULTA['txt'].'">';
				echo '
					<div style="max-width:200px;">
						<div class="uk-card-body" id="row'.$thisID.'">
							<div>
								<input class="editarajax uk-input" data-tabla="productoscolor" data-campo="name" data-id="'.$thisID.'" value="'.$rowCONSULTA['name'].'">
							</div>
							<div class="uk-margin uk-flex uk-flex-center">
								'.$colorTxt.'
							</div>
							<div class="uk-text-center">
								<a href="#modaleliminaexistencias" uk-toggle data-id="'.$thisID.'" class="fichalink uk-icon-button uk-button-danger" uk-icon="trash"></a>
							</div>
						</div>
					</div>';
			}


			echo '
		</div>
	</div>';

// AUXILIAR PARA LEER EL ID QUE SE DESEA EDITAR
	echo '
	<input type="hidden" id="fichaid">';

// MODAL SUBE TEXTURA
	echo '
	<div id="colorpic" uk-modal>
		<div class="uk-modal-dialog uk-modal-body">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<p>JPG 50 x 50 px</p>
			<div id="colorupload">
				Cargar
			</div>
			<div class="uk-margin uk-text-center">
				<a href="#" class="uk-button uk-button-white uk-button-large uk-modal-close">Cancelar</a>
			</div>
		</div>
	</div>';

// MODAL ELIMINA EXISTENCIAS
	echo '
	<div id="modaleliminaexistencias" uk-modal>
		<div class="uk-modal-dialog uk-modal-body bg-danger">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<div class="uk-margin uk-text-center color-white text-xxl">ATENCIÓN</div>
			<div class="uk-margin uk-text-center color-white text-xl">Se eliminarán las existencias</div>
			<div class="uk-margin uk-text-center">
				<button id="borrarexistencias" class="uk-button uk-button-white uk-button-large" tabindex="10">Eliminar</button>
				<a href="#" class="uk-button uk-button-primary uk-button-large uk-modal-close">Cancelar</a>
			</div>
		</div>
	</div>';


$scripts='
	// PONER ID AUXILIAR
		$(".fichalink").click(function(){
			var id = $(this).attr("data-id");
			$("#fichaid").val(id);
		})	

	// ELIMINAR
		$("#borrarexistencias").click(function(){
			var id = $("#fichaid").val();
			UIkit.modal.confirm("Esta acción no se puede deshacer").then(function() {
				$.ajax({
					method: "POST",
					url: "modulos/'.$modulo.'/acciones.php",
					data: { 
						eliminarexistencias: 1,
						tabla: "productoscolor",
						campo: "color",
						id: id
					}
				})
				.done(function( response ) {
					console.log( response );
					UIkit.notification.closeAll();
					datos = JSON.parse( response );
					UIkit.notification(datos.msj,{pos:"bottom-right"});
					if(datos.estatus==1){
						$("#row"+id).fadeOut();
					}
				});
			}, function () {
				UIkit.notification(\'<div class="uk-text-center color-white bg-primary padding-10 text-lg">Cancelado</div>\',{pos:"bottom-right"});
			});
		});
	
	// SUBE TEXTURA
		$("#colorupload").uploadFile({
			url: "../library/upload-file/php/upload.php",
			fileName: "myfile",
			maxFileCount: 1,
			showDelete: \'false\',
			allowedTypes: "jpg,jpeg",
			maxFileSize: 20000000,
			showFileCounter: false,
			showPreview: false,
			returnType: \'json\',
			onSuccess:function(data){
				window.location = (\'index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&filenametextura=\'+data);
			}
		});



	';










