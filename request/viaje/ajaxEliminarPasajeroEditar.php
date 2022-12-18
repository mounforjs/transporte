<?php
session_start();

    $i=0;
    $narray=array();

    while($i<count($_SESSION['pasajerosEdit'])){
        if($_SESSION['pasajerosEdit'][$i]['pasajero_id']!=$_POST['id']){
            $narray[]=$_SESSION['pasajerosEdit'][$i];
        }
        $i++;
    }

    $_SESSION['pasajerosEdit']=$narray;
    echo "ok";
?>
