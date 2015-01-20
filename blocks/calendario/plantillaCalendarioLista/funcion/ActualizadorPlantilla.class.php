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
    	
    	$datos['id_plantilla']=$_REQUEST['id_plantilla']; 
    	$datos['nombre_plantilla']=$_REQUEST['nombre_plantilla'];
    	$datos['descripcion_plantilla']=$_REQUEST['descripcion_plantilla'];
    	$datos['propietario']=$_REQUEST['propietario'];
    	$datos['estado']=$_REQUEST['estado'];
    	
    	$datos=json_encode($datos);
    	
    	$usuario=$_REQUEST['id_usuario'];
    	
    	$miComponente=new Componente();
    	   
    	$resultadoPlantilla=$miComponente->actualizarPlantilla($datos);    	
    	
    	if ($resultadoPlantilla==TRUE) {
    		$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'plantillaEditada' );
    	}else {
    		$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'errorPlantillaEditada' );
    	}
    	
    	Redireccionador::redireccionar("actualizacionPlantillaOK", $usuario);
    	}else{
    		$datos['id_plantilla']=$_REQUEST['id_plantilla'];    		
    		$usuario=$_REQUEST['id_usuario'];
    		
    		Redireccionador::redireccionar("actualizacionPlantillaOK", $usuario);
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



