<?php
    session_start();
    require_once '../../rutas.php';
    require_once CLASES.'/model.php';
    require_once DB;

    $r="";

    abrirConexion();
    $model=new model();
    $estado=$model->getDescripcionTable("users", $_POST['id'], "estado");
    if($estado==1){
        $estado=0;
    }else{
        $estado=1;
    }

    $query="UPDATE users SET estado=$estado WHERE id=".$_POST['id'];
    $result=pg_query($query);
    if($result){
        $r="true";
    }else{
        $r="false";
    }
    
    cerrarConexion();

    echo $r;
?>
