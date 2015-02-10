<?php
namespace component\GestorProcesos\Modelo;

include_once ('component/GestorProcesos/Modelo/Base.class.php');


class Flujo extends Base{
    
    
    public function __construct(){
    	
    }
    
    public function crearFlujo($procesoId = '',$actividadPadreId = '', $actividadHijoId = '',$ordenEvaluacionCondicion = '',$condicion = '',$tipoEjecucionId = '',$rutaEjecucionCondicion = '',$estadoRegistroId = '' ){

    	$parametros = array();
    	
    	
    	if(!is_null($procesoId)||$procesoId!= '') return false; 
    		$parametros['proceso_id'] = $procesoId;
    	if(!is_null($actividadPadreId)||$actividadPadreId!= '') return false; 
    		$parametros['padre_id'] = $actividadPadreId;
    	if(!is_null($actividadHijoId)||$actividadHijoId!= '') return false;
    	 $parametros['hijo_id'] = $actividadHijoId;
    	 
    	if(!is_null($ordenEvaluacionCondicion)||$ordenEvaluacionCondicion!= '') return false;
    	 $parametros['orden_evaluacion_condicion'] = $ordenEvaluacionCondicion;
    	if(!is_null($condicion)||$condicion!= '') return false;
    	 $parametros['condicion'] = $condicion;
    	if(!is_null($tipoEjecucionId)||$tipoEjecucionId!= '') return false;
    	 $parametros['tipo_ejecucion_id'] = $tipoEjecucionId;
    	
    	if(!is_null($rutaEjecucionCondicion)||$$rutaEjecucionCondicion!= '') return false;
    	 $parametros['ruta_ejecucion_condicion'] = $rutaEjecucionCondicion;
    	if(!is_null($estadoRegistroId)||$estadoRegistroId!= '') $parametros['estado_registro_id'] = 3;
    	 $parametros['estado_registro_id'] = $estadoRegistroId;

    	 return $this->dao-> crearFlujoProceso($parametros);
    	
    }
    
    public function actualizarFlujo($id, $procesoId = '',$actividadPadreId = '', $actividadHijoId = '',$ordenEvaluacionCondicion = '',$condicion = '',$tipoEjecucionId = '',$rutaEjecucionCondicion = '',$estadoRegistroId = ''){
    	if(is_null($id)||$id=='')  return false;
    	
    	$parametros = array();
    	 
    	 $parametros['id'] = $id;
    	if(!is_null($procesoId)&&$procesoId!= '') $parametros['proceso_id'] = $procesoId;
    	if(!is_null($actividadPadreId)&&$actividadPadreId!= '') $parametros['padre_id'] = $actividadPadreId;
    	if(!is_null($actividadHijoId)&&$actividadHijoId!= '') $parametros['hijo_id'] = $actividadHijoId;
    	
    	if(!is_null($ordenEvaluacionCondicion)&&$ordenEvaluacionCondicion!= '') $parametros['orden_evaluacion_condicion'] = $ordenEvaluacionCondicion;
    	if(!is_null($condicion)&&$condicion!= '') $parametros['condicion'] = $condicion;
    	if(!is_null($tipoEjecucionId)&&$tipoEjecucionId!= '') $parametros['tipo_ejecucion_id'] = $tipoEjecucionId;

    	if(!is_null($rutaEjecucionCondicion)&&$$rutaEjecucionCondicion!= '') $parametros['ruta_ejecucion_condicion'] = $rutaEjecucionCondicion;
    	if(!is_null($estadoRegistroId)&&$estadoRegistroId!= '') $parametros['estado_registro_id'] = $estadoRegistroId;
    	
    	 
    	 
    	return $this->dao-> actualizarFlujoProceso($parametros);
    	 
    	
    }
    
    public function consultarFlujo($id = '', $procesoId = '',$actividadPadreId = '', $actividadHijoId = '',$tipoEjecucionId = '',$estadoRegistroId = '', $fecha = '' ){
    	
    	$parametros = array();
    	
    	if(!is_null($id)&&$id!= '') $parametros['id'] = $id;
    	if(!is_null($procesoId)&&$procesoId!= '') $parametros['proceso_id'] = $procesoId;
    	if(!is_null($actividadPadreId)&&$actividadPadreId!= '') $parametros['padre_id'] = $actividadPadreId;
    	if(!is_null($actividadHijoId)&&$actividadHijoId!= '') $parametros['hijo_id'] = $actividadHijoId;
    	if(!is_null($tipoEjecucionId)&&$tipoEjecucionId!= '') $parametros['tipo_ejecucion_id'] = $tipoEjecucionId;
    	if(!is_null($estadoRegistroId)&&$estadoRegistroId!= '') $parametros['estado_registro_id'] = $estadoRegistroId;
    	if(!is_null($fecha)&&$fecha!= '') $parametros['fecha_registro'] = $fecha;
    	
    	
    	
    	return $this->dao-> consultarFlujoProceso($parametros);
    	
    }

    
    public function activarInactivarFlujoProceso($id ){
    
    	if(is_null($id)||$id=='') return false;
    
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> activarInactivarFlujoProceso($parametros);
    
    }
    
    public function duplicarFlujoProceso($id ){
    
    	if(is_null($id)||$id=='') return false;
    
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> duplicarFlujoProceso($parametros);
    
    }
    
    
    public function eliminarFlujoProceso($id ){
    
    	if(is_null($id)||$id=='') return false;
    
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> eliminarFlujoProceso($parametros);
    
    }
    
    
    
    
}