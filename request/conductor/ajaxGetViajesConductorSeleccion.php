<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();

$r="";
$viaje=new Viaje();

extract($_GET);
$list=$viaje->getListCondicional("viajes",200,"conductor_id=".$selectConductor." and (estado=1 or estado=2)");

$viajes=array();
$i=0;

if($list!=false){
    while($row=pg_fetch_array($list))
    {
        $viajes[$i]['id']=$row['id'];
        $i++;
    }

    $json_viajes=json_encode($viajes);

    cerrarConexion();

    echo $json_viajes;

}else{
    echo "1"; //Sin resultados
}


?>

