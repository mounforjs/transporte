<?php
    require_once '../rutas.php';
    require_once DB;
    require_once CLASES.'/user.php'; //Necesario colocar antes del session start para que el objeto $user llegue por  session
    require_once 'functions.php';
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
    <title>::REGISTRO:: USUARIOS</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="../css/estilo.css" type="text/css" rel="stylesheet">
    <link href="../css/colorbox.css" type="text/css" rel="stylesheet">
    <script src="../js/jquery/jquery-1.4.2.min.js"></script>
    <script src="../js/jquery/jquery-ui-1.8.js"></script>
    <script src="../js/jquery/jquery-validate/jquery.validate.js"></script>
    <script src="../js/jquery/colorbox.js"></script>

    <script type="text/javascript">

                $().ready(function(){

                $.post("../request/usuarios/ajaxGetUsuarios.php", null, function(r){
                    if(r!="false"){
                        $('#tablaUsuarios').append(r);
                    }
                });


                $("a[name='editarUsuario']").live("click",function(){
                    url=this.url;
                    id=this.id;
                

                $(this).colorbox({open:"true",url:url,transition:'fade',speed:800,onComplete:function(){
                     oldusername=$('#txtUsername').val();
                     $('#btnRegistrar').click(function(){

                            $("#txtUsername").rules("add", {
                              required: true,remote:{url:"../request/usuarios/ajaxCheckUsernameModi.php",type:"post",data:{username:$("#txtUsername").val(),oldusername:oldusername}},
                              messages: {
                              required: "Este campo es requerido",
                              remote:"El Usuario(Username) que intenta agregar ya se encuentra registrado"
                              }
                              });

                              $("#txtNombreUsuario").rules("add", {
                              required: true,
                              messages: {
                              required: "Este campo es requerido"

                              }
                              });

                              $("#selectRol").rules("add", {
                              required: true,
                              messages: {
                              required: "Este campo es requerido"

                              }
                              });


                              if($("#frmUsuario").validate().element("#txtNombreUsuario") & $("#frmUsuario").validate().element("#txtUsername") & $("#frmUsuario").validate().element("#selectRol")){
                                $.post("../request/usuarios/ajaxActualizarUsuario.php",{id:id,nombre:$('#txtNombreUsuario').val(),rol:$('#selectRol').val(),username:$('#txtUsername').val()},function(r){
                                    if(r!="false"){
                                        alert("Se han registrados los cambios satisfactoriamente");
                                        document.location=document.location;
                                    }else{
                                        alert("No se han podido modificar los datos del usuario seleccionado");
                                    }
                                });
                              }

                      });

                      $('#frmUsuario').validate({errorPlacement: function(error, element) {
                         error.appendTo(element.parent());
                      }});

                }});

                return false;
            });

            $("a[name='cambiarEstado']").live("click",function(){
                    id=this.id;
                    if(confirm("¿Esta seguro que desea cambiar el estado de este Usuario?")){
                        $.post("../request/usuarios/ajaxCambiarEstadoUsuario.php",{id:id},function(r){
                            if(r!="false"){
                                alert('Cambio realizado satisfactoriamente');
                                document.location=document.location;
                            }else{
                                alert("No se puedo cambiar el estado del usuario seleccionado");
                            }
                        });
                    }
            });


            $("a#agregarUsuario").colorbox({url:this.url,transition:'fade', speed:800,onComplete:function(){

                 $('#btnRegistrar').click(function(){

                            $("#txtUsername").rules("add", {
                              required: true,remote:{url:"../request/usuarios/ajaxCheckUsername.php",type:"post",data:{username:$("#txtUsername").val()}},
                              messages: {
                              required: "Este campo es requerido",
                              remote:"El Usuario(Username) que intenta agregar ya se encuentra registrado"
                              }
                              });

                              $("#txtNombreUsuario").rules("add", {
                              required: true,
                              messages: {
                              required: "Este campo es requerido"

                              }
                              });

                              $("#txtPassword").rules("add", {
                              required: true,
                              messages: {
                              required: "Este campo es requerido"

                              }
                              });

                              $("#selectRol").rules("add", {
                              required: true,
                              messages: {
                              required: "Este campo es requerido"

                              }
                              });

                          if($("#frmUsuario").validate().element("#txtNombreUsuario") & $("#frmUsuario").validate().element("#txtUsername") & $("#frmUsuario").validate().element("#selectRol") & $("#frmUsuario").validate().element("#txtPassword")){
                              $.post("../request/usuarios/ajaxRegistrarUsuario.php",{nombre:$('#txtNombreUsuario').val(),rol:$('#selectRol').val(),username:$('#txtUsername').val(),password:$('#txtPassword').val()},function(r){
                                if(r!="false"){
                                    alert("Usuario registrado satisfactoriamente");
                                    document.location=document.location;
                                }else{
                                    alert("No se puedo registrar al usuario");
                                }

                            });
                          }
                   });

                   $('#frmUsuario').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());
                    }});

            }});

        });

    </script>

  </head>
  <body>

    <div id="main">
        <div id="header"><img src="../img/membrete.png"><br><img src="../img/banner.png"></div>
        <div id="infobar"><div id="profile"><img class="img"align="left" id="profile" src="../img/profile.png"><strong>Usuario:&nbsp;&nbsp;</strong><?php echo $_SESSION['username'] ?></div><div id="logout"><img align="left" class="img" src="../img/logout.png"><a href="login.php">Salir del Sistema</a></div></div>
        <div id="contenido">
             <div id="maincontenido">
                <br><br>

                <span class="titulo">USUARIOS</span>
                <br><br><br><br>
                <a id="agregarUsuario" href="nusuario.php">Agregar Nuevo</a>
                <br><br><br>
                 <table id="tablaUsuarios" width="720" border="0" cellspacing="0">
                      <tr class="tableTitle">
                        <td width="73">ID</td>
                        <td width="200">Nombre </td>
                        <td width="120">Username</td>
                        <td width="100">Rol</td>
                        <td width="70">Estado</td>
                        <td width="200">Acciones</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>

                  </table>

                 <br>
             </div>
        </div>
    </div>

