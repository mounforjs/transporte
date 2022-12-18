<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/model.php';
require_once DB;

abrirConexion();
$term = trim(strip_tags($_GET['term']));

$qstring = "SELECT nombre,id FROM pasajeros WHERE nombre ILIKE '%".$term."%'";
$result = pg_query($qstring);

$row_set = array();

while ($row = pg_fetch_array($result))
{               
                $row['value']= $row['id'];
		$row['label']=htmlentities(stripslashes($row['nombre']));
		$row['id']= (int)$row['id'];
		$row_set[] = $row;
}

echo json_encode($row_set);

?>

