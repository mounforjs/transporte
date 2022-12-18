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
$total=$viaje->getTotalCondicionado("viajes", "monto_pago", "pago_conductor=1 and conductor_id=$selectConductor and estado=3 and fecha BETWEEN $desde and $hasta");
if($total==""){
    $total=0;
}
echo "<span class='titulo'><strong>TOTAL A PAGAR: </strong>".number_format($total,2,",",".")." Bs</span>";
?>

