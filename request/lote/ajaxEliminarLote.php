<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lote.php';
require_once DB;

extract($_POST);
$lote=new Lote();
abrirConexion();

if($lote->delete("lotes", "id", $id))
{
    echo "ok";
}else
{
    echo "false";
}

cerrarConexion();

?>
