<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();
extract($_POST);
$r="";
$viaje=new Viaje();
$desde=$viaje->convertFechaSQLPostgres($desde);
$hasta=$viaje->convertFechaSQLPostgres($hasta);
$list=$viaje->getListCondicional("viajes",30,"estado=3 and fecha BETWEEN $desde and $hasta ORDER BY fecha ASC");

if($list!=false){
    $r.="<tr class='tableTitle'>
            <td>ID</td>
            <td>Fecha</td>
            <td>Conductor</td>
            <td>Ruta</td>
            <td>Pago</td>
          </tr><td colspan='5'></td>";

    while($row=pg_fetch_array($list)){
        
        extract($row);
        $conductor=$viaje->getDescripcionTable("conductores", $conductor_id, "nombre");

        $r.="<tr id=$id>
        <td><a href='visualizarViaje.php?id=$id' target='_blank'>$id</a></td>
        <td>".$viaje->fechaVE($fecha)."</td>
        <td>$conductor</td>
        <td>$ruta</td>
        <td>".number_format($monto_pago,2,",",".")." Bs</td>
      </tr>";
        
    }

    

}else{
    $r="<tr><td colspan=5><td></tr><tr><td colspan=5>No existen viajes en este periodo de tiempo.<td></tr>";
}

cerrarConexion();


echo $r;
?>

