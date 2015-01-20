<?php

namespace component\GestorProcesos;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class Sql extends \Sql {
	var $miConfigurador;
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
	}
	function cadena_sql($tipo, $variable = "") {
		
		/**
		 * 1.
		 * Revisar las variables para evitar SQL Injection
		 */
		$prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
		$idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
		
		switch ($tipo) {
			
			/**
			 * Clausulas específicas
			 */
			
			// CALENDARIOS////////////////////////////
			
			case "insertarCalendario" :
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= " calendario";
				$cadenaSql .= " (";
				$cadenaSql .= " nombre_calendario, ";
				$cadenaSql .= " descripcion_calendario, ";
				$cadenaSql .= " propietario, ";
				$cadenaSql .= " zona_horaria, ";
				$cadenaSql .= " id_plantilla, ";
				$cadenaSql .= " estado, ";
				$cadenaSql .= " id_proceso ";
				$cadenaSql .= ")";
				$cadenaSql .= " VALUES (";
				$cadenaSql .= " '" . $variable ['nombre_calendario'] . "',";
				$cadenaSql .= " '" . $variable ['descripcion_calendario'] . "',";
				$cadenaSql .= " '" . $variable ['propietario'] . "',";
				$cadenaSql .= " '" . $variable ['zona_horaria'] . "',";
				$cadenaSql .= " '" . $variable ['id_plantilla'] . "',"; // solamente cuando perte de una plantilla
				$cadenaSql .= " '" . $variable ['estado'] . "',";
				$cadenaSql .= " '" . $variable ['id_proceso'] . "'";
				$cadenaSql .= " )";
				
				break;
			
			case "insertarPermiso" :
				$cadenaSql = " INSERT INTO calendario_permiso";
				$cadenaSql .= " (";
				$cadenaSql .= " tipo_objeto, ";
				$cadenaSql .= " id_objeto, ";
				$cadenaSql .= " id_usuario, ";
				$cadenaSql .= " permiso ";
				$cadenaSql .= " )";
				$cadenaSql .= " VALUES (";
				$cadenaSql .= " '" . $variable ['tipo_objeto'] . "',";
				$cadenaSql .= " '" . $variable ['id_objeto'] . "',";
				$cadenaSql .= " '" . $variable ['id_usuario'] . "',";
				$cadenaSql .= " '" . $variable ['permiso'] . "'";
				$cadenaSql .= " )";
				
				break;
			
			case "consultarSecuencia" :
				$cadenaSql = "SELECT  ";
				$cadenaSql .= " currval('" . $variable . "')";
				
				break;
			
			case "actualizarCalendario" :
				$cadenaSql = "UPDATE ";
				$cadenaSql .= " calendario";
				$cadenaSql .= " SET ";
				$cadenaSql .= " nombre_calendario='" . $variable ['nombre_calendario'] . "',";
				$cadenaSql .= " descripcion_calendario='" . $variable ['descripcion_calendario'] . "',";
				// $cadenaSql .= " propietario='" . $variable ['propietario'] . "',";
				$cadenaSql .= " zona_horaria='" . $variable ['zona_horaria'] . "',";
				$cadenaSql .= " estado='" . $variable ['estado'] . "'";
				$cadenaSql .= " WHERE id_calendario='" . $variable ['id_calendario'] . "'";
				
				break;
			
			case "borrarCalendario" :
				$cadenaSql = "UPDATE ";
				$cadenaSql .= " calendario";
				$cadenaSql .= " SET ";
				$cadenaSql .= " estado='" . $variable ['estado'] . "'";
				$cadenaSql .= " WHERE id_calendario='" . $variable ['id_calendario'] . "'";
				
				break;
			
			case "consultarCalendario" :
				$cadenaSql = "SELECT ";
				$cadenaSql .= " id_calendario, ";
				$cadenaSql .= " nombre_calendario, ";
				$cadenaSql .= " descripcion_calendario, ";
				$cadenaSql .= " propietario, ";
				$cadenaSql .= " zona_horaria, ";
				$cadenaSql .= " estado, ";
				$cadenaSql .= " id_plantilla, ";
				$cadenaSql .= " id_proceso, ";
				$cadenaSql .= " id_usuario, ";
				$cadenaSql .= " permiso";
				$cadenaSql .= " FROM";
				$cadenaSql .= " calendario";
				$cadenaSql .= " INNER JOIN";
				$cadenaSql .= " calendario_permiso";
				$cadenaSql .= " ON id_calendario=id_objeto";
				$cadenaSql .= " WHERE";
				$cadenaSql .= " id_calendario='" . $variable . "'";
				
				break;
			
			case "consultarCalendarioTodos" :
				$cadenaSql = "SELECT ";
				$cadenaSql .= " id_calendario, ";
				$cadenaSql .= " nombre, ";
				$cadenaSql .= " descripcion, ";
				$cadenaSql .= " propietario, ";
				$cadenaSql .= " zona_horaria, ";
				$cadenaSql .= " estado ";
				$cadenaSql .= " FROM";
				$cadenaSql .= " calendario";
				// $cadenaSql .= " WHERE";
				// $cadenaSql .= " id_calendario='". $variable ['id_calendario'] . "'";
				
				break;
			case "consultarCalendariosUsuario" :
				$cadenaSql = " SELECT ";
				$cadenaSql .= " id_calendario, ";
				$cadenaSql .= " nombre_calendario, ";
				$cadenaSql .= " descripcion_calendario, ";
				$cadenaSql .= " propietario, ";
				$cadenaSql .= " zona_horaria, ";
				$cadenaSql .= " estado, ";
				$cadenaSql .= " id_plantilla, ";
				$cadenaSql .= " id_proceso, ";
				$cadenaSql .= " id_usuario, ";
				$cadenaSql .= " tipo_objeto, ";
				$cadenaSql .= " permiso";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " calendario";
				$cadenaSql .= " INNER JOIN";
				$cadenaSql .= " calendario_permiso ON id_calendario = id_objeto";
				$cadenaSql .= " WHERE id_usuario=" . $variable;
				
				break;
			
			// EVENTOS//////////////////////////
			
			case "insertarEvento" :
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= " evento";
				$cadenaSql .= " (";
				$cadenaSql .= " id_calendario, ";
				$cadenaSql .= " nombre_evento, ";
				$cadenaSql .= " descripcion_evento, ";
				$cadenaSql .= " tipo, ";
				$cadenaSql .= " fecha_inicio, ";
				$cadenaSql .= " fecha_fin, ";
				$cadenaSql .= " ubicacion, ";
				$cadenaSql .= " estado ";
				$cadenaSql .= ")";
				$cadenaSql .= " VALUES (";
				$cadenaSql .= " '" . $variable ['id_calendario'] . "',";
				$cadenaSql .= " '" . $variable ['nombre_evento'] . "',";
				$cadenaSql .= " '" . $variable ['descripcion_evento'] . "',";
				$cadenaSql .= " '" . $variable ['tipo'] . "',";
				$cadenaSql .= " '" . $variable ['fecha_inicio'] . "',";
				$cadenaSql .= " '" . $variable ['fecha_fin'] . "',";
				$cadenaSql .= " '" . $variable ['ubicacion'] . "',";
				$cadenaSql .= " '" . $variable ['estado'] . "'";
				$cadenaSql .= " )";
				
				break;
			
			case "actualizarEvento" :
				$cadenaSql = "UPDATE ";
				$cadenaSql .= " evento";
				$cadenaSql .= " SET ";
				$cadenaSql .= " id_calendario='" . $variable ['id_calendario'] . "',";
				$cadenaSql .= " nombre_evento='" . $variable ['nombre_evento'] . "',";
				$cadenaSql .= " descripcion_evento='" . $variable ['descripcion_evento'] . "',";
				$cadenaSql .= " tipo='" . $variable ['tipo'] . "',";
				$cadenaSql .= " fecha_inicio='" . $variable ['fecha_inicio'] . "',";
				$cadenaSql .= " fecha_fin='" . $variable ['fecha_fin'] . "',";
				$cadenaSql .= " ubicacion='" . $variable ['ubicacion'] . "',";
				$cadenaSql .= " estado='" . $variable ['estado'] . "'";
				$cadenaSql .= " WHERE id_evento='" . $variable ['id_evento'] . "'";
				
				break;
			
			case "borrarEvento" :
				$cadenaSql = "UPDATE ";
				$cadenaSql .= " evento";
				$cadenaSql .= " SET ";
				$cadenaSql .= " estado='" . $variable ['estado'] . "'";
				$cadenaSql .= " WHERE id_evento='" . $variable ['id_evento'] . "'";
				
				break;
			
			case "consultarEvento" :
				$cadenaSql = " SELECT ";
				$cadenaSql .= " id_evento, ";
				$cadenaSql .= " id_calendario,";
				$cadenaSql .= " nombre_evento,";
				$cadenaSql .= " descripcion_evento,";
				$cadenaSql .= " tipo, ";
				$cadenaSql .= " fecha_inicio, ";
				$cadenaSql .= " fecha_fin, ";
				$cadenaSql .= " ubicacion, ";
				$cadenaSql .= " estado";
				$cadenaSql .= " FROM evento";
				$cadenaSql .= " WHERE id_calendario='" . $variable . "'";
				
				break;
			
			// PLANTILLAS///////
			
			case "consultarPlantillaPermiso" :
				$cadenaSql = " SELECT ";
				$cadenaSql .= " id_plantilla, ";
				$cadenaSql .= " nombre_plantilla, ";
				$cadenaSql .= " descripcion_plantilla, ";
				$cadenaSql .= " propietario, ";
				$cadenaSql .= " estado, ";
				$cadenaSql .= " id_proceso, ";
				$cadenaSql .= " tipo_objeto, ";
				$cadenaSql .= " id_objeto, ";
				$cadenaSql .= " id_usuario, ";
				$cadenaSql .= " permiso";
				$cadenaSql .= " FROM plantillacalendario";
				$cadenaSql .= " INNER JOIN calendario_permiso";
				$cadenaSql .= " ON id_plantilla = id_objeto";
				$cadenaSql .= " WHERE";
				$cadenaSql .= " id_usuario='" . $variable . "'";
				
				break;
			
			case "consultarPlantilla" :
				$cadenaSql = " SELECT ";
				$cadenaSql .= " id_plantilla, ";
				$cadenaSql .= " nombre_plantilla, ";
				$cadenaSql .= " descripcion_plantilla, ";
				$cadenaSql .= " propietario ";
				// $cadenaSql .= " plantillacalendario.estado";
				$cadenaSql .= " FROM plantillacalendario";
				$cadenaSql .= " WHERE";
				$cadenaSql .= " id_plantilla='" . $variable . "'";
				
				break;
			
			case "insertarPlantilla" :
				$cadenaSql = " INSERT INTO plantillacalendario";
				$cadenaSql .= " (";
				$cadenaSql .= " nombre_plantilla,";
				$cadenaSql .= " descripcion_plantilla,";
				$cadenaSql .= " propietario,";
				$cadenaSql .= " estado,";
				$cadenaSql .= " id_proceso";
				$cadenaSql .= " )";
				$cadenaSql .= " VALUES";
				$cadenaSql .= " (";
				$cadenaSql .= " '" . $variable ['nombre_plantilla'] . "',";
				$cadenaSql .= " '" . $variable ['descripcion_plantilla'] . "',";
				$cadenaSql .= " '" . $variable ['propietario'] . "',";
				$cadenaSql .= " '" . $variable ['estado'] . "',";
				$cadenaSql .= " '" . $variable ['id_proceso'] . "'";
				$cadenaSql .= " )";
				
				break;
			
			case "insertarPlantillaUsuario" :
				$cadenaSql = " INSERT INTO ";
				$cadenaSql .= " plantillacalendario_usuario";
				$cadenaSql .= " (";
				$cadenaSql .= " id_usuario,";
				$cadenaSql .= " id_plantilla,";
				$cadenaSql .= " privilegio,";
				$cadenaSql .= " id_proceso,";
				$cadenaSql .= " estado)";
				$cadenaSql .= " VALUES ";
				$cadenaSql .= " (";
				$cadenaSql .= " '" . $variable ['propietario'] . "',";
				$cadenaSql .= " '" . $variable ['id_plantilla'] . "',";
				$cadenaSql .= " '" . $variable ['privilegio'] . "',";
				$cadenaSql .= " '" . $variable ['id_proceso'] . "',";
				$cadenaSql .= " '" . $variable ['estado'] . "'";
				$cadenaSql .= " )";
				
				break;
			
			case "actualizarPlantilla" :
				$cadenaSql = " UPDATE";
				$cadenaSql .= " plantillacalendario";
				$cadenaSql .= " SET";
				$cadenaSql .= " nombre_plantilla='" . $variable ['nombre_plantilla'] . "',";
				$cadenaSql .= " descripcion_plantilla='" . $variable ['descripcion_plantilla'] . "',";
				$cadenaSql .= " propietario='" . $variable ['propietario'] . "',";
				$cadenaSql .= " estado='" . $variable ['estado'] . "'";
				$cadenaSql .= " WHERE id_plantilla='" . $variable ['id_plantilla'] . "'";
				
				break;
			
			// Eventos de plantilla
			
			case "insertarEventoPlantilla" :
				$cadenaSql = " INSERT INTO plantillaevento";
				$cadenaSql .= " (";
				$cadenaSql .= " id_plantilla,";
				$cadenaSql .= " nombre_plantillaevento,";
				$cadenaSql .= " descripcion_plantillaevento,";
				$cadenaSql .= " tipo,";
				$cadenaSql .= " estado";
				$cadenaSql .= " )";
				$cadenaSql .= " VALUES";
				$cadenaSql .= " (";
				$cadenaSql .= " '" . $variable ['id_plantilla'] . "',";
				$cadenaSql .= " '" . $variable ['nombre_plantillaevento'] . "',";
				$cadenaSql .= " '" . $variable ['descripcion_plantillaevento'] . "',";
				$cadenaSql .= " '" . $variable ['tipo'] . "',";
				$cadenaSql .= " '" . $variable ['estado'] . "'";
				$cadenaSql .= " )";
				
				break;
			
			case "actualizarEventoPlantilla" :
				$cadenaSql = " UPDATE ";
				$cadenaSql .= " plantillaevento";
				$cadenaSql .= " SET ";
				$cadenaSql .= " id_plantilla='" . $variable ['id_plantilla'] . "',";
				$cadenaSql .= " nombre_plantillaevento='" . $variable ['nombre_plantillaevento'] . "',";
				$cadenaSql .= " descripcion_plantillaevento='" . $variable ['descripcion_plantillaevento'] . "',";
				$cadenaSql .= " tipo='" . $variable ['tipo'] . "',";
				$cadenaSql .= " estado='" . $variable ['estado'] . "'";
				$cadenaSql .= " WHERE id_plantillaevento='" . $variable ['id_plantillaevento'] . "'";
				break;
			
			case "consultarEventosPlantilla" :
				$cadenaSql = " SELECT ";
				$cadenaSql .= " id_plantillaevento, ";
				$cadenaSql .= " id_plantilla,";
				$cadenaSql .= " nombre_plantillaevento,";
				$cadenaSql .= " descripcion_plantillaevento,";
				$cadenaSql .= " tipo, ";
				$cadenaSql .= " estado";
				$cadenaSql .= " FROM plantillaevento";
				$cadenaSql .= " WHERE id_plantilla='" . $variable . "'";
				$cadenaSql .= " ORDER BY id_plantillaevento ASC";
				
				break;
			
			case "consultarEventoPlantilla" :
				$cadenaSql = " SELECT ";
				$cadenaSql .= " id_plantillaevento, ";
				$cadenaSql .= " id_plantilla,";
				$cadenaSql .= " nombre_plantillaevento,";
				$cadenaSql .= " descripcion_plantillaevento,";
				$cadenaSql .= " tipo, ";
				$cadenaSql .= " estado";
				$cadenaSql .= " FROM plantillaevento";
				$cadenaSql .= " WHERE id_plantillaevento='" . $variable . "'";
				$cadenaSql .= " ORDER BY id_plantillaevento ASC";
				
				break;
			
			case "borrarEventoPlantilla" :
				$cadenaSql = " DELETE ";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " plantillaevento";
				$cadenaSql .= " WHERE ";
				$cadenaSql .= " id_plantillaevento='" . $variable ['id_plantillaevento'] . "'";
				
				break;
			
			// Relación de eventos d plantilla
			
			case "insertarRelacionEventos" :
				
				$cadenaSql = " INSERT INTO ";
				$cadenaSql .= " plantillaevento_orden";
				$cadenaSql .= " (";
				$cadenaSql .= " id_plantilla, ";
				$cadenaSql .= " posicion, ";
				$cadenaSql .= " id_evento1,";
				$cadenaSql .= " id_evento2, ";
				$cadenaSql .= " intervalo";
				$cadenaSql .= " )";
				$cadenaSql .= " VALUES ";
				$cadenaSql .= " (";
				$cadenaSql .= " '" . $variable ['id_plantilla'] . "',";
				$cadenaSql .= " '" . $variable ['posicion'] . "',";
				$cadenaSql .= " '" . $variable ['id_evento1'] . "',";
				$cadenaSql .= " '" . $variable ['id_evento2'] . "',";
				$cadenaSql .= " '" . $variable ['intervalo'] . "'";
				$cadenaSql .= " )";
				
				break;
			
			case "borrarRelacionEventoPlantilla" :
				
				$cadenaSql = " DELETE";
				$cadenaSql .= " FROM";
				$cadenaSql .= " plantillaevento_orden";
				$cadenaSql .= " WHERE";
				// $cadenaSql .= " id_evento1=" . $variable ['id_plantillaevento'] . "";
				// $cadenaSql .= " OR";
				$cadenaSql .= " id_evento2=" . $variable ['id_plantillaevento'] . "";
				
				break;
			
			case "actualizarRelacionEventos" :
				
				$cadenaSql = " UPDATE ";
				$cadenaSql .= " plantillaevento_orden";
				$cadenaSql .= " SET ";
				$cadenaSql .= " posicion='" . $variable ['posicion'] . "',";
				$cadenaSql .= " id_evento1='" . $variable ['id_evento1'] . "',";
				$cadenaSql .= " id_evento2='" . $variable ['id_evento2'] . "',";
				$cadenaSql .= " intervalo='" . $variable ['intervalo'] . "'";
				$cadenaSql .= " WHERE ";
				$cadenaSql .= " id_plantillaevento_orden='" . $variable ['id_plantillaevento_orden'] . "'";
				
				break;
			
			case "consultarPosicionEvento1" :
				
				$cadenaSql = " SELECT";
				$cadenaSql .= " posicion";
				$cadenaSql .= " FROM plantillaevento_orden";
				$cadenaSql .= " WHERE";
				$cadenaSql .= " id_evento2='" . $variable . "'";
				
				break;
			
			case "consultarRelacionEventos" :
				
				$cadenaSql = " SELECT ";
				$cadenaSql .= " id_plantillaevento_orden, ";
				$cadenaSql .= " id_plantilla, ";
				$cadenaSql .= " posicion, ";
				$cadenaSql .= " id_evento1, ";
				$cadenaSql .= " id_evento2,";
				$cadenaSql .= " intervalo";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " plantillaevento_orden";
				$cadenaSql .= " WHERE ";
				$cadenaSql .= " id_plantilla='" . $variable . "'";
				$cadenaSql .= " ORDER BY posicion ASC";
				break;
			
			// //////////////////////////////permiso
			
			case "buscarPermiso" :
				
				$cadenaSql = " SELECT ";
				$cadenaSql .= " id_calendario_permiso, ";
				$cadenaSql .= " tipo_objeto, ";
				$cadenaSql .= " id_objeto, ";
				$cadenaSql .= " id_usuario, ";
				$cadenaSql .= " permiso";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " calendario_permiso";
				$cadenaSql .= " WHERE tipo_objeto='" . $variable ['tipo_objeto'] . "'";
				$cadenaSql .= " AND id_objeto='" . $variable ['id_objeto'] . "'";
				$cadenaSql .= " AND id_usuario='" . $variable ['id_usuario'] . "'";
				break;
		}
		
		return $cadenaSql;
	}
}
?>
