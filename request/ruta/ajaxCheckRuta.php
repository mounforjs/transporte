<?php
    session_start();
    require_once '../../rutas.php';
    require_once DB;
    require_once CLASES.'/model.php';

    $r="false";
    $model=new model();
    extract($_POST);
    abrirConexion();


    if($model->existe("rutas","descripcion","'".$txtRuta."'"))
    {
        $r="false";
    }else
    {
        $r="true";
    }
    echo $r;
    
    cerrarConexion();
?>
