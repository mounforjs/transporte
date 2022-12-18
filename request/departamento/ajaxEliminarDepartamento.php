<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/pasajero.php';
require_once DB;

extract($_POST);
$pasajero=new Pasajero();
abrirConexion();

if(!$pasajero->existe("viajes", "departamento_id", $id)){
    if($pasajero->delete("departamentos", "id", $id))
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
