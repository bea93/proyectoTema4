/* Base de datos a usar */
    USE dbs272025;

/* Creación de la tabla departamento */
    CREATE TABLE Departamento (
            CodDepartamento VARCHAR(3) PRIMARY KEY,
            DescDepartamento VARCHAR(255) NOT NULL,
            FechaBaja INT DEFAULT NULL,
            VolumenNegocio FLOAT DEFAULT NULL
    ) ENGINE=INNODB;