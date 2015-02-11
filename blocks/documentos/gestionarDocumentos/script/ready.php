<?php
$_REQUEST ['tiempo'] = time ();
$this->site = $this->miConfigurador->getVariableConfiguracion ( "site" );

?>

setTimeout(function() {
    $('#divMensaje').hide( "drop", { direction: "up" }, "slow" );
}, 3000); // <-- time in milliseconds




  $('#<?php echo $this->campoSeguro('fecha_inicio');?>').datepicker({
	        dateFormat: 'dd/mm/yy',
	        //maxDate: 0,
	        changeYear: true,
	        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
				'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
				dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
				dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']
        });
        
$('#<?php echo $this->campoSeguro('fecha_fin');?>').datepicker({
	        dateFormat: 'dd/mm/yy',
	        //maxDate: 1,
	        changeYear: true,
	        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
				'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
				dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
				dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']
        });
        
      
        
// Asociar el widget de validación al formulario
     $("#calendarioLista").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
	         });
	

        $(function() {
            $("#calendarioLista").submit(function() {
                $resultado=$("#calendarioLista").validationEngine("validate");
                   
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });


$('#example').DataTable({
        	  	"jQueryUI": true,
        	  
				"language": {				
					"url":  "<?php echo $this->host.$this->site.'/plugin/scripts/javascript/datatables.esp.txt';?>"      																	    
  				}
        	          	               
        	});
        	        	
 
 
  $(function() {
$( "#tabs" ).tabs();
});
  

  
