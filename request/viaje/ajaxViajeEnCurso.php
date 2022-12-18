<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;

extract($_POST);
$viaje=new viaje();
abrirConexion();

$arr=array('estado'=>2);
if($viaje->update("viajes", "id", $arr,$id))
{
    echo "ok";
}else
{
    echo "false";
}

cerrarConexion();

?>
