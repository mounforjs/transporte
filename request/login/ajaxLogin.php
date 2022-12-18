<?php
    session_start();
    require_once '../../rutas.php';
    require_once DB;
    require_once CLASES.'/user.php';

    extract($_POST);
    abrirConexion();
    $user=new User();
    $r=$user->comprobarSession($username, $password);
    echo $r;
?>
