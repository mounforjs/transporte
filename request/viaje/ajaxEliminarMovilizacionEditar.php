<?php
session_start();

    $i=0;
    $narray=array();

    while($i<count($_SESSION['movilizacionesEdit'])){
        if($_SESSION['movilizacionesEdit'][$i]['id']!=$_POST['id']){
            $narray[]=$_SESSION['movilizacionesEdit'][$i];
        }
        $i++;
    }

    $_SESSION['movilizacionesEdit']=$narray;
    echo "ok";
?>
