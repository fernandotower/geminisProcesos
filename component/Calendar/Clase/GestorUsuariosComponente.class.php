<?php

namespace component\Calendar\Clase;


use component\Calendar\interfaz\IGestionarUsuariosComponente;
use component\Calendar\Sql;
include_once  ('component/Calendar/Interfaz/IGestorUsuariosComponente.php');
include_once ("core/manager/Configurador.class.php");
include_once ("component/Calendar/Sql.class.php");
class GestorUsuariosComponente implements IGestionarUsuariosComponente {
	private $elCalendario;
	var $miSql;
	var $miConfigurador;
	
	
	/**
	 * 
	 * @see \component\Calendar\interfaz\IGestionarUsuariosComponente::consultarRelacion()
	 */
	function consultarRelacion($datos) {		
		
		$this->miSql=new Sql();
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'buscarPermiso', $datos );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );		
		
		return $resultado[0];
		
		
		
	}
}
