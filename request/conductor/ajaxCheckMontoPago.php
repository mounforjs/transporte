<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/conductor.php';
require_once DB;

extract($_GET);
$conductor=new Conductor();
abrirConexion();

$monto_total_deuda=$conductor->getDescripcionTable("deudas", $deuda_id, "monto");
$pagado=$conductor->getTotalCondicionado("pagos_deudas", "pago", "deuda_id=".$deuda_id);
$deuda_actual=$monto_total_deuda-$pagado;

if($txtMontoCancelar>$deuda_actual){
    echo "false";
}else{
    echo "true";
}

cerrarConexion();

?>
