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
	public function ejecutarActividad($actividad) {
		echo $actividad;
		$actividad = $actividad;
		// 1. determina el tipo de objeto bpmn con el id
		
		switch ($actividad) {
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
		
		// 1. Consultar flujo
		$this->flujoTrabajo [] = [ 
				'flujo_proceso_id' => '1',
				'proceso_id' => '1',
				'actividad_padre_id' => 'NULL',
				'actividad_hijo_id' => '1',
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
				'actividad_padre_id' => '2',
				'actividad_hijo_id' => '3',
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
				'actividad_padre_id' => '3',
				'actividad_hijo_id' => '4',
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
				'actividad_padre_id' => '3',
				'actividad_hijo_id' => '5',
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
				'actividad_padre_id' => '4',
				'actividad_hijo_id' => '6',
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
				'actividad_padre_id' => '5',
				'actividad_hijo_id' => '6',
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
				'actividad_padre_id' => '6',
				'actividad_hijo_id' => '7',
				'flujo_proceso_orden_evaluacion_condicion' => '-1',
				'flujo_proceso_condicion' => '-1',
				'tipo_ejecucion_id' => '',
				'flujo_proceso_ruta_ejecucion_condicion' => '',
				'estado_registro_id' => '1',
				'flujo_proceso_fecha_registro' => '2015/01/01' 
		];
		
		// var_dump ( $this->flujoTrabajo );
		
		// 2. crear trabajo
		
		// 3. consultar paso(s) actuales
		// para cada paso:
		// 4. consultar actividad del paso
		// 5. ejecutar actividad (actividad[])
		$this->ejecutarActividad ( 'compuertaAnd' );
		// 6. registrar ejecución
		// 7. actualizar pasos
		
		
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
		// 3. Si realiza todo con éxito
		return true;
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
	private function ejecutarCompuertaAnd() {
		
		$paso=3;
		// Consulta todas las actividades padre
		$padres = $this->consultarAtividadesPadre ( $paso );
		//consulta si estan terminadas
			//$actividades='aqui va la consulta';
		// Si alguna esta sin terminar retorna FALSE
		/**
		 * foreach ( $actividades as $actividad ) {
		 * if ($actividad == 'terminada') {
		 * } else {
		 * return FALSE;
		 * }
		 * }
		 */
		
		// si todas estan terminadas
		// Activa todas las salidas ¿como?
		// 1. consulta todos los hijos
		//$hijos=$this->consultarAtividadesHijo($paso);
		// 2. activa todos los hijos
		
		
		var_dump ( $this->flujoTrabajo );
		exit ();
		
		// si todas las entradas estan activas entonces activa todas las salidas
		// Consulta todas las actividades padre de la compuerta
	}
	
	//
	// Ejecucion accion , retorna el valor de la ejecucion
	//
	private function procesarRegla() {
		return true;
	}
	private function procesarFuncion() {
		return true;
	}
	private function procesarWSSoap() {
		return true;
	}
	private function procesarEnviarMensaje() {
		return true;
	}
	private function procesarRecibirMensaje() {
		return true;
	}
	private function procesarTemporizador() {
		return true;
	}
	private function procesarGET() {
		return true;
	}
	
	/**
	 * Consulta en el flujo actual los pasos hijo del paso padre ($id_actividadPadre).
	 * si el resultado es vacio retorna FALSE
	 * @param unknown $id_actividadPadre
	 * @return string
	 */
	private function consultarAtividadesHijo($id_actividadPadre) {
		foreach ( $this->flujoTrabajo as $relacion ) {
			if ($relacion ['actividad_padre_id'] == $id_actividadPadre) {
				$hijos [] = $relacion ['actividad_hijo_id'];
			}
		}
		return $hijos;
	}
	/**
	 * Consulta en el flujo actual los pasos padre del paso hijo ($id_actividadHijo).
	 * @param unknown $id_actividadHijo
	 * @return string|boolean
	 */
	private function consultarAtividadesPadre($id_actividadHijo) {
		foreach ( $this->flujoTrabajo as $relacion ) {
			if ($relacion ['actividad_hijo_id'] == $id_actividadHijo and $relacion ['actividad_padre_id'] != 'NULL') {
				$padres [] = $relacion ['actividad_padre_id'];
			}
		}
		if (is_array ( $padres )) {
			return $padres;
			;
		} else {
			return FALSE;
		}
	}
}
