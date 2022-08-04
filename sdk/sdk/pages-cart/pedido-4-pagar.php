<?php
  $idmd5=$_GET['idmd5'];
  $CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE idmd5 = '$idmd5'");
  $row_CONSULTA = $CONSULTA -> fetch_assoc();

  $pedido  = $row_CONSULTA['id'];
  $importe = $row_CONSULTA['importe'];

  // Build the query string
  $queryString  = "?cmd=_cart";
  $queryString .= "&upload=1";
  $queryString .= "&trackingId=".$pedido;
  $queryString .= "&noshipping=1";
  $queryString .= "&charset=utf-8";
  $queryString .= "&currency_code=MXN";
  $queryString .= "&business=".urlencode($payPalCliente);
  $queryString .= "&return=".urlencode($ruta.'success');
  $queryString .= "&notify_url=".urlencode($ruta.$idmd5.'_IPN');
  $queryString .= "&cancel_return=".urlencode($ruta.'mi-cuenta');
  
  $queryString .= '&item_number_1='.$pedido;
  $queryString .= '&item_name_1='.urlencode('Orden: '.$pedido);
  $queryString .= '&amount_1='.urlencode($importe);
  $queryString .= '&quantity_1=1';


  //echo ('Location: https://www.'.$sandbox.'paypal.com/cgi-bin/webscr' .$queryString);
  
  header('Location: https://www.'.$sandbox.'paypal.com/cgi-bin/webscr' .$queryString);




