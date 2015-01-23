<?php

namespace component\GestorProcesos\Clase;

use component\GestorProcesos\interfaz\ICoordinadorFlujo;


include_once ('component/GestorProcesos/Interfaz/ICoordinadorFlujo.php');

class CoordinadorFlujo implements ICoordinadorFlujo {
	var $miSql;
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\GestorProcesos\interfaz\ICoordinarFlujo::ejecutarActividad()
	 */
	public function ejecutarActividad($actividad) {
		$tipoElementoBpmn = $actividad ['elemento_bpmn_nombre'];
		// 1. determina el tipo de objeto bpmn con el id
		
		switch ($tipoElementoBpmn) {
			case 'eventoInicio' :
				$this->ejecutarEventoInicio ();
			case 'eventoIntermedio' :
				$this->ejecutarEventoIntermedio ();
			case 'eventoFin' :
				$this->ejecutarEventoFin ();
			case 'tareaHumana' :
				$this->ejecutarTareaHumana ();
			case 'tareaServicio' :
				$this->ejecutarTareaServicio ();
			case 'tareaLlamada' :
				$this->ejecutarTareaLlamada ();
			case 'tareaRecibirMensaje' :
				$this->ejecutarTareaRecibirMensaje ();
			case 'tareaEnviarMensaje' :
				$this->ejecutarTareaEnviarMensaje ();
			case 'tareaScript' :
				$this->ejecutarTareaScript ();
			case 'tareaTemporizador' :
				$this->ejecutarTareaTemporizador ();
			case 'compuertaOr' :
				$this->ejecutarCompuertaOr ();
			case 'compuertaXor' :
				$this->ejecutarCompuertaXor ();
			case 'compuertaAnd' :
				$this->ejecutarCompuertaAnd ();
			
			default :
				echo 'No existe el elemento bpmn';
		}
		// 2. ejecuta las acciones asociadas al objeto bpmn
		
		return true;
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\GestorProcesos\interfaz\ICoordinarFlujo::ejecutarProceso()
	 */
	public function ejecutarProceso($idProceso, $id_usuario, $ejecucionAutomatica) {
		
		// 1. consultar flujo;
		// 2. crear trabajo
		// para cada ejecucion:
		// 3. consultar paso
		// 4. consultar actividad del paso
		// 5. ejecutar actividad (actividad[])
		// 6. registrar ejecución
		// 7. actualizar pasos
		return 1;
	}
	
	//
	// Ejecucion paso objetos bpmn
	//
	private function ejecutarEventoInicio($valor) {
		return true;
	}
	private function ejecutarEventoIntermedio($valor) {
	}
	private function ejecutarEventoFin($valor) {
		return true;
	}
	private function ejecutarTareaHumana($valor) {
	}
	private function ejecutarTareaServicio($valor) {
	}
	private function ejecutarTareaLlamada($valor) {
	}
	private function ejecutarTareaRecibirMensaje($valor) {
	}
	private function ejecutarTareaEnviarMensaje($valor) {
	}
	private function ejecutarTareaScript($valor) {
	}
	private function ejecutarTareaTemporizador($valor) {
	}
	private function ejecutarCompuertaOr($valor) {
	}
	private function ejecutarCompuertaXor($valor) {
	}
	private function ejecutarCompuertaAnd($valor) {
	}
	
	//
	// Ejecucion accion , retorna el valor de la ejecucion
	//
	private function procesarRegla() {
	}
	private function procesarFuncion() {
	}
	private function procesarWSSoap() {
	}
	private function procesarEnviarMensaje() {
	}
	private function procesarRecibirMensaje() {
	}
	
	private function procesarTemporizador() {
	}
	private function procesarGET() {
	}
}
