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