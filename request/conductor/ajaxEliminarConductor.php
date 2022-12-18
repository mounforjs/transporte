<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/conductor.php';
require_once DB;

extract($_POST);
$conductor=new Conductor();
abrirConexion();

if(!$conductor->existe("viajes", "conductor_id", $id)){
    if($conductor->delete("conductores", "id", $id))
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
