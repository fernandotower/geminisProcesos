<?php

namespace component\GestorDocumentos;

use component\Component;

include 'component/GestorDocumentos/Interfaz/IGestorDocumentos.php';
use component\GestorDocumentos\interfaz\IGestionarDocumentos as IGestionarDocumentos;

include 'component/GestorDocumentos/Clase/GestionarDocumento.class.php';
use component\GestorDocumentos\Modelo\GestionarDocumentos as GestorDocumentos;


include 'component/GestorDocumentos/Modelo/Modelo.class.php';
use component\GestorDocumentos\Modelo\Modelo as Modelo;



require_once ('component/Component.class.php');
class Componente extends Component implements IGestionarDocumentos {
	private $miGestor;
	
	
	// El componente actua como Fachada
	
	/**
	 * un objeto de la clase GestorProcesos
	 */
	public function __construct() {
		$this->miGestor = new GestorDocumentos ();
		
	}
	
	public function guardarDocumento($nombre, $ruta, $alias = '', $descripcion = '', $etiquetas, $tipoMime, $estadoRegistro = 1){
		return $this->miGestor->guardarDocumento($nombre, $ruta, $alias, $descripcion, $etiquetas, $tipoMime, $estadoRegistro) ;
	}
	
	
	public function abrirDocumento($idDocumento){
		return $this->miGestor->abrirDocumento($idDocumento);
	}
	
	public function validarDocumento($tipoMime, $idDocumento){
		return $this->miGestor->validarDocumento($tipoMime, $idDocumento);
	}
	
	public function actualizarDocumento($idDocumento, $nombre = '', $ruta = '', $alias = '', $descripcion = '', $etiquetas = '', $tipoMime = '', $estadoRegistro = ''){
		return $this->miGestor->actualizarDocumento($idDocumento, $nombre, $ruta, $alias, $descripcion, $etiquetas, $tipoMime, $estadoRegistro);
	}
	
	public function consultarDocumento($idDocumento='', $nombre='', $ruta = '', $alias, $descripcion, $etiquetas, $tipoMime, $estadoRegistro, $fechaRegistro){
		return $this->miGestor->consultarDocumento($idDocumento, $nombre, $ruta, $alias, $descripcion, $etiquetas, $tipoMime, $estadoRegistro, $fechaRegistro);
	}
	
	public function archivarDocumento($idDocumento){
		return $this->miGestor->archivarDocumento($idDocumento);
	}
	
	public function getListaTipoMIME(){
		return $this->miGestor->getListaTipoMIME;
	}
	
	public function setRuta($idRuta){
		return $this->miGestor->setRuta($idRuta);
	}
	
}


