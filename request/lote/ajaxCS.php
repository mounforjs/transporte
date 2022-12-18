<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lote.php';
require_once DB;

extract($_POST);

abrirConexion();
$lote=new Lote();

foreach ($chkviajes as $viaje) {
    $arr = array('solicitud_servicio' => 0);
    $lote->update("viajes", "id", $arr, $viaje);
}

echo "ok";    

cerrarConexion();

?>
