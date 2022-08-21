DROP DATABASE  IF EXISTS controlppp_bd;
CREATE DATABASE IF NOT EXISTS controlppp_bd;
USE controlppp_bd;

DROP TABLE IF EXISTS roles;
CREATE TABLE roles(
    id_rol int(11) auto_increment,
    nombre_rol varchar(50),
    descripcion text,
    estado boolean,
    fecha_crea DATETIME,
    fecha_modifica DATETIME default now(),
    PRIMARY KEY(id_rol)
);

DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios(
    id_usuario INT(11) auto_increment,
    usuario  varchar(50),
    password text,
    email_institucional varchar(100),
    id_rol int(11),
    ultimo_online boolean DEFAULT 0,
    code text default NULL,
    estado boolean,
    fecha_crea DATETIME,
    fecha_modifica DATETIME default now(),
    PRIMARY KEY(id_usuario)
);

DROP TABLE IF EXISTS modulos;
CREATE TABLE modulos(
    id_modulo INT(11) auto_increment,
    nombre varchar(50),
    descripcion text,
    estado boolean,
    fecha_crea DATETIME,
    fecha_modifica DATETIME default now(),
    PRIMARY KEY(id_modulo)
);

DROP TABLE IF EXISTS permisos;
CREATE TABLE permisos(
    id_permiso int(11)  auto_increment,
    id_modulo int(11),
    id_rol  int(11),
    r int(11),
    w int(11),
    u int(11),
    d int(11),
    PRIMARY KEY(id_permiso)
);

DROP TABLE IF EXISTS alumnos;
CREATE TABLE alumnos(
    id_alumno int(11) auto_increment,
    cedula  varchar(10),
    nombre  varchar(50),
    apellido  varchar(50),
    email_personal  varchar(100),
    telefono  varchar(10),
    sexo varchar(1),
    estado boolean,
    fecha_crea DATETIME,
    fecha_modifica DATETIME default now(),
    PRIMARY KEY(id_alumno)
);

DROP TABLE IF EXISTS profesores;
CREATE TABLE profesores(
    id_profesor int(11) auto_increment,
    cedula  varchar(10),
    nombre  varchar(50),
    apellido  varchar(50),
    email_personal  varchar(100),
    telefono  varchar(10),
    sexo varchar(1),
    estado boolean,
    fecha_crea DATETIME,
    fecha_modifica DATETIME default now(),
    PRIMARY KEY(id_profesor)
);



ALTER TABLE permisos ADD CONSTRAINT fk_modulo FOREIGN KEY (id_modulo) REFERENCES modulos(id_modulo);
ALTER TABLE permisos ADD CONSTRAINT fk_rol FOREIGN KEY (id_rol) REFERENCES roles(id_rol);

INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Dashboard','modulo de dashboard',1,now());
INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Usuarios','modulo de usuarios',1,now());
INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Roles','modulo de roles',1,now());
INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Respaldo','modulo de respaldo',1,now());
INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Permisos','modulo de permisos',1,now());

INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Alumnos','modulo de alumnos',1,now());
INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Profesores','modulo de profesores',1,now());

INSERT INTO roles (nombre_rol,descripcion,estado,fecha_crea) values ("Administrador","permisos de acceso a todo el sistema",1,now());

INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (1,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (2,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (3,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (4,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (5,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (6,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (7,1,1,1,1,1);

INSERT INTO usuarios (usuario,password,email_institucional,id_rol,estado,fecha_crea) VALUES ("josu3","$2y$10$nLtnKbUrAQnMMfWi9bqsEuQ53U5k1pKCRsKYWEw0x/R5hgKNcHiYK","jjhuacon@est.itsgg.edu.ec",1,1,now());
