<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/model.php';
require_once DB;
abrirConexion();

$r="";
$model=new model();
$list=$model->getListCondicional("departamentos",500,"id!=000 ORDER BY nombre ASC");

if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);

        $empresa=$model->getDescripcionTable("empresas", $empresa_id, "nombre");
        
        $r.="<tr id=$id>
        <td>$id&nbsp;</td>
        <td>$nombre&nbsp;</td>
        <td>$codigo&nbsp;</td>
        <td>$empresa&nbsp;</td>
        <td><input class='fecha' id='fi-$id' size='9' name='fecha_ini' type='text'> AL <input id='ff-$id' class='fecha' size='9' name='fecha_final' type='text'>&nbsp;&nbsp;<input type='button' class='enviar' id='btn-$id' name='$id' value='Enviar'></td>
      </tr>";
    }
}
cerrarConexion();

echo $r;
?>

