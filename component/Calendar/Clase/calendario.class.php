<?php
class calendario {
	public $festivos;
	public $ano;
	function __construct($ano) {
		$this->ano = $ano;
	}
	/**
	 * Dat
	 */
	function buscarFestivo() {
		// Tipo
		// 1:Fecha Fija
		// 2:Lunes siguiente
		// 3:Respecto a la Pascua Fijos
		// 4:Respecto a la Pascua Lunes siguiente
		
		// Festivos fecha fija
		$resultadoFestivos [] = array (
				'tipo' => '1',
				'mes' => '1',
				'dia' => '1',
				'descripcion' => 'Primero de Enero' 
		);
		$resultadoFestivos [] = array (
				'tipo' => '1',
				'mes' => '5',
				'dia' => '1',
				'descripcion' => 'Dia del Trabajo' 
		);
		$resultadoFestivos [] = array (
				'tipo' => '1',
				'mes' => '7',
				'dia' => '20',
				'descripcion' => 'Independencia' 
		);
		$resultadoFestivos [] = array (
				'tipo' => '1',
				'mes' => '8',
				'dia' => '7',
				'descripcion' => 'Batalla de Boyacá' 
		);
		$resultadoFestivos [] = array (
				'tipo' => '1',
				'mes' => '12',
				'dia' => '8',
				'descripcion' => 'Maria Inmaculada' 
		);
		$resultadoFestivos [] = array (
				'tipo' => '1',
				'mes' => '12',
				'dia' => '25',
				'descripcion' => 'Navidad' 
		);
		// festivos emiliani, se pasan al siguiente lunes
		$resultadoFestivos [] = array (
				'tipo' => '2',
				'mes' => '1',
				'dia' => '6',
				'descripcion' => 'Reyes Magos' 
		);
		$resultadoFestivos [] = array (
				'tipo' => '2',
				'mes' => '3',
				'dia' => '19',
				'descripcion' => 'San Jose' 
		);
		$resultadoFestivos [] = array (
				'tipo' => '2',
				'mes' => '6',
				'dia' => '29',
				'descripcion' => 'San Pedro y San Pablo' 
		);
		$resultadoFestivos [] = array (
				'tipo' => '2',
				'mes' => '8',
				'dia' => '15',
				'descripcion' => 'Asunción' 
		);
		$resultadoFestivos [] = array (
				'tipo' => '2',
				'mes' => '10',
				'dia' => '12',
				'descripcion' => 'Descubrimiento de América' 
		);
		$resultadoFestivos [] = array (
				'tipo' => '2',
				'mes' => '11',
				'dia' => '1',
				'descripcion' => 'Todos los santos' 
		);
		$resultadoFestivos [] = array (
				'tipo' => '2',
				'mes' => '11',
				'dia' => '11',
				'descripcion' => 'Independencia de Cartagena' 
		);
		// Festivos fijos respecto a la pascua
		$resultadoFestivos [] = array (
				'tipo' => '3',
				'mes' => '0',
				'dia' => '0',
				'descripcion' => 'jueves santo' 
		);
		
		foreach ( $resultadoFestivos as $clave => $valor ) {
			if ($resultadoFestivos [$clave] ['tipo'] == '1') {
				$this->festivos = $resultadoFestivos;
			}
		}
		
		foreach ( $resultadoFestivos as $clave => $valor ) {
			if ($resultadoFestivos [$clave] ['tipo'] == '2') {
				// $this->festivos=$resultadoFestivos;
				$emiliani = $this->calcula_emiliani ( $resultadoFestivos [$clave] ['mes'], $resultadoFestivos [$clave] ['dia'] );
				$this->festivos [$clave] ['tipo'] = $resultadoFestivos [$clave] ['tipo'];
				$this->festivos [$clave] ['mes'] = $emiliani ['mes'];
				$this->festivos [$clave] ['dia'] = $emiliani ['dia'];
				$this->festivos [$clave] ['descripcion'] = $resultadoFestivos [$clave] ['descripcion'];
			}
		}
		
		//número de días después del 21 de marzo
		$pascua_dias=easter_days($this->ano);
		//fecha base (21 de marzo) + los días obtenidos para el año especifico
		$pascua = new DateTime($this->ano.'-03-21');
		$pascua->add(new DateInterval('P'.$pascua_dias.'D'));
		var_dump($pascua);exit;
		
		var_dump ( $this->festivos );
		exit ();
	}
	function calcularFechaFinalDiasHabiles($fechaIni, $intervalo) {
		;
	}
	function calcularFechaFinalDiasCalendario($fechaIni, $intervalo) {
		;
	}
	
	/**
	 * Función que pasa el festivo al siguiente lunes de acuerdo a la ley emiliani
	 *
	 * @param unknown $mes
	 *        	// mes del festivo
	 * @param unknown $dia
	 *        	// dia del festivo
	 */
	function calcula_emiliani($mes, $dia) {
		
		// Extrae el dia de la semana, 0 Domingo, 6 Sábado
		$diaDeSemana = date ( "w", mktime ( 0, 0, 0, $mes, $dia, $this->ano ) );
		switch ($diaDeSemana) {
			case 0 : // Domingo
				$dia = $dia + 1;
				break;
			case 2 : // Martes.
				$dia = $dia + 6;
				break;
			case 3 : // Miércoles
				$dia = $dia + 5;
				break;
			case 4 : // Jueves
				$dia = $dia + 4;
				break;
			case 5 : // Viernes
				$dia = $dia + 3;
				break;
			case 6 : // Sábado
				$dia = $dia + 2;
				break;
		}
		$mes = date ( "n", mktime ( 0, 0, 0, $mes, $dia, $this->ano ) ) + 0;
		$dia = date ( "d", mktime ( 0, 0, 0, $mes, $dia, $this->ano ) ) + 0;
		return array (
				'mes' => $mes,
				'dia' => $dia 
		);
	}
}

$miFecha = new calendario ( 2014 );
$miFecha->buscarFestivo ();
var_dump ( $miFecha->festivos );
?>