<?php

namespace calendario\calendarioLista;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/builder/InspectorHTML.class.php");
include_once ("core/builder/Mensaje.class.php");
include_once ("core/crypto/Encriptador.class.php");

// Esta clase contiene la logica de negocio del bloque y extiende a la clase funcion general la cual encapsula los
// metodos mas utilizados en la aplicacion

// Para evitar redefiniciones de clases el nombre de la clase del archivo funcion debe corresponder al nombre del bloque
// en camel case precedido por la palabra Funcion
class Funcion {
	var $sql;
	var $funcion;
	var $lenguaje;
	var $ruta;
	var $miConfigurador;
	var $error;
	var $miRecursoDB;
	var $crypto;
	function verificarCampos() {
		include_once ($this->ruta . "/funcion/verificarCampos.php");
		if ($this->error == true) {
			return false;
		} else {
			return true;
		}
	}
	function consultarCalendario() {
		include_once ($this->ruta . "funcion/ConsultorCalendario.class.php");
		
		return $resultado;
	}
	function actualizarCalendario() {
		include_once ($this->ruta . "funcion/ActualizadorCalendario.class.php");
		
		return $resultado;
	}
	function actualizarEvento() {
		include_once ($this->ruta . "funcion/ActualizadorEvento.class.php");
		
		return $resultado;
	}
	function crearCalendario() {
		include_once ($this->ruta . "funcion/CreadorCalendario.class.php");
		
		return $resultado;
	}
	function crearCalendarioConPlantilla() {
		include_once ($this->ruta . "funcion/CreadorCalendarioConPlantilla.class.php");
		
		return $resultado;
	}
	function duplicarCalendario() {
		include_once ($this->ruta . "funcion/DuplicadorCalendario.class.php");
		
		return $resultado;
	}
	function crearEvento() {
		include_once ($this->ruta . "funcion/CreadorEvento.class.php");
		
		return $resultado;
	}
	function borrarEvento() {
		include_once ($this->ruta . "funcion/BorradorEvento.class.php");
		
		return $resultado;
	}
	
	function editarPermiso() {
		include_once ($this->ruta . "funcion/ActualizadorPermiso.class.php");
	
		return $resultado;
	}
	
	function redireccionar() {
		include_once ($this->ruta . "funcion/Cancelador.class.php");
		return $resultado;
	}
	function procesarAjax() {
		include_once ($this->ruta . "funcion/procesarAjax.php");
	}
	function action() {
		$resultado = true;
		
		// Aquí se coloca el código que procesará los diferentes formularios que pertenecen al bloque
		// aunque el código fuente puede ir directamente en este script, para facilitar el mantenimiento
		// se recomienda que aqui solo sea el punto de entrada para incluir otros scripts que estarán
		// en la carpeta funcion
		
		// Importante: Es adecuado que sea una variable llamada opcion o action la que guie el procesamiento:
		
		if (isset ( $_REQUEST ['procesarAjax'] )) {
			$this->procesarAjax ();
		} elseif (isset ( $_REQUEST ['opcion'] )) {
			switch ($_REQUEST ['opcion']) {
				case 'consultarCalendario' :
					$resultado = $this->consultarCalendario ();
					break;
				
				case 'actualizarCalendario' :
					$resultado = $this->actualizarCalendario ();
					break;
				
				case 'actualizarEvento' :
					$resultado = $this->actualizarEvento ();
					break;
				
				case 'crearCalendario' :
					$resultado = $this->crearCalendario ();
					break;
				
				case 'crearCalendarioConPlantilla' :
					$resultado = $this->crearCalendarioConPlantilla ();
					break;
				
				case 'duplicarCalendario' :
					$resultado = $this->duplicarCalendario ();
					break;
				
				case 'crearEvento' :
					$resultado = $this->crearEvento ();
					break;
				
				case 'borrarEvento' :
					$resultado = $this->borrarEvento ();
					break;
				
				case 'editarPermiso' :
					$resultado = $this->editarPermiso ();
					break;
				
				default :
					return false;
					exit ();
			}
		}
		
		return $resultado;
	}
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->ruta = $this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );
		
		$this->miMensaje = \Mensaje::singleton ();
		
		$conexion = "aplicativo";
		$this->miRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		if (! $this->miRecursoDB) {
			
			$this->miConfigurador->fabricaConexiones->setRecursoDB ( $conexion, "tabla" );
			$this->miRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		}
	}
	public function setRuta($unaRuta) {
		$this->ruta = $unaRuta;
	}
	function setSql($a) {
		$this->sql = $a;
	}
	function setFuncion($funcion) {
		$this->funcion = $funcion;
	}
	public function setLenguaje($lenguaje) {
		$this->lenguaje = $lenguaje;
	}
	public function setFormulario($formulario) {
		$this->formulario = $formulario;
	}
}

?>
