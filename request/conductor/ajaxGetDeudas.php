<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/conductor.php';
require_once DB;
abrirConexion();

extract($_POST);
$r="";
$conductor=new Conductor();
$list=$conductor->getListCondicional("deudas",500,"conductor_id=$id");


if($list!=false){

    while($row=pg_fetch_array($list)){

        extract($row);

        //TOTAL PAGOS REALIZADOS DE LA DEUDA ACTUAL

        $query="SELECT SUM(pagos_deudas.pago) as total
                FROM pagos_deudas INNER JOIN deudas
                    ON deudas.id=pagos_deudas.deuda_id WHERE deudas.id=$id";


        $result=pg_query($query);
        $total=pg_fetch_array($result);
        $totalPagado=$total['total'];
        if($totalPagado==""){
            $totalPagado=0;
        }

        //////////////////////////////////////////////

        if($estado==0){
            $trPagar="<td>Pagada</td>";
        }else{
            $trPagar="<td><a id='".$id."' name='pagarDeuda'>Pagar</a></td>";
        }

        $porPagar=$monto-$totalPagado;

        $r.="<tr id=$id>
        <td><a id='$id' name='verAbonos'>$id</a></td>
        <td>".$conductor->fechaVE($fecha)."</td>
        <td>$observaciones</td>".
        "<td>".number_format($monto,2,",",".")." Bs.</td>
        <td>".number_format($totalPagado,2,",",".")." Bs.</td>
        <td>".number_format($porPagar,2,",",".")." Bs.</td>".
        $trPagar.
      "</tr>";
    }
}else{
    $r="<tr><td colspan='7'>No existen deudas registradas para este conductor aún.</td></tr>";
}
cerrarConexion();

echo $r;
?>


