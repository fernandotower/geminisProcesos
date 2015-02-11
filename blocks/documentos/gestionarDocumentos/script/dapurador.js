<?php 

$_REQUEST['tiempo']=time();


?>

setTimeout(function() {
    $('#divMensaje').hide( "drop", { direction: "up" }, "slow" );
}, 4000); // <-- time in milliseconds




  $('#<?php echo $this->campoSeguro('fecha_inicio');?>').datepicker({
	        dateFormat: 'yy-mm-dd',
	        // maxDate: 0,
	        changeYear: true,
	        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
				'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
				dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
				dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']
        });
        
$('#<?php echo $this->campoSeguro('fecha_fin');?>').datepicker({
	        dateFormat: 'yy-mm-dd',
	        // maxDate: 1,
	        changeYear: true,
	        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
				'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
				dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
				dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']
        });
        
        
$('#<?php echo $this->campoSeguro('calendarioLista');?>').validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
        });
        $(function() {
            $('#<?php echo $this->campoSeguro('calendarioLista');?>').submit(function() {
                $resultado=$("'#<?php echo $this->campoSeguro('calendarioLista');?>'").validationEngine("validate");
                
                
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });


        var table = $('#example').DataTable({
      	  "jQueryUI": true        	               
      	});

table
	.rows()
	.eq( 0 )
	.each
	( function (rowIdx) 
			{
				table.row( rowIdx ).child( 'Row details for row: '+rowIdx );
			} );


$('#example tbody').on( 'click', 'tr', function () {
  var child = table.row( this ).child;

  if ( child.isShown() ) {
      child.hide();
  }
  else {
      child.show();
  }
} );

} );
 

$(document).ready(function() {
    $('#example').dataTable();
     

} );