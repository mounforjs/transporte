<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/conductor.php';
require_once DB;

extract($_POST);

abrirConexion();
$conductor=new Conductor();
$conductorID=$conductor->getDescripcionTable("deudas", $id, "conductor_id");
$totalDeuda=$conductor->getTotalCondicionado("deudas", "monto", "id=$id");
$arr=array('pago'=>"'".$txtMontoCancelar."'",'deuda_id'=>"'".$id."'",'fecha'=>"current_date",'conductor_id'=>$conductorID);

if($conductor->save("pagos_deudas",$arr))
{
   echo "ok";
}else{
   echo "false";
}

//TOTAL PAGOS REALIZADOS DE LA DEUDA ACTUAL

$query="SELECT SUM(pagos_deudas.pago) as total
        FROM pagos_deudas INNER JOIN deudas
            ON deudas.id=pagos_deudas.deuda_id WHERE deudas.id=$id and deudas.estado=1";


$result=pg_query($query);
$total=pg_fetch_array($result);
$totalPagado=$total['total'];
if($totalPagado==""){
    $totalPagado=0;
}

//////////////////////////////////////////////

if($totalDeuda==$totalPagado){
    $arr=array('estado'=>0);
    $conductor->update("deudas", "id", $arr, $id);
}


cerrarConexion();

?>
