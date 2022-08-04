<?php
$fallo=0;
$fecha=date('Y-m-d H:i:s');

// Dame producto
	if (isset($_POST['dameproducto'])) {
		include '../../../includes/connection.php';
		$msjClase='danger';
		$msjIcon='ban';
		$msjTxt='No se pudo guardar';
		$estatus=0;

		$id =(isset($_POST['id']))?  $_POST['id']:'';
		$num=(isset($_POST['num']))?$_POST['num']:'';
		$row='';

		$CONSULTA = $CONEXION -> query("SELECT * FROM productos WHERE id = $id");
		$numItems = $CONSULTA->num_rows;
		if ($numItems>0) {
			$row_CONSULTA = $CONSULTA -> fetch_assoc();
			$thisName=html_entity_decode($row_CONSULTA['titulo']);

			
			$row.='<tr id="row'.$num.'">';
				$row.='<td>';
					$row.='<a href="javascript:elimnarow('.$num.')" class="uk-icon-button uk-button-danger" uk-icon="trash"></a>';
				$row.='</td>';
				$row.='<td>';
					$row.=''.$thisName.'';
				$row.='</td>';
				$row.='<td>';
					$row.='<input type="number" class="uk-input" name="cantidad'.$num.'" value="0" required>';
				$row.='</td>';
				$row.='<td>';
					$row.='<input type="hidden" name="id'.$num.'" value="'.$id.'">';
					$row.='<input type="text" class="uk-input" name="ladoa'.$num.'" value="0" required>';
				$row.='</td>';
				$row.='<td>';
					$row.='<input type="text" class="uk-input" name="ladob'.$num.'" value="0" required>';
				$row.='</td>';
				$row.='<td>';
					$row.='<input type="text" class="uk-input" name="unidad'.$num.'" placeholder="pza, caja o m2" required>';
				$row.='</td>';
				$row.='<td>';
					$row.='<select class="uk-select" name="precio'.$num.'">';
						$row.='<option>'.$row_CONSULTA['precio1'].'</option>';
						$row.='<option>'.$row_CONSULTA['precio2'].'</option>';
						$row.='<option>'.$row_CONSULTA['precio3'].'</option>';
					$row.='</select>';
				$row.='</td>';
			$row.='</tr>';

			$msjClase='success';
			$msjIcon='check';
			$msjTxt='Guardado';
			$estatus=1;
		}
		
		$row=str_replace('"', "'", $row);

		echo '{ "msj":"<div class=\'uk-text-center color-blanco bg-'.$msjClase.' padding-10 text-lg\'><i uk-icon=\'icon:'.$msjIcon.';ratio:3;\'></i> &nbsp; '.$msjTxt.'</div>", "estatus":"'.$estatus.'", "row":"'.$row.'" }';

		mysqli_close($CONEXION);
		if (file_exists('error_log')) {
			unlink('error_log');
		}
	}

// Carro de compra
	if (isset($_POST['vaciarcarro'])) {
		if (isset($_SESSION['carro'])) { unset($_SESSION['carro']); }
		if (isset($_SESSION['formato'])) { unset($_SESSION['formato']); }
		if (isset($_SESSION['tablaBody'])) { unset($_SESSION['tablaBody']); }
	}
	$carroTotalProds=0;

	if (isset($_POST['modificacarro'])) {
		// Si ya hay productos en la variable de sesión
		if(isset($_SESSION['carro'])){
			// Almacenar los productos en la variable arreglo
			$arreglo=$_SESSION['carro'];
			foreach ($arreglo as $key1) {
				foreach ($key1 as $key2) {
					$carroTotalProds+=$key2['Cantidad'];
				}
			}
		}
	}

	// Agregar artículos al carro
	if (isset($_POST['addtocart'])){
		if (isset($_POST['formato'])){
			$_SESSION['formato']=$_POST['formato'];
		}

		for ($i=1; $i < 50; $i++){
			if (
				(isset($_POST['cantidad'.$i]) and $_POST['cantidad'.$i]!==0 and $_POST['cantidad'.$i]!=='')
				OR (isset($_POST['ladoa'.$i]) and $_POST['ladoa'.$i]!==0 and $_POST['ladoa'.$i]!=='')
			){
				$carroTotalProds+=$_POST['cantidad'.$i];

				$thisID=$_POST['id'.$i];

				$CONSULTA = $CONEXION -> query("SELECT * FROM productos WHERE id = $thisID");
				$row_CONSULTA = $CONSULTA -> fetch_assoc();

				$arregloNuevo[]=array('Id'=>$row_CONSULTA['id'],
						'Nombre'=>$row_CONSULTA['titulo'],
						'Precio'=>$_POST['precio'.$i],
						'Cantidad'=>$_POST['cantidad'.$i],
						'Unidad'=>$_POST['unidad'.$i],
						'Ladoa'=>$_POST['ladoa'.$i],
						'Ladob'=>$_POST['ladob'.$i]
					);
			}
		}

		if (isset($arregloNuevo)) {
			if (!isset($arreglo)) {
				$arreglo[0]=$arregloNuevo;
			}else{
				$num=key($arreglo);
				foreach ($arreglo as $key1) {
					foreach ($arregloNuevo as $key2) {
						if($key1[0]['Nombre']==$key2['Nombre']){
							unset($arreglo[$num]);
						}
					}
					$num++;
				}
				array_push($arreglo, $arregloNuevo);
			}
		}

		// Agregamos todos los productos a la variable de sesión carro
		if (isset($arreglo)) {
			$_SESSION['carro']=$arreglo;
		}
	}

// Configuración Editar
	if(isset($_POST['action']) and $_POST['action']=='textos_editar'){
		foreach ($_POST as $key => $value) {
			$actualizar = $CONEXION->query("UPDATE cotizacion_config SET $key = '$value' WHERE id = 1");
			$exito=1;
		}
	}


// Clientes Nuevo
	if(isset($_POST['clientes_nuevo'])){
		session_start();
		foreach ($_POST as $key => $value) {
			${$key}=$value;
		}

		// Verificamos que el usuarios no esté registrado previamente
		$CONSULTA_REPETIDO = $CONEXION -> query("SELECT * FROM usuarios WHERE email = '$email'");
		$numRows = mysqli_num_rows($CONSULTA_REPETIDO);
		if ($numRows>0) {
			$row_CONSULTA_REPETIDO = $CONSULTA_REPETIDO -> fetch_assoc();
			$fallo=1; 
			$legendFail.="<br>El cliente ya está registrado";
		}

		if($fallo==0){
			$sql = "INSERT INTO usuarios (alta)".
				"VALUES ('$hoy')";
			if($insertar = $CONEXION->query($sql))
			{
				$id=$CONEXION->insert_id;
				$_SESSION['clienteid']=$id;
				$exito=1;
				$legendSuccess.="<br>Cliente nuevo";
				foreach ($_POST as $key => $value) {
					$dato = trim(htmlentities($value, ENT_QUOTES));
					$actualizar = $CONEXION->query("UPDATE usuarios SET $key = '$dato' WHERE id = $id");
				}
			}else{
				$fallo=1;  
				$legendFail.="<br>No se pudo agregar a la base de datos";
			}
		}
	}

// Clientes Editar
	if(isset($_POST['action']) and $_POST['action']=='clientes_editar'){

		if(isset($_POST['nombre'])){ $nombre=htmlentities($_POST['nombre']); }else{ $nombre=false; $fallo=1; $legendFail.="<br> - Proporcione nombre";}
		if(isset($_POST['empresa'])){ $empresa=htmlentities($_POST['empresa']); }else{ $empresa=false; $fallo=1; $legendFail.="<br> - Proporcione empresa";}
		if(isset($_POST['domicilio'])){ $domicilio=htmlentities($_POST['domicilio']); }else{ $domicilio=false; }
		if(isset($_POST['email'])){ $email=$_POST['email']; }else{ $email=false; }
		if(isset($_POST['tel1'])){ $tel1=$_POST['tel1']; }else{ $tel1=false; }
		if(isset($_POST['tel2'])){ $tel2=$_POST['tel2']; }else{ $tel2=false; }

		if ($fallo==0) {
			if(
				$actualizar = $CONEXION->query("UPDATE usuarios SET nombre = '$nombre' WHERE id = $id")
			and	$actualizar = $CONEXION->query("UPDATE usuarios SET empresa = '$empresa' WHERE id = $id")
			and	$actualizar = $CONEXION->query("UPDATE usuarios SET domicilio = '$domicilio' WHERE id = $id")
			and	$actualizar = $CONEXION->query("UPDATE usuarios SET email = '$email' WHERE id = $id")
			and	$actualizar = $CONEXION->query("UPDATE usuarios SET tel1 = '$tel1' WHERE id = $id")
			and	$actualizar = $CONEXION->query("UPDATE usuarios SET tel2 = '$tel2' WHERE id = $id")
				)
			{
				$exito=1;
				$legendSuccess.="<br>Cliente editado";
			}else{
				$fallo=1;  
				$legendFail.="<br>No se pudo modificar la base de datos";
			}
		}else{ 
			$codigo=false; 
			$legendFail.="<br> - Proporcione código"; 
		}
	}

// Clientes Borrar
	if(isset($_GET['clientes_borrar']))	{
		if(
			$actualizar = $CONEXION->query("DELETE FROM usuarios WHERE id = $id")
			)
		{
			$exito=1;
			$legendSuccess.="<br>Eliminar";
		}else{
			$fallo=1;  
			$legendFail.="<br>No se pudo eliminar";
		}
	} 

// Cotizacion Nuevo
	if(isset($_POST['nuevacotizacion']) AND isset($_SESSION['tablaBody'])){

		if(isset($_POST['importe'])){      $importe   = $_POST['importe'];        }else{  $importe   = false; }
		if(isset($_SESSION['clienteid'])){ $clienteid = ($_SESSION['clienteid']); }else{  $clienteid = false; }
		if(isset($_SESSION['tablaBody'])){ $tablabody = ($_SESSION['tablaBody']); }else{  $tablabody = false; }
		if(isset($_POST['formato'])){      $formato   = ($_POST['formato']);      }else{  $formato   = false; }
		if(isset($_POST['masiva'])){       $masiva    = ($_POST['masiva']);       }else{  $masiva    = false; }
		if(isset($_POST['moneda'])){       $moneda    = ($_POST['moneda']);       }else{  $moneda    = false; }
		if(isset($_POST['numprods'])){     $numprods  = ($_POST['numprods']);     }else{  $numprods  = false; }

		unset($_SESSION['tablaBody']);
		unset($_SESSION['clienteid']);

		$sql = "INSERT INTO cotizacion (fecha,tablabody,cantidad,importe,cliente,formato,moneda,masiva,ejecutivo)".
			"VALUES ('$fecha','$tablabody','$numprods','$importe','$clienteid','$formato','$moneda','$masiva','$uid')";
		if($insertar = $CONEXION->query($sql))
		{
			$id=$CONEXION->insert_id;

			foreach ($_POST as $key => $value) {
				$actualizar = $CONEXION->query("UPDATE cotizacion SET $key = '$value' WHERE id = $id");
				$exito=1;
			}

			$CONSULTA1 = $CONEXION -> query("SELECT * FROM usuarios WHERE id = '$clienteid'");
			$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
			foreach ($row_CONSULTA1 as $key => $value) {
				if ($key!='id') {
					$actualizar = $CONEXION->query("UPDATE cotizacion SET $key = '$value' WHERE id = $id");
				}
			}


		}else{
			$fallo=1;  
			$legendFail.="<br>No se pudo agregar a la base de datos :'( $sql";
		}
	}

// Cotizacion Borrar
	if(isset($_GET['cotizacion_borrar']))	{
		if($borrar = $CONEXION->query("DELETE FROM cotizacion WHERE id = $id")){
			$exito=1;
		}else{
			$fallo=1;  
			$legendFail.="<br>No se pudo eliminar";
		}
	} 

// Solicitud Borrar
	if(isset($_GET['borrarPedido']))	{
		if($borrar = $CONEXION->query("DELETE FROM pedidos WHERE id = $id")){
			$exito=1;
		}else{
			$fallo=1;  
			$legendFail.="<br>No se pudo eliminar";
		}
	} 

// Cambiar estatus
	if (isset($_POST['nivelestatus'])) {
		include '../../../includes/connection.php';
		$id = $_POST['id'];
		$nivelestatus = $_POST['nivelestatus']-1;
		if($actualizar = $CONEXION->query("UPDATE cotizacion SET estatus = $nivelestatus WHERE id = $id")){
			echo '<div class="uk-text-center bg-success color-white"><span uk-icon="icon:check;ratio:1.5;"></span> Guardado</div>';
		}else{
			echo '<div class="uk-text-center bg-danger color-white"><span uk-icon="icon:ban;ratio:1.5;"></span> Error<br>'.$id.'<br>'.$nivel.'</div>';
		}
	}

// Archivar
	if(isset($_POST['archivo'])){
		require_once('../../../includes/connection.php'); 

		$id=$_POST['id'];
		$archivo=$_POST['archivo'];

		if ($actualizar = $CONEXION->query("UPDATE cotizacion SET archivo = $archivo WHERE id = $id")) {
			$mensajeClase='success';
			$mensajeIcon='check';
			$mensaje='Guardado';
		}else{
			$mensajeClase='danger';
			$mensajeIcon='exclamation-triangle';
			$mensaje='No se pudo guardar';
		}
		echo '<div class="uk-text-center color-white bg-'.$mensajeClase.' padding-10 text-lg"><i class="fa fa-'.$mensajeIcon.'"></i> &nbsp; '.$mensaje.'</div>';		
	} 

// Archivar
	if(isset($_POST['archivosolicitud'])){
		require_once('../../../includes/connection.php'); 

		$id=$_POST['id'];
		$archivo=$_POST['archivosolicitud'];

		if ($actualizar = $CONEXION->query("UPDATE pedidos SET archivo = $archivo WHERE id = $id")) {
			$mensajeClase='success';
			$mensajeIcon='check';
			$mensaje='Guardado';
		}else{
			$mensajeClase='danger';
			$mensajeIcon='exclamation-triangle';
			$mensaje='No se pudo guardar';
		}
		echo '<div class="uk-text-center color-white bg-'.$mensajeClase.' padding-10 text-lg"><i class="fa fa-'.$mensajeIcon.'"></i> &nbsp; '.$mensaje.'</div>';		
	} 



// Quitar mensaje de error
	if(isset($fallo) AND $fallo==0){
		unset($fallo);
	}
