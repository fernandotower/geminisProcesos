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
		
		// si alguna de las pasos se ejecuta (TRUE) se vueven a consultar los pasos y
		// se solicita la ejecución de las actividades.
		$resultadoEjecucion = TRUE;
		while ( $resultadoEjecucion == TRUE ) {
			$pasos = $this->consultarPasos ( 50 );
			$resultadoEjecucion = $this->ejecutarActividades ( $pasos );
		}
		
		return FALSE;
		
		// 6. registrar ejecución
		// 7. actualizar pasos
	}
	
	/**
	 * Ejecuta las actividades correspondentes a los pasos del flujo recibidos
	 * retorna TRUE si alguno de los pasos se ejecutó
	 * si ninguno se ejecuta retorna FALSE.
	 *
	 * @param array $pasos        	
	 * @return boolean
	 */
	private function ejecutarActividades($pasos) {
		$avanzar = FALSE;
		foreach ( $pasos as $paso ) {
			$actividad = $this->consultarActividad ( $paso );
			// se deben pasar todos los datos de la actividad,
			// es decir todo el registro obtenido de la consulta
			
			$resultadoEjecucionActividad = $this->ejecutarActividad ( $actividad, $paso );
			if ($resultadoEjecucionActividad == TRUE) {
				$avanzar = TRUE;
			}
		}
		return $avanzar;
	}
	private function consultarPasos($id_trabajo) {
		$pasos = [ 
				3 
		];
		return $pasos;
	}
	private function consultarActividad($paso) {
		$actividad ['id_actividad'] = '25';
		$actividad ['tipo_elementoBpmn'] = 'compuertaAnd';
		return $actividad;
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\GestorProcesos\interfaz\ICoordinarFlujo::ejecutarActividad()
	 */
	public function ejecutarActividad($actividad, $paso) {
		
		// 1. determina el tipo de objeto bpmn con el id
		switch ($actividad ['tipo_elementoBpmn']) {
			case 'eventoInicio' :
				return $this->ejecutarEventoInicio ();
				break;
			case 'eventoIntermedio' :
				$this->ejecutarEventoIntermedio ();
				break;
			case 'eventoFin' :
				$this->ejecutarEventoFin ();
				break;
			case 'tareaHumana' :
				$this->ejecutarTareaHumana ();
				break;
			case 'tareaServicio' :
				$this->ejecutarTareaServicio ();
				break;
			case 'tareaLlamada' :
				$this->ejecutarTareaLlamada ();
				break;
			case 'tareaRecibirMensaje' :
				$this->ejecutarTareaRecibirMensaje ();
				break;
			case 'tareaEnviarMensaje' :
				$this->ejecutarTareaEnviarMensaje ();
				break;
			case 'tareaScript' :
				$this->ejecutarTareaScript ();
				break;
			case 'tareaTemporizador' :
				$this->ejecutarTareaTemporizador ();
				break;
			case 'compuertaOr' :
				$this->ejecutarCompuertaOr ();
				break;
			case 'compuertaXor' :
				$this->ejecutarCompuertaXor ($paso);
				break;
			case 'compuertaAnd' :
				return $this->ejecutarCompuertaAnd ($paso);
				break;
			
			default :
				echo 'No existe el elemento bpmn';
				break;
		}
		// 2. ejecuta las acciones asociadas al objeto bpmn
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
		return FALSE;
	}
	private function ejecutarTareaRecibirMensaje($valor) {
		return FALSE;
	}
	private function ejecutarTareaEnviarMensaje($valor) {
		return FALSE;
	}
	private function ejecutarTareaScript($valor) {
		return FALSE;
	}
	private function ejecutarTareaTemporizador($valor) {
		return FALSE;
	}
	private function ejecutarCompuertaOr() {
		return FALSE;
		// 1.
	}
	
	/**
	 * 
	 * @param array $paso
	 * @return boolean
	 */
	private function ejecutarCompuertaXor($paso) {
		
		
		//1. consulta los hijos (registros complero del paso)
		//2. los organiza por prioridad, al final la condición default
		//	para cada hijo
		//3. evalua condicion
		// si TRUE: actualiza actividad y registra actividad hijo y return TRUE, 
		// si FALSE: no hace nada;
		//5. Si ninguna condición es verdadera activa la actividad asociada la condición Default y return=TRUE		
		
		return FALSE;
		
		
	}
	private function ejecutarCompuertaAnd($paso) {
		echo 'estoy en la compuestaAnd';
		return FALSE;
		$paso = 3;
		// Consulta todas las actividades padre del paso del flujo
		$padres = $this->consultarAtividadesPadre ( $paso );
		// consulta si estan terminadas
		// $actividades='aqui va la consulta';
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
		// $hijos=$this->consultarAtividadesHijo($paso);
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
		return FALSE;
	}
	private function procesarFuncion() {
		return FALSE;
	}
	private function procesarWSSoap() {
		return FALSE;
	}
	private function procesarEnviarMensaje() {
		return FALSE;
	}
	private function procesarRecibirMensaje() {
		return FALSE;
	}
	private function procesarTemporizador() {
		return FALSE;
	}
	private function procesarGET() {
		return FALSE;
	}
	
	/**
	 * Consulta en el flujo actual los pasos hijo del paso padre ($id_actividadPadre).
	 * si el resultado es vacio retorna FALSE
	 *
	 * @param unknown $id_actividadPadre        	
	 * @return string
	 */
	private function consultarAtividadesHijo($id_actividadPadre) {
		foreach ( $this->flujoTrabajo as $relacion ) {
			if ($relacion ['actividad_padre_id'] == $id_actividadPadre) {
				$hijos [] = $relacion ['actividad_hijo_id'];
			}
		}
		if (is_array ( $padres )) {
			return $hijos;
			;
		} else {
			return FALSE;
		}
	}
	/**
	 * Consulta en el flujo actual los pasos padre del paso hijo ($id_actividadHijo).
	 *
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
