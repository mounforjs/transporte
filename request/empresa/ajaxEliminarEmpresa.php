<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/empresa.php';
require_once DB;

extract($_POST);
$empresa=new Empresa();
abrirConexion();

if(!$empresa->existe("viajes", "empresa_id", $id))
{
    if($empresa->delete("empresas", "id", $id))
    {
        echo "ok";
    }else
    {
        echo "false";
    }
}else{
    echo "referencia";
}

cerrarConexion();

?>
