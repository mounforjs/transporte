<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lista.php';
require_once DB;

extract($_POST);
abrirConexion();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$lista = new Lista();
$fecha = date("d/m/Y");
$fecha = $lista->convertFechaSQLPostgres($fecha);


if(!isset($txtHora))
	$txtHora = 0;

if(!isset($txtHoraConductor))
	$txtHoraConductor = 0;


$arr = array('descripcion' => "'".$txtDescripcion."'", 'fecha' => $fecha,'hora_espera' => $txtHora,'hora_espera_conductor' => $txtHoraConductor, 'estructura_lista_id' => $inputEstructuraLista);
$result = $lista->saveId("listas", $arr);
$r = "true";



if($result)
{

	if(!empty($inputEstructuraLista))
	{

		$estructura_rutas = $lista->getListCondicional("listas_rutas","ALL" ,"lista_id=".$inputEstructuraLista);

		while($reg = pg_fetch_assoc($estructura_rutas))
		{



			$precio = $reg['precio'] + ($reg['precio']*($selectIncremento/100));
			$precio_conductor = $reg['precio_conductores'] + ($reg['precio_conductores']*($selectIncremento/100));


			$arr_rutas = array('lista_id' => $result->id, 'ruta_id' => $reg['ruta_id'] ,'ruta' => "'".$reg['ruta']."'",'precio' => $precio,'precio_conductores' => $precio_conductor);
		

			if(!$lista->save("listas_rutas", $arr_rutas))
			{
				$r = "false";
			}

		}

	}


}else{
   $r = "false";
}

if($r == "true" )
{
	$r = "true";
}else{
	$r = "false";

}

echo $r;

cerrarConexion();

?>
