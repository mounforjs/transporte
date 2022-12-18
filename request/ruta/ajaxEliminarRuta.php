<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/ruta.php';
require_once DB;

extract($_POST);
$ruta=new Ruta();
abrirConexion();

if(!$ruta->existe("listas_rutas", "ruta_id", $id)){
    if($ruta->delete("rutas", "id", $id))
    {
        echo "ok";
    }else
    {
        echo "false";
    }
}else{
    echo "referencia";
}

cerrarConexion();

?>
