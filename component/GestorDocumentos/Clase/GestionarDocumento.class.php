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
	
	private function getRutaFisisca($ruta){
		
		$rutaFisica = $this->documento->getRuta($ruta,'id','valor');
		
		//revisa si existe en la bd y se pueda escribir
		if(!$rutaFisica||!is_writable ($rutaFisica)){
		
			$this->mensaje->addMensaje("101","errorRutaFisica",'error');
			return false;
				
		}
		
		$rutaFisica .=DIRECTORY_SEPARATOR;
		
		return $rutaFisica;
	}
	
	
	private function guardarArchivo($file = '',$ruta = 1, $alias = '', $descripcion = '', $etiquetas, $tipoMime, $estadoRegistro = 1){
		if(!is_array($file)) return false;
		
		$rutaFisica = $this->getRutaFisisca($ruta);
		if(!$rutaFisica) return false;
		
		
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
			
		if(!$this->crearDocumentoTipoMIME($idDocumento, $tipoMime,$estadoRegistro)) return false;
		
		
		return $idDocumento;
		
	}
	
	
	public function guardarDocumento($nombre_html = '',$ruta = 1, $alias = '', $descripcion = '', $etiquetas, $tipoMime, $estadoRegistro = 1){
	   
		
		if($ruta == ''||$etiquetas == ''||$tipoMime ==''||$estadoRegistro==''){
			
			$this->mensaje->addMensaje("101","errorParametrosEntrada",'error');
			return false;
			
		}
		
		
		if($nombre_html !==''&&!is_null($nombre_html)){
			
			if(!isset($_FILES[$nombre_html])){
				$this->mensaje->addMensaje("101","errorNombreHTML",'error');
				return false;
			}
			
			$file = $_FILES[$nombre_html];
			
			
			$guardar =$this-> guardarArchivo($file,$ruta, $alias, $descripcion, $etiquetas, $tipoMime, $estadoRegistro);

			if($guardar === false) return false;
			
			return $guardar;
		}
		

		$resultados =  array();
		
		foreach ($_FILES as $file){
			
			$guardar =$this-> guardarArchivo($file,$ruta, $alias, $descripcion, $etiquetas, $tipoMime, $estadoRegistro);

			
			if($guardar === false) return false;
			$resultados[] =  $guardar;
			
		}
		
		if(count($resultados)===0) return false;
		if(count($resultados)==1) return $resultados[0]; 
	    else return $resultados;
	}
		
	public function crearDocumentoTipoMIME($idDocumento, $tipoMime,$estadoRegistro){
		
		//almacenar en documento Tipo MIME
		$arrayTipoMIME = explode(',',$tipoMime);
			
		foreach ($arrayTipoMIME as $tipoId){
			$idDocumentoTipoMIME = $this->documentoTipoMIME->crearDocumentoTipoMIME($idDocumento, $tipoId,$estadoRegistro);
		    
			if(!$idDocumentoTipoMIME) return false;
		}
		
		return true;
	}
	
	private function moverArchivo($origen, $destino){
		
		if($origen===''|$destino==='') return false;
		
		//copia
		if (copy($origen, $destino)) {
			$delete[] = $origen;
		}else{
			$this->mensaje->addMensaje("101","errorMoverArchivo",'error');
			return false;
			
		}
		
		//elimina
		foreach ( $delete as $file ) {
			unlink( $file );
		}
		
		return true;
		
	}
	
	
	private function revisarTamannoMaximoArchivo($size){
		if(is_null($size)||$size==='') return false;
		if ($size > $this->tamannoMaximo) {
			return false;
		}
		return true;
	}
	
	private function revisarFormato($extension , $tipo, $tipoMime){
		
		if($tipo===''||$extension==='') {
			$this->mensaje->addMensaje("101","errorExtensionTipo",'error');
			return false;
		}
		
		
		
		if($tipoMime=='*'||$tipoMime==0) return true;
		
		$tipoMimesArray = explode(',',$tipoMime);
		
		
		$validacionExtension =  false;
		$validacionMIME =  false;
		
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
				
			}
			$validacionExtension =  true;
			
			
			//revisar tipo MIME
			if($tipo!=$mimeNombre){
				$this->mensaje->addMensaje("101","errorMime",'error');
				
			}
			
			$validacionMIME =  true;
			
			if($validacionMIME===true&&$validacionExtension==true) return true;
		}
		
		
		return false;
		
		
	}
	
	
	
	
	public function abrirDocumento($idDocumento){
		
		
		//consultar registro documento
		$consulta =  $this->documento->consultarDocumento($idDocumento,'','','','','',1,'');
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
	
	
	public function validarDocumento($tipoMime, $idDocumento){
		
		/***
		 * es enecesario habilitar la extension 
		 * extension=php_fileinfo.dll
		 * extension=php_fileinfo.so
		 */
		
		//consultar registro documento
		$consulta =  $this->documento->consultarDocumento($idDocumento,'','','','','',1,'');
		if(!is_array($consulta)) return false;
		
		$nombre_real = $consulta[0]['nombre_real'];
		$nombre = $consulta[0]['nombre'];;
		$alias = $consulta[0]['alias'];
		$idRuta = $consulta[0]['ruta_id'];
		$extension = pathinfo($nombre,PATHINFO_EXTENSION);
		
		$rutaL = $this->documento->getRuta($idRuta,'id','valor');
		if(!$rutaL) return false;
		$rutaL .=DIRECTORY_SEPARATOR;
		
		$extension  = pathinfo($nombre,PATHINFO_EXTENSION);;
		$file = $rutaL.$nombre_real;
		
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$tipo =  finfo_file($finfo, $file);
		finfo_close($finfo);
		
		if($tipoMime=='*') $tipoMime=0;
		if(!$this->revisarFormato($extension , $tipo, $tipoMime)) return false;
			
		return true;
		
	}
	
	public function actualizarDocumento($idDocumento, $nombre = '', $ruta = '', $alias = '', $descripcion = '', $etiquetas = '', $tipoMime = '', $estadoRegistro = ''){
		
		if($idDocumento=='') return false;
		
		
		if($ruta!=''&&!is_null($ruta)){
			if(!$this->moverDocumento($idDocumento, $ruta )) return false;
		}
		
		if($tipoMime!==''
				&&!is_null($tipoMime)
				&&$this->validarDocumento($tipoMime, $idDocumento)){
			
			if(!$this->actualizarTiposMIME($idDocumento,$tipoMime))		return false;
			
		}
		
		if($nombre!==''
				||$alias!==''
				||$descripcion!==''
				||$etiquetas!==''
				||$estadoRegistro!==''){
			$actualizacion = $this->documento->actualizarDocumento($idDocumento,$nombre, $alias,'',$descripcion,$etiquetas,'',  $estadoRegistro);
			if($actualizacion===false) return false;
		}
		
		
		return true;
		
	}

	
	public function actualizarTiposMIME($idDocumento,$tipoMime){
		
		
		if(!$this->eliminarTiposMIME($idDocumento)) return false;
		if(!$this->crearDocumentoTipoMIME($idDocumento, $tipoMime,1)) return false;
		
		return true;
		
	}
	
	
	
	public function eliminarTiposMIME($idDocumento){
		$consulta =  $this->documentoTipoMIME->consultarDocumentoTipoMIME('',$idDocumento,'',1);
		if(!$consulta) return false;
		
		//extraer ids
		$listaIds =  array();
		foreach ($consulta as $fila){
			$listaIds[] = $fila['id'];
			if(!$this->documentoTipoMIME->eliminarDocumentoTipoMIME($fila['id'])) return false;
		}
		
		return true;
	}
	
	public function moverDocumento($idDocumento, $idRutaDestino , $nombreDestino = ''){
		
		
		//consultar registro documento
		$consulta =  $this->documento->consultarDocumento($idDocumento,'','','','','',1,'');
		
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
		if(!$rutaDestino) return false;
		$rutaDestino .=DIRECTORY_SEPARATOR;
		
		$extension  = pathinfo($nombre,PATHINFO_EXTENSION);
		$origen = $rutaL.$nombre_real;
		
		if($nombreDestino!=''&&$nombreDestino!='.old') {
			$nombre_real =  $this->getNombreReal();
			$destino = $rutaDestino.$nombre_real;
			$nombre = $nombreDestino;
		}elseif ($nombreDestino==".old") {
			$nombre_real =  $this->getNombreReal();
			$destino = $rutaDestino.$nombre_real.".old";
			$nombre = $nombre_real.".old";
			$estadoRegistroId = 2;
		}else{
			$nombre_real =  $this->getNombreReal();
			$destino = $rutaDestino.$nombre_real;
			
		}
		
		if (!file_exists($origen)) {
			$this->mensaje->addMensaje("101","errorLocalizacionArchivo",'error');
			return false;
		}
		
		if(!$this->moverArchivo($origen, $destino)) return false;
		
		return $this->documento->actualizarDocumento($idDocumento,$nombre, '',$nombre_real,'','',$idRutaDestino,  $estadoRegistroId);
		
		
	}
	
	public function consultarDocumento($idDocumento = '', $nombre = '', $ruta = '', $alias = '', $etiquetas = '', $tipoMime='', $estadoRegistro = '', $fechaRegistro = ''){
	
		//etiquetas lo debe hacer como un like
		
		return 
		  $this->documento->consultarDocumento($idDocumento,$nombre, $alias,'', $etiquetas,$ruta,$estadoRegistro, $fechaRegistro);
	}
	
	public function archivarDocumento($idDocumento){
		
		//cambia de ruta, nombre y 
		if(!$this->moverDocumento($idDocumento, 0 , '.old' )) return false;
		
		
		return $this->eliminarTiposMIME($idDocumento)
		       &&$this->documento->eliminarDocumento($idDocumento);
		
	}
	
	public function getListaTipoMIME(){
		return $this->documento->getListaTipoMIME() ;
	}
	
	public function setRuta($idRuta){
		$this->ruta = $idRuta;
	}
	

	
	
}
