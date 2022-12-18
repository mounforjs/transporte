<?php
session_start();

    $i=0;
    $narray=array();

    while($i<count($_SESSION['movilizaciones'])){
        if($_SESSION['movilizaciones'][$i]['id']!=$_POST['id']){
            $narray[]=$_SESSION['movilizaciones'][$i];
        }
        $i++;
    }

    $_SESSION['movilizaciones']=$narray;
    echo "ok";
?>
