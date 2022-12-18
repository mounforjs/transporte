<?php
    session_start();
    require_once '../../rutas.php';
    require_once DB;
    
    $r="true";

    abrirConexion();
    $query="SELECT id FROM users WHERE username='".$_POST['username']."'";
    $result=pg_query($query);
    cerrarConexion();
    
    if(pg_num_rows($result)>=1){
        $r="false";
    }

    echo $r;
?>
