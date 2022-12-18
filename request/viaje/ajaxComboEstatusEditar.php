<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();

$r="";
$viaje=new Viaje();
$empresas=$viaje->getList("empresas", 1000);
$idViaje=$_POST['viaje'];
$estatus_viaje_id=$viaje->getDescripcionTable("viajes", $idViaje, "estado");


$estatus=array(1=>'Planificado',2=>'En Curso');
foreach($estatus as $indice=>$estatu){

    if($estatus_viaje_id==$indice){
        $r.="<option value=\"$indice\" selected>$estatu</option>";
    }else{
        $r.="<option value=\"$indice\">$estatu</option>";
    }

}


echo $r;
?>

