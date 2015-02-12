<?php

namespace component\GestorDocumentos\Clase;

//include 'component/GestorDocumentos/Interfaz/IGestionarDocumento.php';
use component\GestorDocumentos\interfaz\IGestionarDocumentos as IGestionarDocumentos;


use component\GestorDocumentos\Modelo\Modelo as Modelo;

include_once ("core/builder/Mensaje.class.php");
use \Mensaje as Mensaje;

class GestionarDocumentos implements IGestionarDocumentos {
	
	const PREFIJO = 'file_';
	const EXTENSION = 'file';
	const TAMANNO_MAX = 5000000000;
	
	private $modelo;
	private $documento;
	private $documentoTipoMIME;
	private $prefijo;
	private $tamannoMaximo;
	private $mensaje;
	private $ruta =  null;
	private $extension;
	
	public function __construct($prefijo = self::PREFIJO, $tamanno = self::TAMANNO_MAX,$extension =self::EXTENSION){
		
		$this->documento =  new Modelo('Documento');
		$this->documentoTipoMIME =  new Modelo('DocumentoTipoMIME');
		$this->mensaje =  Mensaje::singleton();
		$this->setPrefijoDocumento($prefijo);
		$this->setTamannoMaximo($tamanno);
		$this->setExtension($extension);
	}
	
	public function setPrefijoDocumento($prefijo =self::PREFIJO){
		$this->prefijo = $prefijo;
	}
	
	public function setExtension($extension =self::EXTENSION){
		$this->extension = $extension;
	}
	
	public function setTamannoMaximo($tamanno =self::TAMANNO_MAX){
		$this->tamannoMaximo = $tamanno;
	}
	
	private function getNombreReal(){
		return (string) uniqid($this->prefijo).".".$this->extension  ;
	}
	
	
	public function guardarDocumento($ruta = 1, $alias = '', $descripcion = '', $etiquetas, $tipoMime, $estadoRegistro = 1){
	   
		if(count($_FILES)<1) {
			$this->mensaje->addMensaje("101","errorVariableArchivoVacia",'error');
			return false;
		}
		
		if($ruta == ''||$etiquetas == ''||$tipoMime ==''||$estadoRegistro==''){
			$this->mensaje->addMensaje("101","errorParametrosEntrada",'error');
			return false;
		}
		
		$rutaFisica = $this->documento->getRuta($ruta,'id','valor');
		
		//revisa si existe en la bd y se pueda escribir
		if(!$rutaFisica||!is_writable ($rutaFisica)){
			$this->mensaje->addMensaje("101","errorRutaFisica",'error');
			return false;
		}
		$rutaFisica .=DIRECTORY_SEPARATOR;
		
		
		/***
		 * cambiar l siguente bloque por un metodo que se llame procesar archivos
		 * $idDocumento
		 * $rutaFisica
		 * $tipoMime
		 * 
		 * hay que primero hacer actualizarTipoMime
		 */
		
		
		foreach ($_FILES as $file){
			$nombre_real = $this->getNombreReal(); 
			$nombre =   basename($file["name"]);
			$extension = pathinfo($file["name"],PATHINFO_EXTENSION);
			$tipo = $file["type"];
			$size = $file['size'];
			$archivoRuta = $rutaFisica .$nombre_real;
			
			//archivo a guardar existe
			if (file_exists($archivoRuta)){
				$this->mensaje->addMensaje("101","errorArchivoExiste",'error');
				return false;
			}
			
			
			
			if(!$this->revisarTamannoMaximoArchivo($size)) return false;
			
			if($tipoMime=='*') $tipoMime=0;
			if(!$this->revisarFormato($extension , $tipo, $tipoMime)) return false;
			
			
			if(!$this-> moverArchivo($file["tmp_name"], $archivoRuta))return false;
			
			
			//almacenar en documento
			$idDocumento =  $this->documento->crearDocumento($nombre, $alias,$nombre_real,$descripcion, $etiquetas,$ruta,$estadoRegistro);
			
			
			if(!$idDocumento) return false;
			
			//almacenar en documento Tipo MIME
			$arrayTipoMIME = explode(',',$tipoMime);
			
			foreach ($arrayTipoMIME as $tipoId){
				$idDocumentoTipoMIME = $this->documentoTipoMIME->crearDocumentoTipoMIME($idDocumento, $tipoId,$estadoRegistro);
				
				if(!$idDocumentoTipoMIME) return false;
			}
			
			$uploadOk = 1;
			
		}
		
	   return $idDocumento;
	}
	
	private function moverArchivo($origen, $destino){
		
		if($origen==''|$destino=='') return false;
		if (!move_uploaded_file($origen, $destino)){
			$this->mensaje->addMensaje("101","errorMoverArchivo",'error');
			return false;
		}
		
		return true;
	}
	
	private function revisarTamannoMaximoArchivo($size){
		if(is_null($size)||$size=='') return false;
		if ($size > $this->tamannoMaximo) {
			return false;
		}
		return true;
	}
	
	private function revisarFormato($extension , $tipo, $tipoMime){
		
		if($tipo==''||$extension=='') {
			$this->mensaje->addMensaje("101","errorExtensionTipo",'error');
			return false;
		}
		
		if($tipoMime=='*'||$tipoMime==0) return true;
		
		$tipoMimesArray = explode(',',$tipoMime);
		
		
		foreach ($tipoMimesArray as $mimeId){
			
			$mimeExtension = $this->documento->getTipoMIME($mimeId,'id','extension');
			$mimeNombre = $this->documento->getTipoMIME($mimeId,'id','nombre');
			
			if(!$mimeExtension||!$mimeNombre){
				$this->mensaje->addMensaje("101","errorTipoMime",'error');
				return false;
			}
			
			//revisar extension
			$mimeExtensionArray =  explode(',',$mimeExtension);
			
			
			if(!in_array($extension,$mimeExtensionArray)){
				$this->mensaje->addMensaje("101","errorExtension",'error');
				return false;
			}
			
			//revisar tipo MIME
			if($tipo!=$mimeNombre){
				$this->mensaje->addMensaje("101","errorMime",'error');
				return false;
			}
		}
		
		
		return true;
		
		
	}
	
	
	
	
	public function abrirDocumento($idDocumento){
		
		
		//consultar registro documento
		$consulta =  $this->documento->consultarDocumento($idDocumento,'','','','','','',1,'');
		if(!is_array($consulta)) return false;
		
		$nombre_real = $consulta[0]['nombre_real'];
		$nombre = $consulta[0]['nombre'];;
		$alias = $consulta[0]['alias'];
		$idRuta = $consulta[0]['ruta_id'];
		
		$rutaL = $this->documento->getRuta($idRuta,'id','valor');
		if(!$rutaL) return false;
		$rutaL .=DIRECTORY_SEPARATOR;
		
		$extension  = pathinfo($nombre,PATHINFO_EXTENSION);;
		$file = $rutaL.$nombre_real;
		
		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.$nombre.'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			readfile($file);
			exit;
		}else {
			$this->mensaje->addMensaje("101","errorLocalizacionArchivo",'error');
			return false;
		}
		
	}
	
	//no se va a usar
	public function validarDocumento($tipoMime, $idDocumento){
		;
	}
	
	public function actualizarDocumento($idDocumento, $nombre = '', $ruta = '', $alias = '', $descripcion = '', $etiquetas = '', $tipoMime = '', $estadoRegistro = ''){
		
		if($idDocumento=='') return false;
		
		;
	}
	
	public function actualizarTiposMIME($idDocumento,$tipoMime){
		
	}
	
	public function moverDocumento($idDocumento, $idRutaDestino , $nombreDestino = ''){
		
		
		//consultar registro documento
		$consulta =  $this->documento->consultarDocumento($idDocumento,'','','','','','',1,'');
		if(!is_array($consulta)) return false;
		
		$nombre_real = $consulta[0]['nombre_real'];
		$nombre = $consulta[0]['nombre'];;
		$alias = $consulta[0]['alias'];
		$idRuta = $consulta[0]['ruta_id'];
		$estadoRegistroId = $consulta[0]['estado_registro_id'];
		$rutaL = $this->documento->getRuta($idRuta,'id','valor');
		if(!$rutaL) return false;
		$rutaL .=DIRECTORY_SEPARATOR;
		
		$rutaDestino = $this->documento->getRuta($idRutaDestino,'id','valor');
		if(!$rutaArchivar) return false;
		$rutaArchivar .=DIRECTORY_SEPARATOR;
		
		$extension  = pathinfo($nombre,PATHINFO_EXTENSION);
		$origen = $rutaL.$nombre_real;
		
		if($nombreDestino!=''&&$nombreDestino!='.old') {
			$nombre_real =  $this->getNombreReal();
			$destino = $rutaL.$nombre_real;
			$nombre = $nombreDestino;
		}elseif ($nombreDestino==".old") {
			$nombre_real =  $this->getNombreReal();
			$destino = $rutaL.$nombre_real.".old";
			$nombre = $nombre_real.".old";
			$estadoRegistroId = 2;
		}else{
			$nombre_real =  $this->getNombreReal();
			$destino = $rutaL.$nombre_real;
			
		}
		
		if (!file_exists($origen)) {
			$this->mensaje->addMensaje("101","errorLocalizacionArchivo",'error');
			return false;
		}
		
		if(!$this->moverArchivo($origen, $destino)) return false;
		
		return $this->documento->actualizarDocumento($idDocumento,$nombre, '',$nombre_real,'','',$idRutaDestino,  $estadoRegistroId);
		
		
	}
	
	public function consultarDocumento($idDocumento = '', $nombre = '', $ruta = '', $alias = '', $etiquetas = '', $tipoMime='', $estadoRegistro = '', $fechaRegistro = ''){
	
	}
	
	public function archivarDocumento($idDocumento){
		
		//cambia de ruta, nombre y 
		if(!$this->moverDocumento($idDocumento, 0 , '.old' )) return false;
		
		// eliminar.... falta eliminar los tipos mimes
		
		return $this->documento->eliminarDocumentoTipoMIME($idDocumento)
		       &&$this->documento->eliminarDocumento($idDocumento);
		
	}
	
	public function getListaTipoMIME(){
		return $this->documento->getListaTipoMIME() ;
	}
	
	public function setRuta($idRuta){
		$this->ruta = $idRuta;
	}
	

	
	
}
