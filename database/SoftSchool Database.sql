
CREATE TABLE IF NOT EXISTS `Administrativo` (
  `IdAmin` int(100) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Genero` varchar(10) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `Cargo` varchar(50) NOT NULL,
  `Foto` varchar(100) NOT NULL,
  `Clave` varchar(50) NOT NULL,
  PRIMARY KEY (`IdAmin`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

INSERT INTO `Administrativo`(`IdAmin`, `Nombre`, `Apellido`, `Genero`, `Correo`, `Telefono`, `Cargo`, `Foto`, `Clave`) 
VALUES (1, 'Juan', 'Ramirez', 'Masculino','juanramirez@gmail.com','(809) 269-5698' ,'Administrador', '', '8cb2237d0679ca88db6464eac60da96345513964');

CREATE TABLE IF NOT EXISTS `Estudiante` (
  `IdEstudiante` int(100) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Edad` int(25) NOT NULL,
  `Genero` varchar(10) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `Direccion` varchar(15) NOT NULL,
  `Foto` varchar(100) NOT NULL,
  PRIMARY KEY (`IdEstudiante`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `Profesor` (
  `IdProfesor` int(100) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Genero` varchar(10) NOT NULL,
  `Edad` int(25) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `Direccion` varchar(100) NOT NULL,
  `Especialidad` varchar(50) NOT NULL,
  `Foto` varchar(100) NOT NULL,
  PRIMARY KEY (`IdProfesor`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `Materia` (
  `IdMateria` int(100) NOT NULL AUTO_INCREMENT,
  `NombreMateria` varchar(50) NOT NULL,
  `Descripción` varchar(30) NOT NULL,
  `Edad` int(25) NOT NULL,
  `IdProfesor` int(100) NOT NULL,
  `IdEstudiante` int(100) NOT NULL,
  PRIMARY KEY (`IdMateria`),
  FOREIGN KEY (`IdProfesor`) REFERENCES `Profesor`(`IdProfesor`),
  FOREIGN KEY (`IdEstudiante`) REFERENCES `Estudiante`(`IdEstudiante`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `Aula` (
  `IdAula` int(100) NOT NULL AUTO_INCREMENT,
  `NúmeroAula` varchar(10) NOT NULL,
  `Capacidad` int(30) NOT NULL,
  `Tipo` int(20) NOT NULL,
  `IdMateria` int(100) NOT NULL,
  PRIMARY KEY (`IdAula`),
  FOREIGN KEY (`IdMateria`) REFERENCES `Materia`(`IdMateria`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
