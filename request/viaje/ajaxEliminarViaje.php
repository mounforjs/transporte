<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;

extract($_POST);
$viaje=new viaje();
abrirConexion();

if($viaje->delete("viajes", "id", $id))
{
    echo "ok";
}else
{
    echo "false";
}

cerrarConexion();

?>
