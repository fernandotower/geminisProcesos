<?php

namespace proceso\procesoLista;

// Evitar un acceso directo a este archivo
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

// Todo bloque debe implementar la interfaz Bloque
include_once ("core/builder/Bloque.interface.php");

include_once ("core/manager/Configurador.class.php");
//include_once ("core/connection/DAL.class.php");
include_once ("core/connection/Persistencia.class.php");
include_once ("core/general/Rango.class.php");
include_once ("core/general/Tipos.class.php");
include_once ("component/GestorProcesos/Componente.php");

use component\GestorProcesos\Componente as GestorProcesos;

// Elementos que constituyen un bloque típico CRUD.

// Interfaz gráfica
include_once ("Frontera.class.php");

// Funciones de procesamiento de datos
include_once ("Funcion.class.php");

// Compilación de clausulas SQL utilizadas por el bloque
include_once ("Sql.class.php");

// Mensajes
include_once ("Lenguaje.class.php");	

// Esta clase actua como control del bloque en un patron FCE

// Para evitar redefiniciones de clases el nombre de la clase del archivo bloque debe corresponder al nombre del bloque
// precedida por la palabra Bloque
if (!class_exists ( '\\proceso\\procesoLista\\Bloque' )) {
	class Bloque implements \Bloque {
		var $nombreBloque;
		var $miFuncion;
		var $miSql;
		var $miConfigurador;
		public 

		function __construct($esteBloque, $lenguaje = "") {
			
			// El objeto de la clase Configurador debe ser único en toda la aplicación
			$this->miConfigurador = \Configurador::singleton ();
			
			$ruta = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" );
			$rutaURL = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" );
			
			if (! isset ( $esteBloque ["grupo"] ) || $esteBloque ["grupo"] == "") {
				$ruta .= "/blocks/" . $esteBloque ["nombre"] . "/";
				$rutaURL .= "/blocks/" . $esteBloque ["nombre"] . "/";
			} else {
				$ruta .= "/blocks/" . $esteBloque ["grupo"] . "/" . $esteBloque ["nombre"] . "/";
				$rutaURL .= "/blocks/" . $esteBloque ["grupo"] . "/" . $esteBloque ["nombre"] . "/";
			}
			
			$this->miConfigurador->setVariableConfiguracion ( "rutaBloque", $ruta );
			$this->miConfigurador->setVariableConfiguracion ( "rutaUrlBloque", $rutaURL );
			
			$this->miFuncion = new Funcion ();
			$this->miSql = new Sql ();
			$this->miFrontera = new Frontera ();
			$this->miLenguaje = new Lenguaje ();
		}
		public function bloque() {
			
			//var_dump($_REQUEST);
			$dal = new \DAL();
			//$dal->setEstadoHistorico(true);
			//$dal->setConexion('academica');
			//$dal->setConexion('estructura');
			//var_dump($dal->getListaOperacion());
			//var_dump($dal->consultarFlujoProceso());
			//var_dump($dal->getQuery());
			//var_dump($dal->getConexion());
			//var_dump($dal->getTablaAlias());
			//exit;
			//var_dump(\Tipos::validarTipo(3.3,3));
			//var_dump(\Tipos::validarTipo('',6));
			//var_dump(\Tipos::evaluarTipo('hhh',6));
			//var_dump(\Rango::validarRango(10.6,3,"0,10"));
			//var_dump($dal->getEstadoHistorico());
			//var_dump($dal->getListaColumnas());
            //var_dump($dal->getListaPermiso());
			//var_dump($dal->getListaObjetos());
			//var_dump($dal->getEstadoRegistro(1,'id','uuid'));
			//var_dump($dal->getTipoDato(1,'id','alias'));
			$parametros['id'] = 1;
			//$parametros['nombre'] = 'carlos';
			//$parametros['alias'] = 'carlos288';
			//$parametros['descripcion'] = 'carlos';
			//var_dump($dal->consultarUsuario($parametros));
			//var_dump($dal->crearUsuario($parametros));
			//var_dump($dal->eliminarUsuario($parametros));
			//var_dump($dal->actualizarUsuario($parametros));
			//var_dump($dal->duplicarUsuario($parametros));
			//$per = new \Persistencia('estructura','core.core_objetos');
			//var_dump($per->getListaColumnas());
			
			$gp = new GestorProcesos;
			$idProceso = 1;
			var_dump($gp->ejecutarProceso($idProceso));
			//var_dump($gp->probarFuncion());
			
			
			
			exit;
			
			if (isset ( $_REQUEST ['botonCancelar'] ) && $_REQUEST ['botonCancelar'] == "true") {
				$this->miFuncion->redireccionar ( "paginaPrincipal" );
			} else {
				
				$this->miFrontera->setSql ( $this->miSql );
				$this->miFrontera->setFuncion ( $this->miFuncion );
				$this->miFrontera->setLenguaje ( $this->miLenguaje );
				
				$this->miFuncion->setSql ( $this->miSql );
				$this->miFuncion->setFuncion ( $this->miFuncion );
				$this->miFuncion->setLenguaje ( $this->miLenguaje );
				
				if (! isset ( $_REQUEST ['action'] )) {					
					$this->miFrontera->frontera ();
				} else {
					
					$respuesta = $this->miFuncion->action ();
				}
			}
		}
	}
}
// @ Crear un objeto bloque especifico
// El arreglo $unBloque está definido en el objeto de la clase ArmadorPagina o en la clase ProcesadorPagina

if (isset ( $_REQUEST ["procesarAjax"] )) {
	$unBloque ["nombre"] = $_REQUEST ["bloqueNombre"];
	$unBloque ["grupo"] = $_REQUEST ["bloqueGrupo"];
}

$this->miConfigurador->setVariableConfiguracion ( "esteBloque", $unBloque );

if (isset ( $lenguaje )) {
	$esteBloque = new Bloque ( $unBloque, $lenguaje );
} else {
	$esteBloque = new Bloque ( $unBloque );
}
$esteBloque->bloque ();

?>
