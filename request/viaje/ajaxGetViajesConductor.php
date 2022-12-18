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
$list=$viaje->getListCondicional("viajes",700,"estado=3 and conductor_id=$selectConductor and fecha BETWEEN $desde and $hasta ORDER BY fecha ASC");

if($list!=false) {
    $r.="<tr class='tableTitle'>
            <td>ID</td>
            <td>Fecha</td>
            <td>Conductor</td>
            <td>Ruta</td>
            <td>Pagado</td>
            <td>Pago</td>
            <td>Acciones</td>
          </tr><td colspan='5'></td>";

    while($row=pg_fetch_array($list)) {

        extract($row);
        $conductor=$viaje->getDescripcionTable("conductores", $conductor_id, "nombre");


        if($pago_conductor==0) {
            $trPago_conductor="<td>Pagado&nbsp;&nbsp;<a id=$id name='deshacerPago'>Deshacer Pago</a></td>";
        }else {
            $trPago_conductor="<td><input type='checkbox' id='chkPagado' name='chkPagar[]' value='$id'></td>";
        }


        $r.="<tr id=$id>
        <td><a id='$id' name='viewviaje'>$id</a></td>
        <td>".$viaje->fechaVE($fecha)."</td>
        <td>$conductor</td>
        <td>$ruta</td>
                $trPago_conductor
        <td>".number_format($monto_pago,2,",",".")." Bs</td>
        <td><a href='../../pagina/viaje/editarViaje.php?id=$id' target='_blank'>Editar</a></td>
      </tr>";

    }

    $r.="<br><br>";

}else {
    $r="<tr><td colspan=5><td></tr><tr><td colspan=5>No existen viajes de este conductor en este periodo de tiempo.<td></tr>";
}

cerrarConexion();


echo $r;
?>

