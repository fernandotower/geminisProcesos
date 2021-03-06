<?php

namespace calendar;
use component\Calendar\Componente;
use calendario\calendarioLista\Redireccionador;

include_once('Redireccionador.php');
include_once('component/Calendar/Componente.php');

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
    	$datos['id_calendario']=$_REQUEST['id_calendario']; 
    	$datos['nombre_calendario']=$_REQUEST['nombre_calendario'];
    	$datos['descripcion_calendario']=$_REQUEST['descripcion_calendario'];
    	$datos['zona_horaria']=$_REQUEST['zona_horaria'];
    	$datos['estado']=$_REQUEST['estado'];
    	$datos['permiso']=$_REQUEST['permiso'];
    	$datos['id_usuario']=$_REQUEST['id_usuario'];
    	
    	$datosJson=json_encode($datos);
    	
    	
    	
    	$miComponente=new Componente();
    	   
    	$resultadoCalendario=$miComponente->actualizarCalendario($datosJson);    	
    	
    	Redireccionador::redireccionar("actualizacionCalendarioOK", $datos);
    	}else{
    		
    		$datos['id_calendario']=$_REQUEST['id_calendario'];
    		$datos['id_usuario']=$_REQUEST['id_usuario'];
    		$datos['permiso']=$_REQUEST['permiso'];
    		Redireccionador::redireccionar("actualizacionCalendarioOK", $datos);
    		
    	}
    	
    	   
        
    }
    
    function resetForm(){
        foreach($_REQUEST as $clave=>$valor){
             
            if($clave !='pagina' && $clave!='development' && $clave !='jquery' &&$clave !='tiempo'){
                unset($_REQUEST[$clave]);
            }
        }
    }

    function mostarFormularioCalendario($calendario) {    	    	
    	
    	$miBloque = $this->miConfigurador->getVariableConfiguracion ( 'esteBloque' );
    	$resultado = $this->miConfigurador->getVariableConfiguracion ( 'errorFormulario' );
    	include ($this->miConfigurador->getVariableConfiguracion ( 'rutaBloque' ) . 'formulario/consultorDatosCalendario.php');
    	    				/**echo $calendario['id_calendario']."-";
    				echo $calendario['nombre_calendario']."-";
    				echo $calendario['descripcion_calendario']."-";
    				echo $calendario['estado'];
    				echo "<br><br>";*/
    }    
    
    function mostrarDatosCalendario($calendario) {
    	var_dump($calendario);
    }
    
    
}





$miRegistrador = new RegistradorCalendario ( $this->lenguaje, $this->sql );

$resultado= $miRegistrador->procesarFormulario ();



