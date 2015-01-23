----Tablas parametricas

--Tabla de grupos Aplicaciones (esquema del core)

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
  OWNER TO ecosiis;
  
  INSERT INTO core.core_grupo_aplicacion
  (grupo_aplicacion_nombre,grupo_aplicacion_alias,grupo_aplicacion_descripcion)
  VALUES
  ('core','Core','Objetos a usar core'),
  ('usuarios','Usuarios','Objetos componente de usuarios'),
  ('reglas','Reglas','Objetos componente de reglas'),
  ('procesos','Procesos','Objetos componente de procesos');

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
  OWNER TO ecosiis;
  
  
  ---Lnea Tabla de Objetos
  INSERT INTO core.core_objetos(
            objetos_nombre,objetos_alias,objetos_ejecutar, objetos_descripcion , objetos_prefijo_columna, 
            grupo_aplicacion_id ,objetos_listar,objetos_visible,objetos_crear, objetos_consultar, objetos_actualizar , 
            objetos_cambiarEstado , objetos_duplicar , objetos_eliminar,objetos_historico)
   VALUES 

( 'core.core_estado_registro','Estado Registro', 'estadoRegistro','Tabla parametrica core','estado_registro_',1,true ,false,false,false,false,false,false, false,false),
( 'core.core_tipo_dato','Tipos de datos', 'tipoDato','Tabla parametrica core','tipo_dato_',1,true ,false,false,false,false,false,false,false,false),
( 'core.core_objetos','Objetos', 'objetos','Tabla parametrica core','objetos_',1,true ,false,false,false,false,false,false,false,false),
( 'core.core_grupo_aplicacion','Grupos de Aplicaciones', 'grupoAplicacion','Tabla parametrica core','grupo_aplicacion_',1,true ,false,false,false,false,false,false, false,false),
( 'core.core_columnas','Columnas', 'columnas','Tabla parametrica core','columnas_',1,true ,true,true,true,true,false,false,false,false),
( 'core.core_eventos_html','Eventos HTML', 'eventosHtml','Tabla parametrica core','eventos_html_',1,true ,false,false,false,false,false,false,false,false),
( 'core.core_eventos_columnas','Eventos HTML de las columnas', 'eventosColumnas','Tabla parametrica core','eventos_columnas_',1,true ,true,true,true,true,false,false,false,false),
( 'usuarios.usuario','Usuario' ,'usuario','Tabla de usuario del gestor de usuarios','usuario_',2,false, true,true,true,true,true,true,false,false),
( 'usuarios.relacion','Permisos', 'relacion','Tabla de relaciones entre usuarios, permisos, objetos y registros de los objetos','rel_',2,false,true,true,true,true,true,false,true,true),
( 'usuarios.acceso','Acceso', 'acceso','Tabla de log de acceso del gestor de usuarios','acceso_',2,false,false,true,false,false,false,false,false,false),
( 'usuarios.rol','Rol', 'rol','Tabla de roles del gestor de usuarios','rol_',2,false ,true,true,true,true,false,false,false,false),
( 'usuarios.usuario_rol','Rol', 'usuarioRol','Tabla de roles del gestor de usuarios','usuario_rol_',2,false ,true,true,true,true,false,false,false,false),
( 'usuarios.permisos','Permisos', 'permisos','Tabla lista permisos del gestor de usuarios','permisos_',2,true ,false,false,false,false,false,false,false,false),

( 'reglas.parametros','Parametros','parametro','Tabla de parametros de las reglas','par_',3,false, true,true,true,true,true,true,false,true),
( 'reglas.variables','Variables','variable','Tabla de variables de las reglas','var_',3,false, true,true,true,true,true,true,false,true),
( 'reglas.funciones','Funciones','funcion','Tabla de funciones de las reglas','fun_',3,false, true,true,true,true,true,true,false,true),
( 'reglas.reglas','Reglas','regla','Tabla de reglas de las reglas','reg_',3,false, true,true,true,true,true,true,false,true),
( 'reglas.operadores','Operadores','opreadores','Tabla de operadores de las reglas','ope_',3,true, false,false,false,false,false,false,false,false),
( 'reglas.categoria_funcion','Categoria Función','categoriaFuncion','Tabla de categorias de las funciones','cfun_',3,true, false,false,false,false,false,false,false,false),

( 'proceso.grupo_elemento_bpmn','Grupo de elementos BPMN','grupoElementoBpmn','Tabla de grupos de elementos bpmn','grupo_elemento_bpmn_',4,true, false,false,false,false,false,false,false,false),
( 'proceso.elemento_bpmn','Elementos BPMN','elementoBpmn','Tabla elementos BPMN','elemento_bpmn_',4,true, false,false,false,false,false,false,false,false),
( 'proceso.tipo_ejecucion','Tipo Ejecucion','tipoEjecucion','Tabla tipo de ejecucion','tipo_ejecucion_',4,true, false,false,false,false,false,false,false,false),
( 'proceso.estado_paso','Estado paso','estadoPaso','Tabla de estado paso','estado_paso_',4,true, false,false,false,false,false,false,false,false),

( 'proceso.actividad','Reglas','regla','Tabla de reglas de las reglas','reg_',3,false, true,true,true,true,true,true,false,true),
( 'proceso.actividad','Reglas','regla','Tabla de reglas de las reglas','reg_',3,false, true,true,true,true,true,true,false,true),
( 'proceso.actividad','Reglas','regla','Tabla de reglas de las reglas','reg_',3,false, true,true,true,true,true,true,false,true),
( 'proceso.actividad','Reglas','regla','Tabla de reglas de las reglas','reg_',3,false, true,true,true,true,true,true,false,true),
( 'proceso.actividad','Reglas','regla','Tabla de reglas de las reglas','reg_',3,false, true,true,true,true,true,true,false,true)


;

--Tabla de columnas (esquema del core)
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
  OWNER TO ecosiis;

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
  OWNER TO ecosiis;

insert into core.core_estado_registro (estado_registro_nombre,estado_registro_alias,estado_registro_descripcion)
VALUES
('activo','Activo','Estado que indica que el registro es usable'),
('inactivo','Inactivo','Estado que indica que el registro no es usable'),
('creado','Creado','Estado que indica que el registro acaba de ser creado');



  