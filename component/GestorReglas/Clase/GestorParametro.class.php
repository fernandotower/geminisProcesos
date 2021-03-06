<?php

namespace reglas;



if (! isset ( $GLOBALS ["autorizado"] )) {
    include ("../index.php");
    exit ();
}

include_once ("core/general/Tipos.class.php");
use \Tipos as Tipos;
include_once ("core/general/Rango.class.php");
use \Rango as Rango;

include_once ("core/builder/Mensaje.class.php");
use \Mensaje as Mensaje;
include_once ("core/connection/DAL.class.php");
use \DAL as DAL;

use component\GestorUsuarios\Componente as GestorUsuariosComponentes;

class GestorParametro{
    
	const ID_OBJETO = 1;

	private $parametros ;
    private $registrador;
    private $usuario;
    public $mensaje;
    private $verificadorAcceso ;
    
    function __construct(){
    	
    	$this->registrador = new DAL();
    	
    	
    	
    	//configurar usuario
    	$this->usuario = $_REQUEST['usuario'];
    	$this->registrador->setUsuario($this->usuario);
    	$this->verificadorAcceso = new  GestorUsuariosComponentes();
    	
    }
    
    
    private function getValorReal($valor = '',$tipo = ''){
    	
    	$valor= base64_decode($valor);
    	
    	if(!Tipos::validarTipo($valor,$tipo)){
    		$this->mensaje->addMensaje("101","errorEntradaParametrosTipo",'error');
    		return false;
    	}
    	 
    	if(Tipos::validarTipo($valor,$tipo)) $valor = is_null(Tipos::evaluarTipo($valor,$tipo))?'nulo':base64_encode(Tipos::evaluarTipo($valor,$tipo)) ;
    	if(strtolower(Tipos::getTipoAlias($tipo))=='porcentaje')
    		$valor = base64_encode($valor*100);
    	if(strtolower(Tipos::getTipoAlias($tipo))=='nulo')
    		$valor = base64_encode('nulo');
    	if(strtolower(Tipos::getTipoAlias($tipo))=='boleano')
    		$valor = (string) $valor==''?base64_encode('0'):base64_encode(1);
    	
    	return $valor;
    }
    
    public function crearParametro($nombre ='',$descripcion='',$proceso='',$tipo = '',$valor='',$estado=''){
    	
    	if(!$this->verificadorAcceso->validarAcceso(0,1,self::ID_OBJETO)) return false;
    	if($nombre==''||$proceso==''||$valor==''||$tipo==''){
    		$this->mensaje->addMensaje("101","errorEntradaParametrosGeneral",'error');
    		return false;
    	}
    	
    	if($estado=='') $estado = 1;
    	if($tipo=='') $tipo = 1;
    	
    	$parametros['nombre'] = $nombre;
    	if($descripcion!='')	$parametros['descripcion'] = $descripcion;
    	$parametros['proceso'] = $proceso;
    	$parametros['tipo'] = $tipo;
    	
    	$parametros['valor'] = $this->getValorReal($valor,$tipo);
    	if(!$parametros['valor']) return false;
    	
    	$parametros['estado'] = $estado;
    	
    	$ejecutar = $this->registrador->crearParametro($parametros);
    	
    	if(!$ejecutar){
    		
    		return false;
    	}
    	
    	return $ejecutar;
    	
    }
    
    public function actualizarParametro($id = '',$nombre ='',$descripcion='',$proceso='',$tipo = '',$valor='',$estado='',$justificacion = ''){
    	 
    
    	if(!$this->verificadorAcceso->validarAcceso($id,3,self::ID_OBJETO)) return false;
    	if($id==''||is_null($id)||$justificacion == ''||is_null($justificacion)){
    		$this->mensaje->addMensaje("101","errorEntradaParametrosGeneral",'error');
    		return false;
    	}
    	 
    	if($nombre!='')	$parametros['nombre'] = $nombre; 
    	if($descripcion!='')	$parametros['descripcion'] = $descripcion;
    	if($proceso!='')	$parametros['proceso'] = $proceso;
    	if($tipo!='')	$parametros['tipo'] = $tipo;
    	else{
    		//consultar tipo
    		$consulta = $this->registrador->ejecutar(self::ID_OBJETO,array($id),2);
    		$tipo = $consulta[0]['tipo'];
    	}
    	
    	if($valor!=''){
    		$parametros['valor'] = $this->getValorReal($valor,$tipo);
    		$valor = $parametros['valor']; 
    		if(!$parametros['valor']) return false;
    		 
    	}
    	if($estado!='')	$parametros['estado'] = $estado;
    	$parametros['id'] = $id;

    	$parametros['justificacion'] = $justificacion;
    	 
    	if(!$this->registrador->actualizarParametro($parametros)){
    
    		return false;
    	}
    	 
    	return true;
    	 
    }
    
    public function consultarParametro($id = '',$nombre ='',$proceso='',$tipo = '',$estado='',$fecha=''){
    
     
    	if(!$this->verificadorAcceso->validarAcceso($id,2,self::ID_OBJETO)) return false;
    	$parametros =  array();
    	if($nombre!='')	$parametros['nombre'] = $nombre; 
    	//if($descripcion!='')	$parametros['descripcion'] = $descripcion;
    	if($proceso!='')	$parametros['proceso'] = $proceso;
    	if($tipo!='')	$parametros['tipo'] = $tipo;
    	//if($valor!='')	$parametros['valor'] = $valor;
    	if($estado!='')	$parametros['estado'] = $estado;
    	if($id!='') $parametros['id'] = $id;
    	if($fecha!='') $parametros['fecha_registro'] = $fecha;
    	
    	$consulta = $this->registrador->consultarParametro($parametros);
    	
    	if(!$consulta){
    
    		return false;
    	}
    
    	return $this->verificadorAcceso->filtrarPermitidos($consulta);
    
    }
    
    public function activarInactivarParametro($id = ''){
    
    	if(!$this->verificadorAcceso->validarAcceso($id,3,self::ID_OBJETO)) return false;
    	if($id==''||is_null($id)){
    		$this->mensaje->addMensaje("101","errorEntradaParametrosGeneral",'error');
    		return false;
    	}
    
    	$parametros =  array();
    	$parametros['id'] = $id;
    
    	
    	 
    	if(!$this->registrador->activarInactivar($parametros)){
    
    		return false;
    	}
    
    	return true;
    
    }
    
    public function duplicarParametro($id = ''){
    
    	if(!$this->verificadorAcceso->validarAcceso($id,1,self::ID_OBJETO)) return false;
    	if($id==''||is_null($id)){
    		$this->mensaje->addMensaje("101","errorEntradaParametrosGeneral",'error');
    		return false;
    	}
    
    	$parametros =  array();
    	$parametros['id'] = $id;
    
    	 
    
        $ejecutar = $this->registrador->duplicarParametro($parametros);
     	if(!$ejecutar){
    		
    		
    		return false;
    	}
    	
    	return $ejecutar;
    
    }
    


}

?>
