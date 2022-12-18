<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();
extract($_POST);
$r="";
$viaje=new Viaje();
$ndesde=$desde;
$nhasta=$hasta;
$desde=$viaje->convertFechaSQLPostgres($desde);
$hasta=$viaje->convertFechaSQLPostgres($hasta);
$query="SELECT viajes.id as id,viajes.monto_viaje,viajes.fecha as fecha, viajes.ruta as ruta,viajes.retorno as retorno,viajes.conductor_id as conductor_id from viajes
        INNER JOIN pasajeros_viajes ON (viajes.id=pasajeros_viajes.viaje_id)
        WHERE pasajero_id=$selectPasajero AND fecha BETWEEN $desde and $hasta ORDER BY fecha ASC";

$list=pg_query($query);

//$list=$viaje->getListCondicional("pasajeros_viajes",100,"estado=3 and pasajero_id=$selectPasajero and fecha BETWEEN $desde and $hasta ORDER BY fecha ASC");

if($list!=false) {

    $r.="<tr class='tableTitle'>
            <td>ID</td>
            <td>Fecha</td>
            <td>Ruta</td>
            <td>Conductor</td>
            <td>Retorno</td>
            <td>Monto</td>
            <td>Acciones</td>
          </tr><td colspan='4'></td>";

    while($row=pg_fetch_array($list)) {

        extract($row);

        $conductor=$viaje->getDescripcionTable("conductores", $conductor_id, "nombre");
        switch ($retorno){
            case 0:
                $retorno="No";
                break;
            case 1:
                $retorno="Si";
                break;
        }
        $r.="<tr id=$id>
        <td><a id='$id' name='viewviaje' >$id</a></td>
        <td>".$viaje->fechaVE($fecha)."</td>
        <td>$ruta</td>
        <td>$conductor</td>
        <td>$retorno</td>
        <td>".number_format($monto_viaje,2,",",".")." Bs </td>
            <td><a href='../../pagina/viaje/editarViaje.php?id=$id' target='_blank'>Editar</a></td>
      </tr>";

    }

    $r.="<tr><td colspan='4'><br><br><a href=\"../../pagina/pasajero/reportePasajero.php?pasajero=$selectPasajero&desde=$ndesde&hasta=$nhasta\">Reporte</a></td></tr>";

}else {
    $r="<tr><td colspan=4><td></tr><tr><td colspan=4>No existen viajes de este conductor en este periodo de tiempo.<td></tr>";
}

cerrarConexion();


echo $r;
?>

