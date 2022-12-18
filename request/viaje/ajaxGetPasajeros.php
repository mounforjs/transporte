<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();

unset($_SESSION['pasajerosEdit']);
$r="";

$viaje=new Viaje();

$idViaje=$_POST['viaje'];
$pasajeros=$viaje->getListCondicional('pasajeros_viajes', 1000, 'viaje_id='.$idViaje);

if($pasajeros!=false){

    while($row=pg_fetch_array($pasajeros)){
        extract($row);
        $pasajero_nombre=$viaje->getDescripcionTable('pasajeros', $pasajero_id, 'nombre');
        $pasajero_telefono=$viaje->getDescripcionTable('pasajeros', $pasajero_id, 'telefono');

        $arr=array('pasajero_id'=>$pasajero_id,
           'viaje_id'=>$_POST['viaje']);

        

        $_SESSION['pasajerosEdit'][]=$arr;

        $r.="<tr id=pasajero$pasajero_id>
        <td>$pasajero_nombre</td>
        <td>$pasajero_telefono</td>
        <td><a name='eliminarPasajero' id=$pasajero_id>Eliminar</a></td>
      </tr>";
        
    }

}

cerrarConexion();


echo $r;
?>

