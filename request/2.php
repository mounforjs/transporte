<?php

require_once 'class.phpmailer.php';
require_once 'class.smtp.php';



$html ="HOLA MUNDO";

$mail = new PHPMailer(); 
$mail->IsSMTP(); 
$mail->Mailer = "smtp";
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
$mail->SMTPDebug = 1;

$mail->Username = "arenas.transporteca@gmail.com"; 
$mail->Password = "4564N";
$mail->Port=465;
$mail->IsHTML(true); 



$mail->FromName = "Transporte Arenas C.A";
$mail->Subject = "Solicitudes de Servicio pendiente desde el $fi AL $ff";



$mail->AddAddress("alex.masdiez@gmail.com");


$mail->WordWrap = 50; 
$mail->Body = $html;


if($mail->Send()){
       echo "ok";
       $_SESSION['email']=1;
    }else{
		echo $mail->ErrorInfo;
       echo "<br>No se pudo enviar el correo. Si es necesario repita el procedimiento.";
    }

?>
