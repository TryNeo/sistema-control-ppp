DROP DATABASE  IF EXISTS CONTROLPPP_BD;
CREATE DATABASE IF NOT EXISTS CONTROLPPP_BD;
USE CONTROLPPP_BD;

DROP TABLE IF EXISTS Roles;
CREATE TABLE Roles(
    id_rol int(11) auto_increment,
    nombre_rol varchar(50),
    descripcion text,
    estado boolean,
    fecha_crea DATETIME,
    fecha_modifica DATETIME default now(),
    PRIMARY KEY(id_rol)
)ENGINE=InnoDB CHARACTER SET utf8;

DROP TABLE IF EXISTS Usuarios;
CREATE TABLE Usuarios(
    id_usuario INT(11) auto_increment,
    usuario  varchar(50),
    password text,
    email_institucional varchar(100),
    email_activo boolean DEFAULT 0,
    id_rol int(11),
    ultimo_online boolean DEFAULT 0,
    code text default NULL,
    estado boolean,
    fecha_crea DATETIME,
    fecha_modifica DATETIME default now(),
    PRIMARY KEY(id_usuario)
)ENGINE=InnoDB CHARACTER SET utf8;

DROP TABLE IF EXISTS Modulos;
CREATE TABLE Modulos(
    id_modulo INT(11) auto_increment,
    nombre varchar(50),
    descripcion text,
    estado boolean,
    fecha_crea DATETIME,
    fecha_modifica DATETIME default now(),
    PRIMARY KEY(id_modulo)
)ENGINE=InnoDB CHARACTER SET utf8;

DROP TABLE IF EXISTS Permisos;
CREATE TABLE Permisos(
    id_permiso int(11)  auto_increment,
    id_modulo int(11),
    id_rol  int(11),
    r int(11),
    w int(11),
    u int(11),
    d int(11),
    PRIMARY KEY(id_permiso)
)ENGINE=InnoDB CHARACTER SET utf8;


DROP TABLE IF EXISTS Carreras;
CREATE TABLE Carreras(
    id_carrera int(11) auto_increment,
    nombre_carrera varchar(200),
    descripcion text,
    estado boolean,
    fecha_crea DATETIME,
    fecha_modifica DATETIME default now(),
    PRIMARY KEY(id_carrera)
)ENGINE=InnoDB CHARACTER SET utf8;

DROP TABLE IF EXISTS Campus;
CREATE TABLE Campus(
    id_campus int(11) auto_increment,
    nombre_campus varchar(200),
    descripcion text,
    estado boolean,
    fecha_crea DATETIME,
    fecha_modifica DATETIME default now(),
    PRIMARY KEY(id_campus)
)ENGINE=InnoDB CHARACTER SET utf8;



DROP TABLE IF EXISTS Alumnos;
CREATE TABLE Alumnos(
    id_alumno int(11) auto_increment,
    cedula  varchar(10),
    nombre  varchar(50),
    apellido  varchar(50),
    email_personal  varchar(100),
    telefono  varchar(12),
    sexo varchar(1),
    id_carrera int(11),
    id_usuario int(11),
    estado boolean,
    fecha_crea DATETIME,
    fecha_modifica DATETIME default now(),
    PRIMARY KEY(id_alumno)
)ENGINE=InnoDB CHARACTER SET utf8;

DROP TABLE IF EXISTS Profesores;
CREATE TABLE Profesores(
    id_profesor int(11) auto_increment,
    cedula  varchar(10),
    nombre  varchar(50),
    apellido  varchar(50),
    email_personal  varchar(100),
    telefono  varchar(12),
    sexo varchar(1),
    id_campus int(11),
    id_usuario  int(11),
    estado boolean,
    fecha_crea DATETIME,
    fecha_modifica DATETIME default now(),
    PRIMARY KEY(id_profesor)
)ENGINE=InnoDB CHARACTER SET utf8;


DROP TABLE IF EXISTS Empresas;
CREATE TABLE Empresas(
    id_empresa int(11) auto_increment,
    ruc_empresa varchar(13),
    nombre_empresa varchar(200),
    direccion_empresa varchar(200),
    telefono_empresa varchar(12),
    correo_empresa varchar(40),
    cedula_representante varchar(10),
    nombre_representante varchar(150),
    telefono_representante varchar(12),
    descripcion_empresa text,
    estado boolean,
    fecha_crea DATETIME,
    fecha_modifica DATETIME default now(),
    PRIMARY KEY(id_empresa)
)ENGINE=InnoDB CHARACTER SET utf8;

DROP TABLE IF EXISTS Practicas_pre_profesionales;
CREATE TABLE IF NOT EXISTS Practicas_pre_profesionales(
    id_practica int(11) auto_increment,
    id_alumno int(11),
    id_profesor int(11),
    tipo_practica int(11),
    alcance_proyecto int(11),
    id_empresa int(11),
    departamento varchar(80),
    nivel int(11),
    fecha_inicio date,
    fecha_fin date,
    total_horas_ppp int(11),
    estado boolean,
    fecha_crea DATETIME,
    fecha_modifica DATETIME default now(),
    PRIMARY KEY(id_practica)
)ENGINE=InnoDB CHARACTER SET utf8;


ALTER TABLE Permisos ADD CONSTRAINT fk_modulo FOREIGN KEY (id_modulo) REFERENCES Modulos(id_modulo);
ALTER TABLE Permisos ADD CONSTRAINT fk_rol FOREIGN KEY (id_rol) REFERENCES Roles(id_rol);

ALTER TABLE Alumnos ADD CONSTRAINT fk_usuario_al FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario);
ALTER TABLE Alumnos ADD CONSTRAINT fk_carrera FOREIGN KEY (id_carrera) REFERENCES Carreras(id_carrera);

ALTER TABLE Profesores ADD CONSTRAINT fk_usuario_prof FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario);
ALTER TABLE Profesores ADD CONSTRAINT fk_campus FOREIGN KEY (id_campus) REFERENCES Campus(id_campus);

ALTER TABLE Practicas_pre_profesionales ADD CONSTRAINT fk_alumno FOREIGN KEY (id_alumno) REFERENCES Alumnos(id_alumno);
ALTER TABLE Practicas_pre_profesionales ADD CONSTRAINT fk_profesor FOREIGN KEY (id_profesor) REFERENCES Profesores(id_profesor);
ALTER TABLE Practicas_pre_profesionales ADD CONSTRAINT fk_empresa FOREIGN KEY (id_empresa) REFERENCES Empresas(id_empresa);


INSERT INTO Modulos (nombre,descripcion,estado,fecha_crea) values('Principal','modulo de pagina principal',1,now());
INSERT INTO Modulos (nombre,descripcion,estado,fecha_crea) values('Usuarios','modulo de usuarios',1,now());
INSERT INTO Modulos (nombre,descripcion,estado,fecha_crea) values('Roles','modulo de roles',1,now());
INSERT INTO Modulos (nombre,descripcion,estado,fecha_crea) values('Respaldo','modulo de respaldo',1,now());
INSERT INTO Modulos (nombre,descripcion,estado,fecha_crea) values('Permisos','modulo de permisos',1,now());
INSERT INTO Modulos (nombre,descripcion,estado,fecha_crea) values('Estudiantes','modulo de alumnos',1,now());
INSERT INTO Modulos (nombre,descripcion,estado,fecha_crea) values('Docentes','modulo de profesores',1,now());
INSERT INTO Modulos (nombre,descripcion,estado,fecha_crea) values('Empresas','modulo de convenios',1,now());
INSERT INTO Modulos (nombre,descripcion,estado,fecha_crea) values('Practicas profesionales','modulo de practicas profesionales',1,now());
INSERT INTO Modulos (nombre,descripcion,estado,fecha_crea) values('Historial estudiante','modulo de historial estudiante',1,now());

INSERT INTO Roles (nombre_rol,descripcion,estado,fecha_crea) values ("Administrador","permisos de acceso a todo el sistema",1,now());
INSERT INTO Roles (nombre_rol,descripcion,estado,fecha_crea) values ("Estudiante","permisos de acceso para el estudiante",1,now());
INSERT INTO Roles (nombre_rol,descripcion,estado,fecha_crea) values ("Docente","permisos de acceso para el Docente",1,now());

INSERT INTO Permisos (id_modulo,id_rol,r,w,u,d) VALUES (1,1,1,1,1,1);
INSERT INTO Permisos (id_modulo,id_rol,r,w,u,d) VALUES (2,1,1,1,1,1);
INSERT INTO Permisos (id_modulo,id_rol,r,w,u,d) VALUES (3,1,1,1,1,1);
INSERT INTO Permisos (id_modulo,id_rol,r,w,u,d) VALUES (4,1,1,1,1,1);
INSERT INTO Permisos (id_modulo,id_rol,r,w,u,d) VALUES (5,1,1,1,1,1);
INSERT INTO Permisos (id_modulo,id_rol,r,w,u,d) VALUES (6,1,1,1,1,1);
INSERT INTO Permisos (id_modulo,id_rol,r,w,u,d) VALUES (7,1,1,1,1,1);
INSERT INTO Permisos (id_modulo,id_rol,r,w,u,d) VALUES (8,1,1,1,1,1);
INSERT INTO Permisos (id_modulo,id_rol,r,w,u,d) VALUES (9,1,1,1,1,1);
INSERT INTO Permisos (id_modulo,id_rol,r,w,u,d) VALUES (10,1,1,1,1,1);

INSERT INTO Permisos (id_modulo,id_rol,r,w,u,d) VALUES (1,2,1,1,1,1);
INSERT INTO Permisos (id_modulo,id_rol,r,w,u,d) VALUES (10,2,1,0,0,0);

INSERT INTO Permisos (id_modulo,id_rol,r,w,u,d) VALUES (1,3,1,1,1,1);


INSERT INTO Carreras (nombre_carrera,descripcion,estado,fecha_crea) values ("Tecnología Superior en Administración","no hay descripcion",0,now());
INSERT INTO Carreras (nombre_carrera,descripcion,estado,fecha_crea) values ("Tecnología Superior en Contabilidad","El objeto de estudio de la carrera de Tecnología Superior en Contabilidad es el estudio del proceso contable y las variaciones del patrimonio a través del tiempo",1,now());
INSERT INTO Carreras (nombre_carrera,descripcion,estado,fecha_crea) values ("Tecnología Superior en Desarrollo de Software","Formar profesionales con la capacidad para desarrollar aplicaciones informáticas, con conocimientos, estrategias y criterio a nivel corporativo; para satisfacer las necesidades de las empresas públicas y privadas mejorando su productividad y desarrollo, teniendo como cimiento la ética, la responsabilidad y el compromiso con la sociedad",1,now());
INSERT INTO Carreras (nombre_carrera,descripcion,estado,fecha_crea) values ("Tecnología Superior en Electricidad","Desarrollar competencias profesionales en el campo de la generación de energía eléctrica en función de la tendencia del uso y aplicación de las energías renovables, amigables con el ambiente",1,now());
INSERT INTO Carreras (nombre_carrera,descripcion,estado,fecha_crea) values ("Tecnología Superior en Electrónica","Desarrollar competencias profesionales en el campo de la generación de energía eléctrica en función de la tendencia del uso y aplicación de las energías renovables, amigables con el ambiente",1,now());
INSERT INTO Carreras (nombre_carrera,descripcion,estado,fecha_crea) values ("Tecnología Superior en Mecánica Automotriz","Realizar el diagnostico, mantenimiento y reparación del motor de combustión interna y sus sistemas, considerando especificaciones técnicas del fabricante, regulaciones de entidades de control, protección del medio ambiente y normas de seguridad industrial e higiene laboral",1,now());
INSERT INTO Carreras (nombre_carrera,descripcion,estado,fecha_crea) values ("Tecnología Superior en Producción Agrícola","Formar tecnólogos superiores en producción en agrícola con conocimientos teóricos prácticos, en los proceso de diagnóstico, control y ejecución de operaciones en el cultivo con valores éticos, innovadores, emprendedores, preservando la interculturalidad y competentes",1,now());
INSERT INTO Carreras (nombre_carrera,descripcion,estado,fecha_crea) values ("Tecnología Superior en Producción Pecuaria","Formar tecnólogos superiores en producción pecuaria, a través de un proceso de formación integral innovador, con habilidades, destrezas, conocimientos y valores, que le permitan aportar soluciones eficientes para el crecimiento y desarrollo del sector pecuario nacional",1,now());
INSERT INTO Carreras (nombre_carrera,descripcion,estado,fecha_crea) values ("Tecnología Superior en Desarrollo Infantil","Formar profesionales a nivel tecnológico superior con calidad humana capaces de diseñar, ejecutar y evaluar procesos de atención integral a la primera infancia y a mujeres estantes, que integren conocimientos teórico-prácticos en la generación de estrategias, técnicas y herramientas de cuidado materno infantil",1,now());
INSERT INTO Carreras (nombre_carrera,descripcion,estado,fecha_crea) values ("Tecnología Superior en Seguridad Ciudadana y Orden Púbilco","Formar profesionales a nivel tecnológico superior con calidad humana capaces de diseñar, ejecutar y evaluar procesos de atención integral a la primera infancia y a mujeres estantes, que integren conocimientos teórico-prácticos en la generación de estrategias, técnicas y herramientas de cuidado materno infantil",1,now());


INSERT INTO Campus (nombre_campus,descripcion,estado,fecha_crea) values ("Campus Cuerpo Docente Matriz Chimbo","no hay descripcion",1,now());
INSERT INTO Campus (nombre_campus,descripcion,estado,fecha_crea) values ("Campus Campus Guaranda","no hay descripcion",1,now());
INSERT INTO Campus (nombre_campus,descripcion,estado,fecha_crea) values ("Campus Campus Ángel Polibio Chávez","no hay descripcion",1,now());
INSERT INTO Campus (nombre_campus,descripcion,estado,fecha_crea) values ("Campus Campus San Pablo","no hay descripcion",1,now());
INSERT INTO Campus (nombre_campus,descripcion,estado,fecha_crea) values ("Campus Simiátug","no hay descripcion",1,now());





INSERT INTO Usuarios (usuario,password,email_institucional,email_activo,id_rol,estado,fecha_crea) 
    VALUES ("superadmin","$2y$10$nLtnKbUrAQnMMfWi9bqsEuQ53U5k1pKCRsKYWEw0x/R5hgKNcHiYK","jjhuacon@est.itsgg.edu.ec",1,1,1,now());

