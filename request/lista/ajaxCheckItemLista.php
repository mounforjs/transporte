<?php
    session_start();
    require_once '../../rutas.php';
    require_once DB;
    require_once CLASES.'/model.php';

    $r = "false";
    $model = new model();
    extract($_GET);
    abrirConexion();

    if(!isset($_SESSION['idLista'])){
        $listActiva = $model->getModelCondicionado("listas", "estado=1");
        $lista_id = $listActiva['id'];
    }else{
        $lista_id = $_SESSION['idLista'];
    }


    if($model->existeCondiciones("listas_rutas","ruta_id", $inputRuta,"lista_id=".$lista_id))
    {
        $r="false";
    }else
    {
        $r="true";
    }
    echo $r;
    
?>
