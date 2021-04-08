<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 05</title>
        <style>
            td, tr{
                padding: 10px;
            }
        </style>
    </head>
    <body>  

        <?php
        /**
          @author: Bea Merino
          @since: 07/04/2021
          @description: Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno
         */
        
        //Fichero de configuración de la BBDD
        require_once '../config/confDB.php';

        try {
            //Objeto PDO con los datos de conexión
            $miBD = new PDO(HOST,USER,PASS);
            $miBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            
            //Inicializa la transacción
            $miBD->beginTransaction();
            
            //Crea los tres querys de los insert
            $insert1 = $miBD->prepare('INSERT INTO Departamento (CodDepartamento, DescDepartamento) VALUES("BEA","Yo")');
            $insert2 = $miBD->prepare('INSERT INTO Departamento (CodDepartamento, DescDepartamento) VALUES("NAJ","Nerea")');
            $insert3 = $miBD->prepare('INSERT INTO Departamento (CodDepartamento, DescDepartamento) VALUES("OLA","La otra")');
            
            $insert1->execute(); 
            $insert2->execute(); 
            $insert3->execute();
            
            $miBD -> commit();

            //Mensaje de salida
            echo "<h3 style='color: green'>Las instrucciones se han realizado correctamente</h3>" . "<br>";
            $consultaSelect = $miBD->prepare('SELECT * FROM Departamento');
            $consultaSelect->execute();
            //Crea una tabla para introducir los datos que hay en la BBDD
            echo "<table border='0'>";
            echo "<tr>";
            echo "<th>Codigo</th>";
            echo "<th>Descripción</th>";
            echo "<th>VolumenNegocio</th>";
            echo "</tr>";
            //Al realizar el fetchObject, se pueden sacar los datos de $registro como si fuera un objeto
            while ($registro = $consultaSelect->fetchObject()) {
                echo "<tr>";
                echo "<td>$registro->CodDepartamento</td>";
                echo "<td>$registro->DescDepartamento</td>";
                echo "<td>$registro->VolumenNegocio</td>";
                echo "</tr>";
            }
            echo "</table>";
        //Captura de la excepción
        } catch (Exception $e) {
            $miBD->rollback();
            echo "<h3 style='color: red'>Error en la transacción</h3>";
            echo $e->getMessage();
        } finally {
            //Cerramos la conexion
            unset($miBD); //Se cierra la conexion
        }
        ?>
    </body>
</html>