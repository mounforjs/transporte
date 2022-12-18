<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/destino.php';
require_once DB;
abrirConexion();

$r = "";
$destino = new Destino();
$list = $destino->getListCondicional("destinos", 800, "descripcion ILIKE '%".$_GET['q']."%' ORDER BY descripcion DESC");
$result = array();
$reg = null;

if($list != false)
{
    while($row = pg_fetch_array($list))
    {
        extract($row);
        $reg['id'] = $id;
        $reg['name'] = $descripcion; 

        $result[] = $reg;
    }
}

cerrarConexion();

echo json_encode($result);

?>

