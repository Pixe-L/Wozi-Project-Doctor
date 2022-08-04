<?php
$fallo=0;
$error='';
$raw_post_data = file_get_contents('php://input');


// Verificar el correo del vendedor
if($_POST['receiver_email']==$payPalCliente){ 
	$receiver_email = $_POST['receiver_email'];
}else{
	$fallo=1;
	$error.='-ER:receiver_email '.$_POST['receiver_email'];
}


// Obtener el ID de transación
if(isset($_POST['txn_id'])){ 
	$txn_id = $_POST['txn_id'];
}else{
	$fallo=1;
	$error.='-ER:txn_id';
}

// Verificar el que se haya completado el pago
if($_POST['payment_status']!='Completed'){ 
	$fallo=1;
	$error.='-ER:estatus '.$_POST['payment_status'];
}

// Obtenemos los datos del pedido
$pedidos = $CONEXION -> query("SELECT * FROM pedidos WHERE idmd5 = '$idmd5'");
$numeroFilas = $pedidos ->num_rows;
if($numeroFilas==1){
	$row_pedidos = $pedidos -> fetch_assoc();
	$pedido=$row_pedidos['id'];
}else{
	$fallo=1;
	$error.='-ER:pedido no encontrado';
}

$payer_email=$_POST['payer_email'];

if ($fallo==0) {
	$sql = "INSERT INTO ipn (email,txn_id,pedido,ipn) VALUES ('$payer_email','$txn_id','$pedido','$raw_post_data')";
	if($insertar = $CONEXION->query($sql)){
		$ipnID = $CONEXION->insert_id;
		$actualizar = $CONEXION->query("UPDATE pedidos SET 
			estatus = 1,
			ipn = $ipnID
			WHERE id = '$pedido'");
	}else{
		$sql = "INSERT INTO ipn (ipn) VALUES ('ERROR -> No pudo guardar')";
		$insertar = $CONEXION->query($sql);
	}
}else{
	$sql = "INSERT INTO ipn (ipn,pedido) VALUES ('$error',$pedido)";
	$insertar = $CONEXION->query($sql);
}




