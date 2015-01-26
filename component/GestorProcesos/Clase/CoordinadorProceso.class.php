<?php

namespace component\GestorProcesos\Clase;

<<<<<<< HEAD
use component\gestorprocesos\interfaz\ICoordinarProceso;
=======
>>>>>>> branch 'master' of https://github.com/fernandotower/geminisProcesos.git

include_once ('component/GestorProcesos/Interfaz/ICoordinadorProceso.php');
<<<<<<< HEAD
include_once ("core/manager/Configurador.class.php");
include_once ("component/GestorUsuarios/Sql.class.php");
class CoordinadorProceso implements ICoordinarProceso {
=======
use component\GestorProcesos\Interfaz\ICoordinadorProceso as ICoordinadorProceso; 

class CoordinadorProceso implements ICoordinadorProceso {
>>>>>>> branch 'master' of https://github.com/fernandotower/geminisProcesos.git
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
