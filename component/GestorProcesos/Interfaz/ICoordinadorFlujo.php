<?php

namespace component\GestorProcesos\interfaz;

interface ICoordinarFlujo {
	public function ejecutar($valor);
	public function ejecutarEventoInicio($valor);
	public function ejecutarEventoIntermedio($valor);	
	public function ejecutarEventoFin($valor);
	public function ejecutarTareaHumana($valor);
	public function ejecutarTareaServicio($valor);
	public function ejecutarTareaLlamada($valor);
	public function ejecutarTareaRecibirMensaje($valor);
	public function ejecutarTareaEnviarMensaje($valor);
	public function ejecutarTareaScript($valor);
	public function ejecutarTareaTemporizador($valor);
	public function ejecutarCompuertaOr($valor);
	public function ejecutarCompuertaXor($valor);
	public function ejecutarCompuertaAnd($valor);
}


?>