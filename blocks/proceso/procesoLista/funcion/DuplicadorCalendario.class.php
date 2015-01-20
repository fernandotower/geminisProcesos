<?php

namespace calendar;

use component\Calendar\Componente;
use calendario\calendarioLista\Redireccionador;

include_once ('Redireccionador.php');
include_once ('component/Calendar/Componente.php');
class DuplicadorCalendario {
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
		// echo 'Esta el la funcion Duplicador,Pasos: 
		//1. Registrar calendario, 
		//2. registrar usuario, 
		//3. consultar los eventos, 
		//4. insertar los eventos';exit;
		
		$datos ['id_calendario_base'] = $_REQUEST ['id_calendario'];
		$datos ['nombre_calendario'] = $_REQUEST ['nombre_calendario'];
		$datos ['descripcion_calendario'] = $_REQUEST ['descripcion_calendario'];
		$datos ['propietario'] = $_REQUEST ['propietario'];
		$datos ['zona_horaria'] = $_REQUEST ['zona_horaria'];
		$datos ['estado'] = 1; // Todo calendario nuevo se crea como borrador
		$datos ['id_proceso'] = $_REQUEST ['id_proceso'];		
		$datos ['id_plantilla'] = -1;
		$datos ['id_usuario'] = $_REQUEST ['id_usuario'];
		$datos ['permiso'] = $_REQUEST ['permiso'];
		
		$datosJson = json_encode ( $datos );
		
		
		$miComponente = new Componente ();
		
		$resultadoCalendario = $miComponente->crearCalendario ( $datosJson );
		
		if ($resultadoCalendario == true) {
			// consulto el id_calendario asignado en el registro
			$secuencia = 'calendario_id_calendario_seq';
			$id_calendario = $resultadoSecuencia = $miComponente->consultarSecuencia ( $secuencia );
			
			$datos ['id_calendario'] = $id_calendario; // se agrega el valor de calendario insertado en el arreglo $datos
			$datos ['id_objeto'] = $id_calendario; // se agrega el valor de calendario insertado en el arreglo $datos
			$datos ['tipo_objeto'] = '1';//calendario
			$datos ['permiso'] = 'p';//propietario			
			$datosCalendarioPermiso = json_encode ( $datos );
			
			$resultadoCalendario = $miComponente->registrarPermisoCalendario ( $datosCalendarioPermiso );
						
			
			if ($resultadoCalendario == true) {
				// consulta los eventos del calendario base
				$eventosCalendarioBase = $miComponente->consultarEvento ( $datos ['id_calendario_base'] );
				if ($eventosCalendarioBase) {
					foreach ( $eventosCalendarioBase as $evento => $valor ) {
						//$datosEvento ['id_evento']= $eventosCalendarioBase[$evento]['id_evento'];
						$datosEvento ['id_calendario']= $id_calendario;//se refiere al calendario nuevo
						$datosEvento ['nombre_evento']= $eventosCalendarioBase[$evento]['nombre_evento'];
						$datosEvento ['descripcion_evento']= $eventosCalendarioBase[$evento]['descripcion_evento'];
						$datosEvento ['tipo']= $eventosCalendarioBase[$evento]['tipo'];
						$datosEvento ['fecha_inicio']= $eventosCalendarioBase[$evento]['fecha_inicio'];
						$datosEvento ['fecha_fin']= $eventosCalendarioBase[$evento]['fecha_fin'];
						$datosEvento ['ubicacion']= $eventosCalendarioBase[$evento]['ubicacion'];
						$datosEvento ['estado']= $eventosCalendarioBase[$evento]['estado'];
						
						$datosEvento=json_encode($datosEvento);
						
						$resultadoEvento=$miComponente->crearEvento($datosEvento);
						unset ($datosEvento);
					}

					$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'calendarioDuplicado' );
				} else {
					$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'errorEventoDuplicado' );					
				}
			} else {
				echo "no se realizó el registro del calendario";
			}
		}
		
		$this->resetForm();
		
		Redireccionador::redireccionar ( "creacionCalendarioOK", $datos );
		}else{
			$datos ['id_calendario'] = ''; // se agrega el valor de calendario insertado en el arreglo $datos
			$datos ['id_usuario'] = $_REQUEST ['id_usuario'];
			$datos ['permiso'] = '';
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

$miDuplicador = new DuplicadorCalendario ( $this->lenguaje, $this->sql );

$resultado = $miDuplicador->procesarFormulario ();



