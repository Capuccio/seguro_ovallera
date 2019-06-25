DROP DATABASE IF EXISTS seguro_ovallera;

CREATE DATABASE seguro_ovallera;

USE seguro_ovallera;

CREATE TABLE pacientes (
  id_pacientes INTEGER NOT NULL AUTO_INCREMENT COMMENT "ID de los Pacientes",
  nombre_pac VARCHAR(20) NOT NULL COMMENT "Nombre de los Pacientes",
  apellido_pac VARCHAR(20) NOT NULL COMMENT "Apellido de los Pacientes",
  cedula_pac INTEGER(8) NOT NULL COMMENT "Cédula de los Pacientes",
  correo_pac TEXT NOT NULL COMMENT "Correo de los Pacientes",
  celular_pac VARCHAR(13) NOT NULL COMMENT "Celular de los Pacientes",
  telefono_pac VARCHAR(13) NOT NULL COMMENT "Teléfono de los Pacientes",
  direccion_pac TEXT NOT NULL COMMENT "Dirección de los Paciente",
  sexo_pac INTEGER(2) NOT NULL COMMENT "Sexo de los Pacientes, 1-Masculino 2-Femenino",
  edad_pac INTEGER(2) NOT NULL COMMENT "Edad de los Pacientes",
  PRIMARY KEY(id_pacientes)
) COMMENT "Tabla de Pacientes";

CREATE TABLE trabajadores (
  id_trabajadores INTEGER NOT NULL AUTO_INCREMENT COMMENT "ID de los doctores",
  nombre_tra VARCHAR(20) NOT NULL COMMENT "Nombre de los Trabajadores",
  apellido_tra VARCHAR(20) NOT NULL COMMENT "Apellido de los Trabajadores",
  cedula_tra INTEGER(8) NOT NULL COMMENT "Cédula de los Trabajadores",
  correo_tra TEXT NOT NULL COMMENT "Correo de los Trabajadores",
  clave_tra TEXT NOT NULL COMMENT "Clave de los Trabajadores",
  celular_tra VARCHAR(13) NOT NULL COMMENT "Celular de los Trabajadores",
  telefono_tra VARCHAR(13) NOT NULL COMMENT "Teléfono de los Trabajadores",
  direccion_tra TEXT NOT NULL COMMENT "Dirección de los Trabajadores",
  sexo_tra INTEGER(2) NOT NULL COMMENT "Sexo de los Trabajadores, 1-Masculino 2-Femenino",
  edad_tra INTEGER(2) NOT NULL COMMENT "Edad de los Trabajadores",
  especialidad_tra VARCHAR(50) NOT NULL COMMENT "Especialidad de los trabajadores/doctores",
  turno_tra INTEGER(1) COMMENT "Turnos de los doctores, 1-Mañana 2-Tarde",
  nivel_tra INTEGER(1) NOT NULL COMMENT "Nivel de los Trabajadores, 1-Administrador 2-Secretario/a  3-Doctor/a",
  PRIMARY KEY(id_trabajadores)
) COMMENT "Tabla de los Doctores";

CREATE TABLE citas (
  id_citas INTEGER NOT NULL AUTO_INCREMENT COMMENT "ID de las Citas",
  id_trabajadores INTEGER NOT NULL COMMENT "ID de el Doctor",
  id_pacientes INTEGER NOT NULL COMMENT "ID de el Paciente",
  motivo_cit TEXT NOT NULL COMMENT "Motivo de la visita del Paciente",
  respuesta_cit TEXT NOT NULL COMMENT "Respuesta del Doctor al Paciente",
  fecha_cit VARCHAR(10) NOT NULL COMMENT "Fecha de la cita",
  hora_cit VARCHAR(5) NOT NULL COMMENT "Hora de la cita",
  status_cit INTEGER NOT NULL COMMENT "Estatus de la cita, 1-Activo 2-Finalizado, 3-Anulado",
  PRIMARY KEY(id_citas),
  FOREIGN KEY(id_trabajadores) REFERENCES trabajadores(id_trabajadores),
  FOREIGN KEY(id_pacientes) REFERENCES pacientes(id_pacientes)
) COMMENT "Tabla de Citas";

CREATE TABLE insumos (
  id_insumos INTEGER NOT NULL AUTO_INCREMENT COMMENT "ID de los Insumos",
  nombre_ins TEXT NOT NULL COMMENT "Nombre del Insumo",
  cantidad_ins INTEGER NOT NULL COMMENT "Cantidad del Insumo",
  fecha_vencimiento_ins VARCHAR(10) NOT NULL COMMENT "Fecha de Vencimiento del Insumo",
  PRIMARY KEY(id_insumos)
) COMMENT "Tabla de Insumos";

CREATE TABLE auditoria (
  id_auditoria INTEGER NOT NULL AUTO_INCREMENT COMMENT "ID de las Auditorias",
  id_trabajadores INTEGER NOT NULL COMMENT "ID del Trabajador",
  accion_aud TEXT NOT NULL COMMENT "Acción hecha por el Trabajador",
  fecha_aud VARCHAR(10) NOT NULL COMMENT "Fecha de la Acción",
  hora_aud VARCHAR(5) NOT NULL COMMENT "Hora de la Acción",
  PRIMARY KEY(id_auditoria),
  FOREIGN KEY(id_trabajadores) REFERENCES trabajadores(id_trabajadores)
) COMMENT "Tabla de Auditoría";

/* Claves por defecto: administrador, secretario y doctor */

INSERT INTO trabajadores (nombre_tra, apellido_tra, cedula_tra, correo_tra, clave_tra, celular_tra, telefono_tra, direccion_tra, sexo_tra, edad_tra, especialidad_tra, turno_tra, nivel_tra) VALUES
('Administrador', 'Admin', '26715098', 'admin@gmail.com', 'e7951aa8f403ff1', '0412-7446157', '0243-2465683', 'Avenida 19 de Abril', '1', '19', 'Administrador', '1', '1'),
('Secretario', 'Secretary', '11980197', 'secretario@gmail.com', '97bb2eaab5d0276', '0412-4420071', '0243-2465683', 'Calle Principal Bermudez', '2', '20', 'Secretario/a', '1', '2'),
('Doctor', 'Apeshido', '9674471', 'doctor@gmail.com', '0af4e2a428d75aa', '0412-8840031', '0243-4215461', 'Avenida Bolivar', '1', '40', 'Oftamologia', '1', '3');