<?php

namespace component\Calendar\Clase;

use component\Calendar\interfaz\IRegistrador;
use component\Calendar\Sql;
use component\Calendar\interfaz\IGestionarCalendario;

include_once ('component/Calendar/Interfaz/IGestorCalendario.php');
include_once ("core/manager/Configurador.class.php");
include_once ("component/Calendar/Sql.class.php");
class GestorCalendario implements IGestionarCalendario {
	private $elCalendario;
	var $miSql;
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::crearCalendario()
	 */
	function crearCalendario($datos) {
		$this->miSql = new Sql ();
		$calendario = json_decode ( $datos, true );
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'insertarCalendario', $calendario );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
		
		if ($resultado == TRUE) {
			$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'calendarioCreado' );
		} else {
			$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'errorCalendarioCreado' );
		}
		
		return $resultado;
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::consultarSecuencia()
	 */
	function consultarSecuencia($secuencia) {
		$this->miSql = new Sql ();
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'consultarSecuencia', $secuencia );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		
		return $resultado [0] [0];
	}
	/**
	 * Registra los permisos de usuario para el calendario al momento de crear un nuevo elemento
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::registrarCalendarioUsuario()
	 */
	function registrarPermisoCalendario($datos) {
		$this->miSql = new Sql ();
		
		$calendarioPermiso = json_decode ( $datos, true );
		// var_dump($calendarioPermiso);
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		// consulta si ya se encuentra registrado el permiso
		$cadenaSql = $this->miSql->cadena_sql ( 'buscarPermiso', $calendarioPermiso ); // echo $cadenaSql;
		$permisoRegistrado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		
		// Si no existe ningún permiso se registra por primera vez
		if (! is_array ( $permisoRegistrado )) {
			$cadenaSql = $this->miSql->cadena_sql ( 'insertarPermiso', $calendarioPermiso );
			$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
		} else {
			// el tipo de permiso ya esta registrado
			if (strstr ( $permisoRegistrado [0] ['permiso'], $calendarioPermiso ['permiso'] )) {
				$resultado = true;
			} else {
				// Si existen permisos diferentes, concatenar el nuevo permiso con los demás
				$calendarioPermiso ['id_calendario_permiso'] = $permisoRegistrado [0] ['id_calendario_permiso'];
				$calendarioPermiso ['permiso'] = $calendarioPermiso ['permiso'] . $permisoRegistrado [0] ['permiso'];
				$cadenaSql = $this->miSql->cadena_sql ( 'actualizarPermiso', $calendarioPermiso );
				$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'actualizar' ); // solo para consulta colocar en el segundo parametro 'busqueda'
			}
		}
		// $this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'permisosCreados' );
		return $resultado;
	}
	/**
	 * Elimina el permiso especificado, si existen mas permisos actualiza el registro dejando los demás permisos
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::eliminarPermisoCalendario()
	 */
	function eliminarPermisoCalendario($datos) {
		$this->miSql = new Sql ();
		
		$calendarioPermiso = json_decode ( $datos, true );
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		// consulta si ya se encuentra registrado el permiso
		$cadenaSql = $this->miSql->cadena_sql ( 'buscarPermiso', $calendarioPermiso ); // echo $cadenaSql;
		$permisoRegistrado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		
		// Si no existe ningún permiso se registra por primera vez
		if (is_array ( $permisoRegistrado )) {
			// contiene el permiso dentro de la cadena?
			if (strstr ( $permisoRegistrado [0] ['permiso'], $calendarioPermiso ['permiso'] )) {
				// Es igual?
				if ($permisoRegistrado [0] ['permiso'] == $calendarioPermiso ['permiso']) {
					// es el único, borrar el registro.;
					$calendarioPermiso ['id_calendario_permiso'] = $permisoRegistrado [0] ['id_calendario_permiso'];
					
					$cadenaSql = $this->miSql->cadena_sql ( 'borrarPermiso', $calendarioPermiso );
					$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'borrar' ); // solo para consulta colocar en el segundo parametro 'busqueda'

				} else {
					// No es el único, actializar cadena, 
					// se quita el permiso de la cadena
					$calendarioPermiso ['permiso'] = str_replace ( $calendarioPermiso ['permiso'], "", $permisoRegistrado [0] ['permiso'] );
					$calendarioPermiso ['id_calendario_permiso'] = $permisoRegistrado [0] ['id_calendario_permiso'];
					//se actualiza el registro
					$cadenaSql = $this->miSql->cadena_sql ( 'actualizarPermiso', $calendarioPermiso );
					$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'actualizar' ); // solo para consulta colocar en el segundo parametro 'busqueda'
				}
			} else {
				// No esta el permiso en la cadena, no hacer nada
				echo 'El permiso no está en la cadena';
				exit ();
			}
		} else {
			echo 'no existen permisos registrados';
			exit ();
		}
			
		// $this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'permisosCreados' );
		return $resultado;
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::actualizarCalendario()
	 */
	function actualizarCalendario($datos) {
		$this->miSql = new Sql ();
		$calendario = json_decode ( $datos, true );
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'actualizarCalendario', $calendario );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'actualizar' );
		if ($resultado == TRUE) {
			$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'calendarioEditado' );
		} else {
			$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'errorCalendarioEditado' );
		}
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::borrarCalendario()
	 */
	function borrarCalendario($datos) {
		$this->miSql = new Sql ();
		$calendario = json_decode ( $datos, true );
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'borrarCalendario', $calendario );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'actualizar' );
		if ($resultado == TRUE) {
			$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'calendarioBorrado' );
		} else {
			$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'errorCalendarioBorrado' );
		}
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::consultarCalendario()
	 */
	function consultarCalendario($id_calendario) {
		$this->miSql = new Sql ();
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		// si no se envía el parámetro $id_calendario (NULL) consulta todos los calendarios
		// Si se envía consulta solo un calendario
		
		$cadenaSql = $this->miSql->cadena_sql ( 'consultarCalendario', $id_calendario ); // echo $cadenaSql;
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		
		$this->miSql = new Sql ();
		
		if ($resultado == TRUE) {
			
			return $resultado [0];
		} else {
			echo 'Error en la consulta';
		}
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::consultarCalendariosUsuario()
	 */
	function consultarCalendariosUsuario($id_usuario) {
		$this->miSql = new Sql ();
		
		$this->miConfigurador = \Configurador::singleton ();
		// configuracion es el nombre de la conexión principal de SARA - se crea de forma automática tomando los
		// datos de config.inc.php
		$conexion = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->cadena_sql ( 'consultarCalendariosUsuario', $id_usuario );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		
		$this->miSql = new Sql ();
		
		if ($resultado == TRUE) {
			return $resultado;
		} else {
			return false;
		}
	}
}
