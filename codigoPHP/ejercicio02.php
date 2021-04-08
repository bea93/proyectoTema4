<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">        
        <title>Ejercicio 02</title>
        <style>
            td, tr{
                padding: 10px;
            }
        </style>
    </head>

    <body>
        <?php
        /**
          @author: Bea Merino Macía
          @since: 07/04/2021
          @description: Mostrar el contenido de la tabla Departamento y el número de registros.
         */
        
        //Fichero de configuración de la BBDD
        require_once '../config/confDB.php';
        
        try {
            //Objeto PDO con los datos de conexión
            $miBD = new PDO(HOST,USER,PASS);
            $miBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Consulta SQL
            $sentenciaSQL = "SELECT * FROM Departamento";
            //Crea una variable con la consulta sql
            $resultadoSQL = $miBD->query($sentenciaSQL); 
            echo "<h1>Código con query</h1>";
            //Muestra el resultado de la consulta
            echo "Número de registros en la tabla Departamento: " . $resultadoSQL->rowCount(); 
            echo "<br><br>";

            //Crea una tabla para introducir los datos que hay en la BBDD
            echo "<table border='0'>";
            echo "<tr>";
                echo "<th>Codigo</th>";
                echo "<th>Descripción</th>";
                echo "<th>Volumen Negocio</th>";
            echo "</tr>";
            //Al realizar el fetchObject, se pueden sacar los datos de $departamento como si fuera un objeto
            while ($departamento = $resultadoSQL->fetchObject()) { 
                echo "<tr>";
                echo "<td>$departamento->CodDepartamento</td>";
                echo "<td>$departamento->DescDepartamento</td>";
                echo "<td>$departamento->VolumenNegocio</td>";
                echo "</tr>";
            }
            echo "</table>";
               
            //Consulta SQL
            $consultaPreparada2 = 'SELECT * FROM Departamento';
            $resultadoSQL2 = $miBD->prepare($consultaPreparada2);
            $resultadoSQL2->execute(); 
            echo "<h1>Código con prepare y execute</h1>";
            //Muestra el resultado de la consulta
            echo "Número de registros en la tabla Departamento: " . $resultadoSQL2->rowCount(); 
            echo "<br><br>";

            //Crea una tabla para introducir los datos que hay en la BBDD
            echo "<table border='0'>";
            echo "<tr>";
                echo "<th>Codigo</th>";
                echo "<th>Descripción</th>";
                echo "<th>Volumen Negocio</th>";
            echo "</tr>";
            //Al realizar el fetchObject, se pueden sacar los datos de $departamento como si fuera un objeto
            while ($departamento = $resultadoSQL2->fetchObject()) { 
                echo "<tr>";
                echo "<td>$departamento->CodDepartamento</td>";
                echo "<td>$departamento->DescDepartamento</td>";
                echo "<td>$departamento->VolumenNegocio</td>";
                echo "</tr>";
            }
            echo "</table>";
            
        //Captura de la excepción
        } catch (PDOException $mensajeError) { 
            //Mensaje de salida
            echo "Error " . $mensajeError->getMessage() . "<br>"; 
            //Código del error
            echo "Codigo del error " . $mensajeError->getCode() . "<br>"; 
        } finally {
            //Cerramos la conexion
            unset($miBD); 
        }
        ?>
    </body>
</html>