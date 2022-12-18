<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/model.php';
require_once DB;

abrirConexion();

$model = new model();
$term = trim(strip_tags($_GET['term']));

$lista = $model->getModelCondicionado("listas", "estado=1");


$qstring = "SELECT ruta ,ruta_id FROM listas_rutas WHERE lista_id=".$_GET['lista']." and ruta ILIKE '%".$term."%'";
$result = pg_query($qstring);

$row_set = array();

//echo $qstring;



while ($row = pg_fetch_array($result))
{               
         $row['label']=htmlentities(stripslashes($row['ruta']));
		$row['value']=$row['ruta_id'];
		$row['id']= (int)$row['ruta_id'];
		$row_set[] = $row;
}

echo json_encode($row_set);

?>

