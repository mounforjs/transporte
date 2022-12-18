<?php
session_start();

    $i=0;
    $narray=array();

    while($i<count($_SESSION['pasajeros'])){
        if($_SESSION['pasajeros'][$i]['pasajero_id']!=$_POST['id']){
            $narray[]=$_SESSION['pasajeros'][$i];
        }
        $i++;
    }

    $_SESSION['pasajeros']=$narray;
    echo "ok";
?>
