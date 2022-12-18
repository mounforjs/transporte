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
$conductor_viaje_id=$viaje->getDescripcionTable("viajes", $idViaje, "conductor_id");

if($conductores!=false){

    while($row=pg_fetch_array($conductores)){
        extract($row);
        $conductor=$viaje->getDescripcionTable("conductores", $id, "nombre");
        if($id!=$conductor_viaje_id){
            $r.="<option value='$id'>$conductor</option>";
        }else{
            $r.="<option value='$id' selected>$conductor</option>";
        }
        
    }

}else{
    $r="<option>Sin Conductores</option>";
}

cerrarConexion();


echo $r;
?>

