<?php
    require_once '../../rutas.php';
    require_once DB;
    require_once CLASES.'/user.php';
    require_once '../functions.php';
    session_start();

    abrirConexion();
    if(comprobarSession($_SESSION['username'], $_SESSION['password']))
    {
        $user=new User();
        $user=$_SESSION['user'];
        cerrarConexion();
    }else
    {
        cerrarConexion();
        header("location:login.php");
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>:: CONDUCTOR ::</title>
            <link href="../../css/colorbox.css" type="text/css" rel="stylesheet">
            <link href="../../css/estilo.css" type="text/css" rel="stylesheet">
            <link href="../../css/jquery-ui-1.8.css" type="text/css" rel="stylesheet">
            <script src="../../js/jquery/jquery-1.4.2.min.js"></script>
            <script src="../../js/jquery/jquery-ui-1.8.js"></script>
            <script src="../../js/jquery/colorbox.js"></script>
            <script src="../../js/jquery/jquery-validate/jquery.validate.js"></script>

        <script type="text/javascript">

            $().ready(function(){
                $.post("../../request/conductor/ajaxGetConductorDescripcion.php", {id:<?php echo $_GET['idConductor'] ?>}, function(r){
                    if(r!="false"){
                        $('#divConductorDescripcion').html(r);
                    }
                });

                $.post("../../request/conductor/ajaxGetDeudas.php", {id:<?php echo $_GET['idConductor'] ?>}, function(r){
                    if(r!="false"){
                        $('#tablaDeudas').append(r);
                    }
                });

                $('a#nuevaDeuda').colorbox({transition:'fade', speed:800,width:"400px", height:"360px",onComplete:function(){

                    $('#btnRegistrar').click(function(){

                       $("#txtConcepto").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });

                        $("#txtMonto").rules("add", {
                         required: true,number:true,
                         messages: {
                           required: "<br>Este campo es requerido",
                           number:"<br>Este campo sólo acepta caracteres númericos"
                         }
                        });


                        if($('#frmDeuda').validate().element("#txtConcepto") &
                           $('#frmDeuda').validate().element("#txtMonto")){
                            $('#btnRegistrar').attr("disabled", "true");
                            $.post("../../request/conductor/ajaxRegistrarDeuda.php", $('#frmDeuda').serialize(), function(r){

                                if(r=="ok")
                                {
                                    document.location=document.location;
                                }else
                                {
                                    alert("No se pudo registrar la deuda.");
                                    $('#btnRegistrar').removeAttr("disabled");
                                }
                            });
                        }


                    });

                    $('#frmDeuda').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());

                }});

                }});


                $("a[name=pagarDeuda]").live("click",function(){


                $(this).colorbox({transition:'fade',href:"pagarDeuda.php?id="+this.id ,speed:800,width:"400px", height:"300px",onComplete:function(){
                    deuda_id=this.id;
                    $('#btnRegistrar').click(function(){

                        $("#txtMontoCancelar").rules("add", {
                         required: true,number:true,remote:{type:"get",url:"../../request/conductor/ajaxCheckMontoPago.php?deuda_id="+deuda_id},
                         messages: {
                           required: "<br>Este campo es requerido",
                           number:"<br>Este campo sólo acepta caracteres númericos",
                           remote:"<br>El monto escrito, supera la deuda actual del conductor"
                         }
                        });


                        if($('#frmPagar').validate().element("#txtMontoCancelar")){
                            $('#btnRegistrar').attr("disabled", "true");
                            $.post("../../request/conductor/ajaxRegistrarPago.php", $('#frmPagar').serialize(), function(r){

                                if(r=="ok")
                                {
                                    document.location=document.location;
                                }else
                                {
                                    alert("No se pudo registrar el pago de la deuda.");
                                    $('#btnRegistrar').removeAttr("disabled");
                                }
                            });
                        }


                    });

                    $('#frmPagar').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());

                }});

                }});

                });


                $("a[name='verAbonos']").live("click",function(){

                    idDeuda=$(this).attr("id");

                    $(this).colorbox({open:true,href:"viewAbonos.php?id="+$(this).attr("id"),transition:'fade', speed:400,width:"620px", height:"570px",onComplete:function(){
                            
                        $.post("../../request/conductor/ajaxGetAbonosDeuda.php", {id:idDeuda}, function(r){
                            $('#tableAbonos').append(r);
                        });

                    }});
                });

                

            });
        </script>
    </head>
    <body>
        <div id="main">
        <div id="header"><?php require_once HEADER ?></div>
         <div id="contenido">
             <div id="maincontenido">
                <br><br><br>
                <span class="titulo">DEUDAS</span>
                <br><br><br>
                <div id="divConductorDescripcion">
                    
                </div>
                <br>
                <div id="divDeudas">
                    <br><br>
                    <a id="nuevaDeuda" href="ndeuda.php?conductor_id=<?php echo $_GET['idConductor'] ?>">Nueva Deuda</a>&nbsp;&nbsp;&nbsp;<br><br><br>
                    <table id="tablaDeudas" class="testilo" cellspacing="0" width="900px">

                        <tr class="tableTitle">
                            <td>ID</td>
                            <td>Fecha</td>
                            <td>Concepto</td>
                            <td>Deuda</td>
                            <td>Pagado</td>
                            <td>Por Pagar</td>
                            <td>Pagar</td>
                        </tr>
                    </table>
                </div>
                <br><br><br>
             </div>
         </div>
        </div>
    </body>
</html>
