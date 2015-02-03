<?php

namespace component\GestorSoap;


require_once ('component/Component.class.php');
use component\Component as Component;


require_once ('component/GestorSoap/Interfaz/IGestorSoap.php');
use component\GestorSoap\interfaz\IGestorSoap as IGestorSoap;

require_once ('component/GestorSoap/Clase/Servidor.class.php');
use component\GestorSoap\Clase\Servidor as Servidor;


class Componente extends Component implements IGestorSoap {
	private $miUsuario;
	private $server = null;

	
	// El componente actua como Fachada
	
	/**
	 * un objeto de la clase GestorUsuarios
	 */
	public function __construct() {
		
		

	}
	
	public function setAmbiente($datos){
		if($datos=='') return false;	
		return $this->server = new Servidor($datos);
		
	}
	
	public function initServer(){
		if(is_null($this->server)); return false;
		return $this->server->initServer(); 
		
	}
		
	
}


