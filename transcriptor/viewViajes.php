<?php
    require_once '../rutas.php';
    require_once DB;
    require_once CLASES.'/user.php';
    require_once '../pagina/functions.php';
    session_start();

    abrirConexion();
    if(comprobarSessionTranscriptor($_SESSION['username'], $_SESSION['password']))
    {
        $user=new User();
        //$user=$_SESSION['user'];
        $model=new model();
        
    }else
    {
        cerrarConexion();
        header("location:../login.php");
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>:: VIAJES ::</title>
            <link href="../../css/colorbox.css" type="text/css" rel="stylesheet">
            <link href="../../css/estilo.css" type="text/css" rel="stylesheet">
            <link href="../../css/jquery-ui-1.8.css" type="text/css" rel="stylesheet">
            <script src="../../js/jquery/jquery-1.4.2.min.js"></script>
            <script src="../../js/jquery/jquery-ui-1.8.js"></script>
            <script src="../../js/jquery/colorbox.js"></script>
            <script src="../../js/jquery/jquery.jkey-1.1.js"></script>
            <script src="../../js/jquery/jquery-validate/jquery.validate.js"></script>
            <link href="../../css/jquery.tagsinput.css" type="text/css" rel="stylesheet">
            <script src="../../js/jquery/jquery.tagsinput.js"></script>
            <script src="../../js/jquery/init.js"></script>
            <script src="../../js/jquery/sessvars.js"></script>

        <script type="text/javascript">

            $().ready(function(){

                s="cs";

                $.post("../../request/viaje/ajaxGetViajes.php", null, function(r){
                    if(r!="false"){
                        $('#tablaViajes').append(r);
                    }
                });


               $("a[name='eliminar']").live("click",function(){
                    if(confirm("¿Esta seguro de que desea eliminar este viaje?")){
                        $.post("../../request/viaje/ajaxEliminarViaje.php", {id:this.id}, function(r){
                            if(r=="ok"){
                                document.location=document.location;
                            }
                        });
                     }
                });

                $('#btnConfirmar').click(function(){
                    $.post("../../request/viaje/ajaxConfirmarSolicitudes.php", $('#frmViajes').serialize(), function(){
                        document.location=document.location;
                    })
                });

                $('#btnDeshacer').click(function(){
                    $.post("../../request/viaje/ajaxDeshacerExistencia.php", $('#frmViajes').serialize(), function(){
                        document.location=document.location;
                    })
                });

                $("a[name='sinSolicitud']").live("click",function(){
                    $.post("../../request/viaje/ajaxSinSolicitud.php",{id:this.id}, function(){
                        document.location=document.location;
                    });
                });

                $("#btnRegistrarEnLote").live("click",function(){
                    
                    if(confirm("¿Esta seguro que desea añadir este viaje al lote")){
                        $.post("../../request/lote/ajaxRegistrarEnLote.php",$('#frmViajes').serialize(),function(r){
                            if(r=="true"){
                                alert('Añadido(s) satisfactoriamente');
                                document.location=document.location;
                            }else{
                                alert("Los viajes "+r+" no puedieron ser incluidos. Posiblemente no tengan solicitud. O la empresa del lote no corresponde con la empresa del viaje");
                            }
                        });
                    }
                });

                $("#btnSeleccionar").click(function(){


                $.getJSON("../../request/viaje/ajaxGetViajesSeleccionados.php", {empresa:$('#selectEmpresas').val(),tipo:$('#selectTipoViaje').val(),seleccion:s}, function(viajes){

                        if(viajes!=1){
                            $("input[type='checkbox']:checked").click();
                            $.each(viajes, function(i,viaje){
                                $("input[value='"+viaje.id+"']").click();
                            });
                            $('#ubicacion').show();
                        }else{
                            alert("Sin resultados");
                        }
                    });
                });
                

            $("input[type='checkbox']").live("click",function(){
                
                if($(this).is(":checked")){
                    $('#ubicacion').show();
                }else{

                    if($("input[type='checkbox']:checked").length<=0){
                        $('#ubicacion').hide();
                    }   
                }
            });

            $('#ubicacion').hide();
            $('#btnDesmarcar').click(function(){
                $("input[type='checkbox']:checked").click();

                if($("input[type='checkbox']:checked").length<=0){
                        $('#ubicacion').hide();
                    }  

            });

            $("input[name='seleccion']").click(function(){
               s=$(this).attr("value");

            });


            $("a[name='clonarViaje']").live("click",function(){

                idViaje=$(this).attr("id");
                $.colorbox({href:"clonarViaje.php?id="+$(this).attr("id"),transition:'fade', speed:400,width:"620px", height:"350px",onComplete:function(){

                    $("a[name='actionClonarViaje']").click(function(){
                        $.post("../../request/viaje/ajaxClonarViaje.php",$("#frmClonar").serialize()+"&idViaje="+idViaje,function(r){
                                //alert("hola");
                                //alert(r);
                                //document.location="viajes.php?idClonado="+r;
                        });
                    });

                }});

            });

            idClonado=<?php 
            if(isset($_GET['idClonado']))
                echo $_GET['idClonado'];
            else{ echo "0";}
            ?>;
            if(idClonado!=0){
                alert("Viaje Clonado ! ID "+idClonado);
                $("#"+idClonado+" > td").css("background-color","green");
            }

            });
            
        </script>
            
    </head>

    <body>
        <div id="main">
        <div id="header"><?php require_once HEADER_TRANSCRIPTOR ?></div>
         <div id="contenido">
             <div id="maincontenido">
                <br><br><br>
                <span class="titulo">VIAJES TERMINADOS</span>
                <br><br><br>
                <form id="frmViajes">
                <fieldset>
                    <legend>Selección de viajes</legend>
                Empresa:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select id="selectEmpresas">
               
                    <?php $model->getCombolModel("empresas", "nombre") ?>
                </select><BR>
                Tipo de viaje:
                <select id="selectTipoViaje">
                    <option value="1">Transporte de personal</option>
                    <option value="2">Encomiendas</option>
                    <option value="3">Todos</option>
                </select><BR><BR>
                <input type="radio" name="seleccion" value="cs" checked>&nbsp;Seleccionar con solicitudes<br>
                <input type="radio" name="seleccion" value="ss">&nbsp;Seleccionar sin solicitudes<br><br>
                <input id="btnSeleccionar" type="button" value="SELECCIONAR">&nbsp;<input id="btnDesmarcar" type="button" value="DESMARCAR TODOS">
                </fieldset><br>
                <fieldset id="ubicacion">
                    <legend>Ubicar en lote</legend>
                    <select id="selectLote" name="selectLote">
                    <?php echo $model->getCombolModelDESC("lotes", "descripcion") ?>
                </select><BR>
                
                <input id="btnRegistrarEnLote" type="button" value="REGISTRAR">
                </fieldset>
                <br><br><br>

                
                    <table id="tablaViajes" class="testilo" cellspacing="0" width="930px">
                        <tr class="tableTitle">
                            <td width="50">ID</td>
                            <td width="80">Fecha</td>
                            <td>Ruta</td>
			    <td>Empresa</td>
                            <td>S.S</td>
                            <td>Tipo</td>
                            <td>Pasajero</td>
                            <td>Acciones</td>
                        </tr>
                        <tr>
                            <td colspan="8"></td>
                        </tr>
                    </table>
               </form>
                <br><br>
                <input id="btnConfirmar" type="button" value="CONFIRMAR EXISTENCIA DE SOLICITUD">&nbsp;&nbsp;<input id="btnDeshacer" type="button" value="DESHACER EXISTENCIA DE SOLICITUD">
                <br><br><br>
             </div>
         </div>
        </div>
    </body>
</html>
