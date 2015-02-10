<?php
namespace component\GestorDocumentos\interfaz;

interface IGestionarDocumentos{

	public function guardarDocumento($nombre, $ruta, $alias, $descripcion, $etiquetas, $tipoMime, $estadoRegistro);
	
	
	public function abrirDocumento($idDocumento);
	
	public function validarDocumento($tipoMime, $idDocumento);
	
	public function actualizarDocumento($idDocumento, $nombre, $ruta, $alias, $descripcion, $etiquetas, $tipoMime, $estadoRegistro);
	
	public function consultarDocumento($idDocumento, $nombre, $ruta, $alias, $descripcion, $etiquetas, $tipoMime, $estadoRegistro, $fechaRegistro);
	
	public function archivarDocumento($idDocumento);
	
	public function getListaTipoMIME();
	
	public function setRuta($idRuta);
	
}


?>