<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();

$r="";
$viaje=new Viaje();
$lista_id=$viaje->getId("listas", "estado", 1);
$rutas=$viaje->getListCondicional("listas_rutas", 1000, "lista_id=$lista_id ORDER BY ruta ASC");

if($rutas!=false){

    while($row=pg_fetch_array($rutas)){
        extract($row);
        $ruta=$viaje->getDescripcionTable("rutas", $ruta_id, "descripcion");
        $r.="<option value='$ruta_id'>$ruta</option>";
    }

}else{
    $r="<option>Sin rutas</option>";
}

cerrarConexion();


echo $r;
?>

