 --Crea esquema y asigna permisos
CREATE SCHEMA documento
  AUTHORIZATION geminis;

--------Tabla tipo_mime
-----tomado de:
---https://technet.microsoft.com/en-us/library/ee309278(office.12).aspx
---http://www.openoffice.org/framework/documentation/mimetypes/mimetypes.html
---http://shailesh-patil.blogspot.com/2010/02/mime-types-for-microsoft-office-2007.html
CREATE TABLE documento.tipo_mime
(
  tipo_mime_id serial NOT NULL,
  tipo_mime_nombre text NOT NULL,
  tipo_mime_alias text NOT NULL,
  tipo_mime_extension text NOT NULL,
  CONSTRAINT tipo_mime_pk PRIMARY KEY (tipo_mime_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE documento.tipo_mime
  OWNER TO geminis;

insert into documento.tipo_mime (tipo_mime_nombre,tipo_mime_alias,tipo_mime_extension)
VALUES
('application/x-tar','4.3BSD tar format','tar'),
('application/pdf','Adobe Acrobat','pdf'),
('audio/x-aiff','AIFF audio','aif, aifc, aiff'),
('application/astound','Astound','asd, asn'),
('application/acad','AutoCAD','dwg'),
('application/x-dwf','AutoCAD','dwf'),
('audio/basic','BASIC audio (u-law)','au, snd'),
('application/x-bcpio','binary CPIO','bcpio'),
('image/bmp','Bitmap','bmp'),
('application/x-sh','Bourne shell script','sh'),
('application/clariscad','ClarisCAD','ccad'),
('image/x-cmu-raster','CMU raster','ras'),
('application/arj','compressed archive','arj'),
('x-conference/x-cooltalk','CoolTalk','ice'),
('application/x-csh','C-shell script','csh'),
('application/dxf','DXF (AutoCAD)','dxf'),
('application/x-mif','FrameMaker MIF','mif'),
('image/gif','GIF image','gif'),
('application/x-gtar','GNU tar','gtar'),
('application/x-gzip','GNU ZIP','gz, gzip'),
('multipart/x-gzip','GNU ZIP archive','gzip'),
('text/html','HTML','htm, html'),
('application/vnd.oasis.opendocument.text-web','HTML Document Template','oth'),
('application/iges','IGES graphics format','iges, igs'),
('image/ief','Image Exchange Format','ief'),
('application/STEP','ISO-10303 STEP data','st, step, stp'),
('application/java-archive','Java archive','jar'),
('application/x-javascript','JavaScript','js'),
('image/jpeg','JPEG image','jpe, jpeg, jpg'),
('application/x-latex','LaTeX source','latex'),
('application/mac-binhex40','Macintosh binary BinHex 4.0','hqx'),
('application/x-macbinary','Macintosh compressed','bin'),
('image/pict','Macintosh PICT','pict'),
('application/x-director','Macromedia Director','dcr, dir, dxr'),
('application/x-shockwave-flash','Macromedia Shockwave','swf'),
('application/drafting','MATRA Prelude drafting','drw'),
('application/solids','MATRA Prelude Solids','sol'),
('application/msaccess','Microsoft Access','mdb'),
('application/vnd.ms-excel','Microsoft Excel','xla, xls, xlt, xlw'),
('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','Microsoft Office Excel 2007 workbook','xlsx'),
('application/msonenote','Microsoft Office OneNote 2007 section','one'),
('application/vnd.openxmlformats-officedocument.presentationml.presentation','Microsoft Office PowerPoint 2007 presentation','pptx'),
('application/vnd.openxmlformats-officedocument.wordprocessingml.document','Microsoft Office Word 2007 document','docx'),
('application/vnd.ms-powerpoint','Microsoft PowerPoint','pot, pps, ppt'),
('application/msproject','Microsoft Project','mpp'),
('application/x-winhelp','Microsoft Windows help','hlp'),
('video/msvideo','Microsoft Windows video','avi'),
('audio/x-wav','Microsoft Windows WAVE audio','wav'),
('application/msword','Microsoft Word','doc, word, w6w'),
('application/mswrite','Microsoft Write','wri'),
('application/x-midi','MIDI','mid'),
('audio/midi','MIDI','mid, midi'),
('text/richtext','MIME Richtext','rtx'),
('audio/x-mpeg','MPEG audio','mp3'),
('video/mpeg','MPEG video','mpe, mpeg, mpg'),
('application/x-hdf','NCSA HDF Data File','hdf'),
('application/oda','ODA','oda'),
('application/vnd.ms-excel.addin.macroEnabled.12','Office Excel 2007 add-in','xlam'),
('application/vnd.ms-excel.sheet.binary.macroEnabled.12','Office Excel 2007 binary workbook','xlsb'),
('application/vnd.ms-excel.sheet.macroEnabled.12','Office Excel 2007 macro-enabled workbook','xlsm'),
('application/vnd.ms-excel.template.macroEnabled.12','Office Excel 2007 macro-enabled workbook template','xltm'),
('application/vnd.openxmlformats-officedocument.spreadsheetml.template','Office Excel 2007 template','xltx'),
('application/msonenote','Office OneNote 2007 package','onepkg'),
('application/msonenote','Office OneNote 2007 temporary file','onetmp'),
('application/msonenote','Office OneNote 2007 TOC','onetoc2'),
('application/vnd.ms-powerpoint.addin.macroEnabled.12','Office PowerPoint 2007 add-in','ppam'),
('application/vnd.ms-powerpoint.presentation.macroEnabled.12','Office PowerPoint 2007 macro-enabled presentation','pptm'),
('application/vnd.ms-powerpoint.template.macroEnabled.12','Office PowerPoint 2007 macro-enabled presentation template','potm'),
('application/vnd.ms-powerpoint.slide.macroEnabled.12','Office PowerPoint 2007 macro-enabled slide','sldm'),
('application/vnd.ms-powerpoint.slideshow.macroEnabled.12','Office PowerPoint 2007 macro-enabled slide show','ppsm'),
('application/vnd.openxmlformats-officedocument.presentationml.slide','Office PowerPoint 2007 slide','sldx'),
('application/vnd.openxmlformats-officedocument.presentationml.slideshow','Office PowerPoint 2007 slide show','ppsx'),
('application/vnd.openxmlformats-officedocument.presentationml.template','Office PowerPoint 2007 template','potx'),
('application/vnd.ms-word.document.macroEnabled.12','Office Word 2007 macro-enabled document','docm'),
('application/vnd.ms-word.template.macroEnabled.12','Office Word 2007 macro-enabled document template','dotm'),
('application/vnd.openxmlformats-officedocument.wordprocessingml.template','Office Word 2007 template','dotx'),
('application/vnd.oasis.opendocument.chart','OpenDocument Chart','odc'),
('application/vnd.oasis.opendocument.database','OpenDocument Database','odb'),
('application/vnd.oasis.opendocument.graphics','OpenDocument Drawing','odg'),
('application/vnd.oasis.opendocument.graphics-template','OpenDocument Drawing Template','otg'),
('application/vnd.oasis.opendocument.formula','OpenDocument Formula','odf'),
('application/vnd.oasis.opendocument.image','OpenDocument Image ','odi'),
('application/vnd.oasis.opendocument.text-master','OpenDocument Master Document','odm'),
('application/vnd.oasis.opendocument.presentation-template','OpenDocument Presentation Template','otp'),
('application/vnd.oasis.opendocument.presentation','OpenDocument Presentation ','odp'),
('application/vnd.oasis.opendocument.spreadsheet','OpenDocument Spreadsheet','ods'),
('application/vnd.oasis.opendocument.spreadsheet-template','OpenDocument Spreadsheet Template','ots'),
('application/vnd.oasis.opendocument.text ','OpenDocument Text','odt '),
('application/vnd.oasis.opendocument.text-template','OpenDocument Text Template','ott'),
('application/vnd.openofficeorg.extension','OpenOffice.org extension (since OOo 2.1) ','oxt'),
('image/x-portable-anymap','PBM Anymap format','pnm'),
('image/x-portable-bitmap','PBM Bitmap format','pbm'),
('image/x-portable-graymap','PBM Graymap format','pgm'),
('image/x-portable-pixmap','PBM Pixmap format','ppm'),
('multipart/x-zip','PKZIP archive','zip'),
('text/plain','plain text','C, cc, h, txt'),
('image/png','Portable Network Graphic','png'),
('application/x-cpio','POSIX CPIO','cpio'),
('application/x-ustar','POSIX tar format','ustar'),
('application/postscript','PostScript','ai, eps, ps'),
('application/pro_eng','PTC Pro/ENGINEER','part, prt'),
('video/quicktime','QuickTime video','mov, qt'),
('audio/x-pn-realaudio','RealAudio','ra, ram'),
('audio/x-pn-realaudio-plugin','RealAudio plug-in','rpm'),
('image/x-rgb','RGB image','rgb'),
('application/rtf','Rich Text Format','rtf'),
('application/i-deas','SDRC I-DEAS','unv'),
('application/set','SET (French CAD)','set'),
('video/x-sgi-movie','SGI Movieplayer format','movie'),
('text/x-sgml','SGML','sgm, sgml'),
('application/x-shar','shell archive','shar'),
('application/sla','stereolithography','stl'),
('text/x-setext','Structurally Enhanced Text','etx'),
('application/x-stuffit','StuffIt archive','sit'),
('application/x-sv4cpio','SVR4 CPIO','sv4cpio'),
('application/x-sv4crc','SVR4 CPIO with CRC','sv4crc'),
('application/x-tcl','TCL script','tcl'),
('application/x-dvi','TeX DVI','dvi'),
('application/x-tex','TeX source','tex'),
('application/x-texinfo','Texinfo (Emacs)','texi, texinfo'),
('text/tab-separated-values','text with tabs','tsv'),
('image/tiff','TIFF image','tif, tiff'),
('application/x-troff','Troff','roff, t, tr'),
('application/x-troff-man','Troff with MAN macros','man'),
('application/x-troff-me','Troff with ME macros','me'),
('application/x-troff-ms','Troff with MS macros','ms'),
('application/x-netcdf','Unidata netCDF','cdf, nc'),
('application/octet-stream','uninterpreted binary','bin'),
('application/vda','VDA-FS Surface data','vda'),
('video/vdo','VDO streaming video','vdo'),
('x-world/x-svr','Virtual reality','svr'),
('x-world/x-vrt','Virtual reality','vrt'),
('video/vivo','VIVO streaming video','viv, vivo'),
('audio/x-voice','Voice','voc'),
('x-world/x-vrml','VRML Worlds','wrl'),
('application/x-wais-source','WAIS source','src'),
('image/x-xbitmap','X Bitmap','xbm'),
('image/x-xpixmap','X Pixmap','xpm'),
('image/x-xwindowdump','X Window System dump','xwd'),
('application/zip','ZIP archive','zip')

;

CREATE TABLE documento.ruta
(
  ruta_id serial NOT NULL,
  ruta_nombre text NOT NULL,
  ruta_alias text NOT NULL,
  ruta_valor text NOT NULL,
  ruta_descripcion text NOT NULL,
  CONSTRAINT ruta_pk PRIMARY KEY (ruta_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE documento.ruta
  OWNER TO geminis;

insert into documento.ruta
(ruta_id, ruta_nombre, ruta_alias, ruta_valor, ruta_descripcion)
VALUES
(0, 'Archivo','Ruta de los Archivos','/usr/local/apache/htdocs/geminis/component/GestorDocumentos/Archivos/Historico/','Ruta de los historicos'),
(1, 'Predeterminada','Ruta Predeterminada','/usr/local/apache/htdocs/geminis/component/GestorDocumentos/Archivos/Default/','Ruta pedeterminada'),
(2, 'Archivo1','Ruta de los Archivos','C:\Developer\WAPP\apache2\htdocs\geminisProcesos\component\GestorDocumentos\Archivos\Historico\','Ruta de los historicos'),
(3, 'predeterminada1','Ruta p','C:\Developer\WAPP\apache2\htdocs\geminisProcesos\component\GestorDocumentos\Archivos\Default\','Ruta pre')

;



---------------Tabla documento
CREATE TABLE documento.documento
(
  documento_id serial NOT NULL,
  documento_nombre text NOT NULL,
  documento_alias text ,
  documento_nombre_real text NOT NULL,
  documento_descripcion text ,
  documento_etiquetas text NOT NULL,
  ruta_id integer NOT NULL,
  estado_registro_id integer NOT NULL,
  documento_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT ruta_fk FOREIGN KEY (ruta_id)
      REFERENCES documento.ruta (ruta_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
      
  CONSTRAINT documento_pk PRIMARY KEY (documento_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE documento.documento
  OWNER TO geminis;


---------------Tabla documento HHHH
CREATE TABLE documento.documento_h
(
  documento_h_id serial NOT NULL,
  documento_id_h integer NOT NULL,
  documento_nombre_h text NOT NULL,
  documento_alias_h text ,
  documento_nombre_real_h text NOT NULL,
  documento_descripcion_h text ,
  documento_etiquetas_h text NOT NULL,
  ruta_id_h integer NOT NULL,
  estado_registro_id_h integer NOT NULL,
  documento_fecha_registro_h DATE NOT NULL,
  documento_h_justificacion text,
  documento_h_usuario text,
  documento_h_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT documento_h_pk PRIMARY KEY (documento_h_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE documento.documento_h
  OWNER TO geminis;




---------------Tabla documento_tipo_mime
CREATE TABLE documento.documento_tipo_mime
(
  documento_tipo_mime_id serial NOT NULL,
  documento_id integer NOT NULL,
  tipo_mime_id integer NOT NULL ,
  estado_registro_id integer NOT NULL,
  documento_tipo_mime_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT documento_fk FOREIGN KEY (documento_id)
      REFERENCES documento.documento (documento_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
  CONSTRAINT tipo_mime_fk FOREIGN KEY (tipo_mime_id)
      REFERENCES documento.tipo_mime (tipo_mime_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE SET NULL,
      
  CONSTRAINT documento_tipo_mime_pk PRIMARY KEY (documento_tipo_mime_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE documento.documento_tipo_mime
  OWNER TO geminis;


---------------Tabla documento HHHH
CREATE TABLE documento.documento_tipo_mime_h
(
  documento_tipo_mime_h_id serial NOT NULL,
  documento_tipo_mime_id_h integer NOT NULL,
  documento_id_h text NOT NULL,
  tipo_mime_id_h text ,
  estado_registro_id_h integer NOT NULL,
  documento_tipo_mime_fecha_registro_h DATE NOT NULL,
  documento_tipo_mime_h_justificacion text,
  documento_tipo_mime_h_usuario text,
  documento_tipo_mime_h_fecha_registro DATE NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT documento_tipo_mime_h_pk PRIMARY KEY (documento_tipo_mime_h_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE documento.documento_tipo_mime_h
  OWNER TO geminis;

  