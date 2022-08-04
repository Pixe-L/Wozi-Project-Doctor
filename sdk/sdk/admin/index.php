<?php
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//							SOFTWARE DESARROLLADO POR 
//							 EFRAÍN GONZALEZ MACÍAS
//							  ing_efrain@yahoo.com
//
//					LICENCIA PARA USO SOLO EN ESTE SITIO WEB
//				 QUEDA PROHIBIDA SU DISTRIBUCIÓN O MOFICIFACIÓN
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

// CONECTANDO CON LA BASE DE DATOS
	require_once('../includes/connection.php');
	require_once('../includes/widgets.php');

// OBTENIENDO VARIABLES
	$id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : $id=false;
	$modulo = (isset($_REQUEST['modulo'])) ? $_REQUEST['modulo'] : $modulo='blank';
	$archivo = (isset($_REQUEST['archivo'])) ? $_REQUEST['archivo'] : $archivo='inicio';
	$cat = (isset($_REQUEST['cat'])) ? $_REQUEST['cat'] : $cat=false;
	if(isset($_GET['showsuccess'])){ $exito=1; }

// LOGIN 
	require_once("modulos/varios/login_proceso.php");
	require_once('modulos/varios/includes.php');
	if(!isset($acceso) or $acceso==false){ 
		require_once("modulos/varios/login.php");
	} 

// MOSTRANDO EL DISEÑO INTERIOR
	if(isset($acceso) and $acceso==1){ 
		require_once('modulos/'.$modulo.'/acciones.php');

		echo $head;
		echo $header;

		require_once('modulos/varios/mensajes.php');
		require_once('modulos/'.$modulo.'/'.$archivo.'.php'); 

		echo $jquery;
		echo $scripts;
		echo $footer;

	} 

// CERRAR CONEXIÓN Y BORRAR ERROR_LOG SI EXISTE
	mysqli_close($CONEXION);
	flush();
	if (file_exists('error_log')) {
		unlink('error_log');
	}
