/* Creación de la Base de Datos */
    CREATE DATABASE if NOT EXISTS DAW213DBDepartamentos;
    
/* Creación del usuario */
    CREATE USER IF NOT EXISTS 'usuarioDAW213DBDepartamentos'@'%' identified BY 'paso'; 
    
/* Usar la base de datos creada */
    USE DAW213DBDepartamentos;

/* Creación de la table departamento */
    CREATE TABLE Departamento (
            CodDepartamento VARCHAR(3) PRIMARY KEY,
            DescDepartamento VARCHAR(255) NOT NULL,
            FechaBaja INT DEFAULT NULL,
            VolumenNegocio FLOAT NOT NULL
    ) ENGINE=INNODB DEFAULT CHARSET=LATIN1;

/* Dar permisos al usuario creado */
    GRANT ALL PRIVILEGES ON DAW213DBDepartamentos.* TO 'usuarioDAW213DBDepartamentos'@'%'; 

/* Base de datos a usar */
    USE DAW213DBDepartamentos;

/* Introduccion de datos dentro de la tabla creada */
    INSERT INTO Departamento(CodDepartamento,DescDepartamento,FechaBaja, VolumenNegocio) VALUES
        ('INF', 'Departamento de informatica',1574772123, 50),
        ('VEN', 'Departamento de ventas',1574772123, 800000),
        ('CON', 'Departamento de contabilidad',1574772123, 900000),
        ('MAT', 'Departamento de matematicas',1574772123, 80000000),
        ('CAT', 'Departamento de gatos',1574772123, 12584631268);

/* Borrar base de datos */
    DROP database DAW213DBDepartamentos;

/* Borrar usuario asociado a esa base de datos */
    DROP USER usuarioDAW213DBDepartamentos;