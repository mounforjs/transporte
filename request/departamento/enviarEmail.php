<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lista.php';
require_once CLASES.'/model.php';
require_once LIB.'/phpmailer/class.phpmailer.php';
require_once LIB.'/phpmailer/class.smtp.php';
require_once DB;

ini_set('display_errors', 1);
error_reporting(E_ALL);

abrirConexion();
extract($_POST);
$model=new model();
$emails=true;

$departamento=$model->getDescripcionTable("departamentos", $departamento_id, "nombre");

$fi=$fecha_ini;
$ff=$fecha_final;
$fecha_ini=$model->convertFechaSQLPostgres($fecha_ini);
$fecha_final=$model->convertFechaSQLPostgres($fecha_final);


$pasajeros_str="";
$tipo="";
$tr="";
$html="<html><head>

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
<strong>Reciba un cordial saludo de parte de TRANSPORTE ARENAS C.A</strong>,<br>
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
//echo $query;
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

$tabla.="$tr</table><br><br><strong>Comentarios:</strong><br><br>$obs</div>";
$html.=$tabla;

$mail = new PHPMailer(); 
$mail->IsSMTP(); 
$mail->Mailer = "smtp";
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
$mail->SMTPDebug = 1;

$mail->Username = "arenas.transporteca@gmail.com"; 
$mail->Password = "guanabana";
$mail->Port=465;
$mail->IsHTML(true); 



$mail->FromName = "Transporte Arenas C.A";
$mail->Subject = "Solicitudes de Servicio pendiente desde el $fi AL $ff";


//$mail->AddAddress("arenasacosta@hotmail.com");
$mail->AddAddress("alex.masdiez@gmail.com");
//$mail->AddAddress("arenas.transporteca@gmail.com");

/*$pasaEmails=$model->getListCondicional("pasajeros", 500, "departamento_id=$departamento_id and email!=''");
if($pasaEmails!=false){
    $emails=true;
    while($p=pg_fetch_array($pasaEmails)){
        //echo $p['email'];
        $mail->AddAddress($p['email']);
    }
}else{
    $emails=false;
}*/

$mail->WordWrap = 50; 
$mail->Body = $html;

if($mail->Send()){
       echo "ok";
       $_SESSION['email']=1;
    }else{
       echo "<br>No se pudo enviar el correo. Si es necesario repita el procedimiento.";
    }

 
/*if($_SESSION['email']!=1){
    if($mail->Send()){
       echo "ok";
       $_SESSION['email']=1;
    }else{
       echo "<br>No se pudo enviar el correo. Si es necesario repita el procedimiento.";
    }
}*/




}

//echo $html;

cerrarConexion();
?>