<?php

namespace component\GestorDocumentos\Clase;

include_once ('component/GestorDocumentos/Interfaz/IGestionarDocumentos.php');
use component\GestorDocumentos\interfaz\IGestionarDocumentos;


use component\GestorDocumentos\Modelo\Modelo as Modelo;

class GestionarDocumentos implements IGestionarDocumentos {
	
	public function guardarDocumento($nombre, $ruta, $alias, $descripcion, $etiquetas, $tipoMime, $estadoRegistro){
	   var_dump($_FILES);
	   return 1;
	}
	
	
	public function abrirDocumento($idDocumento);
	
	public function validarDocumento($tipoMime, $idDocumento);
	
	public function actualizarDocumento($idDocumento, $nombre, $ruta, $alias, $descripcion, $etiquetas, $tipoMime, $estadoRegistro);
	
	public function consultarDocumento($idDocumento, $nombre, $ruta, $alias, $descripcion, $etiquetas, $tipoMime, $estadoRegistro, $fechaRegistro);
	
	public function archivarDocumento($idDocumento);
	
	public function getListaTipoMIME();
	
	public function setRuta($idRuta);
	

	
	
}
