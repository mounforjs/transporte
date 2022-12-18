<?php
session_start();
require_once '../../rutas.php';
require_once CLASES . '/viaje.php';
require_once DB;
abrirConexion();

$r = "";
$viaje = new Viaje();
$idViaje = $_POST['viaje'];
$fecha = $viaje->getDescripcionTable("viajes", $idViaje, "fecha");

$fechaArr = explode('-', $fecha);
list($año, $mes, $dia) = $fechaArr;
$r = $dia . "-" . $mes . "-" . $año;
echo $r;
?>

