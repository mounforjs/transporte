<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lote.php';
require_once DB;


abrirConexion();
$r="true";
$lote=new Lote();
//$arr=array('departamento_id'=>$selectLote);

	extract($_POST);


        $lote->begin();
    
	if($departamentos){

	    foreach($departamentos as $departamento){


		     $arr_departamento = explode("-", $departamento);
		     //echo $arr[1];

		     if(isset($arr_departamento[1])){

		     $datos=array('departamento_id'=>$arr_departamento[1]);

		     

			     if(!$lote->update("viajes", "id", $datos, $arr_departamento[0])){
				 $r="false";
			     }
		     }
		 
	    }

	}


	if($conductores){

	    foreach($conductores as $conductor){


		     $arr_conductor = explode("-", $conductor);
		     //echo $arr[1];

		     if(isset($arr_conductor[1])){


			     $datos=array('conductor_id'=>$arr_conductor[1]);
			     if(!$lote->update("viajes", "id", $datos, $arr_conductor[0])){
				 $r="false";
			     }
		     }
		 
	    }

	}



    if($r!="false"){
        $lote->commit();
    }

    echo $r;


cerrarConexion();

?>
