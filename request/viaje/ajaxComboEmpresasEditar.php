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
$empresa_viaje_id=$viaje->getDescripcionTable("viajes", $idViaje, "empresa_id");

if($empresas!=false){

    while($row=pg_fetch_array($empresas)){
        extract($row);
        $empresa=$viaje->getDescripcionTable("empresas", $id, "nombre");
        if($id!=$empresa_viaje_id){
            $r.="<option value='$id'>$empresa</option>";
        }else{
            $r.="<option value='$id' selected>$empresa</option>";
        }
        
    }

}else{
    $r="<option>Sin empresas</option>";
}

cerrarConexion();


echo $r;
?>

