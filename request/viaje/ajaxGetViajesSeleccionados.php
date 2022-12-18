<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();

$r="";
$viaje=new Viaje();

switch ($_GET['seleccion']){
    case 'cs':
        $s=0;
        break;
    case 'ss':
        $s=1;
}

switch ($_GET['tipo']){
    case 1:
        $list=$viaje->getListCondicional("viajes",200,"viajes.lote_id=0 and viajes.estado=3 and encomienda=0 and empresa_id=".$_GET['empresa']." and viajes.solicitud_servicio=$s");
    break;
    case 2:
        $list=$viaje->getListCondicional("viajes",200,"viajes.lote_id=0 and viajes.estado=3 and encomienda=1  and empresa_id=".$_GET['empresa']." and viajes.solicitud_servicio=$s");
    break;
    case 3:
        $list=$viaje->getListCondicional("viajes",200,"viajes.lote_id=0 and viajes.estado=3 and empresa_id=".$_GET['empresa']." and viajes.solicitud_servicio=$s");
    break;
}

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

