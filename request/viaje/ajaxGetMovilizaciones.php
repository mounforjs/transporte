<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();

unset($_SESSION['movilizacionesEdit']);
$r="";

$viaje=new Viaje();

$idViaje=$_POST['viaje'];
$movilizaciones=$viaje->getListCondicional('movilizaciones', 1000, 'viaje_id='.$idViaje);


if($movilizaciones!=false){
    $i=1;
    while($row=pg_fetch_array($movilizaciones)){
        extract($row);
        $movilizacion_descripcion=$viaje->getDescripcionTable('movilizaciones', $id, 'descripcion');
        

        $arr=array('id'=>$i,'descripcion'=>$movilizacion_descripcion,
           'viaje_id'=>$_POST['viaje'],'precio'=>$precio,'pago'=>$pago);


        $_SESSION['movilizacionesEdit'][]=$arr;

        if(isset ($_SESSION['nmovilizacionesEdit'])){
            $nmovilizaciones=$_SESSION['nmovilizacionesEdit'];
            $nmovilizaciones+=1;
        }else{
            $nmovilizaciones=1;
        }

        $_SESSION['nmovilizacionesEdit']=$nmovilizaciones;

        $r.="<tr id=movilizacion$i>
        <td>$movilizacion_descripcion</td>
        <td><a name='eliminarMovilizacion' id=$i>Eliminar</a></td>
        </tr>";

        $i++;
    }

}

cerrarConexion();


echo $r;
?>

