<?php
namespace component\GestorDocumento\Modelo;

include_once ('component/GestorProcesos/Modelo/Base.class.php');


class Actividad extends Base{
    
    
    public function __construct(){
    	
    }
    
    public function crearDocumento($nombre = '', $alias = '',$descripcion = '', $idElementoBpmn = '',$rutaEjecucion = '', $idTipoEjecucion = '', $estadoRegistroId = '', $fechaRegistro = ''){
    	
    	$parametros = array();
    	 
    	if(!is_null($nombre)||$nombre!= '') return false;
    	if(!is_null($alias)||$alias!= '') return false;
    	if(!is_null($idElementoBpmn)||$idElementoBpmn!= '') return false;
    	if(!is_null($rutaEjecucion)||$rutaEjecucion!= '') return false;
    	
    	 
    	if(!is_null($nombre)&&$nombre!= '') $parametros['nombre'] = $nombre;
    	if(!is_null($alias)&&$alias!= '') $parametros['alias'] = $alias;
    	if(!is_null($descripcion)&&$$descripcion!= '') $parametros['descripcion'] = $descripcion;
    	
    	if(!is_null($idElementoBpmn)&&$idElementoBpmn!= '') $parametros['elemento_bpmn_id'] = $idElementoBpmn;
    	if(!is_null($rutaEjecucion)&&$rutaEjecucion!= '') $parametros['ruta_ejecucion'] = $rutaEjecucion;
    	 
    	 
    	if(!is_null($idTipoEjecucion)&&$idTipoEjecucion!= '') $parametros['tipo_ejecucion_id'] = $idTipoEjecucion;
    	if(!is_null($estadoRegistroId)&&$estadoRegistroId!= '') $parametros['estado_registro_id'] = $estadoRegistroId;
    	if(!is_null($estadoRegistroId)&&$fechaRegistro!='') $parametros['fecha_registro'] = $fechaRegistro;
    	 
    	
    	return $this->dao-> actualizarActividad($parametros);
    	 
    	
    }
    
    public function actualizarDocumento($id = '',$nombre = '', $alias = '',$descripcion = '', $idElementoBpmn = '',$rutaEjecucion = '', $idTipoEjecucion = '', $estadoRegistroId = '', $fechaRegistro = ''){

    	$parametros = array();
    	
    	if(!is_null($id)||$id!= '') return false; 
    	$parametros['id'] = $id;
    	
    	if(!is_null($nombre)&&$nombre!= '') $parametros['nombre'] = $nombre;
    	if(!is_null($alias)&&$alias!= '') $parametros['alias'] = $alias;
    	if(!is_null($descripcion)&&$$descripcion!= '') $parametros['descripcion'] = $descripcion;
    	 
    	if(!is_null($idElementoBpmn)&&$idElementoBpmn!= '') $parametros['elemento_bpmn_id'] = $idElementoBpmn;
    	if(!is_null($rutaEjecucion)&&$rutaEjecucion!= '') $parametros['ruta_ejecucion'] = $rutaEjecucion;
    	
    	
    	if(!is_null($idTipoEjecucion)&&$idTipoEjecucion!= '') $parametros['tipo_ejecucion_id'] = $idTipoEjecucion;
    	if(!is_null($estadoRegistroId)&&$estadoRegistroId!= '') $parametros['estado_registro_id'] = $estadoRegistroId;
    	if(!is_null($estadoRegistroId)&&$fechaRegistro!='') $parametros['fecha_registro'] = $fechaRegistro;
    	
    	
    	return $this->dao-> actualizarActividad($parametros);
    	
    }
    
    public function consultarDocumento($id = '',$nombre = '', $alias = '', $idElementoBpmn = '', $idTipoEjecucion = '', $estadoRegistroId = '', $fechaRegistro = ''){

    	$parametros = array();
    	 
    	if(!is_null($id)&&$id!= '') $parametros['id'] = $id;
    	if(!is_null($nombre)&&$nombre!= '') $parametros['nombre'] = $nombre;
    	if(!is_null($alias)&&$alias!= '') $parametros['alias'] = $alias;
    	
    	if(!is_null($idElementoBpmn)&&$idElementoBpmn!= '') $parametros['elemento_bpmn_id'] = $idElementoBpmn;
    	if(!is_null($idTipoEjecucion)&&$idTipoEjecucion!= '') $parametros['tipo_ejecucion_id'] = $idTipoEjecucion;
    	if(!is_null($estadoRegistroId)&&$estadoRegistroId!= '') $parametros['estado_registro_id'] = $estadoRegistroId;
    	if(!is_null($estadoRegistroId)&&$fechaRegistro!='') $parametros['fecha_registro'] = $fechaRegistro;
    	 
    	return $this->dao-> consultarDocumento($parametros);
    	
    }
    
    public function activarInactivarDocumento($id ){
    
    	if(is_null($id)||$id=='') return false;
    
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> actualizarActividad($parametros);
    
    }
    
    public function duplicarActividad($id ){
    
    	if(is_null($id)||$id=='') return false;
    
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> duplicarActividad($parametros);
    
    }
    
    
    public function eliminarActividad($id ){
    
    	if(is_null($id)||$id=='') return false;
    
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> eliminarActividad($parametros);
    
    }
    
    
    
    
    
}