<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 07</title>
        <meta charset="UTF-8">
        <meta name="author" content="Bea Merino">
        <style>
            td, tr{
                padding: 10px;
            }
        </style>
    </head>
    <body>
        <?php
        /**
         * @author Bea Merino
         * @since 08/04/2021
         * @description: Página web que toma datos (código y descripción) de un fichero xml y los añade a la tabla
                    Departamento de nuestra base de datos. (IMPORTAR)
         */
        
        //Fichero de configuración de la BBDD
        require_once '../config/confDB.php';
        
        //Carga el archivo 
        $xml = simplexml_load_file("../tmp/DBXML.xml");
        
        try{
            //Objeto PDO con los datos de conexión
            $miBD = new PDO(HOST,USER,PASS);
            $miBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
            $miBD->beginTransaction();
            
            //Crea un query que borre la tabla y la vuelva a crear para que no dé errores de claves duplicadas
            $consultaDrop = $miBD->prepare('DROP TABLE Departamento'); 
            $consultaDrop->execute();
            
            $consultaCrear = $miBD->prepare(' CREATE TABLE Departamento (
                                            CodDepartamento VARCHAR(3) PRIMARY KEY,
                                            DescDepartamento VARCHAR(255) NOT NULL,
                                            FechaBaja INT DEFAULT NULL,
                                            VolumenNegocio FLOAT DEFAULT NULL
                                            )ENGINE=INNODB;'); 
            $consultaCrear->execute();
            
            //Recorremos el archivo y creamos el sql para su inserción, si se produce algun error sale por el catch
            foreach ($xml as $value) {
                $consultaInsert = $miBD->prepare("INSERT INTO Departamento(CodDepartamento, DescDepartamento) VALUES(:codigo,:desc)");
                //Saca los parámetros del xml
                $parametros = [ ":codigo"=>$value->CodDepartamento,
                                ":desc"=>$value->DescDepartamento
                        ];
                //Ejecuta la sentencia
                $consultaInsert->execute($parametros);
            }
            //Realiza el commit
            $miBD->commit();
            //Mensaje en caso de que todo vaya bien
            echo "<h3 style='color: green'>Datos cargados</h3><br>";
            //Query para mostrar todos los registros de la tabla Departamentos
            $consultaSelect = $miBD->prepare('select * from Departamento'); 
            $consultaSelect->execute();
            
            
            ?>            
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Volumen Negocio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //Al realizar el fetchObject, se pueden sacar los datos de $registro como si fuera un objeto
                    while ($registro = $consultaSelect->fetchObject()) {
                        ?>
                        <tr>
                            <?php
                            echo "<td>" . $registro->CodDepartamento . "</td>";
                            echo "<td>" . $registro->DescDepartamento . "</td>";
                            echo "<td>$registro->VolumenNegocio</td>";                        }
                        ?>
                    </tr>
                </tbody>
            </table>
            <?php
        } catch (PDOException $mensajeError){
            //Mensaje de salida
            echo "Error: " . $mensajeError->getMessage() . "<br>";
            //Código del error
            echo "Código de error: " . $mensajeError->getCode();
            $miBD->rollBack();
        }
          ?>  
    </body>
</html>