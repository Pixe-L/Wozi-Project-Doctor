<?php 
	$rutaFinal="../img/contenido/profile/";
// %%%%%%%%%	Funcion Borrar Imágenes  %%%%%%%%%%%%%%
	function borrarImagen($picName){
		$rutaFinal="../img/contenido/profile/";
		if (strlen($picName)>0){
			if(file_exists($rutaFinal.$picName)) { unlink($rutaFinal.$picName); $exito=1; }
			if(file_exists($rutaFinal.'sq/'.$picName)) { unlink($rutaFinal.'sq/'.$picName); $exito=1; }
			if(file_exists($rutaFinal.'nat/'.$picName)) { unlink($rutaFinal.'nat/'.$picName); $exito=1; }
			if(file_exists($rutaFinal.'otra/'.$picName)) { unlink($rutaFinal.'otra/'.$picName); $exito=1; }
		}
		if (isset($exito)) {
			return true;
		}else{
			return false;
		}
	}

// %%%%%%%%%	Eliminar Usuario %%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['borrarUser'])){
		if($borrar = $CONEXION->query("DELETE FROM usuarios WHERE id = $id")){
			$CONSULTA1 = $CONEXION -> query("SELECT * FROM pedidos WHERE uid = $id");
			while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){
				$pedidoId=$row_CONSULTA1['id'];
				$borrar = $CONEXION->query("DELETE FROM pedidos WHERE id = $pedidoId");
				$borrar = $CONEXION->query("DELETE FROM pedidosdetalle WHERE pedido = $pedidoId");
			}

			$exito='success';
			$legendSuccess.="<br>Usuario eliminado";
			$archivo='inicio';
		}else{
			$fallo='danger';  
			$legendFail.="<br>No se pudo eliminar el Usuario";
		}
	}

// %%%%%%%%%	Eliminar Usuario %%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['picdelete'])){
		include '../../../includes/connection.php';
		$id=$_POST['id'];
		$foto=$_POST['foto'];
		if($actualizar = $CONEXION->query("UPDATE usuarios SET imagen = NULL WHERE id = $id")){
			unlink('../../../img/contenido/profile/'.$foto.'.jpg');
			$mensajeClase='success';
			$mensajeIcon='check';
			$mensaje='Borrado';
		}else{
			$mensajeClase='danger';
			$mensajeIcon='ban';
			$mensaje='No se pudo guardar';
		}
		echo '<div class="uk-text-center color-white bg-'.$mensajeClase.' padding-10 text-lg"><i class="fa fa-'.$mensajeIcon.'"></i> &nbsp; '.$mensaje.'</div>';		
	}






