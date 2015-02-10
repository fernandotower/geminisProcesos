<?php
namespace component\GestorDocumentos\Modelo;

include_once ('component/GestorDocumentos/Modelo/Base.class.php');


class DocumentoTipoMIME extends Base{
    
    
    public function __construct(){
    	
    }
    
    public function crearDocumentoTipoMIME($documentoId = '', $tipoMIMEId = '',$estadoRegistroId = ''){
    	
    	$parametros = array();
    	 
    	if(!is_null($documentoId)||$documentoId!= '') return false;
    	
    	if(!is_null($tipoMIMEId)||$tipoMIMEId!= '') return false;
    	
    	 
    	if(!is_null($documentoId)&&$documentoId!= '') $parametros['documento_id'] = $documentoId;
    	if(!is_null($tipoMIMEId)&&$tipoMIMEId!= '') $parametros['tipo_mime_id'] = $tipoMIMEId;
    	
    	 
    	 
    	if(!is_null($estadoRegistroId)&&$estadoRegistroId!= '') $parametros['estado_registro_id'] = $estadoRegistroId;
    	 
    	
    	return $this->dao-> crearDocumentoTipoMIME($parametros);
    	 
    	
    }
    
    public function actualizarDocumentoTipoMIME($documentoId = '', $tipoMIMEId = '',$estadoRegistroId = ''){

    	$parametros = array();
    	
    	if(!is_null($id)||$id!= '') return false; 
    	$parametros['id'] = $id;
    	
    	 
    	if(!is_null($documentoId)&&$documentoId!= '') $parametros['documento_id'] = $documentoId;
    	if(!is_null($tipoMIMEId)&&$tipoMIMEId!= '') $parametros['tipo_mime_id'] = $tipoMIMEId;
    	
    	 
    	
    	if(!is_null($estadoRegistroId)&&$estadoRegistroId!= '') $parametros['estado_registro_id'] = $estadoRegistroId;
    	
    	
    	
    	return $this->dao-> actualizarDocumentoTipoMIME($parametros);
    	
    }
    
    public function consultarDocumentoTipoMIME($documentoId = '', $tipoMIMEId = '',$estadoRegistroId = '', $fechaRegistro = ''){

    	$parametros = array();
    	 
    	if(!is_null($id)&&$id!= '') $parametros['id'] = $id;

    	if(!is_null($documentoId)&&$documentoId!= '') $parametros['documento_id'] = $documentoId;
    	if(!is_null($tipoMIMEId)&&$tipoMIMEId!= '') $parametros['tipo_mime_id'] = $tipoMIMEId;
    	 
    	
    	
    	if(!is_null($estadoRegistroId)&&$estadoRegistroId!= '') $parametros['estado_registro_id'] = $estadoRegistroId;
    	if(!is_null($estadoRegistroId)&&$fechaRegistro!='') $parametros['fecha_registro'] = $fechaRegistro;
    	 
    	return $this->dao-> consultarDocumentoTipoMIME($parametros);
    	
    }
    
    public function activarInactivarDocumentoTipoMIME($id ){
    
    	if(is_null($id)||$id=='') return false;
    
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> activarInactivarDocumentoTipoMIME($parametros);
    
    }
    
    public function duplicarDocumentoTipoMIME($id ){
    
    	if(is_null($id)||$id=='') return false;
    
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> duplicarDocumentoTipoMIME($parametros);
    
    }
    
    
    public function eliminarDocumentoTipoMIME($id ){
    
    	if(is_null($id)||$id=='') return false;
    
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> eliminarDocumentoTipoMIME($parametros);
    
    }
    
    
    
    
    
}