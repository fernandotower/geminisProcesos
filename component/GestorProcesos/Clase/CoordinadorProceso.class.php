<?php

namespace component\GestorProcesos\clase;

use component\GestorUsuarios\interfaz\IGestionarUsuarios;
use component\GestorUsuarios\Sql;

include_once ('component/GestorUsuarios/Interfaz/IGestorUsuarios.php');
include_once ("core/manager/Configurador.class.php");
include_once ("component/GestorUsuarios/Sql.class.php");
class GestorUsuarios implements IGestionarUsuarios {
	var $miSql;
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::crearCalendario()
	 */
	function consultarProcesos($tipo) {
		$usuarios [] = [ 
				"id_usuario" => "79709508",
				"nombre_usuario" => "Luis Fernando Torres" 
		];
		$usuarios [] = [ 
				"id_usuario" => "79709509",
				"nombre_usuario" => "Gerardo Bermudez" 
		];
		$usuarios [] = [ 
				"id_usuario" => "79709507",
				"nombre_usuario" => "Jorge Salamanca" 
		];
		$usuarios [] = [ 
				"id_usuario" => "79709506",
				"nombre_usuario" => "Rafael Salamanca" 
		];
		$usuarios [] = [ 
				"id_usuario" => "79709505",
				"nombre_usuario" => "Jorge Santos" 
		];
		$usuarios [] = [ 
				"id_usuario" => "79709504",
				"nombre_usuario" => "Javier Salamanca" 
		];
		$usuarios [] = [ 
				"id_usuario" => "79709503",
				"nombre_usuario" => "Jorge Otálora" 
		];
		$usuarios [] = [ 
				"id_usuario" => "79709502",
				"nombre_usuario" => "William Salamanca" 
		];
		$usuarios [] = [ 
				"id_usuario" => "79709600",
				"nombre_usuario" => "Santiago Salamanca" 
		];
		$usuarios [] = [ 
				"id_usuario" => "79709601",
				"nombre_usuario" => "William Bermudez" 
		];
		$usuarios [] = [ 
				"id_usuario" => "79709501",
				"nombre_usuario" => "Orlando Acosta" 
		];
		
		return $usuarios;
		
		$this->miSql = new Sql ();
	
	/**
	 * $calendario = json_decode ( $datos, true );
	 *
	 * $this->miConfigurador = \Configurador::singleton ();
	 * // configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
	 * // datos de config.inc.php
	 * $conexion = "academica";
	 * $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	 *
	 * $cadenaSql = $this->miSql->cadena_sql ( 'insertarCalendario', $calendario );
	 * $resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
	 *
	 * if ($resultado == TRUE) {
	 * $this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'calendarioCreado' );
	 * } else {
	 * $this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'errorCalendarioCreado' );
	 * }
	 *
	 * return $resultado;
	 */
	}
}
