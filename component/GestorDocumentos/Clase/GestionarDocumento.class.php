<?php

namespace component\GestorDocumentos\Clase;

//include 'component/GestorDocumentos/Interfaz/IGestionarDocumento.php';
use component\GestorDocumentos\interfaz\IGestionarDocumentos as IGestionarDocumentos;


use component\GestorDocumentos\Modelo\Modelo as Modelo;

include_once ("core/builder/Mensaje.class.php");
use \Mensaje as Mensaje;

class GestionarDocumentos implements IGestionarDocumentos {
	
	const PREFIJO = 'file_';
	const TAMANNO_MAX = 5000000000;
	
	private $modelo;
	private $documento;
	private $documentoTipoMIME;
	private $prefijo;
	private $tamannoMaximo;
	private $mensaje;
	
	public function __construct($prefijo = self::PREFIJO, $tamanno = self::TAMANNO_MAX){
		
		$this->documento =  new Modelo('Documento');
		$this->documentoTipoMIME =  new Modelo('DocumentoTipoMIME');
		$this->mensaje =  Mensaje::singleton();
		$this->setPrefijoDocumento($prefijo);
		$this->setTamannoMaximo($tamanno);
	}
	
	public function setPrefijoDocumento($prefijo =self::PREFIJO){
		$this->prefijo = $prefijo;
	}
	
	public function setTamannoMaximo($tamanno =self::TAMANNO_MAX){
		$this->tamannoMaximo = $tamanno;
	}
	
	public function guardarDocumento($nombre, $ruta = 1, $alias = '', $descripcion = '', $etiquetas, $tipoMime, $estadoRegistro = 1){
	   
		if(count($_FILES)<1) {
			$this->mensaje->addMensaje("101","errorVariableArchivoVacia",'error');
			return false;
		}
		
		if(count($_FILES)>1&&$nombre!=''){
			if(!is_array($nombre)||count($nombre)!=count($_FILES)) {
				$this->mensaje->addMensaje("101","errorNombreArray",'error');
				return false;
			}
			
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
		
		foreach ($_FILES as $file){
			$nombre_real = (string) uniqid($this->prefijo).".file"  ;
			$nombre =   basename($file["name"]);
			$extension = pathinfo($file["name"],PATHINFO_EXTENSION);
			$tipo = $file["type"];
			$archivoRuta = $rutaFisica .$nombre_real;
			
			//archivo a guardar existe
			if (file_exists($archivoRuta)){
				$this->mensaje->addMensaje("101","errorArchivoExiste",'error');
				return false;
			}
			
			$size = $file['size'];
			
			if(!$this->revisarTamannoMaximoArchivo($size)) return false;
			
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
		
		if($tipoMime=='*') return true;
		
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
		;
	}
	
	public function validarDocumento($tipoMime, $idDocumento){
		;
	}
	
	public function actualizarDocumento($idDocumento, $nombre, $ruta, $alias, $descripcion, $etiquetas, $tipoMime, $estadoRegistro){
		;
	}
	
	public function consultarDocumento($idDocumento, $nombre, $ruta, $alias, $descripcion, $etiquetas, $tipoMime, $estadoRegistro, $fechaRegistro){
	}
	
	public function archivarDocumento($idDocumento){
		;
	}
	
	public function getListaTipoMIME(){
		;
	}
	
	public function setRuta($idRuta){
		;
	}
	

	
	
}
