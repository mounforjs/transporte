<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lista.php';
require_once DB;
abrirConexion();
extract($_POST);

$model=new model();

if($empresa == 1){
    $viajes=$model->getListCondicional("viajes", 500, "(lote_id=".$lote." and empresa_id=".$empresa.") and (departamento_id IS NULL OR conductor_id=49 OR departamento_id=0)");


$r = "1";


if($viajes!=false){

    $r="<tr class='tableTitle'>
<td>ID</td>
<td>Pasajeros</td>
<td>Ruta</td>
<td>Conductor</td>
<td>Departamento</td>
</tr>";

    if(pg_num_rows($viajes) >= 1){
        while($v = pg_fetch_array($viajes)){
            extract($v);

            //ENCONTRANDO A LOS PASAJEROS

            $pasajerosIDS = $model->getListCondicional("pasajeros_viajes", 500, "viaje_id=".$id);
            $pasajerosText = "";
            $i = 0;

            if($pasajerosIDS){
                while($reg = pg_fetch_array($pasajerosIDS)){

                    $pasajeroText = $model->getDescripcionTable("pasajeros", $reg['pasajero_id'], "nombre");

                    if($i == 0){
                        $pasajerosText = $pasajeroText;
                    }else{
                        $pasajerosText.=",".$pasajeroText;
                    }

                    $i++;
                }
            }else{
                $pasajeroText = "Encomienda";
            }

	    if($conductor_id == 49)
        {
		  $conductor = "<input id='selectConductor$id' class='selectConductor' name='conductores[]' type='text' viaje='$id' >";

	    }else{

    		$c = $model->getModel($conductor_id,"conductores");
    		$conductor = $c['nombre'];
	    }

	    if($departamento_id == "" || $departamento_id == 0)
        {
		
		  $inputDepartamento="<input id='selectDepartamento$id' class='selectDepartamento' name='departamentos[]' type='text' viaje='$id' >";

	    }else{
    		$dep = $model->getModel($departamento_id,"departamentos");
    		$inputDepartamento = $dep['nombre'];
	    }



            $r.="<tr id='ss'>
            <td >$id</td>
            <td >$pasajeroText</td>
            <td >$ruta</td>
	    <td >$conductor</td>
            <td >$inputDepartamento</td>
            </tr>";

        }
        

    }else{
        $r = "1";
    }
}
}else{
    $r = "1";
}

echo trim($r);

?>

