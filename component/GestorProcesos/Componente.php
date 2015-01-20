<?php

namespace component\GestorProcesos;

use component\Component;
use component\gestorprocesos\interfaz\ICoordinarFlujo;
use component\gestorprocesos\interfaz\ICoordinarProceso;
use component\gestorprocesos\interfaz\IRegistrar;
use component\gestorprocesos\interfaz\IModelarProceso;
use component\GestorProcesos\Clase\CoordinadorFlujo;
use component\GestorProcesos\Clase\CoordinadorProceso;
use component\GestorProcesos\Clase\Registrador;
use component\GestorProcesos\Clase\ModeladorProceso;

require_once ('component/Component.class.php');
class Componente extends Component implements ICoordinarFlujo, ICoordinarProceso, IRegistrar, IModelarProceso {
	private $miFlujo;
	private $miProceso;
	private $miRegistro;
	private $miModeloProceso;
	
	// El componente actua como Fachada
	
	/**
	 * un objeto de la clase GestorProcesos
	 */
	public function __construct() {
		$this->miFlujo = new CoordinadorFlujo ();
		$this->miProceso = new CoordinadorProceso ();
		$this->miRegistro = new Registrador ();
		$this->miModeloProceso = new ModeladorProceso ();
	}
	
	// ////////////////// METODOS COORDINADOR DE FLUJO///////////////////////////////////////
	public function ejecutar($valor) {
		return $this->miFlujo->ejecutar ( $valor );
	}
	public function ejecutarEventoInicio($valor) {
		return $this->miFlujo->ejecutar ( $valor );
	}
	public function ejecutarEventoIntermedio($valor) {
		return $this->miFlujo->ejecutar ( $valor );
	}
	public function ejecutarEventoFin($valor) {
		return $this->miFlujo->ejecutar ( $valor );
	}
	public function ejecutarTareaHumana($valor) {
		return $this->miFlujo->ejecutar ( $valor );
	}
	public function ejecutarTareaServicio($valor) {
		return $this->miFlujo->ejecutar ( $valor );
	}
	public function ejecutarTareaLlamada($valor) {
		return $this->miFlujo->ejecutar ( $valor );
	}
	public function ejecutarTareaRecibirMensaje($valor) {
		return $this->miFlujo->ejecutar ( $valor );
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
	
	// ////////////////// METODOS COORDINADOR DE PROCESO///////////////////////////////////////
	
	// ////////////////// METODOS REGISTRADOR///////////////////////////////////////
	
	// ////////////////// METODOS MODELADOR DE PROCESO///////////////////////////////////////
}


