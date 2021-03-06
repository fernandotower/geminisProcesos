----Tablas parametricas

--Tabla de grupos Aplicaciones (esquema del core)

  CREATE TABLE core.core_operacion
(
  operacion_id serial NOT NULL ,
  operacion_nombre text NOT NULL,
  operacion_alias text NOT NULL,
  operacion_descripcion text NOT NULL,
  CONSTRAINT operacion_pk PRIMARY KEY (operacion_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE core.core_operacion
  OWNER TO geminis;




INSERT INTO core.core_operacion
(  operacion_id,  operacion_nombre,  operacion_alias,  operacion_descripcion)
VALUES
(1,'crear','Crear','Crear CRUD'),
(2,'consultar','Consultar','Consultar CRUD'),
(3,'actualizar','Actualizar','Actualizar CRUD'),
(4,'duplicar','Consultar','Consultar CRUD'),
(5,'activarInactivar','Cambiar Estado','Cambiar estado registro activo/inactivo'),
(6,'eliminar','Eliminar','Eliminar CRUD');


--Tabla de tipo_dato (esquema del core)
CREATE TABLE core.core_tipo_dato
(
  tipo_dato_id serial NOT NULL,
  tipo_dato_nombre text NOT NULL,
  tipo_dato_alias text NOT NULL,
  CONSTRAINT tipo_dato_pk PRIMARY KEY (tipo_dato_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE core.core_tipo_dato
  OWNER TO geminis;

 --Llenar tabla
  INSERT INTO core.core_tipo_dato(
            tipo_dato_nombre, tipo_dato_alias)
    VALUES 
    ('boolean','Boleano'),
    ('integer','Entero'),
    ('double','Doble'),
    ('percent','Porcentaje'),
    ('date','Fecha'),
    ('string','Texto'),
    ('array','Lista'),
    ('NULL','Vacio');


  CREATE TABLE core.core_grupo_aplicacion
(
  grupo_aplicacion_id serial NOT NULL ,
  grupo_aplicacion_nombre text NOT NULL,
  grupo_aplicacion_alias text NOT NULL,
  grupo_aplicacion_descripcion text NOT NULL,
  CONSTRAINT grupo_aplicacion_pk PRIMARY KEY (grupo_aplicacion_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE core.core_grupo_aplicacion
  OWNER TO geminis;
  
  INSERT INTO core.core_grupo_aplicacion
  (grupo_aplicacion_nombre,grupo_aplicacion_alias,grupo_aplicacion_descripcion)
  VALUES
  ('core','Core','Objetos a usar core'),
  ('usuarios','Usuarios','Objetos componente de usuarios'),
  ('reglas','Reglas','Objetos componente de reglas'),
  ('procesos','Procesos','Objetos componente de procesos'),
  ('documentos','Documentos','Objetos componente documentos');

--Tabla de objetos (esquema del core)----agregar el prefijo de las columnas .. tabla  
  CREATE TABLE core.core_objetos
(
  objetos_id serial NOT NULL ,
  objetos_nombre text NOT NULL,
  objetos_alias text NOT NULL,
  objetos_ejecutar text NOT NULL,
  objetos_descripcion text NOT NULL,
  objetos_prefijo_columna text DEFAULT '',
  grupo_aplicacion_id integer NOT NULL,
  objetos_listar bool NOT NULL DEFAULT FALSE,
  objetos_visible bool NOT NULL DEFAULT FALSE,
  objetos_crear bool NOT NULL DEFAULT FALSE,
  objetos_consultar bool NOT NULL DEFAULT FALSE,
  objetos_actualizar bool NOT NULL DEFAULT FALSE,
  objetos_cambiarEstado bool NOT NULL DEFAULT FALSE,
  objetos_duplicar bool NOT NULL DEFAULT FALSE,
  objetos_eliminar bool NOT NULL DEFAULT FALSE,
  objetos_historico bool NOT NULL DEFAULT FALSE,
  CONSTRAINT grupo_aplicacion_fk FOREIGN KEY (grupo_aplicacion_id)
      REFERENCES core.core_grupo_aplicacion (grupo_aplicacion_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT objetos_pk PRIMARY KEY (objetos_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE core.core_objetos
  OWNER TO geminis;
  
  
  ---Lnea Tabla de Objetos
  
    INSERT INTO core.core_objetos(objetos_id,
            objetos_nombre,objetos_alias,objetos_ejecutar, objetos_descripcion , objetos_prefijo_columna, 
            grupo_aplicacion_id ,objetos_listar,objetos_visible,objetos_crear, objetos_consultar, objetos_actualizar , 
            objetos_cambiarEstado , objetos_duplicar , objetos_eliminar,objetos_historico)
   VALUES 
  ( 0 , 'todo','Todos los obejtos', 'TODOSOBJETOS','Comodin todos los objetos','estado_registro_',1,false,false,false,false,false,false,false,false,false)
    ;
  INSERT INTO core.core_objetos(
            objetos_nombre,objetos_alias,objetos_ejecutar, objetos_descripcion , objetos_prefijo_columna, 
            grupo_aplicacion_id ,objetos_listar,objetos_visible,objetos_crear, objetos_consultar, objetos_actualizar , 
            objetos_cambiarEstado , objetos_duplicar , objetos_eliminar,objetos_historico)
   VALUES 
--core
( 'core.core_estado_registro','Estado Registro', 'estadoRegistro','Tabla parametrica core','estado_registro_',1,true ,false,false,false,false,false,false, false,false),
( 'core.core_tipo_dato','Tipos de datos', 'tipoDato','Tabla parametrica core','tipo_dato_',1,true ,false,false,false,false,false,false,false,false),
( 'core.core_objetos','Objetos', 'objetos','Tabla parametrica core','objetos_',1,true ,false,false,false,false,false,false,false,false),
( 'core.core_grupo_aplicacion','Grupos de Aplicaciones', 'grupoAplicacion','Tabla parametrica core','grupo_aplicacion_',1,true ,false,false,false,false,false,false, false,false),
( 'core.core_columnas','Columnas', 'columnas','Tabla parametrica core','columnas_',1,true ,true,true,true,true,false,false,false,false),
( 'core.core_eventos_html','Eventos HTML', 'eventosHtml','Tabla parametrica core','eventos_html_',1,true ,false,false,false,false,false,false,false,false),
( 'core.core_eventos_columnas','Eventos HTML de las columnas', 'eventosColumnas','Tabla parametrica core','eventos_columnas_',1,true ,true,true,true,true,false,false,false,false),
( 'core.core_operacion','Operaciones', 'operacion','Tabla parametrica core','operacion_',1,true ,true,true,true,true,false,false,false,false),

--usuarios y accesos
( 'usuarios.usuario','Usuario' ,'usuario','Tabla de usuario del gestor de usuarios','usuario_',2,false, true,true,true,true,true,true,false,false),
( 'usuarios.relaciones','Permisos', 'relacion','Tabla de relaciones entre usuarios, permisos, objetos y registros de los objetos','rel_',2,false,true,true,true,true,true,false,true,true),
( 'usuarios.acceso','Acceso', 'acceso','Tabla de log de acceso del gestor de usuarios','acc_',2,false,false,true,false,false,false,false,false,false),
( 'usuarios.rol','Rol', 'rol','Tabla de roles del gestor de usuarios','rol_',2,false ,true,true,true,true,false,false,false,false),
( 'usuarios.usuario_rol','Rol', 'usuarioRol','Tabla de roles del gestor de usuarios','usuario_rol_',2,false ,true,true,true,true,false,false,false,false),
( 'usuarios.permiso','Permisos', 'permiso','Tabla lista permisos del gestor de usuarios','permiso_',2,true ,false,false,false,false,false,false,false,false),

--reglas
( 'reglas.parametros','Parametros','parametro','Tabla de parametros de las reglas','par_',3,false, true,true,true,true,true,true,false,true),
( 'reglas.variables','Variables','variable','Tabla de variables de las reglas','var_',3,false, true,true,true,true,true,true,false,true),
( 'reglas.funciones','Funciones','funcion','Tabla de funciones de las reglas','fun_',3,false, true,true,true,true,true,true,false,true),
( 'reglas.reglas','Reglas','regla','Tabla de reglas de las reglas','reg_',3,false, true,true,true,true,true,true,false,true),
( 'reglas.operadores','Operadores','opreadores','Tabla de operadores de las reglas','ope_',3,true, false,false,false,false,false,false,false,false),
( 'reglas.categoria_funcion','Categoria Función','categoriaFuncion','Tabla de categorias de las funciones','cfun_',3,true, false,false,false,false,false,false,false,false),

--proceso
( 'proceso.grupo_elemento_bpmn','Grupo de elementos BPMN','grupoElementoBpmn','Tabla de grupos de elementos bpmn','grupo_elemento_bpmn_',4,true, false,false,false,false,false,false,false,false),
( 'proceso.elemento_bpmn','Elementos BPMN','elementoBpmn','Tabla elementos BPMN','elemento_bpmn_',4,true, false,false,false,false,false,false,false,false),
( 'proceso.tipo_ejecucion','Tipo Ejecucion','tipoEjecucion','Tabla tipo de ejecucion','tipo_ejecucion_',4,true, false,false,false,false,false,false,false,false),
( 'proceso.estado_paso','Estado paso','estadoPaso','Tabla de estado paso','estado_paso_',4,true, false,false,false,false,false,false,false,false),

( 'proceso.actividad','Actividad','actividad','Tabla de actividades procesos','actividad_',4,false, true,true,true,true,true,true,false,true),
( 'proceso.actividad_rol','Permisos roles actividad','actividadRol','Tabla de permisos roles sobre la actividad','actividad_rol_',4,false, true,true,true,true,true,true,false,true),
( 'proceso.proceso','Proceso','proceso','tabla de procesos','proceso_',4,false, true,true,true,true,true,true,false,true),
( 'proceso.flujo_proceso','Flujo','flujoProceso','tabla del flujo del proceso','flujo_proceso_',4,false, true,true,true,true,true,true,false,true),
( 'proceso.trabajo','Trabajo','trabajo','tabla de trabajos, instancia del proceso','trabajo_',4,false, true,true,true,true,true,true,false,true),
( 'proceso.pasos_trabajo','Pasos Trabajo','pasosTrabajo','registro de pasos que se ejecutan en el trabajo','pasos_trabajo_',4,false, true,true,true,true,true,true,false,true),
( 'proceso.trabajo_usuario','Permisos trabajos usuario','trabajoUsuario','tabla de permisis trabajos usuarios','trabajo_usuario_',4,false, true,true,true,true,true,true,false,true),
( 'proceso.proceso_rol','Permisos proceso Rol','procesoRol','tabla de permisos roles sobre procesos','proceso_rol_',4,false, true,true,true,true,true,true,false,true),

--documentos
( 'documento.ruta','Rutas ubicacion documentos','ruta','Tabla de rutas documentos','ruta_',5,true, false,false,false,false,false,false,false,false),
( 'documento.tipo_mime','Tipos MIME','tipoMIME','Tabla de tipos MIME','tipo_mime_',5,true, false,false,false,false,false,false,false,false),
( 'documento.documento','Documento','documento','Tabla de documentos','documento_',5,false, true,true,true,true,true,true,false,true),
( 'documento.documento_tipo_mime','Documento Tipo MIME','documentoTipoMIME','Tabla de documentos tipos MIME','documento_tipo_mime_',5,false, true,true,true,true,true,true,false,true)

;

--Tabla de columnas (esquema del core)
--Crea tabla de Columnas  
  CREATE TABLE core.core_columnas
(
  columnas_id serial NOT NULL ,
  columnas_nombre text NOT NULL,
  columnas_alias text NOT NULL,
  columnas_input text NOT NULL DEFAULT FALSE,
  tipo_dato_id integer NOT NULL DEFAULT 3,
  grupo_aplicacion_id integer NOT NULL,
  objetos_id integer NOT NULL DEFAULT 0,
  columnas_conexion_nombre text NOT NULL DEFAULT 'estructura',
  columnas_consultar bool NOT NULL DEFAULT FALSE,
  columnas_crear bool NOT NULL DEFAULT FALSE,
  columnas_actualizar bool NOT NULL DEFAULT FALSE,
  columnas_codificada bool NOT NULL DEFAULT FALSE,
  columnas_deshabilitado_consultar bool NOT NULL DEFAULT FALSE,
  columnas_deshabilitado_crear bool NOT NULL DEFAULT FALSE,
  columnas_deshabilitado_actualizar bool NOT NULL DEFAULT FALSE,
  columnas_autocompletar_consultar bool NOT NULL DEFAULT FALSE,
  columnas_autocompletar_crear bool NOT NULL DEFAULT FALSE,
  columnas_autocompletar_actualizar bool NOT NULL DEFAULT FALSE,
  columnas_requerido_consultar bool NOT NULL DEFAULT FALSE,
  columnas_requerido_crear bool NOT NULL DEFAULT FALSE,
  columnas_requerido_actualizar bool NOT NULL DEFAULT FALSE,
  CONSTRAINT grupo_aplicacion_fk FOREIGN KEY (grupo_aplicacion_id)
      REFERENCES core.core_grupo_aplicacion (grupo_aplicacion_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT tipo_dato_fk FOREIGN KEY (tipo_dato_id)
      REFERENCES core.core_tipo_dato (tipo_dato_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT objetos_fk FOREIGN KEY (objetos_id)
      REFERENCES core.core_objetos (objetos_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  
  CONSTRAINT columnas_pk PRIMARY KEY (columnas_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE core.core_columnas
  OWNER TO geminis;

insert into core.core_columnas
(
columnas_nombre , columnas_alias ,  columnas_input ,tipo_dato_id , grupo_aplicacion_id , objetos_id, columnas_conexion_nombre ,
columnas_consultar ,  columnas_crear ,  columnas_actualizar ,  columnas_codificada , 
columnas_deshabilitado_consultar ,  columnas_deshabilitado_crear ,  columnas_deshabilitado_actualizar , 
columnas_autocompletar_consultar ,  columnas_autocompletar_crear ,  columnas_autocompletar_actualizar ,  
columnas_requerido_consultar,  columnas_requerido_crear ,  columnas_requerido_actualizar 
)
VALUES
  ----core
  ('id','Identificación','text', 2,1,0,'estructura',true,false,false,false,false,false,false,true,false,false,false,false,true),
  ('nombre','Nombre','text', 6,1,0,'estructura',true,true,true,false,false,false,false,true,false,false,true, true, false),
  ('alias','Alias','text',6,1,0,'estructura',true,true,true,false,false,false,false,true,false,false,true, true, false),
  ('descripcion','Descripción','textarea',6,1,0,'estructura',false,true,true,false,false,false,false,false,false,false,false, false, false),
  ('etiquetas','Etiquetas','tags',6,1,0,'estructura',false,true,true,false,false,false,false,false,false,false,false, false, false),
  ('nombre_real','Nombre Real','text',6,1,0,'estructura',false,true,true,false,false,false,false,false,false,false,false, false, false),
  ('estado_registro_id','Estado Registro','select',2,1,1,'estructura',true,true,true,true,false,false,false, true,true,true, true,true,true),
  ('fecha_registro','Fecha Registro','date',5,1,0,'estructura',true,false,false,false,true,true,false,false,false,false,false, false, false),
  ('tipo_dato_id','Tipo Dato','select',2,1,2,'estructura',true,true,true,true,false,false,false, true,true,true, true,true,true),
  
  -----usuarios
  ('usuario_id','Usuario','text',2,1,9,'academica',true,true,true,false,false,false,false,true,false,false,true, true, false),
  ('objetos_id','Objeto','select',2,1,3,'academica',true,true,true,true,false,false,false, true,true,true, true,true,true),
  ('registro','Registro','text',2,1,0,'academica',true,true,true,false,false,false,false,true,false,false,true, true, false),
  ('permiso_id','Permiso','text',2,1,14,'academica',true,true,true,true,false,false,false, true,true,true, true,true,true),
  ('rol_id','Permiso','text',2,1,12,'academica',true,true,true,true,false,false,false, true,true,true, true,true,true),
  ('codigo','Codigo','text',6,1,0,'academica',true,true,true,false,false,false,false,true,false,false,true, true, false),
  ('usuario','Usuario','text',6,1,0,'academica',true,true,true,false,false,false,false,true,false,false,true, true, false),
  ('detalle','Detalle','text',6,1,0,'academica',true,true,true,false,false,false,false,true,false,false,true, true, false),
  
  -----procesos
  ('estado_paso_id','Id del estado del paso','select',2,3,24,'academica',true,true,true,true,false,false,false, true,true,true, true,true,true),
  ('elemento_bpmn_id','Id de Objeto BPMN','select',2,3,22,'academica',true,true,true,true,false,false,false, true,true,true, true,true,true),
  ('grupo_elemento_bpmn_id','Grupo del elemento BPMN','select',2,3,21,'academica',true,true,true,true,false,false,false, true,true,true, true,true,true),
  ('tipo_ejecucion_id','Tipo de Ejecucion de actividad','select',2,3,23,'academica',true,true,true,true,false,false,false, true,true,true, true,true,true),
  ('actividad_id','Id del objeto Actividad','text',2,3,25,'academica',true,true,true,true,false,false,false, true,true,true, true,true,true),
  ('proceso_id','Id del objeto Proceso','text',2,3,27,'academica',true,true,true,true,false,false,false, true,true,true, true,true,true),
  ('padre_id','Id del objeto Actividad padre','text',2,3,25,'academica',true,true,true,true,false,false,false, true,true,true, true,true,true),
  ('hijo_id','Id del objeto Actividad hijo','text',2,3,25,'academica',true,true,true,true,false,false,false, true,true,true, true,true,true),
  ('trabajo_id','Id del objeto Trabajo','text',2,3,29,'academica',true,true,true,true,false,false,false, true,true,true, true,true,true),
  ('pasos_trabajo_id','Id de los pasos Trabajo','text',2,3,30,'academica',true,true,true,true,false,false,false, true,true,true, true,true,true),
 
  ----Documentos
  ('ruta_id','Id del objeto Ruta','text',2,3,33,'academica',true,true,true,true,false,false,false, true,true,true, true,true,true),
  ('tipo_mime_id','Id del objeto Tipo MIME','text',2,3,34,'academica',true,true,true,true,false,false,false, true,true,true, true,true,true),
  ('documento_id','Id del objeto Documento','text',2,3,35,'academica',true,true,true,true,false,false,false, true,true,true, true,true,true)
  
  ;
  
    
--Tabla de estado_registro (esquema del core)
CREATE TABLE core.core_estado_registro
(
  estado_registro_id serial NOT NULL,
  estado_registro_nombre text NOT NULL,
  estado_registro_alias text NOT NULL,
  estado_registro_descripcion text NOT NULL,
  CONSTRAINT estado_registro_pk PRIMARY KEY (estado_registro_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE core.core_estado_registro
  OWNER TO geminis;

insert into core.core_estado_registro (estado_registro_nombre,estado_registro_alias,estado_registro_descripcion)
VALUES
('activo','Activo','Estado que indica que el registro es usable'),
('inactivo','Inactivo','Estado que indica que el registro no es usable'),
('creado','Creado','Estado que indica que el registro acaba de ser creado');



  