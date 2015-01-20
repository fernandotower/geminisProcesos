<?php

namespace component\GestorUsuarios;

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

require_once ('component/GestorUsuarios/Clase/GestorUsuarios.class.php');
require_once ('component/GestorUsuarios/Interfaz/IGestorUsuarios.php');

class Componente extends Component implements IGestionarUsuarios {
	private $miUsuario;

	
	// El componente actua como Fachada
	
	/**
	 * un objeto de la clase GestorUsuarios
	 */
	public function __construct() {
		$this->miUsuario = new GestorUsuarios();

	}
	
	public function consultarUsuarios($datos) {
		return $this->miUsuario->consultarUsuarios ( $datos );
	}
	
	
}


