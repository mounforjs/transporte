<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lista.php';
require_once CLASES.'/model.php';
require_once LIB.'/PHPMailer5/class.phpmailer.php';
require_once DB;
abrirConexion();
extract($_GET);
$model=new model();
$emails=true;

unset($_SESSION['email']);
$_SESSION['email']=0;


$departamento=$model->getDescripcionTable("departamentos", $departamento_id, "nombre");

$fi=$fecha_ini;
$ff=$fecha_final;
$fecha_ini =$model->convertFechaSQLPostgres($fecha_ini);
$fecha_final =$model->convertFechaSQLPostgres($fecha_final);

echo $fecha_ini;


$pasajeros_str="";
$tipo="";
$tr="";
$html="<strong>Reciba con un cordial saludo de parte de TRANSPORTE ARENAS C.A</strong>,<br>
el motivo de este correo es informarle sobre solicitudes pendientes desde el $fi al $ff del departamento <strong>$departamento.</strong><br><br>";


$tabla="<table width='815px' class='table-format table-bordes' cellspacing='0'>
        <tr>
            <th><strong>ID</strong></th>
            <th><strong>fecha</strong></th>
            <th width='200px'><strong>Pasajeros</strong></th>
            <th><strong>Destino</strong></th>
            <th><strong>Tipo viaje</strong></th>
            <th><strong>Retorno</strong></th>
        </tr>";

//$query="SELECT * FROM viajes WHERE fecha BETWEEN $fecha_ini AND $fecha_final AND departamento_id=$departamento_id AND solicitud_servicio=1 and estado=3 and lote_id=0";
$query="SELECT * FROM viajes WHERE fecha BETWEEN $fecha_ini AND $fecha_final AND departamento_id=$departamento_id";
echo $query;
$result=pg_query($query);
if(pg_num_rows($result)>=1){
while($reg=pg_fetch_array($result))
{

    extract($reg);
    //OBTENIENDO NOMBRE DE PASAJEROS DEL VIAJE
    $pasajeros_id=$model->getListCondicional("pasajeros_viajes", 100, "viaje_id=".$reg['id']);
    if($pasajeros_id){
        $i=0;
        $pasajeros_str="";
        while($p=pg_fetch_array($pasajeros_id))
        {
            $pasajero=$model->getDescripcionTable("pasajeros", $p['pasajero_id'], "nombre");

            if($i==0){
                $pasajeros_str.=$pasajero;
            }else{
                $pasajeros_str.="-".$pasajero;
            }
            $i++;
        }

        
    }
    
    switch($encomienda){
        case 1:
            $tipo="Encomienda";
			$pasajeros_str=$observaciones;
            break;
        case 0:
            $tipo="Personal";
            break;
    }

    switch($retorno){
        case 1:
            $retorno="Si";
            break;
        case 0:
            $retorno="No";
            break;
    }

    $tr.="<tr><td><strong>$id</strong></td>
           <td>".$model->fechaVE($fecha)."</td>
           <td>$pasajeros_str</td>
           <td>$ruta</td>
           <td>$tipo</td>
           <td>$retorno</td></tr>";



}

$tabla.="$tr</table>";
$html.=$tabla;



}else{
    $html="<br>No se encontraron viajes desde el $fi AL $ff";
    echo $html;
    exit;
}


cerrarConexion();


?>

<html><head>
        
    <style type='text/css'>
        .table-format td{
    padding               : 5px 13px;
    border-left           : 1px solid #CCC;
    border-top            : 1px solid #CCC;
    font-size: 13px;
}

.table-format th{
    padding               : 5px;
    background-color:#2B6FB6;
    color: white;
    font-size: 10px;
}

.table-bordes
{
    border-bottom       : 1px solid #CCC;
    border-right       : 1px solid #CCC;
}

body{
    font-family:'lucida grande',tahoma,verdana,arial,sans-serif;
    font-size: 13px;
    color:#525252;
}


</style>

</head>
<body>
<div style='margin-left:15px;margin-top:10px'>
<br>
<?php echo $html ?>
<br>
<strong>Comentarios:</strong><br>
<textarea id="txtObservaciones" cols="90" rows="4"></textarea>
<br><br>
<button id="btnEnviarEmail">ENVIAR</button>
</div>