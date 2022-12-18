<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/model.php';
require_once DB;

abrirConexion();

$model = new model();
$term = trim(strip_tags($_GET['term']));

//$lista = $model->getModelCondicionado("listas", "estado=1");


$qstring = "SELECT descripcion ,id FROM listas WHERE descripcion ILIKE '%".$term."%'";
$result = pg_query($qstring);

$row_set = array();


while ($row = pg_fetch_array($result))
{               
        $row['label']=htmlentities(stripslashes($row['descripcion']));
		$row['value']=$row['id'];
		$row['id']= (int)$row['id'];
		$row_set[] = $row;
}

echo json_encode($row_set);

?>

