<?php

namespace component\Calendar;

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

require_once ('component/Component.class.php');

require_once ('component/Calendar/Clase/GestorCalendario.class.php');
require_once ('component/Calendar/Interfaz/IGestorCalendario.php');

require_once ('component/Calendar/Clase/GestorPlantilla.class.php');
require_once ('component/Calendar/Interfaz/IGestorPlantilla.php');

require_once ('component/Calendar/Clase/GestorEvento.class.php');
require_once ('component/Calendar/Interfaz/IGestorEvento.php');

require_once ('component/Calendar/Clase/GestorEventoPlantilla.class.php');
require_once ('component/Calendar/Interfaz/IGestorEventoPlantilla.php');

require_once ('component/Calendar/Clase/GestorUsuariosComponente.class.php');
require_once ('component/Calendar/Interfaz/IGestorUsuariosComponente.php');

class Componente extends Component implements IGestionarCalendario, IGestorEvento, IGestionarPlantilla, IGestionarUsuariosComponente {
	private $miCalendario;
	private $miEvento;
	private $miPlantilla;
	private $miEventoPlantilla;
	private $miPermiso;
	
	// El componente actua como Fachada
	
	/**
	 *
	 * @param \INotificador $notificador
	 *        	Un objeto de una clase que implemente la interfaz INotificador
	 */
	public function __construct() {
		$this->miCalendario = new GestorCalendario ();
		$this->miEvento = new GestorEvento ();
		$this->miPlantilla = new GestorPlantilla ();
		$this->miEventoPlantilla = new GestorEventoPlantilla();
		$this->miPermiso= new GestorUsuariosComponente();
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::crearCalendario()
	 */
	public function crearCalendario($datos) {
		return $this->miCalendario->crearCalendario ( $datos );
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::consultarSecuencia()
	 */
	public function consultarSecuencia($secuencia) {
		return $this->miCalendario->consultarSecuencia ( $secuencia );
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::registrarCalendarioUsuario()
	 */
	public function registrarPermisoCalendario($datos) {
		return $this->miCalendario->registrarPermisoCalendario ( $datos );
	}
	/**
	 * 
	 * @param unknown $datos
	 * @return boolean
	 */
	public function eliminarPermisoCalendario($datos) {
		return $this->miCalendario->eliminarPermisoCalendario ( $datos );
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::actualizarCalendario()
	 */
	public function actualizarCalendario($datos) {
		return $this->miCalendario->actualizarCalendario ( $datos );
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::borrarCalendario()
	 */
	public function borrarCalendario($datos) {
		return $this->miCalendario->borrarCalendario ( $datos );
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::consultarCalendario()
	 */
	public function consultarCalendario($id_calendario) {
		return $this->miCalendario->ConsultarCalendario ( $id_calendario );
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::consultarCalendariosUsuario()
	 */
	public function consultarCalendariosUsuario($id_usuario) {
		return $this->miCalendario->consultarCalendariosUsuario ( $id_usuario );
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestorEvento::crearEvento()
	 */
	public function crearEvento($datos) {
		return $this->miEvento->crearEvento ( $datos );
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestorEvento::actualizarEvento()
	 */
	public function actualizarEvento($datos) {
		return $this->miEvento->actualizarEvento ( $datos );
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestorEvento::borrarEvento()
	 */
	public function borrarEvento($datos) {
		return $this->miEvento->borrarEvento ( $datos );
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestorEvento::consultarEvento()
	 */
	public function consultarEvento($id_calendario) {
		return $this->miEvento->consultarEvento ( $id_calendario );
	}
	public function consultarPlantillaUsuario($id_usuario) {
		return $this->miPlantilla->consultarPlantillaUsuario ( $id_usuario );
	}
	
	public function consultarPlantilla($id_plantilla) {
		return $this->miPlantilla->consultarPlantilla ( $id_plantilla );
	}	
	
	public function crearPlantilla($datos) {
		return $this->miPlantilla->crearPlantilla ( $datos );
	}
	public function registrarPlantillaUsuario($datos) {
		return $this->miPlantilla->registrarPlantillaUsuario ( $datos );
	}
	public function actualizarPlantilla($datos) {
		return $this->miPlantilla->actualizarPlantilla ( $datos );
	}
	
	public function crearEventoPlantilla($datos) {
		return $this->miEventoPlantilla->crearEventoPlantilla ( $datos );
	}
	
	public function borrarEventoPlantilla($datos) {
		return $this->miEventoPlantilla->borrarEventoPlantilla ( $datos );
	}
	
	public function actualizarEventoPlantilla($datos) {
		return $this->miEventoPlantilla->actualizarEventoPlantilla ( $datos );
	}
	
	public function consultarEventosPlantilla($id_plantilla) {
		return $this->miEventoPlantilla->consultarEventosPlantilla ( $id_plantilla );
	}
	
	public function consultarEventoPlantilla($id_eventoplantilla) {
		return $this->miEventoPlantilla->consultarEventoPlantilla ( $id_eventoplantilla );
	}
	
	public function crearRelacionEventos($datos) {
		return $this->miEventoPlantilla->crearRelacionEventos ( $datos );
	}
	
	public function actualizarRelacionEventos($datos) {
		return $this->miEventoPlantilla->actualizarRelacionEventos ( $datos );
	}
	
	
	public function consultarRelacionEventos($id_plantilla) {
		return $this->miEventoPlantilla->consultarRelacionEventos ( $id_plantilla );
	}
	
	
	public function consultarRelacion($datos) {
		return $this->miPermiso->consultarRelacion ( $datos );
	}
	
	
	
}


