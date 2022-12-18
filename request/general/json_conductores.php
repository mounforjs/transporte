<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/model.php';
require_once DB;

abrirConexion();

$qstring = "SELECT nombre ,id FROM conductores";
$result = pg_query($qstring);

$row_set = array();

while ($row = pg_fetch_array($result))
{               
                $row['label']=htmlentities(stripslashes($row['nombre']));
		$row['value']=$row['id'];
		$row['id']= (int)$row['id'];
		$row_set[] = $row;
}

echo json_encode($row_set);

?>

