<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();

$r="";
$viaje=new Viaje();
$conductores=$viaje->getList("conductores", 1000);
$idViaje=$_POST['viaje'];
$horario_id=$viaje->getDescripcionTable("viajes", $idViaje, "horario");

$horarios=array(0=>'Horario Regular',1=>'Solo ida',2=>'Solo vuelta',3=>'Ida y vuelta');
foreach($horarios as $indice=>$horario){

    if($horario_id==$indice){
        $r.="<option value=\"$indice\" selected>$horario</option>";
    }else{
        $r.="<option value=\"$indice\">$horario</option>";
    }

}

cerrarConexion();

echo $r;
?>

