<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/conductor.php';
require_once DB;
abrirConexion();

extract($_POST);
$r="<fieldset>";
$conductor=new Conductor();
$nombreconductor=$conductor->getDescripcionTable("conductores", $id, "nombre");
$totalAdeudado=$conductor->getTotalCondicionado("deudas", "monto", "conductor_id=".$id." and estado=1");

//TOTAL PAGOS REALIZADOS DE LAS DEUDAS ACTIVAS

$query="SELECT SUM(pagos_deudas.pago) as total
        FROM pagos_deudas INNER JOIN deudas
            ON deudas.id=pagos_deudas.deuda_id WHERE deudas.estado=1 and deudas.conductor_id=$id";


$result=pg_query($query);
$total=pg_fetch_array($result);
$totalPagado=$total['total'];
if($totalPagado==""){
    $total=0;
}

//////////////////////////////////////////////

$diferencia=$totalAdeudado-$totalPagado;

$r.="<span class='titulo'>$nombreconductor</span><br><br>";
$r.="<strong>Total Deudas: </strong> ".number_format($totalAdeudado,2,",",".")." Bs<br>";
$r.="<strong>Total Pagado : </strong> ".number_format($totalPagado,2,",",".")." Bs<br>";
$r.="<strong>Actualmente Adeudado : </strong> ".number_format($diferencia,2,",",".")." Bs";
$r.="</fieldset>";

cerrarConexion();
echo $r;
?>
