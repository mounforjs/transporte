<?php
    session_start();
    require_once '../../rutas.php';
    require_once DB;
    require_once CLASES.'/model.php';

    $r="false";
    $model=new model();
    extract($_GET);
    abrirConexion();

    if($preruta!=$postruta){
        if($model->existeCondiciones("listas_rutas","ruta_id",$selectRuta,"lista_id=".$_SESSION['idLista']))
        {
            $r="false";
        }else
        {
            $r="true";
        }
    }else{
        $r="true";
    }
    echo $r;
    
?>
