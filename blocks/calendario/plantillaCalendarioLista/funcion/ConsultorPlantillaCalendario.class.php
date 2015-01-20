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

    	$usuario= $_REQUEST['id_usuario'];
    	// 1. Invocar al componente calendario
    	//$miComponente=new Componente();    	 
    	
    	//$resultadoCalendario=$miComponente->consultarCalendariosUsuario($usuario);
    	//$resultadoCalendario=json_encode($resultadoCalendario);
    	   	
    	Redireccionador::redireccionar("consultaPlantillaOK", $usuario);
    	
    	
    
    	/*
    	
    	foreach ($resultadoCalendario as $valor) {
    				$calendarios[]= $valor['id_calendario'];
    	}
    	
    	$numeroCalendario=array_unique($calendarios);
    	
    	//include_once ("core/builder/FormularioHtml.class.php");
    	 
    	$this->ruta = $this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );
    	$this->miFormulario = new \FormularioHtml ();
    	foreach ($numeroCalendario as $numero) {
    		foreach ($resultadoCalendario as $calendario) {
    			if ($numero==$calendario['id_calendario']){
    				
    				//$this->mostarFormularioCalendario($calendario);    				
					//$this->mostrarDatosCalendario($calendario);
    				$evento[$calendario['id_evento']]['id_calendario']=$calendario['id_calendario'];
    				$evento[$calendario['id_evento']]['id_evento']=$calendario['id_evento'];
    				$evento[$calendario['id_evento']]['nombre_evento']=$calendario['nombre_evento'];
    				$evento[$calendario['id_evento']]['descripcion_evento']=$calendario['descripcion_evento'];
    				$evento[$calendario['id_evento']]['fecha_inicio']=$calendario['fecha_inicio'];
    				$evento[$calendario['id_evento']]['fecha_fin']=$calendario['fecha_fin'];
    				
    			}
    		}
    	}
    	
    	
    	
    	exit;
    	foreach ($resultadoCalendario as $clave => $valor){
    		
    		echo "Número calendario: ".$valor['id_calendario']."<br>";
    		echo "Nombre calendario: ".$valor['nombre_calendario']."<br>";
    		echo "Descripción calendario: ".$valor['descripcion_calendario']."<br>";
    		echo "Número evento: ".$valor['id_evento']."<br>";
    		echo "Nombre evento: ".$valor['nombre_evento']."<br>";
    		echo "Descripción evento: ".$valor['descripcion_evento']."<br>";
    		echo "Fecha inicio: ".$valor['fecha_inicio']."<br>";
    		echo "Fecha fin: ".$valor['fecha_fin']."<br>";
    		echo "Ubicación evento: ".$valor['ubicacion']."<br><br><br>";
    		
    	}
    	
    	*/
        
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



