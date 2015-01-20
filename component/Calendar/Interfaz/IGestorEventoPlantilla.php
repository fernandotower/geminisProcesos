<?php

namespace component\Calendar\interfaz;

interface IGestorEventoPlantilla {
	function crearEventoPlantilla($datos);
	function borrarEventoPlantilla($datos);
	function actualizarEventoPlantilla($datos);
	function consultarEventosPlantilla($id_plantilla);
	function consultarEventoPlantilla($id_eventoplantilla);
	function crearRelacionEventos($datos);
	function actualizarRelacionEventos($datos);
	function consultarRelacionEventos($id_plantilla);
}

?>