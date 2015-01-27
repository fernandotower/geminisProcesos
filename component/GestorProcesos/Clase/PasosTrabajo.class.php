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
    
    public function actualizarEstadoPaso($idTrabajo = '', $idActividad = '' ,$idEstadoPaso = '') {
    	$parametros = array();
    	
    	if(is_null($idTrabajo)||is_null($idActividad)||is_null($idEstadoPaso)) return false;
    	if($idTrabajo==''||$idActividad==''||$idEstadoPaso=='') return false;
    	
    	$parametros['trabajo_id'] = $idTrabajo;
    	$parametros['actividad_id'] = $idActividad;
    	$parametros['estado_paso_id'] = $idEstadoPaso;
    	
    	 
    	
    	
    	$dal = new \ DAL();
    	
    	
    	$dal->setConexion('academica');
    	
    	return $dal->actualizarPasosTrabajo($parametros);
    }
    
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