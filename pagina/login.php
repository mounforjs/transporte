<?php
    session_start();
    session_destroy();
?>


<html>
    <head>
        <title>::LOGIN:: CONTROL DE ACCESO</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="../css/estilo.css" type="text/css" rel="stylesheet">
        <script src="../js/jquery/jquery.min.js" type="text/javascript"></script>
        <script src="../js/jquery/jquery-validate/jquery.validate.js" type="text/javascript"></script>
        <script src="../js/jquery/dotimeout.min.js" type="text/javascript"></script>

        <script type="text/javascript">
            $().ready(function(){
                $('#errorLogin').hide();
                $('#btnLogin').click(function(){
                	
                    var datos=$('#frmLogin').serialize();
                    $.post("../request/login/ajaxLogin.php",datos,function(r){
                        
                        ar=new Array();
                        ar=r.split("-");
                	
                        if(ar[0]=="true")
                        {
                        	
                            if(ar[1]=="Administrador" && ar[2]=="admin")
                            {
                                document.location="index.php";
                            }

                            if(ar[1]=="Transcriptor" && ar[2]=="transcriptor")
                            {
                                console.log("dfdsf");
                                document.location="../transcriptor/viewLotes.php";
                            }

                            
                            if(ar[1]=="Departamento" && ar[2]=="administracion"){
                                //alert("hola1");
                                document.location="../departamentos/viewViajesDepartamentoAdmin.php";
                            }else{
                                if(ar[1]=="Departamento"){
                            
                                document.location="../departamentos/viewViajesDepartamento.php?d="+ar[2];
                                }
                            }
                            
                            if(ar[0]=="false"){

                                $('#errorLogin').slideDown(100);
                               $.doTimeout( 5000, function(){
                                    $('#errorLogin').slideUp(300);
                                });
                                document.location=document.location;
                            }

                        }

                    });
                });

            });
        </script>
        <style>
            body{
                margin:0px 0px 0px 0px;
            }
        </style>


    </head>
    <body>

             <br><br>
             <!--<div><img src="../img/logo.png"></div> -->
             <br>
             <div id="main">
                 <div class="titleTab">
                    <img src="../img/accesoTitle.png">
                 </div>
                 <div class="loginPanel">
                    <form id="frmLogin" method="POST" action="actionLogin.php">
                        <span>Usuario</span><br>
                        <span><input name="username" size="50"></span><br><br>

                        <span>Contraseña</span><br>
                        <span><input name="password" type="password" size="30"></span><br>
                    </form>

                    <input id="btnLogin" type="button" value="ACCEDER">
                 </div>
                 <div class="errorLogin" id="errorLogin">
                    <img src="../img/errorLogin.png">
                 </div>
             </div>
    </body>
</html
