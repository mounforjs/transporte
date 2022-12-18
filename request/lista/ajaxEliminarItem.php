<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lista.php';
require_once DB;

extract($_POST);
$lista=new Lista();
abrirConexion();

if($lista->delete("listas_rutas", "id", $id))
{
    echo "ok";
}else
{
    echo "false";
}

cerrarConexion();

?>
