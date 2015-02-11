<?php

namespace calendar;

use component\Calendar\Componente;
use calendario\calendarioLista\Redireccionador;

include_once ('Redireccionador.php');
include_once ('component/Calendar/Componente.php');
class RegistradorCalendario {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	var $conexion;
	function __construct($lenguaje, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
	}
	function procesarFormulario() {
		
		session_start ();
		// La veariable $_SESSION['verifica'] viene del formulario
		// se evita reenviar el formulario al enviar la página o ejecutar la instrucciones
		// sin pasar por el formulario		
		if (isset ( $_SESSION ['verificaReevio'] ) && $_SESSION ['verificaReevio'] == $_REQUEST ['campoSeguro']) {
			unset ( $_SESSION ['verificaReevio'] );
			
			$datos ['nombre_calendario'] = $_REQUEST ['nombre_calendario'];
			$datos ['descripcion_calendario'] = $_REQUEST ['descripcion_calendario'];
			$datos ['propietario'] = $_REQUEST ['propietario'];
			$datos ['zona_horaria'] = $_REQUEST ['zona_horaria'];
			$datos ['estado'] = 1; // Todo calendario nuevo se crea como borrador
			$datos ['id_plantilla'] = - 1;
			$datos ['id_proceso'] = $_REQUEST ['id_proceso'];
			$datos ['id_usuario'] = $_REQUEST ['id_usuario'];
			
			$datosCalendarioJson = json_encode ( $datos );
			
			$miComponente = new Componente ();
			
			$resultadoCalendario = $miComponente->crearCalendario ( $datosCalendarioJson );
			
			if ($resultadoCalendario == true) {
				// consulto el id_calendario asignado en el registro
				$secuencia = 'calendario_id_calendario_seq';
				$id_calendario = $resultadoSecuencia = $miComponente->consultarSecuencia ( $secuencia );
				
				$datos ['id_objeto'] = $id_calendario; // se agrega el valor de calendario insertado en el arreglo $datos
				$datos ['id_calendario'] = $id_calendario; // se agrega el valor de calendario insertado en el arreglo $datos
				$datos ['tipo_objeto'] = '1'; // calendario
				$datos ['permiso'] = 'p'; // propietario
				$datosCalendarioPermiso = json_encode ( $datos );
				
				$resultadoCalendario = $miComponente->registrarPermisoCalendario ( $datosCalendarioPermiso );
			}
			
			$this->resetForm ();
			
			Redireccionador::redireccionar ( "creacionCalendarioOK", $datos );
		} else {
			// Si no viene del formulario o trata de recargar pagina los enviamos al formulario
			$datos ['id_calendario'] = ''; // se agrega el valor de calendario insertado en el arreglo $datos
			$datos ['id_usuario'] = $_REQUEST ['id_usuario'];
			$datos ['permiso'] = 'p';
			Redireccionador::redireccionar ( "creacionCalendarioOK", $datos );
		}
	}
	function resetForm() {
		foreach ( $_REQUEST as $clave => $valor ) {
			
			if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
				unset ( $_REQUEST [$clave] );
			}
		}
	}
}
$miRegistrador = new RegistradorCalendario ( $this->lenguaje, $this->sql );

$resultado = $miRegistrador->procesarFormulario ();



