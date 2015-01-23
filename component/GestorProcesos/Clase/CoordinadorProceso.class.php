<?php

namespace component\GestorProcesos\Clase;


include_once ('component/GestorProcesos/Interfaz/ICoordinadorProceso.php');
use component\GestorProcesos\Interfaz\ICoordinadorProceso as ICoordinadorProceso; 

class CoordinadorProceso implements ICoordinadorProceso {
	var $miSql;
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::crearCalendario()
	 */
	
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
