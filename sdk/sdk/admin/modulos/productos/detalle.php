<?php 
	$consulta = $CONEXION -> query("SELECT * FROM $modulo WHERE id = $id");
	$rowConsultaItem = $consulta -> fetch_assoc();
	$cat       = $rowConsultaItem['categoria'];
	$tipotalla    = $rowConsultaItem['tipotalla'];
	$marcaId   = $rowConsultaItem['marca'];

	$fechaSQL=$rowConsultaItem['fecha'];
	$segundos=strtotime($fechaSQL);
	$fechaUI=date('m/d/Y',$segundos);

	$descuento=($rowConsultaItem['descuento']>0)?$rowConsultaItem['descuento']:0;

	$CATEGORY = $CONEXION -> query("SELECT * FROM $modulocat WHERE id = $cat");
	$row_CATEGORY = $CATEGORY -> fetch_assoc();
	$catNAME=$row_CATEGORY['txt'];
	$catParentID=$row_CATEGORY['parent'];

	$CATEGORY = $CONEXION -> query("SELECT * FROM $modulocat WHERE id = $catParentID");
	$row_CATEGORY = $CATEGORY -> fetch_assoc();
	$catParent=$row_CATEGORY['txt'];

	$marca='';
	$CONSULTA1 = $CONEXION -> query("SELECT * FROM productosmarcas WHERE id = $marcaId");
	$numItems=$CONSULTA1->num_rows;
	if ($numItems>0) {
		$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
		$marca=$row_CONSULTA1['txt'];
	}

// BREADCRUMB
	echo '
	<div class="uk-width-auto margin-v-20">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'">Productos</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=categorias">Categorías</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=catdetalle&cat='.$catParentID.'">'.$catParent.'</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=items&cat='.$cat.'">'.$catNAME.'</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=detalle&id='.$id.'" class="color-red">'.$rowConsultaItem['sku'].'</a></li>
		</ul>
	</div>';

// BOTONES SUPERIORES
	echo '
	<div class="uk-width-expand@xl margin-v-20">
		<div uk-grid class="uk-grid-small uk-flex-right">
			<div>
				<button data-id="'.$rowConsultaItem['id'].'" class="eliminaprod uk-button uk-button-danger" tabindex="1"><i uk-icon="trash"></i> &nbsp; Eliminar</button> 
			</div>
			<div>
				<a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=editar&id='.$id.'" class="uk-button uk-button-primary"><i uk-icon="pencil"></i> &nbsp; Editar</a>
			</div>
			<div>
				<a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=nuevo&cat='.$cat.'" class="uk-button uk-button-success"><i uk-icon="plus"></i> &nbsp; Nuevo</a>
			</div>
		</div>
	</div>';

// TALLAS Y COLORES
	$CONSULTA = $CONEXION -> query("SELECT * FROM productostallaclasif WHERE id = '$tipotalla'");
	while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
		$tipo=$rowCONSULTA['txt'];
	}
	if (!isset($tipo)) {
		$tipo=999;
	}

	echo '
	<div class="uk-width-1-1">
		<div class="uk-card uk-card-default uk-card-body">
			<h3 class="uk-text-center">EXISTENCIAS DE '.strtoupper($tipo).'</h3>
			<ul class="uk-subnav uk-subnav-pill uk-flex-center" uk-switcher>';
			$CONSULTA = $CONEXION -> query("SELECT * FROM productostalla WHERE tipo = '$tipotalla' ORDER BY orden");
			while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
				$thisID=$rowCONSULTA['id'];
				echo '
				<li><a href="#">'.$rowCONSULTA['txt'].'</a></li>';
			}

			echo '
			</ul>

			<ul class="uk-switcher uk-margin">';
			$CONSULTA = $CONEXION -> query("SELECT * FROM productostalla WHERE tipo = '$tipotalla' ORDER BY orden");
			while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
				$tallaId=$rowCONSULTA['id'];
				echo '
				<li>
					<div uk-grid class="uk-child-width-1-3">';

				// Obtener todos
				$CONSULTA2 = $CONEXION -> query("SELECT * FROM productoscolor ORDER BY txt");
				while ($rowCONSULTA2 = $CONSULTA2 -> fetch_assoc()) {
					$colorId  = $rowCONSULTA2['id'];

					$imagen   = '../img/contenido/varios/'.$rowCONSULTA2['imagen'];
					$colorTxt = (strlen($rowCONSULTA2['imagen'])>0 AND file_exists($imagen))?'<div class="uk-border-circle uk-container" style="background:url('.$imagen.');background-size:cover;width:70px;height:70px;border:solid 1px #999;">&nbsp;</div>':'<div class="uk-border-circle uk-container" style="background:'.$rowCONSULTA2['txt'].';width:70px;height:70px;border:solid 1px #999;">&nbsp;</div>';

					$CONSULTA3 = $CONEXION -> query("SELECT * FROM productosexistencias WHERE producto = $id AND talla = $tallaId ANd color = $colorId");
					$numItems=$CONSULTA3->num_rows;
					if ($numItems==0) {
						$existencias=0;
						$estatus=0;
						$sql="INSERT INTO productosexistencias (producto,talla,color,existencias) VALUES ($id,$tallaId,$colorId,$existencias)";
						if ($insertar = $CONEXION->query($sql)) {
							$existenciasId=$CONEXION->insert_id;
						}else{
							$existenciasId=0;
						}
					}else{
						$rowCONSULTA3 = $CONSULTA3 -> fetch_assoc();
						$existenciasId=$rowCONSULTA3['id'];
						$existencias=$rowCONSULTA3['existencias'];
						$estatus=$rowCONSULTA3['estatus'];
					}
					$estatusIcon=($estatus==0)?'off uk-text-muted':'on uk-text-primary';
					echo '
						<div>
							<div class="uk-text-muted">&nbsp;&nbsp;&nbsp; '.$rowCONSULTA2['name'].'</div>
							<div uk-grid>
								<div class="uk-width-auto">
									'.$colorTxt.'
								</div>
								<div class="uk-width-auto">
									<span class="uk-text-muted">Activo</span><br>
									<i class="estatuschange pointer fas fa-lg fa-toggle-'.$estatusIcon.'" data-tabla="productosexistencias" data-campo="estatus" data-id="'.$existenciasId.'" data-valor="'.$estatus.'"></i>
								</div>
								<div class="uk-width-expand">
									<span class="uk-text-muted">Existencias</span><br>
									<input class="editarajax uk-input input-number" type="number" data-tabla="productosexistencias" data-campo="existencias" data-id="'.$existenciasId.'" value="'.$existencias.'">
								</div>
							</div>
						</div>'; 
				}

				echo '
					</div>
				</li>';
			}
			echo '
			</ul>
		</div>
	</div>';

// INFO DEL PRODUCTO
	echo '
		<div class="uk-width-1-2@s margin-v-20">
			<div class="uk-card uk-card-default uk-card-body">
				<div>
					<span class="uk-text-capitalize uk-text-muted">Categoría:</span>
					'.$catNAME.'
				</div>
				<div>
					<span class="uk-text-capitalize uk-text-muted">Marca:</span>
					'.$marca.'
				</div>
				<div class="uk-margin-top">
					<span class="uk-text-muted">SKU:</span>
					'.$rowConsultaItem['sku'].'
				</div>
				<div>
					<span class="uk-text-capitalize uk-text-muted">modelo:</span>
					'.$rowConsultaItem['titulo'].'
				</div>
				<div>
					<span class="uk-text-muted">Precio de lista:</span>
					$'.number_format($rowConsultaItem['precio'],2).'
				</div>
				<div>
					<span class="uk-text-muted">Descuento:</span>
					'.$rowConsultaItem['descuento'].'%
				</div>
				<div>
					<span class="uk-text-capitalize uk-text-muted">Material:</span>
					'.$rowConsultaItem['material'].'
				</div>
				<div class="uk-margin bordered">
					'.$rowConsultaItem['txt'].'
				</div>
				<div class="uk-width-1-1 uk-text-right">
					<span class="uk-text-muted">Fecha de captura:</span>
					'.$fechaUI.'
				</div>
			</div>
		</div>
		<div class="uk-width-1-2@s">
			<div class="uk-card uk-card-default uk-card-body">
				<div class="uk-width-1-1">
					<h4>SEO</h4>
					<span class="uk-text-capitalize uk-text-muted">titulo google:</span>
					'.$rowConsultaItem['title'].'
				</div>
				<div class="uk-width-1-1">
					<span class="uk-text-capitalize uk-text-muted">descripción google:</span>
					'.$rowConsultaItem['metadescription'].'
				</div>
			</div>
		</div>
		';

// FOTOGRAFÍAS
	echo '
		<div class="uk-width-1-1 margin-top-50">
			<h3 class="uk-text-center">Fotografías</h3>
		</div>

		<div class="uk-width-1-1">
			<div id="fileuploader">
				Cargar
			</div>
		</div>
		<div class="uk-width-1-1 uk-text-center">
			<div uk-grid id="pics" class="uk-grid-small uk-grid-match sortable" data-tabla="'.$modulopic.'">';

		$consultaPIC = $CONEXION -> query("SELECT * FROM $modulopic WHERE producto = $id ORDER BY orden,id");
		$numProds=$consultaPIC->num_rows;
		while ($row_consultaPIC = $consultaPIC -> fetch_assoc()) {
			$picId=$row_consultaPIC['id'];
			$pic=$rutaFinal.$picId.'.jpg';
			if(file_exists($pic)){
				echo '
					<div id="'.$picId.'">
						<div class="uk-card uk-card-default uk-card-body uk-text-center">
							<a href="'.$pic.'" class="uk-icon-button uk-button-white" target="_blank" uk-icon="icon:image"></a> &nbsp;
							<a href="javascript:borrarfoto(picID='.$picId.')" class="uk-icon-button uk-button-danger" tabindex="1" uk-icon="icon:trash"></a>
							<br>
							<img src="'.$pic.'" class="uk-border-rounded margin-top-20" style="max-width:200px;">
						</div>
					</div>';
			}else{
				echo '
					<div class="uk-width-1-4@l uk-width-1-2@m uk-width-1-1@s uk-margin-bottom" id="'.$picId.'">
						<div class="uk-card uk-card-default uk-card-body uk-text-center">
							<a href="javascript:borrarfoto(picID='.$picId.')" class="uk-icon-button uk-button-danger" tabindex="1" uk-icon="icon:trash"></a>
							<br>
							Imagen rota<br>
							<i uk-icon="icon:ban;ratio:2;"></i>
						</div>
					</div>';
			}
		}

		echo '
			</div>
		</div>

		';

$scripts='
	// Eliminar foto
		function borrarfoto (id) { 
			var statusConfirm = confirm("Realmente desea eliminar esto?"); 
			if (statusConfirm == true) { 
				$.ajax({
					method: "POST",
					url: "modulos/'.$modulo.'/acciones.php",
					data: { 
						borrarfoto: 1,
						id: id
					}
				})
				.done(function( msg ) {
					UIkit.notification.closeAll();
					UIkit.notification(msg);
					$("#"+id).addClass( "uk-invisible" );
				});
			}
		}

	// Eliminar foto redes
		$(".borrarpicredes").click(function() {
			var statusConfirm = confirm("Realmente desea borrar esto?"); 
			if (statusConfirm == true) { 
				window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&id='.$id.'&borrarpicredes");
			} 
		});

	// Subir imagen de galería
	$(document).ready(function() {
		$("#fileuploader").uploadFile({
			url:"modulos/'.$modulo.'/acciones.php?id='.$id.'",
			multiple: true,
			maxFileCount:1000,
			fileName:"uploadedfile",
			allowedTypes: "jpeg,jpg",
			maxFileSize: 6000000,
			showFileCounter: false,
			showDelete: "false",
			showPreview:false,
			showQueueDiv:true,
			returnType:"json",
			onSuccess:function(files,data,xhr){
				console.log(data);
				var l = data[0].indexOf(".");
				var id = data[0].substring(0,l);
				$("#pics").append("';
				$scripts.='<div id=\'"+id+"\'>';
				$scripts.='<div class=\'uk-card uk-card-default uk-card-body uk-text-center\'>';
				$scripts.='<div>';
				$scripts.='<a href=\'javascript:borrarfoto(\""+id+"\")\' class=\'uk-icon-button uk-button-danger\' uk-icon=\'trash\'></a>';
				$scripts.='</div>';
				$scripts.='<div class=\'uk-margin\' uk-lightbox>';
				$scripts.='<a href=\''.$rutaFinal.'"+data+"\'>';
				$scripts.='<img src=\''.$rutaFinal.'"+data+"\' style=\'max-width:200px;\'>';
				$scripts.='</a>';
				$scripts.='</div>';
				$scripts.='</div>';
				$scripts.='</div>';
				$scripts.='");';
				$scripts.='
			}
		});
	});

	// Subir imagen redes
		$(document).ready(function() {
			$("#fileuploadermain").uploadFile({
				url:"../library/upload-file/php/upload.php",
				fileName:"myfile",
				maxFileCount:1,
				showDelete: \'false\',
				allowedTypes: "jpeg,jpg",
				maxFileSize: 6291456,
				showFileCounter: false,
				showPreview:false,
				returnType:\'json\',
				onSuccess:function(data){ 
					window.location = (\'index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$archivo.'&cat='.$cat.'&id='.$id.'&position=main&filename=\'+data);
				}
			});
		});


	// Eliminar producto
		$(".eliminaprod").click(function() {
			var statusConfirm = confirm("Realmente desea eliminar este Producto?"); 
			if (statusConfirm == true) {
				$.ajax({
					method: "POST",
					url: "modulos/'.$modulo.'/acciones.php",
					data: { 
						borrarPod: 1,
						id: '.$id.'
					}
				})
				.done(function( msg ) {
					UIkit.notification.closeAll();
					UIkit.notification(msg,{pos:"bottom-right"});
					if( msg=="<div class=\'bg-success color-blanco\'><i uk-icon=\'icon: trash;ratio:2;\'></i> &nbsp; Borrado</div>" ){
						window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo=items&cat='.$cat.'");
					}
				});
			} 
		});
		';
