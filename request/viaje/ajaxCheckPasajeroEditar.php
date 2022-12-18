<?php
    session_start();
    require_once '../../rutas.php';
    require_once DB;
    require_once CLASES.'/pasajero.php';

    $r="true";
    extract($_POST);

    if(isset ($_SESSION['pasajerosEdit'])){
        $i=0;
        while($i<count($_SESSION['pasajerosEdit'])){
            if($_SESSION['pasajerosEdit'][$i]['pasajero_id']==$selectPasajero){
                $r="false";
            }
            $i++;
        }
    }

    echo $r;
    
?>
