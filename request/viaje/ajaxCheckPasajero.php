<?php
    session_start();
    require_once '../../rutas.php';
    require_once DB;
    require_once CLASES.'/pasajero.php';

    $r="true";
    extract($_POST);

    if(isset ($_SESSION['pasajeros'])){
        $i=0;
        while($i<count($_SESSION['pasajeros'])){
            if($_SESSION['pasajeros'][$i]['pasajero_id']==$selectPasajero){
                $r="false";
            }
            $i++;
        }
    }

    echo $r;
    
?>
