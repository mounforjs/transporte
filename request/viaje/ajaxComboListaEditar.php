<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();

$r="";
$viaje=new Viaje();
$listas=$viaje->getList("listas", 1000);
$viajeModel=$viaje->getModel($_POST['viaje'], "viajes");
$idLista=$viajeModel['lista_id'];

if($listas!=false){

    while($row=pg_fetch_array($listas)){
        extract($row);
        if($id!=$idLista){
            $r.="<option value='$id'>$descripcion</option>";
        }else{
            $r.="<option value='$id' selected>$descripcion</option>";
        } 
    }

}else{
    $r="<option>Sin listas</option>";
}

cerrarConexion();


echo $r;
?>

