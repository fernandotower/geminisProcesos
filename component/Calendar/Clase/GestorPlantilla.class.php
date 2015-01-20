<?php

namespace component\Calendar\Clase;

// use component\Calendar\interfaz\IRegistrador;
use component\Calendar\Sql;
use component\Calendar\interfaz\IGestionarPlantilla;

include_once ('component/Calendar/Interfaz/IGestorPlantilla.php');
include_once ("core/manager/Configurador.class.php");
include_once ("component/Calendar/Sql.class.php");
class GestorPlantilla implements IGestionarPlantilla {
	var $miSql;
	
	/**
	 * (non-PHPdoc)
	 * 
	 * @see \component\Calendar\interfaz\IGestionarCalendario::crearCalendario()
	 */
	/*
	 * function crearPlantilla($datos) { $this->miSql = new Sql (); $plantilla_calendario = json_decode ( $datos, true ); $this->miConfigurador = \Configurador::singleton (); // configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los // datos de config.inc.php $conexion = "academica"; $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion ); $cadenaSql = $this->miSql->cadena_sql ( 'insertarPlantilla', $plantilla_calendario ); $resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' ); return $resultado;//retorna el id del calendario }
	 */
	function consultarPlantillaUsuario($id_usuario) {
		$this->miSql = new Sql ();
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'consultarPlantillaPermiso', $id_usuario ); 
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		
		$this->miSql = new Sql ();
		
		if ($resultado == TRUE) {
			return $resultado;
		} else {
			false;
		}
	}
	function crearPlantilla($datos) {
		$this->miSql = new Sql ();
		$plantilla = json_decode ( $datos, true );
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'insertarPlantilla', $plantilla );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' ); 
		
		return $resultado;
	}
	function registrarPlantillaUsuario($datos) {
		$this->miSql = new Sql ();
		$usuarioPlantilla = json_decode ( $datos, true );
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'insertarPermiso', $usuarioPlantilla );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );

		return $resultado;
	}
	function actualizarPlantilla($datos) {
		$this->miSql = new Sql ();
		$plantilla = json_decode ( $datos, true );
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'actualizarPlantilla', $plantilla );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'actualizar' );
		
		return $resultado;
	}
	
	public function consultarPlantilla($id_plantilla) {
			$this->miSql = new Sql ();		
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'consultarPlantilla', $id_plantilla );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		if ($resultado == TRUE) {			
			//echo 'Consulta exitosa';
			return $resultado[0];
		} else {
			echo 'No existen plantillas para el usuario';
		}
	}
	
}
