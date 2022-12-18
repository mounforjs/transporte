<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/pasajero.php';
require_once DB;
abrirConexion();

$r="";
extract($_POST);
$pasajero=new pasajero();
$list=$pasajero->getListCondicional("pasajeros_viajes",500,"viaje_id=".$viaje);
$pasajeros = array();

if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);
		$pasajeros[] = $row;
        
    }
}
cerrarConexion();


echo json_encode($pasajeros);
?>

