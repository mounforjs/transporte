<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/conductor.php';
require_once DB;
abrirConexion();

extract($_POST);
$r="";
$conductor=new Conductor();
$list=$conductor->getListCondicional("pagos_deudas",500,"deuda_id=$id");


if($list!=false){

    while($row=pg_fetch_array($list)){

        extract($row);

        $r.="<tr id=$id>
        <td><a id='$id'>$id</a></td>
        <td>".$pago."</td>
            <td>".$fecha."</td>
        </tr>";
    }
}else{
    $r="<tr><td colspan='2'>No existen abonos registradas para esta deuda aún.</td></tr>";
}
cerrarConexion();

echo $r;
?>


