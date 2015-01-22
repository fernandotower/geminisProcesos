 --Crea esquema y asigna permisos
CREATE SCHEMA proceso
  AUTHORIZATION ecosiis;

--------Tabla grupo_elemento_bpmn
CREATE TABLE proceso.grupo_elemento_bpmn
(
  grupo_elemento_bpmn_id serial NOT NULL,
  grupo_elemento_bpmn_nombre text NOT NULL,
  grupo_elemento_bpmn_alias text NOT NULL,
  grupo_elemento_bpmn_descripcion text NOT NULL,
  CONSTRAINT grupo_elemento_bpmn_pk PRIMARY KEY (grupo_elemento_bpmn_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.grupo_elemento_bpmn
  OWNER TO ecosiis;

insert into proceso.grupo_elemento_bpmn (grupo_elemento_bpmn_nombre,grupo_elemento_bpmn_alias,grupo_elemento_bpmn_descripcion)
VALUES
('evento','Evento','Acción que sucede durante el curso del proceso, afectan el flujo de proceso y normalmente tienen una causa (trigger) o resultado'),
('tarea','Tarea','Es el llamado a una funcion o aplicacion'),
('compuerta','Compuerta','Acción usada para la toma de decisiones del flujo del proceso');

----------Tabla elemento_bpmn

CREATE TABLE proceso.elemento_bpmn
(
  elemento_bpmn_id serial NOT NULL,
  elemento_bpmn_nombre text NOT NULL,
  elemento_bpmn_alias text NOT NULL,
  grupo_elemento_bpmn_id integer NOT NULL,
  elemento_bpmn_descripcion text NOT NULL,
  CONSTRAINT elemento_bpmn_grupo_fk FOREIGN KEY (grupo_elemento_bpmn_id)
      REFERENCES proceso.grupo_elemento_bpmn (grupo_elemento_bpmn_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT elemento_bpmn_pk PRIMARY KEY (elemento_bpmn_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.elemento_bpmn
  OWNER TO ecosiis;

insert into proceso.elemento_bpmn
(elemento_bpmn_nombre,elemento_bpmn_alias,grupo_elemento_bpmn_id,elemento_bpmn_descripcion)
values
('eventoInicio','Evento de Inicio',1,'representa el punto de inicio de un proceso'),
('eventoIntermedio','Evento intermedio',1,'Ocurre entre un evento de inicio y de fin'),
('eventoFin','Evendo de fin',1,'Es el que indica cuando un proceso termina'),
('tareaHumana','Tarea Humana',2,'intervención de un humano para su ejecución'),
('tareaServicio','Tarea de Servicio',2,'llamado a un servicio realizada por el sistema sin intervención humana'),
('tareaLlamada','Tarea de LLamada',2,'Se debe poder referenciar a un proceso o tarea, definida de forma
global, que se reutiliza en el proceso actual'),
('tareaRecibirMensaje','Tarea de recibir mensaje',2,'recibe un mensaje, y que una vez el mensaje haya sido recibido, la tarea es completada'),
('tareaEnviarMensaje','Tarea de enviar mensaje',2,'designada para enviar un mensaje a un proceso o caso específico, y que, una vez el mensaje haya sido enviado, la tarea es completada'),
('tareaScript','Tarea de script',2,'tarea automática en la que el servidor ejecuta un script. No tienen interacción humana y no se conecta con ningún servicio externo'),
('tareaTemporizador','Tarea de temporizador',2,'ejecuta un espera antes de ser completada'),
('compuertaOr','Compuerta inclusiva OR',3,'Inclusiva o multi-decisión. Uno o más caminos pueden ser activados. Uno o más caminos deben sincronizarse dependiendo de las actividades anteriores de la misma figura'),
('compuertaXor','Compuerta exclusiva XOR',3,'Solo toma un camino e ignora los demas'),
('compuertaAnd','Compuerta paralela AND',3,'Activa todos los caminos que dependen de ella y valida que todos los que lleguen se cumplan');


-------------tabla tipo_ejecucion
CREATE TABLE proceso.tipo_ejecucion
(
  tipo_ejecucion_id serial NOT NULL,
  tipo_ejecucion_nombre text NOT NULL,
  tipo_ejecucion_alias text NOT NULL,
  tipo_ejecucion_descripcion text NOT NULL,
  CONSTRAINT tipo_ejecucion_pk PRIMARY KEY (tipo_ejecucion_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.tipo_ejecucion
  OWNER TO ecosiis;


insert into proceso.tipo_ejecucion
(tipo_ejecucion_nombre,tipo_ejecucion_alias,tipo_ejecucion_descripcion)
values
('regla','Regla','Ejecuta el llamdo a una regla que retorna true o false'),
('funcion','Funcion','Ejecuta un llamado a una funcion del componente Gestor reglas'),
('WSSoap','Servicio Web SOAP','Ejecuta el llamado a un servicio web SOAP'),
('enviarMensaje','Enviar Mensaje','Ejecuta el envio de un mensaje para que sea recibido'),
('recibirMensaje','Recibir Mensaje','Recibe un mensaje eviado por enviarMensaje'),
('temporizador','Temporizador','Ejecuta una espera'),
('get','GET','Ejecuta un llamado a un URL como un GET');


---------------Tabla actividad
CREATE TABLE proceso.actividad
(
  actividad_id serial NOT NULL,
  actividad_nombre text NOT NULL,
  actividad_alias text NOT NULL,
  actividad_descripcion text NOT NULL,
  elemento_bpmn_id integer NOT NULL,
  tipo_ejecucion_id integer NOT NULL,
  actividad_ruta_ejecucion text NOT NULL,
  estado_registro_id integer NOT NULL,
  actividad_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT tipo_ejecucion_fk FOREIGN KEY (tipo_ejecucion_id)
      REFERENCES proceso.tipo_ejecucion (tipo_ejecucion_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT elemento_bpmn_fk FOREIGN KEY (elemento_bpmn_id)
      REFERENCES proceso.elemento_bpmn (elemento_bpmn_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT estado_registro_fk FOREIGN KEY (estado_registro_id)
      REFERENCES core.core_estado_registro (estado_registro_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT actividad_pk PRIMARY KEY (actividad_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.actividad
  OWNER TO ecosiis;


---------------Tabla actividad HHHH
CREATE TABLE proceso.actividad_h
(
  actividad_h_id serial NOT NULL,
  actividad_id_h integer NOT NULL,
  actividad_nombre_h text NOT NULL,
  actividad_alias_h text NOT NULL,
  actividad_descripcion_h text NOT NULL,
  elemento_bpmn_id_h integer NOT NULL,
  tipo_ejecucion_id_h integer NOT NULL,
  actividad_ruta_ejecucion_h text NOT NULL,
  estado_registro_id_h integer NOT NULL,
  actividad_fecha_registro_h DATE NOT NULL,
  actividad_h_justificacion text,
  actividad_h_usuario text,
  actividad_h_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT actividad_h_pk PRIMARY KEY (actividad_h_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.actividad_h
  OWNER TO ecosiis;


----actividad_rol
CREATE TABLE proceso.actividad_rol
(
  actividad_rol_id serial NOT NULL,
  actividad_id integer NOT NULL,
  rol_id integer NOT NULL,
  permiso_id integer NOT NULL,
  estado_registro_id integer NOT NULL,
  actividad_rol_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT permisos_fk FOREIGN KEY (permiso_id)
      REFERENCES usuarios.permiso (permiso_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT rol_fk FOREIGN KEY (rol_id)
      REFERENCES usuarios.rol (rol_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT actividad_fk FOREIGN KEY (actividad_id)
      REFERENCES proceso.actividad (actividad_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT estado_registro_fk FOREIGN KEY (estado_registro_id)
      REFERENCES core.core_estado_registro (estado_registro_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT actividad_rol_pk PRIMARY KEY (actividad_rol_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.actividad_rol
  OWNER TO ecosiis;


------tabla h actividad_rol_h
CREATE TABLE proceso.actividad_rol_h
(
  actividad_rol_h_id serial NOT NULL,
  actividad_rol_id_h integer NOT NULL,
  actividad_id_h integer NOT NULL,
  rol_id_h integer NOT NULL,
  permiso_id_h integer NOT NULL,
  estado_registro_id_h integer NOT NULL,
  actividad_rol_fecha_registro_h DATE NOT NULL,
  actividad_rol_h_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  actividad_rol_h_justificacion text NOT NULL,
  CONSTRAINT actividad_rol_h_pk PRIMARY KEY (actividad_rol_h_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.actividad_rol
  OWNER TO ecosiis;


---------tabla proceso
CREATE TABLE proceso.proceso
(
  proceso_id serial NOT NULL,
  proceso_nombre text NOT NULL,
  proceso_alias text NOT NULL,
  proceso_descripcion text NOT NULL,
  estado_registro_id integer NOT NULL,
  proceso_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT estado_registro_fk FOREIGN KEY (estado_registro_id)
      REFERENCES core.core_estado_registro (estado_registro_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT proceso_pk PRIMARY KEY (proceso_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.proceso
  OWNER TO ecosiis;

-----------proceso h
CREATE TABLE proceso.proceso_h
(
  proceso_h_id serial NOT NULL,
  proceso_id_h integer NOT NULL,
  proceso_nombre_h text NOT NULL,
  proceso_alias_h text NOT NULL,
  proceso_descripcion_h text NOT NULL,
  estado_registro_id_h integer NOT NULL,
  proceso_fecha_registro_h DATE NOT NULL,
  proceso_h_justificacion text NOT NULL,
  proceso_h_usuario text NOT NULL,
  proceso_h_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT proceso_h_pk PRIMARY KEY (proceso_h_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.proceso_h
  OWNER TO ecosiis;

----------- tabla flujo_proceso
CREATE TABLE proceso.flujo_proceso
(
  flujo_proceso_id serial NOT NULL,
  proceso_id integer NOT NULL,
  actividad_padre_id integer NOT NULL,
  actividad_hijo_id integer NOT NULL,
  flujo_proceso_orden_evaluacion_condicion integer NOT NULL,
  flujo_proceso_condicion boolean NOT NULL DEFAULT false,
  tipo_ejecucion_id integer NOT NULL,
  flujo_proceso_ruta_ejecucion_condicion text NOT NULL,
  estado_registro_id integer NOT NULL,
  flujo_proceso_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT actividad_padre_fk FOREIGN KEY (actividad_padre_id)
      REFERENCES proceso.actividad (actividad_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT actividad_hijo_fk FOREIGN KEY (actividad_hijo_id)
      REFERENCES proceso.actividad (actividad_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT proceso_fk FOREIGN KEY (proceso_id)
      REFERENCES proceso.proceso (proceso_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT estado_registro_fk FOREIGN KEY (estado_registro_id)
      REFERENCES core.core_estado_registro (estado_registro_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT flujo_proceso_pk PRIMARY KEY (flujo_proceso_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.flujo_proceso
  OWNER TO ecosiis;


---------------------------tabla flujo_proceso_h
CREATE TABLE proceso.flujo_proceso_h
(
  flujo_proceso_h_id serial NOT NULL,
  flujo_proceso_id_h integer NOT NULL,
  proceso_id_h integer NOT NULL,
  actividad_padre_id_h integer NOT NULL,
  actividad_hijo_id_h integer NOT NULL,
  flujo_proceso_orden_evaluacion_condicion_h integer NOT NULL,
  flujo_proceso_condicion_h boolean NOT NULL DEFAULT false,
  tipo_ejecucion_id_h integer NOT NULL,
  flujo_proceso_ruta_ejecucion_condicion_h text NOT NULL,
  estado_registro_id_h integer NOT NULL,
  flujo_proceso_fecha_registro_h DATE NOT NULL,
  flujo_proceso_h_justificacion text NOT NULL,
  flujo_proceso_h_usuario text NOT NULL,
  flujo_proceso_h_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT flujo_proceso_h_pk PRIMARY KEY (flujo_proceso_h_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.flujo_proceso_h
  OWNER TO ecosiis;

-----------------tabla trabajo
CREATE TABLE proceso.trabajo
(
  trabajo_id serial NOT NULL,
  proceso_id integer NOT NULL,
  estado_registro_id integer NOT NULL,
  trabajo_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT proceso_fk FOREIGN KEY (proceso_id)
      REFERENCES proceso.proceso (proceso_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT estado_registro_fk FOREIGN KEY (estado_registro_id)
      REFERENCES core.core_estado_registro (estado_registro_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT trabajo_pk PRIMARY KEY (trabajo_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.trabajo
  OWNER TO ecosiis;

----------------tabla trabajo_h
CREATE TABLE proceso.trabajo_h
(
  trabajo_h_id serial NOT NULL,
  trabajo_id_h integer NOT NULL,
  proceso_id_h integer NOT NULL,
  estado_registro_id_h integer NOT NULL,
  trabajo_fecha_registro_h DATE NOT NULL,
  trabajo_h_justificacion text NOT NULL,
  trabajo_h_usuario text NOT NULL,
  trabajo_h_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT trabajo_h_pk PRIMARY KEY (trabajo_h_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.trabajo_h
  OWNER TO ecosiis;



-----------tabla estado_paso
CREATE TABLE proceso.estado_paso
(
  estado_paso_id serial NOT NULL,
  estado_paso_nombre text NOT NULL,
  estado_paso_alias text NOT NULL,
  estado_paso_descripcion text NOT NULL,
  CONSTRAINT estado_paso_pk PRIMARY KEY (estado_paso_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.estado_paso
  OWNER TO ecosiis;

insert into proceso.estado_paso
(estado_paso_nombre,estado_paso_alias,estado_paso_descripcion)
values
('noEjecutado','No ejecutado','indica que un paso no se ha ejecutado'),
('inicio','Inicio','indica que un paso se encuentra en estado de inicio'),
('enProceso','En proceso','indica que un paso se encuentra en estado en proceso, es decir se esta ejecutando'),
('completado','Completado','indica que un paso se completado'),
('deshabilitado','Deshabilitado','indica que un paso esta deshabilitado, es decir no se puede ejecutar');




---------------tabla pasos_trabajo

CREATE TABLE proceso.pasos_trabajo
(
  pasos_trabajo_id serial NOT NULL,
  trabajo_id integer NOT NULL,
  actividad_id integer NOT NULL,
  estado_paso_id integer NOT NULL,
  estado_registro_id integer NOT NULL,
  pasos_trabajo_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT trabajo_fk FOREIGN KEY (trabajo_id)
      REFERENCES proceso.trabajo (trabajo_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT actividad_fk FOREIGN KEY (actividad_id)
      REFERENCES proceso.actividad (actividad_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT estado_paso_fk FOREIGN KEY (estado_paso_id)
      REFERENCES proceso.estado_paso (estado_paso_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT estado_registro_fk FOREIGN KEY (estado_registro_id)
      REFERENCES core.core_estado_registro (estado_registro_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT pasos_trabajo_pk PRIMARY KEY (pasos_trabajo_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.pasos_trabajo
  OWNER TO ecosiis;


----------tabla  pasos_trabajo_h

CREATE TABLE proceso.pasos_trabajo_h
(
  pasos_trabajo_h_id serial NOT NULL,
  pasos_trabajo_id_h integer NOT NULL,
  trabajo_id_h integer NOT NULL,
  actividad_id_h integer NOT NULL,
  estado_paso_id_h integer NOT NULL,
  estado_registro_id_h integer NOT NULL,
  pasos_trabajo_fecha_registro_h DATE NOT NULL ,
  pasos_trabajo_h_justificacion serial NOT NULL,
  pasos_trabajo_h_usuario serial NOT NULL,
  pasos_trabajo_h_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT pasos_trabajo_h_pk PRIMARY KEY (pasos_trabajo_h_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.pasos_trabajo_h
  OWNER TO ecosiis;

------------trabajo usuario

CREATE TABLE proceso.trabajo_usuario
(
  trabajo_usuario_id serial NOT NULL,
  trabajo_id integer NOT NULL,
  usuario_id integer NOT NULL,
  estado_registro_id integer NOT NULL,
  trabajo_usuario_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT trabajo_fk FOREIGN KEY (trabajo_id)
      REFERENCES proceso.trabajo (trabajo_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT usuario_fk FOREIGN KEY (usuario_id)
      REFERENCES usuarios.usuario (usuario_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT estado_registro_fk FOREIGN KEY (estado_registro_id)
      REFERENCES core.core_estado_registro (estado_registro_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT trabajo_usuario_pk PRIMARY KEY (trabajo_usuario_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.trabajo_usuario
  OWNER TO ecosiis;

-------------trabajo_usuario_h

CREATE TABLE proceso.trabajo_usuario_h
(
  trabajo_usuario_h_id serial NOT NULL,
  trabajo_usuario_id_h integer NOT NULL,
  trabajo_id_h integer NOT NULL,
  usuario_id_h integer NOT NULL,
  estado_registro_id_h integer NOT NULL,
  trabajo_usuario_fecha_registro_h DATE NOT NULL ,
  trabajo_usuario_h_justificacion text NOT NULL,
  trabajo_usuario_h_usuario text NOT NULL,
  trabajo_usuario_h_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT trabajo_usuario_h_pk PRIMARY KEY (trabajo_usuario_h_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.trabajo_usuario_h
  OWNER TO ecosiis;


---------------proceso_rol
CREATE TABLE proceso.proceso_rol
(
  proceso_rol_id serial NOT NULL,
  proceso_id integer NOT NULL,
  rol_id integer NOT NULL,
  permiso_id integer NOT NULL,
  estado_registro_id integer NOT NULL,
  proceso_rol_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT proceso_fk FOREIGN KEY (proceso_id)
      REFERENCES proceso.proceso (proceso_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT rol_fk FOREIGN KEY (rol_id)
      REFERENCES usuarios.rol (rol_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT permiso_fk FOREIGN KEY (permiso_id)
      REFERENCES usuarios.permiso (permiso_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT estado_registro_fk FOREIGN KEY (estado_registro_id)
      REFERENCES core.core_estado_registro (estado_registro_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT proceso_rol_pk PRIMARY KEY (proceso_rol_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.proceso_rol
  OWNER TO ecosiis;


----proceso_rol_h
CREATE TABLE proceso.proceso_rol_h
(
  proceso_rol_h_id serial NOT NULL,
  proceso_rol_id_h integer NOT NULL,
  proceso_id_h integer NOT NULL,
  rol_id_h integer NOT NULL,
  permiso_id_h integer NOT NULL,
  estado_registro_id_h integer NOT NULL,
  proceso_rol_fecha_registro_h DATE NOT NULL,
  proceso_rol_h_justificacion text NOT NULL,
  proceso_rol_h_usuario text NOT NULL,
  proceso_rol_h_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT proceso_rol_h_pk PRIMARY KEY (proceso_rol_h_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE proceso.proceso_rol_h
  OWNER TO ecosiis;

  
  