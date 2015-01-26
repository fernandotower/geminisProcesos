<?php

namespace component\GestorProcesos;

use component\Component;
include 'component/GestorProcesos/Interfaz/ICoordinadorFlujo.php';
use component\GestorProcesos\interfaz\ICoordinadorFlujo as ICoordinadorFlujo;
include 'component/GestorProcesos/Interfaz/ICoordinadorProceso.php';
use component\GestorProcesos\interfaz\ICoordinadorProceso as ICoordinadorProceso;
include 'component/GestorProcesos/Interfaz/IRegistrador.php';
use component\GestorProcesos\interfaz\IRegistrar as IRegistrar;
include 'component/GestorProcesos/Interfaz/IModeladorProcesos.php';
use component\GestorProcesos\interfaz\IModelarProceso as IModelarProceso;
include 'component/GestorProcesos/Clase/CoordinadorFlujo.class.php';
use component\GestorProcesos\Clase\CoordinadorFlujo as CoordinadorFlujo;
include 'component/GestorProcesos/Clase/CoordinadorProceso.class.php';
use component\GestorProcesos\Clase\CoordinadorProceso as CoordinadorProceso;
include 'component/GestorProcesos/Clase/Registrador.class.php';
use component\GestorProcesos\Clase\Registrador as Registrador;
include 'component/GestorProcesos/Clase/ModeladorProceso.class.php';
use component\GestorProcesos\Clase\ModeladorProceso as ModeladorProceso;

include 'component/GestorProcesos/Interfaz/ICoordinadorFlujo.php';
include 'component/GestorProcesos/Interfaz/ICoordinadorProceso.php';
include 'component/GestorProcesos/Interfaz/IRegistrador.php';
include 'component/GestorProcesos/Interfaz/IModeladorProceso.php';
include 'component/GestorProcesos/Clase/CoordinadorFlujo.class.php';
include 'component/GestorProcesos/Clase/CoordinadorProceso.class.php';
include 'component/GestorProcesos/Clase/Registrador.class.php';
include 'component/GestorProcesos/Clase/ModeladorProceso.class.php';

require_once ('component/Component.class.php');
class Componente extends Component implements ICoordinadorFlujo, ICoordinadorProceso, IRegistrar, IModelarProceso {
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
	
	
	/**
	 * 
	 * Ejecuta una actividad, true: se ejcuto con exito, falso: se ejecuto con errores o no se pudo ejecutar
	 * @param $idActividad
	 * @return bool
	 * 
	 */
	public function ejecutarActividad($idActividad,$ejecucionAutomatica) {
		return $this->miFlujo->ejecutarActividad ( $idActividad );
	}
	
	/**
	 * 
	 * Crea un trabajo , 
	 * envia se�al de ejecucion del paso de inicio y  
	 * y retorna el id del trabajo
	 * @param $idProceso , integer id del proceso del cual se quiere ejecutar el flujo
	 * @param $ejecucionAutomatica , bool true:comienza a ejecutar actividades hasta que se encuentre con un paso manual , false:solo ejecuta la actividad de inicio.   
	 * @return integer , $idTrabajo
	 * 
	 */
<<<<<<< HEAD
	public function ejecutarProceso() {
		return $this->miFlujo->ejecutarProceso ( );
=======
	public function ejecutarProceso($idProceso, $id_usuario, $ejecucionAutomatica) {
		return $this->miFlujo->ejecutarProceso ( $idProceso , $ejecucionAutomatica);
>>>>>>> branch 'master' of https://github.com/fernandotower/geminisProcesos.git
	}
	
		
	// ////////////////// METODOS COORDINADOR DE PROCESO///////////////////////////////////////
	
	// ////////////////// METODOS REGISTRADOR///////////////////////////////////////
	
	/**
	 *
	 * Actualiza el estado de un paso
	 * @param $idTrabajo , integer obligatorio
	 * @param $idActividad , integer obligatorio
	 * @param $idEstadoPaso , integer obligatorio
	 * @return bool
	 *
	 */
	public function actualizarEstadoPaso($idTrabajo, $idActividad ,$idEstadoPaso) {
		return $this->miRegistro->actualizarEstadoPaso($idTrabajo, $idActividad ,$idEstadoPaso);
	}
	
	/**
	 *
	 * Crea un trabajo
	 * @param $idProceso
	 * @return integer , $idTrabajo
	 *
	 */
	public function crearTrabajo($idProceso) {
		return $this->miRegistro->crearTrabajo($idProceso);
	}
	
	/**
	 *
	 * Consulta pasos , es decir lo que se ha ejecutado y que no en el trabajo
	 * @param $idTrabajo , integer obligatorio
	 * @param $idActividad , integer opcional
	 * @param $idEstadoPaso , integer opcional
	 * @param $idEstadoRegistro , integer opcional
	 * @param $fechaRegistro , string opcional
	 * @return array , array de la consulta 
	 *
	 */
	public function consultarPasos($idTrabajo, $idActividad, $idEstadoPaso, $idEstadoRegistro, $fechaRegistro) {
		$idEstadoRegistro = 1;
		return $this->miRegistro->consultarPasos($idTrabajo, $idActividad, $idEstadoPaso, $idEstadoRegistro, $fechaRegistro);
		
	}
	
	
	
	// ////////////////// METODOS MODELADOR DE PROCESO///////////////////////////////////////
	
	/**
	 *
	 * consulta el flujo asociado a un proceso
	 * @param $idProceso, integer obligatorio
	 * @return array , array de la consulta 
	 *
	 */
	public function consultarFlujo($idProceso) {
		$this->miModeloProceso->consultarFlujo($idProceso);
	}
	
	/**
	 *
	 * Crea un trabajo
	 * @param $idActividad , integer obligatorio
	 * @param $nombreActividad , string opcional
	 * @param $aliasActividad , string opcional
	 * @param $idElementoBpmn , integer opcional
	 * @param $idTipoEjecucion , integer opcional
	 * @param $estadoRegistroId , integer opcional
	 * @param $fechaRegistro , string opcional
	 * @return array , consulta
	 *
	 */
	public function consultarActividad($idActividad,$nombreActividad, $aliasActividad, $idElementoBpmn, $idTipoEjecucion, $estadoRegistroId, $fechaRegistro) {
		$this->miModeloProceso->consultarActividad($idActividad,$nombreActividad, $aliasActividad, $idElementoBpmn, $idTipoEjecucion, $estadoRegistroId, $fechaRegistro);
	}
}


