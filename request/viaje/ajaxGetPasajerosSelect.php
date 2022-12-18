<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();

$r="";
$viaje=new Viaje();
$pasajeros=$viaje->getListCondicional("pasajeros", 1000, "empresa_id=".$_POST['empresa']." ORDER BY nombre ASC");

if(pg_num_rows($pasajeros)>=1){
    while($reg=pg_fetch_array($pasajeros)){
        echo "<option value=".$reg['id'].">".$reg['nombre']."</option>";
    }
}
cerrarConexion();

?>
