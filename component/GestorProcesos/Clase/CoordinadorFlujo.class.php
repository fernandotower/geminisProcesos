<?php

namespace component\GestorProcesos\Clase;

use component\GestorProcesos\interfaz\ICoordinadorFlujo;


include_once ('component/GestorProcesos/Interfaz/ICoordinadorFlujo.php');

class CoordinadorFlujo implements ICoordinadorFlujo {
	var $miSql;
	var $flujoTrabajo;
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\GestorProcesos\interfaz\ICoordinarFlujo::ejecutarActividad()
	 */
	public function ejecutarActividad() {
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
	public function ejecutarProceso() {
		
		echo 'Comienza la ejecución del proceso';
		exit;
		
		$this->flujoTrabajo [] = [ 
				'flujo_proceso_id' => '1',
				'proceso_id' => '1',
				'actividad_padre_id' => '1',
				'actividad_hijo_id' => '2',
				'flujo_proceso_orden_evaluacion_condicion' => '-1',
				'flujo_proceso_condicion' => '-1',
				'tipo_ejecucion_id' => '',
				'flujo_proceso_ruta_ejecucion_condicion' => '',
				'estado_registro_id' => '1',
				'flujo_proceso_fecha_registro' => '2015/01/01' 
		];
		$this->flujoTrabajo [] = [
				'flujo_proceso_id' => '1',
				'proceso_id' => '1',
				'actividad_padre_id' => '1',
				'actividad_hijo_id' => '2',
				'flujo_proceso_orden_evaluacion_condicion' => '-1',
				'flujo_proceso_condicion' => '-1',
				'tipo_ejecucion_id' => '',
				'flujo_proceso_ruta_ejecucion_condicion' => '',
				'estado_registro_id' => '1',
				'flujo_proceso_fecha_registro' => '2015/01/01'
		];
		$this->flujoTrabajo [] = [
				'flujo_proceso_id' => '1',
				'proceso_id' => '1',
				'actividad_padre_id' => '1',
				'actividad_hijo_id' => '2',
				'flujo_proceso_orden_evaluacion_condicion' => '-1',
				'flujo_proceso_condicion' => '-1',
				'tipo_ejecucion_id' => '',
				'flujo_proceso_ruta_ejecucion_condicion' => '',
				'estado_registro_id' => '1',
				'flujo_proceso_fecha_registro' => '2015/01/01'
		];
		$this->flujoTrabajo [] = [
				'flujo_proceso_id' => '1',
				'proceso_id' => '1',
				'actividad_padre_id' => '1',
				'actividad_hijo_id' => '2',
				'flujo_proceso_orden_evaluacion_condicion' => '-1',
				'flujo_proceso_condicion' => '-1',
				'tipo_ejecucion_id' => '',
				'flujo_proceso_ruta_ejecucion_condicion' => '',
				'estado_registro_id' => '1',
				'flujo_proceso_fecha_registro' => '2015/01/01'
		];
		$this->flujoTrabajo [] = [
				'flujo_proceso_id' => '1',
				'proceso_id' => '1',
				'actividad_padre_id' => '1',
				'actividad_hijo_id' => '2',
				'flujo_proceso_orden_evaluacion_condicion' => '-1',
				'flujo_proceso_condicion' => '-1',
				'tipo_ejecucion_id' => '',
				'flujo_proceso_ruta_ejecucion_condicion' => '',
				'estado_registro_id' => '1',
				'flujo_proceso_fecha_registro' => '2015/01/01'
		];
		
		var_dump($this->flujoTrabajo);exit;
		
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
		return true;
	}
	/**
	 * este método borra todos los pasos del flujo y actualiza su estado como terminado
	 * 
	 * @param unknown $valor        	
	 */
	private function ejecutarEventoFin($valor) {
		
		// 1. borrar todos los pasos del trabajo
		// 2. se actualiza el estado del trabajo como terminado
		// 3. Si realiza todo con éxito retorna true
	}
	private function ejecutarTareaHumana($valor) {
		// 1. La tarea humana consulta si se ha realizado
		// 2. si NO hace una parada
		// 3. si SI retorna true
		// 4. para solicitar su ejecución nuevamente, se debe realizar de forma manual desde el flujo
		// 5. En este momento verifica que se haya realizado lo referente a la tarea (puede ser un bit bandera).
		// 6. Retorna al paso 1
	}
	private function ejecutarTareaServicio($valor) {
		// llama servicio si se ejecutó retorna true;
		true;
	}
	private function ejecutarTareaLlamada($valor) {
		// No definido
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
		// 1.
	}
	private function ejecutarCompuertaXor($valor) {
	}
	private function ejecutarCompuertaAnd($valor) {
		
		// si todas las entradas estan activas entonces activa todas las salidas
		// Consulta todas las actividades padre de la compuerta
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
