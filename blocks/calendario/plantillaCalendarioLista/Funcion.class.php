<?php

namespace calendario\plantillaCalendarioLista;



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
	function consultarPlantillaCalendario() {
		include_once ($this->ruta . "funcion/ConsultorPlantillaCalendario.class.php");
		
		return $resultado;
	}
	function actualizarPlantilla() {
		include_once ($this->ruta . "funcion/ActualizadorPlantilla.class.php");
		
		return $resultado;
	}
	function editarPlantillaEvento() {
		include_once ($this->ruta . "funcion/ActualizadorPlantillaEvento.class.php");
		
		return $resultado;
	}
	function crearPlantilla() {
		include_once ($this->ruta . "funcion/CreadorPlantilla.class.php");
		
		return $resultado;
	}
	function duplicarPlantilla() {
		include_once ($this->ruta . "funcion/DuplicadorPlantilla.class.php");
		
		return $resultado;
	}
	function crearPlantillaEvento() {
		include_once ($this->ruta . "funcion/CreadorPlantillaEvento.class.php");
		
		return $resultado;
	}
	function borrarPlantillaEvento() {
		include_once ($this->ruta . "funcion/BorradorPlantillaEvento.class.php");
		
		return $resultado;
	}
	function crearIntervaloTiempo() {
		include_once ($this->ruta . "funcion/CreadorIntervaloTiempo.class.php");
	
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
				case 'consultarPlantillaCalendario' :
					$resultado = $this->consultarPlantillaCalendario ();
					break;
				
				case 'actualizarPlantilla' :
					$resultado = $this->actualizarPlantilla ();
					break;
				
				case 'editarPlantillaEvento' :
					$resultado = $this->editarPlantillaEvento ();
					break;
				
				case 'crearPlantilla' :
					$resultado = $this->crearPlantilla ();
					break;
				
				case 'duplicarPlantilla' :					
					$resultado = $this->duplicarPlantilla ();
					break;
				
				case 'crearPlantillaEvento' :
					$resultado = $this->crearPlantillaEvento ();
					break;
				
				case 'borrarPlantillaEvento' :
					$resultado = $this->borrarPlantillaEvento ();
					break;
				
				case 'crearIntervaloTiempo' :
					$resultado = $this->crearIntervaloTiempo ();
					break;
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
