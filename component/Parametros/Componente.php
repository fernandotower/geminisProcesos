<?php

namespace component\Parametros;

use component\Component;
use component\Calendar\interfaz\IGestionarCalendario;
use component\Calendar\Clase\GestorCalendario;
use component\Calendar\interfaz\IGestorEvento;
use component\Calendar\Clase\GestorEvento;
use component\Calendar\interfaz\IGestionarPlantilla;
use component\Calendar\Clase\GestorPlantilla;
use component\Calendar\Clase\GestorEventoPlantilla;
use component\Calendar\interfaz\IGestionarUsuariosComponente;
use component\Calendar\Clase\GestorUsuariosComponente;
use component\GestorUsuarios\interfaz\IGestionarUsuarios;
use component\GestorUsuarios\Clase\GestorUsuarios;

require_once ('component/Component.class.php');

require_once ('component/Parametros/Clase/GestorParametros.class.php');
require_once ('component/Parametros/Interfaz/IGestorParametros.php');

class Componente extends Component implements IGestionarParametros {
	private $miParametro;

	
	// El componente actua como Fachada
	
	/**
	 * un objeto de la clase GestorParametros
	 */
	public function __construct() {
		$this->miParametro = new GestorParametros();

	}
	
	public function consultarParametros ($tipo) {
		return $this->miParametro->consultarParametros ( $tipo );
	}
	
	
}


