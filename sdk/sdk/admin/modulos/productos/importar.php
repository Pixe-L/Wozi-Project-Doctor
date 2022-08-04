<?php
echo '
	<div class="uk-width-auto margen-v-20">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'">Productos</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=importar" class="color-red">Importar</a></li>
		</ul>
	</div>
	<div class="uk-width-expand@m margen-v-20">
		<div uk-grid class="uk-flex-right">
			<div>
				<button class="uk-button uk-button-default color-red" id="eliminatodo"><i uk-icon="trash"></i> &nbsp; Borrar todo</button>
			</div>
			<!--
			<div>
				<a href="modulos/productos/exportar.php" class="uk-button uk-button-primary" targer="_blank" download="productos.csv"><i uk-icon="download"></i> &nbsp; Exportar</a>
			</div>
			-->
		</div>
	</div>
';
?>


<div class="uk-width-1-1">
	<div uk-grid>
		<div class="uk-width-1-2@m">
			<div id="fileuploader">
				Cargar
			</div>
		</div>

		<div class="uk-width-1-2@m">
			El archivo debe ser formato CSV<br>
			CSV = Valores separados por comas<br>
			No se deben poner comas adicionles dentro de los campos<br>
			Para poner comas, utilice el símbolo de #<br>
			ID categoría se toma de <a href="index.php?rand=<?=rand(1,999999)?>&seccion=productos&subseccion=catdetalle">aquí</a><br>
			ID marca se toma de <a href="index.php?rand=<?=rand(1,999999)?>&seccion=productos&subseccion=marcas">aquí</a><br>
			Divisa puede ser MXN o USD<br>
		</div>
	</div>
</div>

<div class="uk-width-1-1">
	<p>Ejemplo:</p>
	<p>
		ID categoría,ID Marca,Modelo,Descripción,Divisa,Precio,Descuento,Existencias<br>
		1,1,AH10DNET-5A,DeviceNet Master Module,MXN,1000,15,20
	</p>
	<a href="../img/contenido/importar/ejemplo.csv" download class="uk-button uk-button-white"><i class="fa fa-download"></i> Ejemplo</a>
</div>

<div id="errormessage" class="uk-width-1-1">
	<div class="uk-alert-danger" uk-alert>
		<a class="uk-alert-close" uk-close></a>
		<p>Ocurrió un error.<br>Revise la sintaxis de su archivo</p>
	</div>
</div>

<?php
if (isset($showTable)) {
	echo '
	<div class="uk-width-1-1">
		<div class="uk-margin uk-text-center">
			<button class="continuebutton uk-button uk-button-primary uk-hidden">Continuar</button>
		</div>
		<div class="uk-overflow-auto">
			<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle">
				<thead>
					<tr>
						<th>Categoría</th>
						<th>Marca</th>
						<th>Modelo</th>
						<th>Descripción</th>
						<th>Divisa</th>
						<th>Precio</th>
						<th>Descuento</th>
						<th>Existencias</th>
					</tr>
				</thead>
				<tbody>';
					$numReg=count($infoImportar);
					$numRegUnico=count($array_unique);
					
					// Buscar repetidos
					$sku[0]=0;
					foreach ($infoImportar as $key => $value) {
						$sku[$value[2]]=(isset($sku[$value[2]]))?1:0;
						if ($sku[$value[2]]==1) {
							$dontConinue=1;
							echo '<tr><td colspan="30" class="bg-red color-white text-xl uk-text-left">'.$value[2].'  <span class="text-sm">repetido en el archivo</span><div style="width:0;overflow:hidden;"><input type="text" autofocus></div></td></tr>';
						}
					}
					foreach ($infoImportar as $key => $value) {
						$rowError = '';
						$catName = '';
						$marcaName = '';

						$sql="SELECT txt FROM $seccioncat WHERE id = $value[0]";
						$CONSULTA = $CONEXION -> query($sql);
						$numCats=$CONSULTA->num_rows;
						if ($numCats==1) {
							$rowCONSULTA = $CONSULTA -> fetch_assoc();
							$catName = $rowCONSULTA['txt'];
						}

						$sql="SELECT txt FROM $seccionmarca WHERE id = $value[1]";
						$CONSULTA = $CONEXION -> query($sql);
						$numMarcas=$CONSULTA->num_rows;
						if ($numMarcas==1) {
							$rowCONSULTA = $CONSULTA -> fetch_assoc();
							$marcaName = $rowCONSULTA['txt'];
						}

						$sql="SELECT id FROM $seccion WHERE sku = '$value[2]'";
						// echo $sql;
						$CONSULTA = $CONEXION -> query($sql);
						$repetido = $CONSULTA->num_rows;
						if ($repetido>0) {
							$bg = 'bg-red color-white';
							$rowError .= '<br>'.$value[2].' ya existe';
						}

						$bg = (!isset($value[7]))?'bg-red color-white':$bg;
						$bg = ( isset($value[8]))?'bg-red color-white':$bg;

						$rowError .= (!isset($value[7]))?'<br>Al producto '.$value[2].' le faltan celdas':'';
						$rowError .= ( isset($value[8]))?'<br>Al producto '.$value[2].' le sobran celdas':'';


						if (strlen($rowError)>0) {
							$dontConinue=1;
							echo '<tr><td colspan="30" class="bg-red color-white text-xl uk-text-left">'.$rowError.'<div style="width:0;overflow:hidden;"><input type="text" autofocus></div></td></tr>';
						}
						
						echo "
								<tr>
									<td class='$bg'>$catName</td>
									<td class='$bg'>$marcaName</td>
									<td class='$bg'>".str_replace('#', ',', $value[2])."</td>
									<td class='$bg'>".str_replace('#', ',', $value[3])."</td>
									<td class='$bg'>$value[4]</td>
									<td class='$bg'>$value[5]</td>
									<td class='$bg'>$value[6]</td>
									<td class='$bg'>$value[7]$value[8]$value[9]$value[10]$value[11]$value[12]$value[13]$value[14]</td>
								</tr>";
					}
					echo '
				</tbody>
			</table>
		</div>
	</div>';
}


echo '
<div id="spinnermodal" class="uk-modal-full" uk-modal>
  <div class="uk-modal-dialog uk-flex uk-flex-middle uk-height-viewport">
    <div class="uk-width-1-1">
    	<div class="uk-flex uk-flex-center">
    		<div style="max-width:90%;width:600px;">
				<progress id="js-progressbar" class="uk-progress" value="0" max="100"></progress>
	    	</div>
    	</div>
		<div uk-slider="autoplay:true;autoplay-interval:4000;" class="uk-width-1-1 uk-margin">
			<ul class="uk-width-1-1 uk-slider-items uk-child-width-1-1 uk-grid-match ">
				<li>
					<div class="uk-text-center">
						Espera un momento
					</div>
				</li>
				<li>
					<div class="uk-text-center">
						Procesando tu archivo
					</div>
				</li>
				<li>
					<div class="uk-text-center">
						Codificando el documento
					</div>
				</li>
				<li>
					<div class="uk-text-center">
						Contactando a la NASA
					</div>
				</li>
				<li>
					<div class="uk-text-center">
						El FBI va por ti
					</div>
				</li>
				<li>
					<div class="uk-text-center">
						No te creas, pero es cierto
					</div>
				</li>
				<li>
					<div class="uk-text-center">
						Ya casi terminamos
					</div>
				</li>
				<li>
					<div class="uk-text-center">
						Un minutito más
					</div>
				</li>
				<li>
					<div class="uk-text-center">
						Otro minutito
					</div>
				</li>
				<li>
					<div class="uk-text-center">
						Sé paciente
					</div>
				</li>
				<li>
					<div class="uk-text-center">
						Estamos a punto de acabar
					</div>
				</li>
				<li>
					<div class="uk-text-center">
						¿Tienes un minuto?
					</div>
				</li>
				<li>
					<div class="uk-text-center">
						Ve por un café
					</div>
				</li>
				<li>
					<div class="uk-text-center">
						Me traes uno
					</div>
				</li>
			</ul>
		</div>      
    </div>
  </div>
</div>
';



$scripts.='
	$(document).ready(function() {

		$("#fileuploader").uploadFile({
			url:"../library/upload-file/php/upload.php",
			fileName:"myfile",
			maxFileCount:1,
			showDelete: \'false\',
			allowedTypes: "csv",
			maxFileSize: 9999999,
			showFileCounter: false,
			showPreview:false,
			returnType:\'json\',
			onSuccess:function(data){ 
				window.location = (\'index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$subseccion.'&csvfile=\'+data);
			}
		});

		// Eliminar todo los productos
		$("#eliminatodo").click(function() {
			UIkit.modal.confirm("Desea borrar todos los productos?").then(function () {
				var statusConfirm2 = confirm("Perdona la insistencia, pero es muy importante. Estás a punto de borrar todos los productos. Estás seguro?"); 
				if (statusConfirm2 == true) {
					window.location = ("index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$subseccion.'&borrartodoslosproductos");
				}
			}, function () {
				console.log("Rejected.")
			});
		});

		$(".continuebutton").click(function(){
			UIkit.modal("#spinnermodal").show();
			procesararchivoimportado();
		});

	});

	';


	if (!isset($dontConinue)) {
		$scripts.= '
		$(".continuebutton").removeClass("uk-hidden");
		$("#errormessage").remove();
		';
	}

	if (isset($fileFinal)) {
		$scripts.= '
		function procesararchivoimportado() {
			$.ajax({
				method: "POST",
				url: "modulos/'.$seccion.'/acciones.php",
				data: { 
					file: "'.$fileFinal.'",
					importardatos: 1
				}
			})
			.done(function( response ) {
				console.log( response );
				datos = JSON.parse(response);
				UIkit.notification.closeAll();
				if (datos.estatus == 1) {
					window.location = (\'index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$subseccion.'&showsuccess=1\');
				} else {
					var newvalue = datos.estatus * 100;
					$("#js-progressbar").val(newvalue);
					UIkit.notification(datos.msj,{pos:"bottom-right"});
					procesararchivoimportado();
				}
			});
		}
		';
	}



?>