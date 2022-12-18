<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;

abrirConexion();

$r="";
$viaje=new Viaje();

$viajes=$viaje->getListCondicional('viajes', 15, "estado BETWEEN 1 and 3  ORDER BY fecha DESC,estado ASC");

if($viajes!=false){

    while($row=pg_fetch_array($viajes)){
        extract($row);
        $conductor=$viaje->getDescripcionTable('conductores', $conductor_id, 'nombre');

        switch($estado){
            case 1:$estado="Planificado";
            break;
            case 2:$estado="En Curso";
            break;
            case 3:$estado="Terminado";
            break;
        }
        
        $r.="<tr id=$id class='trclass'>
        <td>$id</td>
         <td>".$viaje->fechaVE($fecha)."</td>
        <td>$ruta</td>
        <td>$estado</td>
        <td>$conductor</td>
         </tr>";
        
    }

}else{
    $r="false";
}

cerrarConexion();

echo $r;

?>

