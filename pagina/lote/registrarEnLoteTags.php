<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
?>
<head>
     
<script>

    $().ready(function(){

        $("#txtTags").tagsInput({
           'unique':true,
           'defaultText':'add a tag',
           'placeholderColor' : '#666666',
            'interactive':true,
            'defaultText':'add a tag',
            'width':'500px'
        });

    });

</script>

</head>


<div id="divPopUp">
    <div id="divNuevaRuta">
        <br>
        <span class="titulo">&nbsp;&nbsp;VIAJES</span><br><br>
        <form id="frmViajesTags">
            
            <input id="txtTags" name="txtTags" type="text"><br>
            <select id="selectLote" name="selectLote">
                    <?php echo $model->getCombolModelCondicional("lotes", "descripcion","estado=1") ?>
            </select>
        </form>

        <button id="btnRegistrarTags">REGISTRAR</button>&nbsp;&nbsp;&nbsp;<button id="btnCopy">COPIAR IDS</button>
    </div>
</div>