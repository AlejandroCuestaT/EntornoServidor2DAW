create database gestion_turnos character set 'utf8mb4';
use gestion_turnos;


CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol varchar(50) NOT NULL,
    activo BOOLEAN DEFAULT TRUE
)engine innodb;

INSERT INTO usuarios (username, password, rol) VALUES
('admin', 'admin123', 'administrativo'),
('drjuan', 'medico123', 'medico'),
('recep1', 'recep123', 'recepcion'),
('enfer1','enfer123','enfermero'),
('drasandra', 'medico123', 'medico'),
('drmiguel', 'medico123', 'medico'),
('draana', 'medico123', 'medico');


CREATE TABLE medicos (
    id_medico INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    email VARCHAR(100),
    especialidad varchar(50) NOT NULL,
    constraint fk_mu FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
)engine innodb;

INSERT INTO medicos (id_usuario, nombre, apellido, telefono, email, especialidad) VALUES
(2, 'Juan', 'Pérez', '555-1234', 'juan.perez@clinica.com', 'Medicina General'),
(5, 'Sandra', 'González', '555-5555', 'sandra.gonzalez@clinica.com', 'Medicina General'),
(6, 'Miguel', 'Torres', '555-6666', 'miguel.torres@clinica.com', 'Cardiología'),        
(7, 'Ana', 'Ramírez', '555-7777', 'ana.ramirez@clinica.com', 'Pediatría');   

CREATE TABLE pacientes (
    num_tarjeta INT PRIMARY KEY,
	activa boolean default true,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE,
    sexo ENUM('M','F','Otro'),
    telefono VARCHAR(20),
    email VARCHAR(100),
    direccion VARCHAR(200),
    fecha_registro date
)engine innodb;

INSERT INTO pacientes (num_tarjeta,activa,nombre, apellido, fecha_nacimiento, sexo, telefono, email, direccion,fecha_registro) VALUES
(111111,true,'María', 'Gómez', '1990-05-12', 'F', '555-1111', 'maria@gmail.com', 'Av. Central 123',now()),
(222222,true,'Carlos', 'Ramírez', '1985-08-20', 'M', '555-2222', 'carlos@gmail.com', 'Calle Norte 456',now()),
(333333,false,'Lucía', 'Fernández', '2001-03-15', 'F', '555-3333', 'lucia@gmail.com', 'Col Primavera 789',now());


CREATE TABLE citas (
    tarjeta_paciente INT NOT NULL,
    id_medico INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    motivo VARCHAR(255),
    estado ENUM('Programada','Confirmada','Cancelada','Completada') 
           DEFAULT 'Programada',
    observaciones TEXT,
    fecha_creacion date,
	primary key (tarjeta_paciente,id_medico,fecha,hora),
	constraint unique_cita UNIQUE (id_medico,fecha,hora),
    constraint fk_cp FOREIGN KEY (tarjeta_paciente) REFERENCES pacientes(num_tarjeta),
    constraint fk_cm1 FOREIGN KEY (id_medico) REFERENCES medicos(id_medico)
)engine innodb;

INSERT INTO citas (tarjeta_paciente, id_medico, fecha, hora, motivo, estado) VALUES
(111111,1,'2026-04-01', '09:00:00', 'Dolor de cabeza', 'Confirmada'),
(222222,3,'2026-04-01', '10:00:00', 'Chequeo general cardiologia', 'Programada'),
(333333,4,'2026-04-02', '11:30:00', 'Consulta por alergia', 'Programada');


CREATE TABLE salas (
    id_sala INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    tipo ENUM('Consulta General','Pediatria','Cardiologia','Procedimientos','Enfermeria') DEFAULT 'Consulta General',
    capacidad INT DEFAULT 1,
    activa BOOLEAN DEFAULT TRUE
)engine innodb;


INSERT INTO salas (nombre, tipo, capacidad) VALUES
('Sala 1', 'Consulta General', 20),
('Sala 2', 'Pediatria', 30),
('Sala Norte 1', 'Cardiologia', 40),
('Sala Norte 2','Enfermeria',40);

CREATE TABLE consultas (
	id_consulta INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    activa BOOLEAN
)engine innodb;

INSERT INTO consultas (nombre, descripcion,activa) VALUES
('Consulta General', 'Evaluación médica básica',true),
('Consulta Pediátrica', 'Atención médica infantil',false),
('Consulta Cardiológica 1', 'Evaluación del corazón',false),
('Consulta Cardiológica 2', 'Evaluación del corazón',true),
('Procedimiento Menor', 'Curaciones y procedimientos simples',true),
('Consulta General', 'Evaluación médica básica',true);

CREATE TABLE sala_consulta (
    id_sala INT NOT NULL,
    id_consulta INT NOT NULL,
	primary key(id_sala,id_consulta),
    constraint fk_scs FOREIGN KEY (id_sala) REFERENCES salas(id_sala),
    constraint fk_scc FOREIGN KEY (id_consulta) REFERENCES consultas(id_consulta)
)engine innodb;


INSERT INTO sala_consulta (id_sala, id_consulta) VALUES
(1,1),
(2,2),
(3,3),
(3,4),
(4,5);


CREATE TABLE medico_consulta (
	id_medico INT,
	id_consulta INT,
	primary key (id_medico,id_consulta),
	CONSTRAINT fk_mcm FOREIGN KEY (id_medico) REFERENCES medicos(id_medico),
	CONSTRAINT fk_mcc FOREIGN KEY (id_consulta) REFERENCES consultas(id_consulta)
)engine innodb;

INSERT INTO medico_consulta VALUES
(3,4),
(1,1),
(4,2);

CREATE TABLE TURNOS (
	id_turno int AUTO_INCREMENT primary key,
	num_turno varchar(4),
	id_medico INT,
	estado enum('espera','en consulta','visitado') default 'espera',
	CONSTRAINT fk_tm FOREIGN KEY (id_medico) REFERENCES medicos(id_medico)
)engine innodb;

insert into turnos (num_turno,id_medico) values 
('ABC9',3),
('QWE3',3),
('ZRT7',3),
('MXP1',2);