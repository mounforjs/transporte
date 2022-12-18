<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();
extract($_POST);

$viaje=new Viaje();
$desde=$viaje->convertFechaSQLPostgres($desde);
$hasta=$viaje->convertFechaSQLPostgres($hasta);
$query="SELECT SUM(monto_viaje) as monto from viajes
        INNER JOIN pasajeros_viajes ON (viajes.id=pasajeros_viajes.viaje_id)
        WHERE pasajero_id=$selectPasajero AND fecha BETWEEN $desde and $hasta";

$result=pg_query($query);
$arr=pg_fetch_array($result);
$monto=$arr['monto'];

//$total=$viaje->getTotalCondicionado("viajes", "monto_pago", "pago_conductor=1 and conductor_id=$selectConductor and estado=3 and fecha BETWEEN $desde and $hasta");
if($monto==""){
    $monto=0;
}
echo "<span class='titulo'><strong>TOTAL: </strong>".number_format($monto,2,",",".")." Bs</span>";
?>

