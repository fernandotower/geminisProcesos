<?php
$this->idioma ["paginaNoExiste"] = "<h2>La p√°gina que est√° buscando no existe</h2><p>Esto se considera un error fatal.</p><p>Por favor contacte al administrador del sistema. Posiblemente sea necesario registrarla.</p>";
$this->idioma ["usuarioNoAutorizado"] = "<h2>Insuficientes Privilegios</h2><p>Imposible realizar la acci√≥n solicitada.</p><p>Por favor contacte al administrador del sistema.</p>";
$this->idioma ["paginaSinBloques"] = "<h2>P√°gina no v√°lida</h2><p>La p√°gina solicitada no tiene bloques asociados.</p><p>Por favor contacte al administrador del sistema.</p>";
$this->idioma ["errorAcceso"] = "<h3>Imposible conectarse a la base de datos.</h3><p>Esto se considera un error no manejable y el aplicativo debe detenerse.</p>";
$this->idioma ["usuarioAnonimo"] = "An√≥nimo";
$this->idioma ["noInstanciaDatos"] = "Imposible crear una instancia de base de datos.";
$this->idioma ["noDefinido"] = "N/D";
$this->idioma ["sesionNoExiste"] = "<h3>No se pudo rescatar una sesi√≥n!!!!</h3><p>Su sesi√≥n de trabajo ha expirado o no tiene permiso de acceder a este recurso.</p><p class='textoNegrita centrar'>En unos instantes ser√° redirigido a la p√°gina de inicio.</span></p>";
$this->idioma ["errorDatos"] = "<h3>Datos no v√°lidos.</h3><p>Por favor revise los datos ingresados y vuelva a reintentar la operaci√≥n.</p>";


//valores para la clase Persistencia.class.php

$this->idioma["errorConexion"]="Error, FallÛ al conectar a la base de datos";
$this->idioma["errorEliminar"]="FallÛ al eliminar registros";
$this->idioma["errorConsulta"]="La tabla no tiene datos Û la consulta ha fallado";
$this->idioma["errorElementosArray"] = "Error, el numero de elementos de los arrays deben ser iguales";
$this->idioma["errorActualizar"] ="FallÛ al realizar la ActualizaciÛn";
$this->idioma["errorInsertar"] ="FallÛ al realizar la inserciÛn";
$this->idioma['errorProceso'] ="El usuario no poseÈ permisos sobre el proceso";
$this->idioma["errorTablaNoExiste"] ="Error Tabla no Existe";
$this->idioma["errorTablaHNoExiste"] ="Error Tabla Historico no Existe";
$this->idioma["errorCampos"] ="Error Campos invalidos";
$this->idioma["errorValores"] ="Error valores invalidos";
$this->idioma["errorWhere"] ="Error sentencia where invalida";
$this->idioma["errorColumnas"] ="Error no es posible consultar las columnas";
$this->idioma["errorHistorico"] ="Error no es posible crear historico";
$this->idioma["errorNoActualizar"] = "No existen elementos para actualizar";
$this->idioma["errorPks"] = "Error no fue posible recuperar las llaves primarias";
$this->idioma["errorConteo"] = "La tabla esta vacia Û no existe";

//fin valores 


//valores clase DAL para mensajes

$this->idioma["errorRecuperarObjetos"] = "Error recuperando Objetos de la base de datos";
$this->idioma["objetoNoEncontrado"] = "Objeto no encontrado";
$this->idioma["errorValorInvalido"] = "Error valor inv·lido";
$this->idioma["errorSeleccionInvalido"] = "Error indice a seleccionar inv·lido";
$this->idioma["errorTipoInvalido"] = "Error indice fuente inv·lido";
$this->idioma["erroridObjetoEntrada"] = "Error en el formato de entrada del Id Objeto";
$this->idioma["errorParametrosEntrada"] = "Error en el formato de entrada de los par·metros";
$this->idioma["errorOperacionEntrada"] = "Error en el formato de entrada de la operaciÛn";
$this->idioma["errorParametrosEntradaIdObjeto"] = "Error id objeto no existe";
$this->idioma["errorColumnaNoExiste"] = "Error atributo no existe";
$this->idioma["errorEntradaParametrosId"] = "Error Id Inv·lido";
$this->idioma["errorEntradaParametrosNombre"] = "Error Nombre Inv·lido";
$this->idioma["errorEntradaParametrosDescripcion"] = "Error DescripciÛn Inv·lida";
$this->idioma["errorEntradaParametrosTipo"] = "Error Tipo Inv·lido";
$this->idioma["errorEntradaParametrosValor"] = "Error Valor Inv·lido";
$this->idioma["errorEntradaParametrosEstado"] = "Error Estado Inv·lido";
$this->idioma["errorEntradaParametrosFechas"] = "Error Fechas Inv·lidas";
$this->idioma["errorEntradaParametrosGeneral"] = "Error en la Entrada de elementos";

//columnas
$this->idioma["errorEntradaColumnaInvalida"] = "Error, columna no v·lida";
$this->idioma["errorTipoDatoColumna"] = "Error, tipo dato columna no v·lido";
$this->idioma["errorValorColumna"] = 'Error, valor columna no v·lido';
$this->idioma["errorInput"] = 'Error, recuperando input columna ';
$this->idioma["errorFk"] = 'Error, valor llave foranea incorrecto ';

/*
//por tablas
$this->idioma["errorCreacion"] = "Error Creando ";
$this->idioma["errorLectura"] = "No se encontraron registros de ";
$this->idioma["errorIdNoDefinido"] = "Identificador no definido para el ";
$this->idioma["errorActualizar"] = "Error Actualizando ";
$this->idioma["errorIdNoExiste"] = "Identificador no Existe para el ";
$this->idioma["errorDuplicar"] = "Error Duplicando ";
$this->idioma["errorEliminar"] = "Error Eliminando ";
$this->idioma["errorCambiarEstado"] = "Error Cambiando Estados ";
$this->idioma["errorRegistroPropietario"]="Error, registro propietario ";

$this->idioma["errorCreacionParametros"] = "Error Creando Par·metros";
$this->idioma["errorLecturaParametros"] = "No se encontraron registros de Par·metros";
$this->idioma["errorIdNoDefinidoParametros"] = "Identificador del par·metro no definido";
$this->idioma["errorActualizarParametros"] = "Error Actualizando Par·metros";
$this->idioma["errorIdNoExisteParametros"] = "Identificador del par·metro no Existe";
$this->idioma["errorDuplicarParametros"] = "Error Duplicando Par·metros";
$this->idioma["errorEliminarParametros"] = "Error Eliminando Par·metros";
$this->idioma["errorCambiarEstadoParametros"] = "Error Cambiando Estados Par·metros";


$this->idioma["errorCreacionFunciones"] = "Error Creando Funciones";
$this->idioma["errorLecturaFunciones"] = "No se encontraron registros de Funciones";
$this->idioma["errorIdNoDefinidoFunciones"] = "Identificador de la FunciÛn no definido";
$this->idioma["errorActualizarFunciones"] = "Error Actualizando FunciÛn";
$this->idioma["errorIdNoExisteFunciones"] = "Identificador de la funciÛn no Existe";
$this->idioma["errorDuplicarFunciones"] = "Error Duplicando Funciones";
$this->idioma["errorEliminarFunciones"] = "Error Eliminando Funciones";
$this->idioma["errorCambiarEstadoFunciones"] = "Error Cambiando Estados Funciones";

$this->idioma["errorCreacionVariables"] = "Error Creando Variables";
$this->idioma["errorLecturaVariables"] = "No se encontraron registros de Variables";
$this->idioma["errorIdNoDefinidoVariables"] = "Identificador de la Variable no definido";
$this->idioma["errorActualizarVariables"] = "Error Actualizando Variable";
$this->idioma["errorIdNoExisteVariables"] = "Identificador de la Variable no Existe";
$this->idioma["errorDuplicarVariables"] = "Error Duplicando Variable";
$this->idioma["errorEliminarVariables"] = "Error Eliminando Variable";
$this->idioma["errorCambiarEstadoVariables"] = "Error Cambiando Estados Variable";

$this->idioma["errorCreacionPermisos"] = "Error Creando Permisos";
$this->idioma["errorLecturaPermisos"] = "No se encontraron registros de Permisos";
$this->idioma["errorIdNoDefinidoPermisos"] = "Identificador del permiso no definido";
$this->idioma["errorActualizarPermisos"] = "Error Actualizando Permisos";
$this->idioma["errorIdNoExistePermisos"] = "Identificador de la permiso no Existe";
$this->idioma["errorDuplicarPermisos"] = "Error Duplicando Permisos";
$this->idioma["errorEliminarPermisos"] = "Error Eliminando Permisos";
$this->idioma["errorCambiarEstadoPermisos"] = "Error Cambiando Estados Permisos";

$this->idioma["errorCreacionReglas"] = "Error Creando Reglas";
$this->idioma["errorLecturaReglas"] = "No se encontraron registros de Reglas";
$this->idioma["errorIdNoDefinidoReglas"] = "Identificador de la regla no definido";
$this->idioma["errorActualizarReglas"] = "Error Actualizando Reglas";
$this->idioma["errorIdNoExisteReglas"] = "Identificador de la regla no Existe";
$this->idioma["errorDuplicarReglas"] = "Error Duplicando Reglas";
$this->idioma["errorEliminarReglas"] = "Error Eliminando Reglas";
$this->idioma["errorCambiarEstadoReglas"] = "Error Cambiando Estados Reglas";

$this->idioma["errorCreacionRelaciones"] = "Error Creando Permiso";
$this->idioma["errorLecturaRelaciones"] = "No se encontraron registros de Permisos";
$this->idioma["errorIdNoDefinidoRelaciones"] = "Identificador del permiso no definido";
$this->idioma["errorActualizarRelaciones"] = "Error Actualizando Permiso";
$this->idioma["errorIdNoExisteRelaciones"] = "Identificador del permiso no Existe";
$this->idioma["errorDuplicarRelaciones"] = "Error Duplicando Permiso";
$this->idioma["errorEliminarRelaciones"] = "Error Eliminando Permiso";
$this->idioma["errorCambiarEstadoRelaciones"] = "Error Cambiando Estados Permiso";
*/

$this->idioma["columnaNoExiste"] ="Columna no existe en tabla ";
$this->idioma["usuarioIndefinido"]="Usuario Indefinido";


//fin valores


//valores componente usuario y acceso
////////////////////////////////////////////////////////////////////////////////////////////

$this->idioma["registroObjetoNoExiste"] = "Registro objeto no existe";
$this->idioma["permisoNoEncontrado"] = "Permiso no encontrado";
$this->idioma["usuarioNoExiste"] = "Usuario no existe";
$this->idioma["errorRecuperarPermisos"] = "error recuperando permisos";
$this->idioma["errorRecuperarColumnas"] = "error recuperando columnas";
$this->idioma["errorRecuperarObjetos"] = "error recuperando objetos";
$this->idioma["objetoNoEncontrado"] = "error objeto no encontrado";
$this->idioma["relacionNoExiste"] = "relaciÛn no existe";
$this->idioma["usuarioNoAutorizado"]="Error, usuario no autorizado";
$this->idioma["errorPermisosGeneral"]="Error, el usuario no tiene permisos para ejecutar esta operacion";
$this->idioma["usuarioSinPermisos"]="Error, usuario no posee permisos";
$this->idioma["errorCadenaMalFormada"]="Error, cadena mal formada";
$this->idioma["errorSoapCall"]="Error, en llamada al metodo soap";
$this->idioma["errorRecuperarOperadores"]="Error, recuperando operadores";
$this->idioma["errorRegistroPropietario"]="Error, registro propietario";
//fin valores


//valores para el componente de documentos
$this->idioma["errorVariableArchivoVacia"]="Error, variable FILES vacia";
$this->idioma["errorNombreArray"]="Error, variable nombre debe ser un array";
$this->idioma["errorRutaFisica"]="Error, ruta fisica Invalida, revise si existe y que tenga permisos de escritura";
$this->idioma["errorArchivoExiste"]="Error, Archivo existe con ese nombre";
$this->idioma["errorExtensionTipo"]="Error, extension Û o tipo documento inv·lido  ";
$this->idioma["errorTipoMime"] = "Error, tipo MIME Iv·lido";
$this->idioma["errorExtension"] = "Error, extension Iv·lida";
$this->idioma["errorMime"] = "Error, tipo MIME documento incorrecto";
$this->idioma["errorMoverArchivo"] = "Error, no fue posible mover el archivo";
$this->idioma["errorLocalizacionArchivo"] = "Error, no fue posible encontrar el archivo";
$this->idioma["errorNombreHTML"] = 'Error, nombre archivo no valido, no existe en la variable de Archivos';
//tablas
$this->idioma["errorCreacionDocumento"] = "Error Creando Documento";
$this->idioma["errorLecturaDocumento"] = "No se encontraron registros de Documentos";
$this->idioma["errorIdNoDefinidoDocumento"] = "Identificador del documento no definido";
$this->idioma["errorActualizarDocumento"] = "Error Actualizando documento";
$this->idioma["errorIdNoExisteDocumento"] = "Identificador del documento no Existe";
$this->idioma["errorDuplicarDocumento"] = "Error Duplicando documento";
$this->idioma["errorEliminarDocumento"] = "Error Eliminando documento";
$this->idioma["errorCambiarEstadoDocumento"] = "Error Cambiando Estados documento";
//
$this->idioma["errorCreacionDocumentoTipoMIME"] = "Error Creando Documentos Tipos MIME";
$this->idioma["errorLecturaDocumentoTipoMIME"] = "No se encontraron registros de Documentos  Tipos MIME";
$this->idioma["errorIdNoDefinidoDocumentoTipoMIME"] = "Identificador del documento Tipos MIME no definido";
$this->idioma["errorActualizarDocumentoTipoMIME"] = "Error Actualizando documento Tipos MIME";
$this->idioma["errorIdNoExisteDocumentoTipoMIME"] = "Identificador del documento Tipos MIME no Existe";
$this->idioma["errorDuplicarDocumentoTipoMIME"] = "Error Duplicando documento Tipos MIME";
$this->idioma["errorEliminarDocumentoTipoMIME"] = "Error Eliminando documento Tipos MIME";
$this->idioma["errorCambiarEstadoDocumentoTipoMIME"] = "Error Cambiando Estados documento Tipos MIME";
//fin valores


?>