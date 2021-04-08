<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 06</title>
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
          @description: Pagina web que cargue registros en la tabla Departamento desde un array departamentosnuevos utilizando una consulta preparada
         */

        //Fichero de configuración de la BBDD
        require_once '../config/confDB.php';
        
        try {

           //Objeto PDO con los datos de conexión
            $miBD = new PDO(HOST,USER,PASS);
            //$miBD = new PDO('mysql:host=192.168.20.19:3306;dbname=DAW213DBDepartamentos', 'usuarioDAW213DBDepartamentos', 'paso');
            $miBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Crea la consulta de inserción
            $sqlInsert ='INSERT INTO Departamento (CodDepartamento,DescDepartamento,VolumenNegocio) values (:codigo,:descripcion,:volumen)';
            //Crea un array con los datos que se van a insertar
            $aParametros = [
                array(
                    "GGG",
                    "Departamento de jejes",
                    "30"
                    ),
                array(
                    "ABC",
                    "Departamento de letras",
                    "50"
                    )
                ];
            $consultaInsert = $miBD->prepare($sqlInsert);
            
            $miBD->beginTransaction();
            //Bucle que recorre el array y otorga los valores
            foreach ($aParametros as $departamentos => $valor) {
                $consultaInsert->bindParam(':codigo', $valor[0]); // Ejecutamos el primer valor del array
                $consultaInsert->bindParam(':descripcion', $valor[1]); // Ejecutamos el tercer valor del array
                $consultaInsert->bindParam(':volumen', $valor[2]); // Ejecutamos el cuarto valor del array
                $consultaInsert->execute();
            }
            
            //Realiza el commit
            $miBD->commit();
            
            //Query para mostrar todos los registros de la tabla Departamentos
            $consultaSelect = $miBD->prepare('SELECT * FROM Departamento'); 
            $consultaSelect->execute();
            
            //Mensaje que se mostrará si no ha ocurrido ningún error
            echo "<h3 style='color: green'>Se han añadido correctamente los departamentos</h3>" . "<br>";
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
                            echo "<td>$registro->VolumenNegocio</td>";                        
                            
                    }?>
                    </tr>
                </tbody>
            </table>
            <?php
        } catch (PDOException $mensajeError) { 
            echo "<h3>Mensaje de ERROR</h3>";
            //Mensaje de salida
            echo "Error: " . $mensajeError->getMessage() . "<br>";
            //Código del error
            echo "Código de error: " . $mensajeError->getCode();
        } finally {
            //Cerramos la conexion
            unset($miBD);
        }
        ?>
    </body>
</html>