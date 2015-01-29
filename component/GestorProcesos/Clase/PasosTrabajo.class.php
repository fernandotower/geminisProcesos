<?php

namespace component\GestorProcesos\Clase;

include_once ('core/connection/DAL.class.php');


class PasosTrabajo{
    
    
    public function __construct(){
    	
    }
    
    public function crearPaso($idTrabajo = '', $idActividad = '' ,$idEstadoPaso = ''){
    	
    	if(is_null($idTrabajo)||is_null($idActividad)||is_null($idEstadoPaso)) return false;
    	if($idTrabajo==''||$idActividad==''||$idEstadoPaso=='') return false;
    	
    	$parametros['trabajo_id'] = $idTrabajo;
    	$parametros['actividad_id'] = $idActividad;
    	$parametros['estado_paso_id'] = $idEstadoPaso;
    	$parametros['estado_registro_id'] = 1;
    	 
    	 
    	$dal = new \ DAL();
    	$dal->setConexion('academica');
    	return $dal->crearPasosTrabajo($parametros);
    	
    }
    
    public function actualizarEstadoPaso($idTrabajo = '', $idActividad = '' ,$idEstadoPaso = '', $estadoRegistroId ='') {
    	$parametros = array();
    	
    	if(is_null($idTrabajo)||is_null($idActividad)||is_null($idEstadoPaso)) return false;
    	if($idTrabajo==''||$idActividad==''||$idEstadoPaso=='') return false;
    	
    	$parametros['trabajo_id'] = $idTrabajo;
    	$parametros['actividad_id'] = $idActividad;
    	$parametros['estado_paso_id'] = $idEstadoPaso;
    	if($estadoRegistroId!='' &&!is_null($estadoRegistroId))
    		$parametros['estado_registro_id'] = $estadoRegistroId;
    	 
    	
    	
    	$dal = new \ DAL();
    	
    	
    	
    	$dal->setConexion('academica');
    	
    	
    	$parametros_consulta =  array();
    	$parametros_consulta['trabajo_id'] = $idTrabajo;
    	$parametros_consulta['actividad_id'] = $idActividad;
    	$parametros_consulta['estado_registro_id'] = 1;
    	
    	//consultar id
    	$datosPasos =$dal->consultarPasosTrabajo($parametros_consulta);
    	
    	if(!$datosPasos) return false;
    	
    	$parametros['pasos_trabajo_id'] = $datosPasos[0]['id'];
    	
    	return $dal->actualizarPasosTrabajo($parametros);
    }
    
    public function finalizarPasosTrabajo($idTrabajo = ''){
    	
    	if(is_null($idTrabajo)||$idTrabajo=='') return false;
    	
    	$dal = new \ DAL();
    	 
    	$dal->setConexion('academica');
    	 
    	$parametros_consulta = array();
    	$parametros_consulta['trabajo_id'] = $idTrabajo;
    	
    	//consulta lista de pasos trabajo
    	$listado = $dal->consultarPasosTrabajo($parametros_consulta); 
    	
    	//cambia estado_registro_id de los pasos a 2

    	if(!is_array($listado)) return false;
    	
    	$parametros = array();
    	$parametros['estado_registro_id'] = 2;
    	
    	foreach ($listado as $fila){
    		$parametros['pasos_trabajo_id'] = $fila['id'];
    		$ejecucion =  $dal->actualizarPasosTrabajo($parametros);
    		
    		
    	}
    	
    	return true;
    }
    
    public function borrarPasosTrabajo($idTrabajo){
    	
    	    	if(is_null($idTrabajo)||$idTrabajo=='') return false;
    	
    	$dal = new \ DAL();
    	 
    	$dal->setConexion('academica');
    	 
    	$parametros_consulta = array();
    	$parametros_consulta['trabajo_id'] = $idTrabajo;
    	
    	//consulta lista de pasos trabajo
    	$listado = $dal->consultarPasosTrabajo($parametros_consulta); 
    	
    	//cambia estado_registro_id de los pasos a 2

    	if(!is_array($listado)) return false;
    	
    	$parametros = array();
    	$parametros['estado_registro_id'] = 2;
    	
    	foreach ($listado as $fila){
    		$parametros['pasos_trabajo_id'] = $fila['id'];
    		$ejecucion =  $dal->eliminarPasosTrabajo($parametros);
    		
    		
    	}
    	
    	return true;}
    
    public function consultarPasosTrabajo($idTrabajo = '', $idActividad = '', $idEstadoPaso = '', $idEstadoRegistro= '', $fechaRegistro= ''){
    	
    	
    	$parametros = array();
    	 
    	
    	if(!is_null($idTrabajo)&&$idTrabajo!='') $parametros['trabajo_id'] = $idTrabajo;
    	if(!is_null($idActividad)&&$idActividad!='') $parametros['actividad_id'] = $idActividad;
    	if(!is_null($idEstadoPaso)&&$idEstadoPaso!='') $parametros['estado_paso_id'] = $idEstadoPaso;
    	if(!is_null($idEstadoRegistro)&&$idEstadoRegistro!='') $parametros['estado_registro_id'] = $idEstadoRegistro;
    	if(!is_null($fechaRegistro)&&$fechaRegistro!='') $parametros['fecha_registro'] = $fechaRegistro;
    	
    	 
    	 
    	$dal = new \ DAL();
    	 
    	 
    	$dal->setConexion('academica');
    	return $dal->consultarPasosTrabajo($parametros);
    	
    }
    
    
    
    
    
}