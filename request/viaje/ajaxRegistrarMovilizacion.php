<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/user.php';
require_once CLASES.'/pasajero.php';
require DB;

extract($_POST);

if(isset ($_SESSION['nmovilizaciones'])){
    $nmovilizaciones=$_SESSION['nmovilizaciones'];
    $nmovilizaciones+=1;
}else{
    $nmovilizaciones=1; 
}

$arr=array('id'=>$nmovilizaciones,'descripcion'=>$txtDescripcion,
           'viaje_id'=>$_SESSION['viajeId'],'precio'=>$txtPrecio,'pago'=>$txtPago);
$_SESSION['movilizaciones'][]=$arr;

$_SESSION['nmovilizaciones']=$nmovilizaciones;

$r="<tr id=movilizacion".$nmovilizaciones.">
        <td>".$txtDescripcion."</td>
        <td><a name='eliminarMovilizacion' id=$nmovilizaciones>Eliminar</a></td>
      </tr>";

echo $r;

?>
