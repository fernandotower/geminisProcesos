<?php

namespace calendario\permisoCalendario;

use component\Calendar\Componente;

include_once ('Redireccionador.php');
include_once ('component/Calendar/Componente.php');
class ActualizadorPermiso {
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
		echo 'el editos por ajax';
		var_dump($_REQUEST);exit;
		
		$datos['id_usuario']=$_REQUEST['id_usuario'];
		// obtener la claves de arreglo, los checkbox seleccionados; tienen valor=on
		foreach ( $_REQUEST as $clave => $valor ) {
			if ($valor == 'on') {
				$seleccionados [] = json_decode ( $clave, true );
			}
		}
		unset($clave, $valor);
		
		//separa los permisos de los usuarios, es decir los checkbox de permisos de los checkbox de usuarios
		foreach ($seleccionados as $seleccionado) {
			if (isset($seleccionado['tipo'])) {
				$permisos[]=$seleccionado;
			}else {
				$usuarios[]=$seleccionado;
			}
		}
		
		
		//crear un arreglo con los que va a registrar en la base de datos
		foreach ($usuarios as $usuario) {
			foreach ($permisos as $clave=>$valor) {
				$registros[$clave.$usuario]['tipo_objeto']=$valor['tipo'];
				$registros[$clave.$usuario]['id_objeto']=$valor['id'];
				$registros[$clave.$usuario]['id_usuario']=$usuario;
				$registros[$clave.$usuario]['permiso']=$valor['permiso'];											
			}
			
		}		
		
		$miComponente = new Componente ();
		
		foreach ($registros as $registro) {

			$registroJson=json_encode($registro);
			$resultadoPermiso = $miComponente->registrarPermisoCalendario($registroJson);
		}		
		
		$this->resetForm ();
		
		Redireccionador::redireccionar ( "creacionPermisosOK", $datos );
	}
	function resetForm() {
		foreach ( $_REQUEST as $clave => $valor ) {
			
			if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
				unset ( $_REQUEST [$clave] );
			}
		}
	}
}
$miRegistrador = new ActualizadorPermiso ( $this->lenguaje, $this->sql );

$resultado = $miRegistrador->procesarFormulario ();



