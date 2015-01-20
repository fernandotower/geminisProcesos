<?php

namespace component\GestorProcesos;

use component\Component;
use component\GestorProcesos\Interfaz\CoordinadorFlujo;

use component\Calendar\Clase\GestorCalendario;


require_once ('component/Component.class.php');

require_once ('component/Procesos/Clase/GestorProcesos.class.php');
require_once ('component/Procesos/Interfaz/IGestorProcesos.php');

class Componente extends Component implements IGestionarProcesos {
	private $miParametro;

	
	// El componente actua como Fachada
	
	/**
	 * un objeto de la clase GestorProcesos
	 */
	public function __construct() {
		$this->miParametro = new GestorProcesos();

	}
	
	public function consultarProcesos ($tipo) {
		return $this->miParametro->consultarProcesos ( $tipo );
	}
	
	
}


