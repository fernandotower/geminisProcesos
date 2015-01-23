<?php

namespace component\GestorProcesos\Clase;

use component\GestorProcesos\interfaz\ICoordinadorFlujo;


include_once ('component/GestorProcesos/Interfaz/ICoordinadorFlujo.php');

class CoordinadorFlujo implements ICoordinadorFlujo {
	var $miSql;
	


	/**
	 * 
	 * Ejecuta una actividad, true: se ejcuto con exito, falso: se ejecuto con errores o no se pudo ejecutar
	 * @param $idActividad
	 * @return bool
	 * 
	 */
	public function ejecutarActividad($idActividad) {
		//1. consulta actividad
		//2. determina el tipo de objeto bpmn con el id
		//3. ejecuta las acciones asociadas al objeto bpmn
		return true;
	}
	
	/**
	 * 
	 * Crea un trabajo , 
	 * envia señal de ejecucion del paso de inicio y  
	 * y retorna el id del trabajo
	 * @param $idProceso , integer id del proceso del cual se quiere ejecutar el flujo
	 * @param $ejecucionAutomatica , bool true:comienza a ejecutar actividades hasta que se encuentre con un paso manual , false:solo ejecuta la actividad de inicio.   
	 * @return integer , $idTrabajo
	 * 
	 */
	public function ejecutarProceso($idProceso,$ejecucionAutomatica) {
		return 1;
	}
	
	
	//
	//Ejecucion paso objetos bpmn
	//
	private function ejecutarEventoInicio($valor) {
		
	}
	
	private function ejecutarEventoIntermedio($valor) {
		
	}
	
	private function ejecutarEventoFin($valor) {
	
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
	//Ejecucion accion , retorna el valor de la ejecucion
	//
	
	private function procesarRegla(){
		
	}
	
	private function procesarFuncion(){
	
	}
	
	private function procesarWSSoap(){
	
	}
	
	private function procesarEnviarMensaje(){
	
	}
	
	private function procesarRecibirMensaje(){
	
	}
	
	
	private function procesarTemporizador(){
	
	}
	
	private function procesarGET(){
	
	}
	
	
	
	
}
