<?php
    require_once '../../rutas.php';
    require_once DB;
    require_once CLASES.'/user.php';
    require_once CLASES.'/model.php';
    require_once '../functions.php';
    session_start();

    abrirConexion();
    if(comprobarSession($_SESSION['username'], $_SESSION['password']))
    {
        $user = new User();
        $user = $_SESSION['user'];
        $_SESSION['idLista'] = $_GET['id'];
        $model = new model();
        $lista = $model->getModel($_GET['id'], "listas");
        cerrarConexion();

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

        <title>:: LISTA ::</title>
        <link href="../../css/colorbox.css" type="text/css" rel="stylesheet">
        <link href="../../css/estilo.css" type="text/css" rel="stylesheet">

        
        <link href="../../css/jquery-ui-1.8.css" type="text/css" rel="stylesheet">
        <script src="../../js/jquery/jquery-1.4.2.min.js"></script>
        <script src="../../js/jquery/jquery-ui-1.8.js"></script>
        <script src="../../js/jquery/colorbox.js"></script>
        <script src="../../js/jquery/jquery-validate/jquery.validate.js"></script>
        <script src="../../js/jquery/jquery.jkey-1.1.js"></script>
        <link href="../../css/jquery.tagsinput.css" type="text/css" rel = "stylesheet">
        <script src="../../js/jquery/jquery.tagsinput.js"></script>
        

        <script src="../../js/jquery/init.js"></script>
        <script type="text/javascript">
            
            $(document).ready(function(){

                var lista_id = <?php echo $_GET['id'] ?>;

                localStorage.setItem("lista_id", lista_id);

                $.post("../../request/lista/ajaxGetItemsLista.php", function(r){

                    if( r != "false"){
                        $('#tablaItems').append(r);
                    }

                });

                $('a#nuevoItem').colorbox({transition:'fade', speed:400,width:"650px", height:"350px",onComplete:function()
                {

                    $('#btnRegistrar').click(function()
                    {

                       $("#inputRuta").rules("add", {
                         required: true,remote:"../../request/lista/ajaxCheckItemLista.php",
                         messages: {
                           required: "<br>Este campo es requerido",
                           remote:"<br>Esta ruta ya ha sido añadida a la lista"
                         }
                        });

                        $("#txtPrecio").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });

                        $("#txtPrecioPago").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });


                        if( $('#frmItem').validate().element("#inputRuta") &
                            $('#frmItem').validate().element("#txtPrecio") &
                            $('#frmItem').validate().element("#txtPrecioPago")){

                            $('#btnRegistrar').attr("disabled", "true");
                            $.post("../../request/lista/ajaxRegistrarItem.php", $('#frmItem').serialize()+"&lista_id="+lista_id, function(r){

                                if(r == "ok")
                                {
                                    document.location = document.location;
                                }else
                                {
                                    alert("No se pudo registrar el Item.");
                                    $('#btnRegistrar').removeAttr("disabled");

                                }
                            });
                        }


                    });

                    $('#frmItem').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());

                }});

                }});


               $("a[name='editar']").live("click",function(){

               $(this).colorbox({open:"true",href:"eitem.php?id="+$(this).attr("id"),transition:'fade', speed:400,width:"680px", height:"390px",onComplete:function(){

                   id = $(this).attr("id");
                   preruta = $("#selectRuta option:selected").text();
               
                    $('#btnRegistrar').click(function()
                    {


                      /* $("#selectRuta").rules("add", {
                         required: true,remote:"../../request/lista/ajaxCheckItemListaActualizar.php?"+"postruta="+$("#selectRuta option:selected").text()+"&preruta="+preruta,
                         messages: {
                           required: "<br>Este campo es requerido",
                           remote:"<br>Este item ya se encuentra registrado"
                         }
                        });*/


                        $("#txtPrecio").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });

                        $("#txtPrecioPago").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });



                        if( $('#frmItem').validate().element("#inputRuta") &
                            $('#frmItem').validate().element("#txtPrecio") &
                            $('#frmItem').validate().element("#txtPrecioPago")){

                            $('#btnRegistrar').attr("disabled", "true");
                            $.post("../../request/lista/ajaxActualizarItem.php", $('#frmItem').serialize()+"&id="+id, function(r){

                                if(r=="ok")
                                {
                                    document.location=document.location;
                                }else
                                {
                                    alert("No se pudo actualizar el Item.");
                                    $('#btnRegistrar').removeAttr("disabled");

                                }
                            });
                        }


                    });

                    $('#frmItem').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());

                }});

                }});

               });


                $("a[name='eliminar']").live("click",function(){
                    id = this.id;
                    if(confirm("¿Esta seguro que desea eliminar este Item?")){
                        $.post("../../request/lista/ajaxEliminarItem.php",{id:id},function(r){
                            if(r=="ok"){
                                alert('Item eliminado satisfactoriamente');
                                $("tr[id="+id+"]").remove();
                            }else{
                                alert("No se pudo eliminar este item");
                            }
                        });
                    }
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
                <span class="titulo">LISTA</span>
                <h2><?php  echo strtoupper($lista['descripcion']) ?></h2>
                <br><br><br>
                <a id="nuevoItem" href="nitem.php">Nuevo Item</a>&nbsp;&nbsp;&nbsp;<br><br><br>

               

                <table id="tablaItems" class="testilo" cellspacing="0" width="900px">

                    <tr class="tableTitle">
                        <th>ID</th>
                        <th>Ruta</th>
                        <th>Precio</th>
                        <th>Precio (Pago)</th>
                        <th>Movilizaciones</th>
                        <th>Acciones</th>
                    </tr>

                </table>
                <br><br><br>
             </div>
         </div>
        </div>
    </body>
</html>