CREATE TABLE TECNICO(	
	NOMBREUSUARIO varchar(16) PRIMARY KEY,
	CONTRASENIA varchar(16)
)

CREATE TABLE Usuario (
    usuario VARCHAR(100) UNIQUE,
    email VARCHAR(100) UNIQUE,
    contraseña VARCHAR(255),
    Nombre TEXT,
    Apellidos TEXT,
    Dirección TEXT,
    Población TEXT,
    CP INT,
    Provincia TEXT,
    Fecha_nacimiento DATE,
    Cuenta_ibam VARCHAR(100),
    Socio TINYINT(1),
    Tutor VARCHAR(100),
    Numero_socio INT,
    Fecha_alta DATE,
    Fecha_baja DATE,
    PRIMARY KEY (usuario, email)
);

INSERT INTO Usuario (usuario, email, contraseña, Nombre, Apellidos, Dirección, Población, CP, Provincia, Fecha_nacimiento, Cuenta_ibam, Socio, Tutor, Numero_socio, Fecha_alta, Fecha_baja) VALUES
('juanlopez', 'juan.lopez@example.com', 'C0ntr@s3ñ@Segur4', 'Juan', 'López', 'Calle del Sol 25', 'Madrid', 28001, 'Madrid', '1988-05-12', 'ES01234567890123456789', 1, NULL, 12345, '2024-05-13', NULL),
('mariagarcia', 'maria.garcia@example.com', 'G@rc14M@r14', 'María', 'García', 'Avenida de la Libertad 78', 'Barcelona', 08001, 'Barcelona', '1992-03-20', 'ES98765432109876543210', 0, NULL, NULL, '2024-05-13', NULL),
('carlosmartinez', 'carlos.martinez@example.com', 'C@rl0sM@rt1n3z', 'Carlos', 'Martínez', 'Calle de la Resistencia 15', 'Valencia', 46001, 'Valencia', '1985-11-22', 'ES54321098765432109876', 1, NULL, 98765, '2024-05-13', NULL),
('luciafernandez', 'lucia.fernandez@example.com', 'Fern@nd3zLuc1@', 'Lucía', 'Fernández', 'Paseo de la Victoria 33', 'Sevilla', 41001, 'Sevilla', '1990-07-05', 'ES67890123456789012345', 0, NULL, NULL, '2024-05-13', NULL),
('diegogomez', 'diego.gomez@example.com', 'G0m3zD13g0', 'Diego', 'Gómez', 'Calle Mayor 7', 'Granada', 18001, 'Granada', '1982-09-18', 'ES09876543210987654321', 1, NULL, 54321, '2024-05-13', NULL),
('laurasilva', 'laura.silva@example.com', 'S1lv@L@ur4', 'Laura', 'Silva', 'Avenida de la Playa 10', 'Málaga', 29001, 'Málaga', '1987-12-02', 'ES13579246801357924680', 0, NULL, NULL, '2024-05-13', NULL),
('manuelrodriguez', 'manuel.rodriguez@example.com', 'R0dr1gu3zM@nuel', 'Manuel', 'Rodríguez', 'Calle del Mar 55', 'Alicante', 03001, 'Alicante', '1980-06-15', 'ES24680135792468013579', 1, NULL, 67890, '2024-05-13', NULL),
('anacastro', 'ana.castro@example.com', 'C@str0An@', 'Ana', 'Castro', 'Avenida de la Paz 20', 'Sevilla', 41001, 'Sevilla', '1989-04-30', 'ES36902468013579246801', 0, NULL, NULL, '2024-05-13', NULL),
('sergiomolina', 'sergio.molina@example.com', 'M0l1n@S3rg10', 'Sergio', 'Molina', 'Calle Mayor 3', 'Madrid', 28001, 'Madrid', '1993-01-10', 'ES57924680135792468013', 1, NULL, 23456, '2024-05-13', NULL),
('patriciagomez', 'patricia.gomez@example.com', 'G0m3zP@tr1c14', 'Patricia', 'Gómez', 'Paseo de la Estrella 8', 'Barcelona', 08001, 'Barcelona', '1984-08-25', 'ES79246801357924680135', 0, NULL, NULL, '2024-05-13', NULL);