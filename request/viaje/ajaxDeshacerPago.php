<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/user.php';
require_once CLASES.'/viaje.php';
require_once DB;

extract($_POST);

abrirConexion();
$viaje=new Viaje();

$arr=array('pago_conductor'=>1);
$viaje->update("viajes", "id", $arr, $id);


cerrarConexion();
?>
