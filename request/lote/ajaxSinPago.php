<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/user.php';
require_once CLASES.'/lote.php';
require_once DB;

extract($_POST);

abrirConexion();
$lote=new Lote();

$arr=array('estado'=>1);
$lote->update("lotes", "id", $arr, $id);


cerrarConexion();
?>
