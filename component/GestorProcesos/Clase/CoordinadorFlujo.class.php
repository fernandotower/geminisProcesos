<?php

namespace component\GestorProcesos\Clase;

use component\GestorProcesos\interfaz\ICoordinadorFlujo;
use component\GestorProcesos\Clase\Registrador as Registrador;
use component\GestorProcesos\Clase\ModeladorProceso as ModeladorProceso;

include_once ('component/GestorProcesos/Interfaz/ICoordinadorFlujo.php');
class CoordinadorFlujo implements ICoordinadorFlujo {
	var $miSql;
	var $flujoTrabajo;
	var $idTrabajo;
	private $registrador;
	private $modelador;
	public function __construct() {
		$this->registrador = new Registrador ();
		$this->modelador = new ModeladorProceso ();
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\GestorProcesos\interfaz\ICoordinarFlujo::ejecutarProceso()
	 */
	public function ejecutarProceso($idProceso = '', $ejecucionAutomatica = FALSE) {
		
		// 1. Consultar flujo
		$this->flujoTrabajo = $this->modelador->consultarFlujo ( $idProceso );
		//var_dump ( $this->flujoTrabajo );
		if (! is_array ( $this->flujoTrabajo ))
			return false;
			
			// actividad null es la prima que se ejecuta
		$idActividadInicio = $this->consultarAtividadesHijo ( null )[0];
		// var_dump ( $idActividadInicio );
		
		if (! $idActividadInicio)
			return false;
			
			// 2. crear trabajo
		$idTrabajo = $this->registrador->crearTrabajo ( $idProceso );
		if (! $idTrabajo)
			return false;
		$this->idTrabajo = $idTrabajo;
		// var_dump ( $this->idTrabajo );
		// crear paso con la primera actividad		
		
		$idPaso = $this->registrador->crearPaso ( $this->idTrabajo, $idActividadInicio, 1 );
		// var_dump ( $idPaso );
		
		// si alguna de las pasos se ejecuta (TRUE) se vueven a consultar los pasos y
		// se solicita la ejecución de las actividades.
		$resultadoEjecucion = TRUE;
		while ( $resultadoEjecucion == TRUE ) {
						
			$pasosNoEjecutados = $this->registrador->consultarPasos ( $this->idTrabajo, '', '1' );			
			echo '<b>INICIO ITERACION</b><br>';
			echo '1. pasos no ejecutados';
			var_dump ( $pasosNoEjecutados );
			$resultadoEjecucion = $this->ejecutarActividades ( $pasosNoEjecutados );
			echo 'resultado iteracion';var_dump ( $resultadoEjecucion );
			unset ( $pasosNoEjecutados );
		}
		// var_dump ( $pasos );
		echo 'final';
		exit ();
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
			
			$actividad = $this->modelador->consultarActividad ( $paso ['actividad_id'] );
			
			echo 'actividad: ';
			var_dump($actividad);
			
			$resultadoEjecucionActividad = $this->ejecutarActividad ( $actividad [0] );
			
			echo 'resultado actividad';
			var_dump($resultadoEjecucionActividad);
			
			if ($resultadoEjecucionActividad == TRUE) {
				
				// actualizar estado del paso
				$actualiza = $this->registrador->actualizarEstadoPaso ( $this->idTrabajo, $paso ['actividad_id'], '4' );
				if(!$actualiza) return false;
				// consultar las hijos
				$hijos = $this->consultarAtividadesHijo ( $paso ['actividad_id'] );
				if(!$hijos) return  false;
				echo 'hijos';
				var_dump($hijos);
				echo "<br><br>";
		
				// registrar hijos en la tabla de pasos_trabajo
				foreach ( $hijos as $hijo ) {
					$paso = $this->registrador->crearPaso ( $this->idTrabajo, $hijo, '1' );
					if(!$paso) return false;
				}
				
				$avanzar = TRUE;
			}
			//echo 'pasos registrados despues de ejecutar una actividad';
			//$pasosRegistrados = $this->registrador->consultarPasos ( $this->idTrabajo );
			//var_dump ( $pasosRegistrados );
			unset ( $hijos );
		}
		
		return $avanzar;
	}
	private function consultarPasos($id_trabajo) {
		$pasos = [ 
				3 
		];
		return $pasos;
	}
	
	/**
	 * Consulta la actividad asociada al paso
	 *
	 * @param unknown $paso        	
	 * @return string
	 */
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
	// public function ejecutarActividad($actividad, $paso) {
	public function ejecutarActividad($actividad) {
		
		// id elemento bpmn de la actividad
		$idElementoBpmn = $actividad ['elemento_bpmn_id'];
		
		$nombreElementoBpmn = $this->registrador->getElementoBpmn ( $idElementoBpmn, 'id', 'nombre' );
		
		// 1. determina el tipo de objeto bpmn con el id
		switch ($nombreElementoBpmn) {
			case 'eventoInicio' :
				return $this->ejecutarEventoInicio ();
				break;
			case 'eventoIntermedio' :
				return $this->ejecutarEventoIntermedio ();
				break;
			case 'eventoFin' :
				return $this->ejecutarEventoFin ($actividad);
				break;
			case 'tareaHumana' :
				return $this->ejecutarTareaHumana ();
				
				break;
			case 'tareaServicio' :
				return $this->ejecutarTareaServicio ();
				break;
			case 'tareaLlamada' :
				return $this->ejecutarTareaLlamada ();
				break;
			case 'tareaRecibirMensaje' :
				return $this->ejecutarTareaRecibirMensaje ();
				break;
			case 'tareaEnviarMensaje' :
				$this->ejecutarTareaEnviarMensaje ();
				break;
			case 'tareaScript' :
				return $this->ejecutarTareaScript ();
				break;
			case 'tareaTemporizador' :
				return $this->ejecutarTareaTemporizador ();
				break;
			case 'compuertaOr' :
				return $this->ejecutarCompuertaOr ();
				break;
			case 'compuertaXor' :
				return $this->ejecutarCompuertaXor ( $paso );
				break;
			case 'compuertaAnd' :
				return $this->ejecutarCompuertaAnd ( $paso );
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
	private function ejecutarEventoInicio() {
		return TRUE;
	}
	private function ejecutarEventoIntermedio($valor) {
		return true;
	}
	
	/**
	 * este método borra todos los pasos del flujo y actualiza su estado como terminado
	 *
	 * @param unknown $valor        	
	 */
	private function ejecutarEventoFin($actividad) {
		
		// 1. borrar todos los pasos del trabajo
		// 2. se actualiza el estado del trabajo como terminado
		// 3. Si realiza todo con éxito
		echo 'ejecutarEventoFin';
		$actualizacion = $this->registrador->actualizarEstadoPaso ( $this->idTrabajo, $actividad ['id'], '4' );
		if(!$actualizacion) return false;
		$cambioRegistro = $this->registrador->finalizarPasosTrabajo($this->idTrabajo);
		if(!$cambioRegistro) return false;
		return true; 
		
	}
	private function ejecutarTareaHumana() {
		// 1. La tarea humana consulta si se ha realizado
		// 2. si NO hace una parada
		// 3. si SI retorna true
		// 4. para solicitar su ejecución nuevamente, se debe realizar de forma manual desde el flujo
		// 5. En este momento verifica que se haya realizado lo referente a la tarea (puede ser un bit bandera).
		// 6. Retorna al paso 1
		return TRUE;
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
		
		// 1. consulta los hijos (registros complero del paso)
		// 2. los organiza por prioridad, al final la condición default
		// para cada hijo
		// 3. evalua condicion
		// si TRUE: actualiza actividad y registra actividad hijo y return TRUE,
		// si FALSE: no hace nada;
		// 5. Si ninguna condición es verdadera activa la actividad asociada la condición Default y return=TRUE
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
		if (isset($hijos)&&is_array ( $hijos )) {
			return $hijos;
			
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
