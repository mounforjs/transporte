<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();

$r="";
$viaje=new Viaje();
$model_viaje=$viaje->getModelCondicionado("viajes","id=".$_POST['viaje']);
//print_r($model_viaje);
$rutas=$viaje->getListCondicional("listas_rutas", 1000, "lista_id=".$model_viaje['lista_id']." ORDER BY ruta ASC");
$idViaje=$_POST['viaje'];
$ruta_viaje_id=$model_viaje['ruta_id'];

//print_r($ruta_viaje_id)

if($rutas!=false){

    while($row=pg_fetch_array($rutas)){
        extract($row);
        $ruta=$viaje->getDescripcionTable("rutas", $ruta_id, "descripcion");
        if($ruta_id!=$ruta_viaje_id){
            $r.="<option value='$ruta_id'>$ruta</option>";
        }else{
            $r.="<option value='$ruta_id' selected>$ruta</option>";
        }
        
    }

}else{
    $r="<option>Sin rutas</option>";
}

cerrarConexion();


echo $r;
?>
