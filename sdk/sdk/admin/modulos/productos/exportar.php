<?php
header('Content-Type: text/csv; charset=utf-8');
require_once('../../../includes/connection.php'); 

$caracteres_no_validos  = array('|','"','®','¿','á','Á','é','É','í','Í','ó','Ó','ú','Ú','ñ','Ñ');
$caracteres_si_validos  = array('',  '', '', '', 'a','A','e','E','i','I','o','O','u','U','n','N');

$conSalto  = array("\r", "\n", ",");
$sinSalto  = array("",   "",   "#");

$sql="SELECT * FROM productos";
$CONSULTA = $CONEXION -> query($sql);
$rowCONSULTA = $CONSULTA -> fetch_assoc();
foreach ($rowCONSULTA as $key => $value) {
	$csv .= '"'.str_replace($conSalto,$sinSalto,$key).'", ';
}
$csv  = substr($csv, 0, -1);
$csv .= '
';


$CONSULTA = $CONEXION -> query($sql);
while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
	foreach ($rowCONSULTA as $key => $value) {
		$csv .= '"'.str_replace($conSalto,$sinSalto,$value).'",';
	}
	$csv  = substr($csv, 0, -1);
	$csv .= '
';
}
echo str_replace($caracteres_no_validos,$caracteres_si_validos,$csv);