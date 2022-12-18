<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lote.php';
require_once DB;

extract($_POST);
$lote=new Lote();
abrirConexion();

$arr=array('lote_id'=>0,'estado'=>3);
if($lote->update("viajes", "id", $arr, $id))
{
    echo "ok";
}else
{
    echo "false";
}

cerrarConexion();

?>
