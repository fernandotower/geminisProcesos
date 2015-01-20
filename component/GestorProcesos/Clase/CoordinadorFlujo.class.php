<?php

namespace component\GestorProcesos\Clase;

use component\GestorProcesos\interfaz\ICoordinarFlujo;
use component\GestorUsuarios\Sql;

include_once ('component/GestorProcesos/Interfaz/ICoordinadorFlujo.php');
include_once ("core/manager/Configurador.class.php");
include_once ("component/GestorProcesos/Sql.class.php");
class CoordinadorFlujo implements ICoordinarFlujo {
	var $miSql;
	

	public function ejecutar($valor) {
		
	}
	public function ejecutarEventoInicio($valor) {
		
	}
	public function ejecutarEventoIntermedio($valor) {
		
	}
	public function ejecutarEventoFin($valor) {
	
	}
	public function ejecutarTareaHumana($valor) {
		
	}
	public function ejecutarTareaServicio($valor) {
		
	}
	public function ejecutarTareaLlamada($valor) {
		
	}
	public function ejecutarTareaRecibirMensaje($valor) {
		
	}
	public function ejecutarTareaEnviarMensaje($valor) {
		return $this->miFlujo->ejecutar ( $valor );
	}
	public function ejecutarTareaScript($valor) {
		return $this->miFlujo->ejecutar ( $valor );
	}
	public function ejecutarTareaTemporizador($valor) {
		return $this->miFlujo->ejecutar ( $valor );
	}
	public function ejecutarCompuertaOr($valor) {
		return $this->miFlujo->ejecutar ( $valor );
	}
	public function ejecutarCompuertaXor($valor) {
		return $this->miFlujo->ejecutar ( $valor );
	}
	public function ejecutarCompuertaAnd($valor) {
		return $this->miFlujo->ejecutar ( $valor );
	}
	
	/**

	function ejecutar($valor) {
		
		echo 'Este método inicia la ejecución del flujo';
		
		
		 * Conexión a la base de datos
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
		 
	}*/
	
	
	
}
