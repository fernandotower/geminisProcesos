<?php

namespace component\Calendar\Clase;

use component\Calendar\interfaz\IGestorEventoPlantilla;
use component\Calendar\Sql;

include_once ('component/Calendar/Interfaz/IGestorEventoPlantilla.php');
include_once ("core/manager/Configurador.class.php");
include_once ("component/Calendar/Sql.class.php");
class GestorEventoPlantilla implements IGestorEventoPlantilla {
	var $miSql;
	function crearEventoPlantilla($datos) {
		$this->miSql = new Sql ();
		$eventoPlantilla = json_decode ( $datos, true );
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'insertarEventoPlantilla', $eventoPlantilla ); 
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
		
		return $resultado;
	}
	
	function borrarEventoPlantilla($datos) {
				
		$this->miSql = new Sql ();
		$eventoPlantilla = json_decode ( $datos, true );

		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
		$cadenaSql = $this->miSql->cadena_sql ( 'borrarEventoPlantilla', $eventoPlantilla );  //echo $cadenaSql;exit;
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
		
		
		if ($resultado==TRUE) {
			$cadenaSql = $this->miSql->cadena_sql ( 'borrarRelacionEventoPlantilla', $eventoPlantilla );
			$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'borrar' );			
			return $resultado;
		} else {
			return FALSE;
		}
	}
	function actualizarEventoPlantilla($datos) {
		
		$this->miSql = new Sql ();
		$eventoPlantilla = json_decode ( $datos, true );
	
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
		$cadenaSql = $this->miSql->cadena_sql ( 'actualizarEventoPlantilla', $eventoPlantilla );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
		
		return $resultado;
		
	}
	function crearRelacionEventos($datos) {
		$this->miSql = new Sql ();
		$relacionEventos = json_decode ( $datos, true );
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		// consultar posicion evento1
		$cadenaSqlPosicion = $this->miSql->cadena_sql ( 'consultarPosicionEvento1', $relacionEventos ['id_evento1'] );
		$resultadoPosicion = $esteRecursoDB->ejecutarAcceso ( $cadenaSqlPosicion, 'busqueda' );
		
		
		if (!is_array($resultadoPosicion)) {
			$relacionEventos ['posicion'] = 1;
		} else {
			$relacionEventos ['posicion'] = $resultadoPosicion [0] [0] + 1;
		}
		
		$cadenaSql = $this->miSql->cadena_sql ( 'insertarRelacionEventos', $relacionEventos ); 
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );

		return $resultado;
	}
	
	function actualizarRelacionEventos($datos) {
				
		$this->miSql = new Sql ();
		$relacionEventos = json_decode ( $datos, true );
	
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
		// consultar posicion evento1
		$cadenaSqlPosicion = $this->miSql->cadena_sql ( 'consultarPosicionEvento1', $relacionEventos ['id_evento1'] );
		$resultadoPosicion = $esteRecursoDB->ejecutarAcceso ( $cadenaSqlPosicion, 'busqueda' );
	
	
		if (!is_array($resultadoPosicion)) {
			$relacionEventos ['posicion'] = 1;
		} else {
			$relacionEventos ['posicion'] = $resultadoPosicion [0] [0] + 1;
		}
			
		$cadenaSql = $this->miSql->cadena_sql ( 'actualizarRelacionEventos', $relacionEventos );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'actualizar' );
		if ($resultado == true) {
			//echo 'Registro exitoso';
			return true;
		} else {
			echo 'Error en la consulta';
		}
	}
	function consultarRelacionEventos($id_plantilla) {
		$this->miSql = new Sql ();
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'consultarRelacionEventos', $id_plantilla );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		
		if ($resultado == FALSE) {
			//echo 'Error en la consulta';
		} else {
			return $resultado;
		}
	}
	
	/*
	 * function actualizarEvento($datos) { $this->miSql=new Sql(); $calendario=json_decode($datos,true); $this->miConfigurador = \Configurador::singleton (); //configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los //datos de config.inc.php $conexion = "academica"; $esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion); $cadenaSql = $this->miSql->cadena_sql ('actualizarEvento',$calendario ); $resultado=$esteRecursoDB->ejecutarAcceso($cadenaSql,'actualizar'); if ($resultado==TRUE){ echo 'Actualización exitosa'; } else{ echo 'Error en la consulta'; } } function borrarEvento($datos) { $this->miSql=new Sql(); $evento=json_decode($datos,true); $this->miConfigurador = \Configurador::singleton (); //configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los //datos de config.inc.php $conexion = "academica"; $esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion); $cadenaSql = $this->miSql->cadena_sql ( 'borrarEvento',$evento ); $resultado=$esteRecursoDB->ejecutarAcceso($cadenaSql,'borrar'); if ($resultado==TRUE){ echo 'Evento: Cambio de estado exitoso'; } else{ echo 'Error en la consulta'; } }
	 */
	function consultarEventosPlantilla($id_plantilla) {
		$this->miSql = new Sql ();
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'consultarEventosPlantilla', $id_plantilla );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		
		if ($resultado == FALSE) {
			// echo 'Error en la consulta';
		} else {
			return $resultado;
		}
	}
	
	function consultarEventoPlantilla($id_eventoplantilla) {
		$this->miSql = new Sql ();
	
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
		$cadenaSql = $this->miSql->cadena_sql ( 'consultarEventoPlantilla', $id_eventoplantilla );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
	
		if ($resultado == FALSE) {
			// echo 'Error en la consulta';
		} else {
			return $resultado[0];
		}
	}
	
	
}
