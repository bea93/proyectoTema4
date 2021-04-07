/* Creación de la Base de Datos */
    CREATE DATABASE if NOT EXISTS DAW213DBDepartamentos;
    
/* Creación del usuario */
    CREATE USER IF NOT EXISTS 'usuarioDAW213DBDepartamentos'@'%' identified BY 'paso';

/* Dar permisos al usuario creado */
    GRANT ALL PRIVILEGES ON DAW213DBDepartamentos.* TO 'usuarioDAW213DBDepartamentos'@'%'; 

    USE DAW213DBDepartamentos;

/* Creación de la table departamento */
    CREATE TABLE Departamento (
            CodDepartamento VARCHAR(3) PRIMARY KEY,
            DescDepartamento VARCHAR(255) NOT NULL,
            FechaBaja INT DEFAULT NULL,
            VolumenNegocio FLOAT DEFAULT NULL
    ) ENGINE=INNODB;