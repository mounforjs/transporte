<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();

$r="";
$viaje=new Viaje();
$departamentos=$viaje->getList("departamentos", 1000);
$idViaje=$_POST['viaje'];
$departamento_viaje_id=$viaje->getDescripcionTable("viajes", $idViaje, "departamento_id");
$r.="<option value=''>N/A</option>";
if($departamentos!=false){

    while($row=pg_fetch_array($departamentos)){
        extract($row);
        $departamento=$viaje->getDescripcionTable("departamentos", $id, "nombre");
        if($id!=$departamento_viaje_id){
            $r.="<option value='$id'>$nombre - $codigo</option>";
        }else{
            $r.="<option value='$id' selected>$nombre - $codigo</option>";
        }
        
    }

}else{
    $r="<option>Sin departamentos</option>";
}

cerrarConexion();


echo $r;
?>

