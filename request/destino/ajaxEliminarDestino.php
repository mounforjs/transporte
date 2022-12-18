<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/destino.php';
require_once DB;

extract($_POST);
$destino=new Destino();
abrirConexion();

if($destino->delete("destinos", "id", $id))
{
    echo "ok";
}else
{
    echo "false";
}

cerrarConexion();

?>
