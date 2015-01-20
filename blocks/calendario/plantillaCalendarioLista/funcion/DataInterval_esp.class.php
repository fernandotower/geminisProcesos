<?php

/**
 * Esta clase codifica y decodifica los valores, año, mes, dia, hora, minuto, segundo 
 * para el manejo del objeto de php DateInterval  
 * @author fernando
 *
 */
class DateInterval_esp extends DateInterval {
	public $intervalo;
	
	/**
	 * Crea una cadena DateInterval del tipo P0Y0M0DT0H0M0S
	 * a partir de las variables ano, mes, dia, hora, minuto,segundo
	 * para mas información remitase a la documentación del objeto DateInterval de php.
	 *
	 * @param $y, $m, $d, $h, $i, $s ; integer
	 */
	function ArmarStringDateInterval($y, $m, $d, $h, $i, $s) {
		
		$intervaloTiempo = "P";
		
		if (isset ( $_REQUEST ['anos'] ) and $_REQUEST ['anos'] !== "" and $_REQUEST ['anos'] !== "0") {
			$intervaloTiempo .= $_REQUEST ['anos'] . "Y";
		}
		if (isset ( $_REQUEST ['meses'] ) and $_REQUEST ['meses'] !== "" and $_REQUEST ['meses'] !== "0") {
			$intervaloTiempo .= $_REQUEST ['meses'] . "M";
		}
		if (isset ( $_REQUEST ['dias'] ) and $_REQUEST ['dias'] !== "" and $_REQUEST ['dias'] !== "0") {
			$intervaloTiempo .= $_REQUEST ['dias'] . "D";
		}
		if ($_REQUEST ['horas'] || $_REQUEST ['minutos'] || $_REQUEST ['segundos']) {
			$intervaloTiempo .= "T";
		}
		if (isset ( $_REQUEST ['horas'] ) and $_REQUEST ['horas'] !== "" and $_REQUEST ['horas'] !== "0") {
			$intervaloTiempo .= $_REQUEST ['horas'] . "H";
		}
		if (isset ( $_REQUEST ['minutos'] ) and $_REQUEST ['minutos'] !== "" and $_REQUEST ['minutos'] !== "0") {
			$intervaloTiempo .= $_REQUEST ['horas'] . "M";
		}
		if (isset ( $_REQUEST ['segundos'] ) and $_REQUEST ['segundos'] !== "" and $_REQUEST ['segundos'] !== "0") {
			$intervaloTiempo .= $_REQUEST ['segundos'] . "S";
		}
		// pasa la cadena intervalo de tiempo P0Y0M0DT0H0M0S para despues se creado el objeto DateInterval ej:
		// $intervaloTiempo = new \DateInterval ( $intervaloTiempo ); // P0Y0M0DT0H0M0S
		
		return $intervaloTiempo;
	}
}
?>