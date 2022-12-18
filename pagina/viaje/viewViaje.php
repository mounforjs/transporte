<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
require_once CLASES.'/viaje.php';
$model=new viaje();
abrirConexion();

$movilizaciones_str="";
$retorno="";
$encomienda="";
$horario="";
$i=1;

$viaje=$model->getModel($_GET['id'], "viajes");
$departamento_id=$viaje['departamento_id'];
if($departamento_id!=""){
$departamento=$model->getDescripcionTable("departamentos", $viaje['departamento_id'], "nombre");
}else{
$departamento="SIN ASIGNAR";
}


$mviaje=$model->getModelCondicionado("pasajeros_viajes", "viaje_id=".$_GET['id']);
$movilizaciones=$model->getListCondicional("movilizaciones", 20, "viaje_id=".$_GET['id']);

if($movilizaciones!=false){
    while($reg=pg_fetch_array($movilizaciones)){
        $movilizaciones_str.=$i.". &nbsp;".$reg['descripcion']." - ".$reg['precio']."<br>";
        $i++;
    }
}else{
    $movilizaciones_str="Ninguna";
}

if($viaje['encomienda']!=1){
    $pasajero_id=$mviaje['pasajero_id'];
    $pasajero=$model->getDescripcionTable("pasajeros", $pasajero_id, "nombre");
}else{
    $pasajero="Ninguno";
}

$lote=$model->getDescripcionTable("lotes", $viaje['lote_id'], "descripcion");
$empresa=$model->getDescripcionTable("empresas", $viaje['empresa_id'], "nombre");
$conductor=$model->getDescripcionTable("conductores", $viaje['conductor_id'], "nombre");



switch ($viaje['retorno']){
    case 1:
        $retorno="Si";
        break;
    case 0:
        $retorno="No";
        break;
}
switch ($viaje['encomienda']){
    case 1:
        $encomienda="Si";
        break;
    case 0:
        $encomienda="No";
        break;
}

switch ($viaje['horario']){
    case 0:
        $horario="Horario regular";
        break;
    case 1:
        $horario="Sola la ida";
        break;
    case 2:
        $horario="Sola la vuelta";
        break;
    case 3:
        $horario="ida y vuelta";
        break;
}

?>



<div id="divPopUp">
    <div id="divNuevoPasajero">
        <br><br>
        <span class="titulo">&nbsp;&nbsp;VIAJE <?php echo $_GET['id'] ?></span><br><br>

        <table width="500px">
                <tr class="tableTitle">
                    <td colspan="2" >Datos del viaje</td>
                </tr>
                <tr>
                    <td width="100px"><strong>Fecha</strong></td>
                    <td><?php echo $model->fechaVE($viaje['fecha']) ?></td>
                </tr>

                <tr>
                    <td><strong>Conductor:</strong></td>
                    <td><?php echo $conductor ?></td>
                </tr>
                <tr>
                    <td><strong>Ruta:</strong></td>
                    <td><?php echo $viaje['ruta'] ?></td>
                </tr>
                <tr>
                    <td><strong>Destino final:</strong></td>
                    <td><?php echo $viaje['destino_final'] ?></td>
                </tr>
                <tr>
                    <td><strong>Empresa:</strong></td>
                    <td>
                        <?php echo $empresa ?>
                    </td>
                </tr>
				<tr>
                    <td><strong>Departamento:</strong></td>
                    <td><?php echo $departamento ?></td>
                </tr>
                <tr>
                    <td><strong>Lote:</strong></td>
                    <td><?php echo $lote ?></td>
                </tr>
                <tr>
                    <td><strong>Retorno:</strong></td>
                    <td><?php echo $retorno  ?></td>
                </tr>
                <tr>
                    <td><strong>Encomienda:</strong></td>
                    <td><?php echo $encomienda  ?></td>
                </tr>

                <tr>
                    <td><strong>Horas de espera:</strong></td>
                    <td><?php echo $viaje['horas_conductor']  ?></td>
                </tr>
                <tr>
                    <td><strong>Movilizaciones:</strong></td>
                    <td><?php echo $movilizaciones_str ?></td>
                </tr>
                <tr class="trhide">
                    <td><strong>Monto viaje:</strong></td>
                    <td><?php echo $viaje['monto_viaje']  ?></td>
                </tr>
                <tr class="trhide">
                    <td><strong>Monto conductor:</strong></td>
                    <td><?php echo $viaje['monto_pago']  ?></td>
                </tr>

            </table><br><br>
            <!--<a id="<?php echo $_GET['id'] ?>" name="clonarViaje" class="boton">Clonar este viaje</a> -->

    </div>
</div>