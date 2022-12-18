<?php
    session_start();
    require_once '../../rutas.php';
    require_once DB;
    require_once CLASES.'/model.php';

    $r="false";
    $model=new model();
    extract($_POST);
    abrirConexion();

    $lista=$model->getModel($id, "listas");
    switch ($lista['estado']){
        case 1:
            $estado=0;
            break;
        case 0:
            $estado=1;
            break;
    }

    $query="UPDATE listas SET estado=0";
    if(pg_query ($query)){
        $query2="UPDATE listas SET estado=$estado WHERE id=$id";
        if(pg_query ($query2)){
            $r="true";
        }
    }

    echo $r;
    
?>
