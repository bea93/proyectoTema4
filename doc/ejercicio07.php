<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 7</title>
        <meta charset="UTF-8">
        <meta name="author" content="Bea Merino">
    </head>
    <body>
        <?php
        /**
         * @author Bea Merino
         * @since 29/10/2020
         * Página web que toma datos (c�digo y descripci�n) de un fichero xml y los a�ade a la tabla
                    Departamento de nuestra base de datos. (IMPORTAR)
         */
        
        //Fichero de configuración de la BBDD
        require_once '../config/confDB.php';
        
        try{
            //Objeto PDO con los datos de conexión
            $miBD = new PDO(HOST,USER,PASS);
            $miBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Crea el query de borrado
            $deleteSQL = "DELETE FROM Departamento";
            //Mete el query en una variable
            $resultadoSQL = $miBD->query($deleteSQL);
            //Ejecuta el query
            $resultadoSQL->execute();
            //Query de inserción
            $sentenciaSQL = ('INSERT INTO Departamento (CodDepartamento, DescDepartamento) VALUES (:codigo, :descripcion);');
            //Prepara la consulta
            $consultaPreparada = $miBD->prepare($sentenciaSQL);
            //El método bindParam asigna valores a los parámetros
            $consultaPreparada->bindParam(':codigo', $codigo);
            $consultaPreparada->bindParam(':descripcion', $descripcion);
            //Fichero del que sacará los valores a añadir
            $ficheroXML = new DOMDocument("1.0", "utf-8");
            //Establece la ruta en la que está el fichero
            $ficheroXML->load('../tmp/DBXML.xml');
            //Copia el arbol XML interno a un string 
            echo $ficheroXML->saveXML();
            
            //Bucle que otorga los valores
            foreach ($ficheroXML as $key => $value) {
                $miBD->beginTransaction();
                //El método bindParam asigna valores a los parámetros
                $consultaPreparada->bindParam(':codigo', $value[0]);
                $consultaPreparada->bindParam(':descripcion', $value[1]);
                $consultaPreparada->execute();
                $miBD->commit();
            }
            //Query para insertar
            $consultaSelect = $miBD->prepare('INSERT INTO Departamento (CodDepartamento, DescDepartamento) VALUES (:codigo, :descripcion);');
            $consultaSelect->execute();
            
            //Mensaje que se mostrará si no ha ocurrido ningún error
            echo "<h3 style='color: green'>Se ha realizado correctamente la importación</h3>";
        }catch (PDOException $mensajeError) { 
            echo "<h3>Mensaje de ERROR</h3>";
            //Mensaje de salida
            echo "Error: " . $mensajeError->getMessage() . "<br>";
            //Código del error
            echo "Código de error: " . $mensajeError->getCode();
        } finally {
            //Cerramos la conexión
            unset($miBD);
        }
        ?>
    </body>
</html>