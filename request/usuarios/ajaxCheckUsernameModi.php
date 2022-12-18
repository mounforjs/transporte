<?php
    session_start();
    require_once '../../rutas.php';
    require_once DB;


    if($_POST['username']!=$_POST['oldusername']){
        abrirConexion();
        $query="SELECT id FROM users WHERE username='".$_POST['username']."'";
        $result=pg_query($query);
        cerrarConexion();
        $r="true";


        if(pg_num_rows($result)>=1){
            $r="false";
        }
     }else{
            $r="true";
     }

    echo $r;
?>
