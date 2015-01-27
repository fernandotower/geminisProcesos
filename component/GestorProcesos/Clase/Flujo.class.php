<?php
namespace component\GestorProcesos\Clase;

include_once ('core/connection/DAL.class.php');


class Flujo{
    
    
    public function __construct(){
    	
    }
    
    public function crearFlujo(){
    	
    }
    
    public function actualizarFlujo(){
    	
    }
    
    public function consultarFlujo($id = '', $procesoId = '',$actividadPadreId = '', $actividadHijoId = '',$tipoEjecucionId = '',$estadoRegistroId = '', $fecha = '' ){
    	
    	$parametros = array();
    	
    	if(!is_null($id)&&$id!= '') $parametros['id'] = $id;
    	if(!is_null($procesoId)&&$procesoId!= '') $parametros['proceso_id'] = $procesoId;
    	if(!is_null($actividadPadreId)&&$actividadPadreId!= '') $parametros['padre_id'] = $actividadPadreId;
    	if(!is_null($actividadHijoId)&&$actividadHijoId!= '') $parametros['hijo_id'] = $actividadHijoId;
    	if(!is_null($tipoEjecucionId)&&$tipoEjecucionId!= '') $parametros['tipo_ejecucion_id'] = $tipoEjecucionId;
    	if(!is_null($estadoRegistroId)&&$estadoRegistroId!= '') $parametros['estado_registro_id'] = $estadoRegistroId;
    	//if(!is_null($tipoEjecucionId)&&$tipoEjecucionId!= '') $parametros['tipo_ejecucion_id'] = $tipoEjecucionId;
    	
    	$dal =  new \DAL();
    	$dal->setConexion('academica');
    	
    	//
    	
    	return $dal-> consultarFlujoProceso($parametros);
    	
    }
    
    
    
    
    
}