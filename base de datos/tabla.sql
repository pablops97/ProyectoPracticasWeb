CREATE TABLE TECNICO(
    ID INT AUTO_INCREMENT PRIMARY KEY,	
	NOMBREUSUARIO varchar(16),
	CONTRASENIA varchar(16),
    EMAIL VARCHAR(100),
    TELEFONO INT
)

CREATE TABLE Usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre TEXT,
    apellidos TEXT,
    dirección TEXT,
    población TEXT,
    CP INT,
    provincia TEXT,
    fecha_nacimiento DATE,
    cuenta_ibam VARCHAR(100),
    socio TINYINT(1),
    tutor VARCHAR(100),
    numero_socio INT,
    fecha_alta DATE DEFAULT CURRENT_DATE,
    fecha_baja DATE,
    imagen VARCHAR(255)
);


CREATE TABLE EVENTO(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    TITULO_EVENTO VARCHAR(100) NOT NULL,
    DESCRIPCION_EVENTO VARCHAR(255),
    LOCALIZACION VARCHAR(100),
    ESTADO VARCHAR(50),
    PRECIO DECIMAL DEFAULT 0,
    FECHA_INICIO_INSCRIPCION DATE,
    FECHA_INICIO DATE,
    FECHA_FIN DATE,
    IDCATEGORIA INT NOT NULL,
    NUMEROMAXPARTICIPANTES INT DEFAULT 20,
    IMAGEN VARCHAR(100),
    IDTECNICO INT NOT NULL,
    FOREIGN KEY(IDTECNICO) REFERENCES TECNICO(ID),
    FOREIGN KEY(IDCATEGORIA) REFERENCES CATEGORIA_EVENTO(ID)
);

/*SCRIPT PARA ACTUALIZAR LOS ESTADOS DE LOS EVENTOS DEPENDIENDO DE LA FECHA*/

SET GLOBAL event_scheduler = ON;

/*SCRIPT PARA COMPROBAR SI EL EVENTO ESTA EN CURSO*/
DELIMITER $$

CREATE EVENT IF NOT EXISTS update_event_state_to_in_course
ON SCHEDULE EVERY 1 MINUTE
DO
BEGIN
    UPDATE EVENTO
    SET ESTADO = 'En curso'
    WHERE CURDATE() = FECHA_INICIO AND ESTADO != 'En curso';
END$$

DELIMITER ;

/*SCRIPT PARA COMPROBAR SI EL EVENTO HA FINALIZADO*/
DELIMITER $$
CREATE EVENT IF NOT EXISTS update_event_state_to_finalized
ON SCHEDULE EVERY 1 MINUTE -- Ejecútalo una vez cada minuto
DO
BEGIN
    UPDATE EVENTO
    SET ESTADO = 'Finalizado'
    WHERE CURDATE() > FECHA_FIN AND ESTADO != 'Finalizado';
END$$
DELIMITER ;

CREATE TABLE CATEGORIA_EVENTO(
	ID INT PRIMARY KEY,
    NOMBRE VARCHAR(100) NOT NULL
);


CREATE TABLE MATRICULACION(
    IDMATRICULACION INT AUTO_INCREMENT primary key,
    IDEVENTO INT NOT NULL,
    IDUSUARIO INT NOT NULL,
    FECHA_MATRICULACION DATE DEFAULT (CURRENT_DATE),
    ESTADO VARCHAR(50),
    FECHA_ANULADO DATE,
    FOREIGN KEY(IDEVENTO) REFERENCES EVENTO(ID),
    FOREIGN KEY(IDUSUARIO) REFERENCES USUARIO(ID)
);




CREATE TABLE COMBINACIONTECNICO (
    IDTECNICO INT PRIMARY KEY,
    COMBINACION VARCHAR(255) NOT NULL,
    FOREIGN KEY (IDTECNICO) REFERENCES TECNICO(ID)
);

CREATE TABLE COMBINACIONUSUARIO (
    IDUSUARIO INT PRIMARY KEY,
    COMBINACION VARCHAR(255) NOT NULL,
    FOREIGN KEY (IDUSUARIO) REFERENCES USUARIO(ID)
);

CREATE TABLE REGISTROLOG(
	ID INT AUTO_INCREMENT PRIMARY KEY,
    MENSAJE VARCHAR(255) NOT NULL,
	FECHA_COMPLETA_EVENTO DATETIME DEFAULT CURRENT_TIMESTAMP,
    ID_TECNICO INT,
    ID_USUARIO INT,
    ID_MATRICULA INT,
    FOREIGN KEY(ID_TECNICO) REFERENCES TECNICO(ID),
    FOREIGN KEY(ID_USUARIO) REFERENCES USUARIO(ID),
    FOREIGN KEY(ID_MATRICULA) REFERENCES MATRICULACION(IDMATRICULACION)
);
ALTER TABLE REGISTROLOG ADD COLUMN ID_EVENTO INT;
ALTER TABLE REGISTROLOG ADD CONSTRAINT FK_IDEVENTO FOREIGN KEY (ID_EVENTO) REFERENCES EVENTO(ID);

CREATE TABLE olvidar_contraseña (
    id INT(11) NOT NULL AUTO_INCREMENT,
    email VARCHAR(200) CHARACTER SET NOT NULL,
    clave_temporal VARCHAR(200) CHARACTER SET NOT NULL,
    creado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
); ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO Usuario (usuario, email, password, nombre, apellidos, direccion, poblacion, CP, provincia, fecha_nacimiento, cuenta_iban, socio, tutor, numero_socio, Fecha_alta, fecha_baja, imagen) VALUES
('juanlopez', 'juan.lopez@example.com', 'C0ntr@s3ñ@Segur4', 'Juan', 'López', 'Calle del Sol 25', 'Madrid', 28001, 'Madrid', '1988-05-12', 'ES01234567890123456789', 1, NULL, 12345, '2024-05-13', NULL, 'noimage.jpg'),
('mariagarcia', 'maria.garcia@example.com', 'G@rc14M@r14', 'María', 'García', 'Avenida de la Libertad 78', 'Barcelona', 08001, 'Barcelona', '1992-03-20', 'ES98765432109876543210', 0, NULL, NULL, '2024-05-13', NULL, 'noimage.jpg'),
('carlosmartinez', 'carlos.martinez@example.com', 'C@rl0sM@rt1n3z', 'Carlos', 'Martínez', 'Calle de la Resistencia 15', 'Valencia', 46001, 'Valencia', '1985-11-22', 'ES54321098765432109876', 1, NULL, 98765, '2024-05-13', NULL, 'noimage.jpg'),
('luciafernandez', 'lucia.fernandez@example.com', 'Fern@nd3zLuc1@', 'Lucía', 'Fernández', 'Paseo de la Victoria 33', 'Sevilla', 41001, 'Sevilla', '1990-07-05', 'ES67890123456789012345', 0, NULL, NULL, '2024-05-13', NULL, 'noimage.jpg'),
('diegogomez', 'diego.gomez@example.com', 'G0m3zD13g0', 'Diego', 'Gómez', 'Calle Mayor 7', 'Granada', 18001, 'Granada', '1982-09-18', 'ES09876543210987654321', 1, NULL, 54321, '2024-05-13', NULL, 'noimage.jpg'),
('laurasilva', 'laura.silva@example.com', 'S1lv@L@ur4', 'Laura', 'Silva', 'Avenida de la Playa 10', 'Málaga', 29001, 'Málaga', '1987-12-02', 'ES13579246801357924680', 0, NULL, NULL, '2024-05-13', NULL, 'noimage.jpg'),
('manuelrodriguez', 'manuel.rodriguez@example.com', 'R0dr1gu3zM@nuel', 'Manuel', 'Rodríguez', 'Calle del Mar 55', 'Alicante', 03001, 'Alicante', '1980-06-15', 'ES24680135792468013579', 1, NULL, 67890, '2024-05-13', NULL, 'noimage.jpg'),
('anacastro', 'ana.castro@example.com', 'C@str0An@', 'Ana', 'Castro', 'Avenida de la Paz 20', 'Sevilla', 41001, 'Sevilla', '1989-04-30', 'ES36902468013579246801', 0, NULL, NULL, '2024-05-13', NULL, 'noimage.jpg'),
('sergiomolina', 'sergio.molina@example.com', 'M0l1n@S3rg10', 'Sergio', 'Molina', 'Calle Mayor 3', 'Madrid', 28001, 'Madrid', '1993-01-10', 'ES57924680135792468013', 1, NULL, 23456, '2024-05-13', NULL, 'noimage.jpg'),
('patriciagomez', 'patricia.gomez@example.com', 'G0m3zP@tr1c14', 'Patricia', 'Gómez', 'Paseo de la Estrella 8', 'Barcelona', 08001, 'Barcelona', '1984-08-25', 'ES79246801357924680135', 0, NULL, NULL, '2024-05-13', NULL, 'noimage.jpg'),
('alejandroperez', 'alejandro.perez@example.com', 'P3r3z@l3j@ndr0', 'Alejandro', 'Pérez', 'Calle de la Luna 15', 'Bilbao', 48001, 'Vizcaya', '1987-04-12', 'ES10293847561029384756', 1, NULL, 12346, '2024-05-14', NULL, 'noimage.jpg'),
('beatrizmartin', 'beatriz.martin@example.com', 'M@rt1nB34tr1z', 'Beatriz', 'Martín', 'Avenida del Cid 22', 'Valladolid', 47001, 'Valladolid', '1990-09-18', 'ES20394857610293847561', 0, NULL, NULL, '2024-05-14', NULL, 'noimage.jpg'),
('fernandolopez', 'fernando.lopez@example.com', 'L0p3zF3rn@nd0', 'Fernando', 'López', 'Calle del Carmen 8', 'Zaragoza', 50001, 'Zaragoza', '1985-11-22', 'ES30485761920394857612', 1, NULL, 98766, '2024-05-14', NULL, 'noimage.jpg'),
('martamoreno', 'marta.moreno@example.com', 'M0r3n0M@rt@', 'Marta', 'Moreno', 'Paseo de Gracia 45', 'Barcelona', 08002, 'Barcelona', '1992-07-05', 'ES40576192030485761920', 0, NULL, NULL, '2024-05-14', NULL, 'noimage.jpg'),
('franciscomartinez', 'francisco.martinez@example.com', 'M@rt1n3zFr@nc1sc0', 'Francisco', 'Martínez', 'Calle Real 12', 'Murcia', 30001, 'Murcia', '1980-12-15', 'ES50619203748576192030', 1, NULL, 54322, '2024-05-14', NULL, 'noimage.jpg'),
('angelagonzalez', 'angela.gonzalez@example.com', 'G0nz@l3z@ng3l@', 'Ángela', 'González', 'Avenida de Andalucía 33', 'Córdoba', 14001, 'Córdoba', '1994-05-12', 'ES60719304857619203040', 0, NULL, NULL, '2024-05-14', NULL, 'noimage.jpg'),
('ignaciolopez', 'ignacio.lopez@example.com', 'L0p3z1gn@c10', 'Ignacio', 'López', 'Calle de la Sierra 18', 'Madrid', 28002, 'Madrid', '1983-06-23', 'ES70820394857619304857', 1, NULL, 67891, '2024-05-14', NULL, 'noimage.jpg'),
('monicacruz', 'monica.cruz@example.com', 'CrUzM0n1c@', 'Mónica', 'Cruz', 'Avenida del Sol 9', 'Toledo', 45001, 'Toledo', '1991-02-28', 'ES80948576192030485761', 0, NULL, NULL, '2024-05-14', NULL, 'noimage.jpg'),
('ricardogarcia', 'ricardo.garcia@example.com', 'G@rc14R1c@rd0', 'Ricardo', 'García', 'Paseo de la Castellana 19', 'Madrid', 28003, 'Madrid', '1982-03-30', 'ES90129384756102938475', 1, NULL, 23457, '2024-05-14', NULL, 'noimage.jpg'),
('saramartinez', 'sara.martinez@example.com', 'M@rt1n3zS@r@', 'Sara', 'Martínez', 'Calle del Prado 14', 'Sevilla', 41002, 'Sevilla', '1989-08-25', 'ES10293847561029485761', 0, NULL, NULL, '2024-05-14', NULL, 'noimage.jpg'),
('jorgefernandez', 'jorge.fernandez@example.com', 'F3rn@nd3zJ0rg3', 'Jorge', 'Fernández', 'Avenida de los Reyes 3', 'Valencia', 46002, 'Valencia', '1987-10-12', 'ES11293847561029384756', 1, NULL, 12347, '2024-05-14', NULL, 'noimage.jpg'),
('claudiamoreno', 'claudia.moreno@example.com', 'M0r3n0Cl@ud14', 'Claudia', 'Moreno', 'Calle de la Estrella 23', 'Granada', 18002, 'Granada', '1991-04-14', 'ES21293847561029384756', 0, NULL, NULL, '2024-05-14', NULL, 'noimage.jpg'),
('javiergonzalez', 'javier.gonzalez@example.com', 'G0nz@l3zJ@v13r', 'Javier', 'González', 'Avenida de las Naciones 10', 'Madrid', 28004, 'Madrid', '1986-07-19', 'ES31293847561029384756', 1, NULL, 98767, '2024-05-14', NULL, 'noimage.jpg'),
('martagarcia', 'marta.garcia@example.com', 'G@rc14M@rt@', 'Marta', 'García', 'Calle de la Amistad 29', 'Bilbao', 48002, 'Vizcaya', '1992-12-05', 'ES41293847561029384756', 0, NULL, NULL, '2024-05-14', NULL, 'noimage.jpg'),
('joseramirez', 'jose.ramirez@example.com', 'R@m1r3zJ0s3', 'José', 'Ramírez', 'Avenida de la Luna 34', 'Barcelona', 08003, 'Barcelona', '1984-01-18', 'ES51293847561029384756', 1, NULL, 54323, '2024-05-14', NULL, 'noimage.jpg'),
('aliciarodriguez', 'alicia.rodriguez@example.com', 'R0dr1gu3z@l1c14', 'Alicia', 'Rodríguez', 'Calle del Río 21', 'Málaga', 29002, 'Málaga', '1990-11-07', 'ES61293847561029384756', 0, NULL, NULL, '2024-05-14', NULL, 'noimage.jpg'),
('miguelmendez', 'miguel.mendez@example.com', 'M3nd3zM1gu3l', 'Miguel', 'Méndez', 'Calle de la Esperanza 11', 'Murcia', 30002, 'Murcia', '1983-08-22', 'ES71293847561029384756', 1, NULL, 67892, '2024-05-14', NULL, 'noimage.jpg'),
('cristinaalvarez', 'cristina.alvarez@example.com', '@lv@r3zCr1st1n@', 'Cristina', 'Álvarez', 'Avenida de la Luz 18', 'Sevilla', 41003, 'Sevilla', '1995-09-23', 'ES81293847561029384756', 0, NULL, NULL, '2024-05-14', NULL, 'noimage.jpg'),
('raulgonzalez', 'raul.gonzalez@example.com', 'G0nz@l3zR@ul', 'Raúl', 'González', 'Calle del Cielo 6', 'Alicante', 03002, 'Alicante', '1982-02-15', 'ES91293847561029384756', 1, NULL, 23458, '2024-05-14', NULL, 'noimage.jpg'),
('sofiacruz', 'sofia.cruz@example.com', 'CrUzS0f14', 'Sofía', 'Cruz', 'Paseo del Parque 8', 'Toledo', 45002, 'Toledo', '1993-06-20', 'ES10293847561029384757', 0, NULL, NULL, '2024-05-14', NULL, 'noimage.jpg');


/*INSERT PARA EVENTOS*/
INSERT INTO EVENTO (TITULO_EVENTO, DESCRIPCION_EVENTO, LOCALIZACION, ESTADO, PRECIO, FECHA_INICIO_INSCRIPCION, FECHA_INICIO, FECHA_FIN, IDCATEGORIA, NUMEROMAXPARTICIPANTES, IMAGEN, IDTECNICO)
VALUES 
('Festival de Música', 'Festival de música local con bandas emergentes', 'Plaza de España', 'Planificado', 15.00, '2024-05-01', '2024-06-20', '2024-06-20', 1, 100, 'festival.jpg', 27),
('Taller de Pintura', 'Taller para aprender técnicas de pintura al óleo', 'Centro Cultural El Tronío', 'Planificado', 10.00, '2024-06-01', '2024-07-05', '2024-07-06', 2, 20, 'taller_pintura.jpg', 27),
('Carrera Popular', 'Carrera popular para todas las edades', 'Parque Municipal', 'Planificado', 0.00, '2024-08-01', '2024-09-10', '2024-09-10', 3, 200, 'carrera.jpg', 27),
('Concierto de Jazz', 'Concierto de jazz en vivo', 'Auditorio Municipal', 'Planificado', 20.00, '2024-07-01', '2024-08-15', '2024-08-15', 1, 150, 'jazz.jpg', 27),
('Curso de Cocina', 'Curso de cocina mediterránea', 'Centro de Formación', 'Planificado', 25.00, '2024-06-15', '2024-07-12', '2024-07-13', 2, 15, 'cocina.jpg', 27),
('Feria del Libro', 'Feria del libro con autores locales', 'Plaza Mayor', 'Planificado', 0.00, '2024-09-01', '2024-10-01', '2024-10-03', 1, 50, 'libro.jpg', 27),
('Yoga al Aire Libre', 'Sesión de yoga al aire libre', 'Parque Los Llanos', 'Planificado', 5.00, '2024-05-15', '2024-06-30', '2024-06-30', 3, 30, 'yoga.jpg', 27),
('Exposición de Arte', 'Exposición de arte contemporáneo', 'Sala de Exposiciones', 'Planificado', 0.00, '2024-07-01', '2024-08-01', '2024-08-15', 1, 50, 'arte.jpg', 27),
('Cine de Verano', 'Proyección de películas al aire libre', 'Parque Municipal', 'Planificado', 3.00, '2024-06-01', '2024-07-20', '2024-07-20', 1, 100, 'cine.jpg', 27),
('Masterclass de Fotografía', 'Clase magistral sobre técnicas fotográficas', 'Centro Cultural El Tronío', 'Planificado', 15.00, '2024-08-01', '2024-09-05', '2024-09-05', 2, 25, 'fotografia.jpg', 27),
('Torneo de Ajedrez', 'Torneo de ajedrez para todas las edades', 'Casa de la Juventud', 'Planificado', 5.00, '2024-06-15', '2024-07-22', '2024-07-22', 3, 40, 'ajedrez.jpg', 27),
('Concierto de Flamenco', 'Concierto de flamenco en vivo', 'Auditorio Municipal', 'Planificado', 18.00, '2024-07-01', '2024-08-30', '2024-08-30', 1, 150, 'flamenco.jpg', 27),
('Taller de Cerámica', 'Taller para aprender técnicas de cerámica', 'Centro Cultural El Tronío', 'Planificado', 20.00, '2024-05-01', '2024-06-10', '2024-06-11', 2, 20, 'ceramica.jpg', 27),
('Festival de Teatro', 'Festival de teatro con obras locales', 'Teatro Municipal', 'Planificado', 12.00, '2024-08-01', '2024-09-15', '2024-09-17', 1, 100, 'teatro.jpg', 27),
('Ruta de Senderismo', 'Ruta de senderismo por la sierra', 'Punto de Encuentro: Plaza Mayor', 'Planificado', 0.00, '2024-06-01', '2024-07-25', '2024-07-25', 3, 50, 'senderismo.jpg', 27),
('Taller de Jardinería', 'Taller sobre técnicas de jardinería', 'Centro de Formación', 'Planificado', 10.00, '2024-05-01', '2024-06-15', '2024-06-16', 2, 15, 'jardineria.jpg', 27),
('Festival Gastronómico', 'Festival con degustaciones de platos locales', 'Plaza de España', 'Planificado', 25.00, '2024-07-01', '2024-08-20', '2024-08-20', 1, 200, 'gastronomia.jpg', 27),
('Curso de Primeros Auxilios', 'Curso básico de primeros auxilios', 'Centro de Salud', 'Planificado', 0.00, '2024-08-01', '2024-09-12', '2024-09-12', 2, 30, 'primeros_auxilios.jpg', 27),
('Espectáculo de Magia', 'Espectáculo de magia para toda la familia', 'Teatro Municipal', 'Planificado', 8.00, '2024-06-01', '2024-07-18', '2024-07-18', 1, 100, 'magia.jpg', 27),
('Competición de Ciclismo', 'Carrera de ciclismo amateur', 'Circuito Urbano', 'Planificado', 0.00, '2024-08-01', '2024-09-20', '2024-09-20', 3, 100, 'ciclismo.jpg', 27);



/*INSERT PARA CATEGORIAS*/

INSERT INTO CATEGORIA_EVENTO (ID, NOMBRE) VALUES (1, 'Educativo');
INSERT INTO CATEGORIA_EVENTO (ID, NOMBRE) VALUES (2, 'Social');
INSERT INTO CATEGORIA_EVENTO (ID, NOMBRE) VALUES (3, 'Cultural');
INSERT INTO CATEGORIA_EVENTO (ID, NOMBRE) VALUES (4, 'Deportivo');
INSERT INTO CATEGORIA_EVENTO (ID, NOMBRE) VALUES (5, 'Empresarial');
INSERT INTO CATEGORIA_EVENTO (ID, NOMBRE) VALUES (6, 'Tecnológico');
INSERT INTO CATEGORIA_EVENTO (ID, NOMBRE) VALUES (7, 'Benéfico');


/*INSERT MATRICULACION (PARA TENER EJEMPLOS)*/

INSERT INTO MATRICULACION (IDEVENTO, IDUSUARIO, FECHA_MATRICULACION, ESTADO, FECHA_ANULADO) VALUES 
(45, 72, '2024-05-11', 'Confirmada', NULL),
(46, 72, '2024-06-05', 'Confirmada', NULL),
(47, 72, '2024-08-03', 'Confirmada', NULL),
(48, 72, '2024-07-15', 'Confirmada', NULL),
(49, 72, '2024-06-25', 'Confirmada', NULL),
(50, 72, '2024-09-06', 'Confirmada', NULL);