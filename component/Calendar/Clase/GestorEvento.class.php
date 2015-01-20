<?php

namespace component\Calendar\Clase;

use component\Calendar\interfaz\IGestorEvento;
use component\Calendar\Sql;

include_once ('component/Calendar/Interfaz/IGestorEvento.php');
include_once ("core/manager/Configurador.class.php");
include_once ("component/Calendar/Sql.class.php");
class GestorEvento implements IGestorEvento {
	var $miSql;
	function crearEvento($datos) {
		$this->miSql = new Sql ();
		$calendario = json_decode ( $datos, true );
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'insertarEvento', $calendario );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
		if ($resultado == true) {
			$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'eventoCreado' );
		} else {
			$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'errorEventoCreado' );
		}
	}
	function actualizarEvento($datos) {
		$this->miSql = new Sql ();
		$calendario = json_decode ( $datos, true );
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'actualizarEvento', $calendario );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'actualizar' );
		if ($resultado == true) {
			$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'eventoEditado' );
		} else {
			$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'errorEventoEditado' );
		}
	}
	function borrarEvento($datos) {
		$this->miSql = new Sql ();
		$evento = json_decode ( $datos, true );
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'borrarEvento', $evento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'borrar' );
		if ($resultado == true) {
			$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'eventoEliminado' );
		} else {
			$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'errorEventoEliminado' );
		}
	}
	function consultarEvento($id_calendario) {
		$this->miSql = new Sql ();
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'consultarEvento', $id_calendario );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		if ($resultado == FALSE) {
			// echo 'Error en la consulta';
		} else {
			return $resultado;
		}
	}
}
