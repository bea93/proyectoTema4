<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 04</title>
        <style>
            td, tr{
                padding: 10px;
            }
        </style>
    </head>
    <body>  
        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <fieldset>
                <legend>DAW213DBDepartamentos: </legend>
                <br>
                <div class="obligatorio">
                    Descripción Departamento: 
                    <input type="text" name="DescDepartamento"
                           value="<?php if( isset($_POST['DescDepartamento'])){ echo $_POST['DescDepartamento'];} ?>"><br>              
                </div>
                <br>
                <div>
                    <input type="submit" name="enviar" value="Buscar">
                </div>
            </fieldset>
        </form>
        
        <?php
        /**
          @author: Bea Merino
          @since: 07/04/2021
          @description: Formulario de búsqueda de departamentos por descripción (por una parte del campo
            DescDepartamento, si el usuario no pone nada deben aparecer todos los departamentos).
         */

        //Importa la librería de validación
        require_once '../core/210322ValidacionFormularios.php';
        
        //Fichero de configuración de la BBDD
        require_once '../config/confDB.php';

        //Inicializa una variable que nos ayudará a controlar si todo esta correcto
        $entradaOK = true;
        
        //Inicializa un array que se encargará de recoger los datos del formulario
        $aFormulario = [
            'DescDepartamento' => null,
        ];

        try {
            //Objeto PDO con los datos de conexión
            $miBD = new PDO(HOST,USER,PASS);
            $miBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Código que se ejecuta cuando se envía el formulario
            if (isset($_POST['enviar'])) {
                $aFormulario['DescDepartamento'] = $_POST['DescDepartamento']; 
                
                //Consulta SQL 
                $sentenciaSQL = $miBD->prepare('SELECT * FROM Departamento WHERE DescDepartamento LIKE ("%":descripcion"%")');
                //El método bindParam asigna valores a los parámetros
                $sentenciaSQL->bindParam(":descripcion", $aFormulario['DescDepartamento']);
                //Ejecuta la sentencia
                $sentenciaSQL->execute(); 
                echo "<br>";
                
                //Si no se encuentra ningún dato al ejecutar la consulta
                if ($sentenciaSQL->rowCount() == 0) {
                    echo "No se ha encontrado ningún departamento con esa descripción";
                } else {
                    echo "<table border='0'>";
                    echo "<tr>";
                    echo "<th>Codigo</th>";
                    echo "<th>Descripción</th>";
                    echo "<th>Volumen de Negocio</th>";
                    echo "</tr>";
                    //Al realizar el fetchObject, se pueden sacar los datos de $registro como si fuera un objeto
                    while ($registro = $sentenciaSQL->fetchObject()) { 
                        echo "<tr>";
                        echo "<td>$registro->CodDepartamento</td>";
                        echo "<td>$registro->DescDepartamento</td>";
                        echo "<td>$registro->VolumenNegocio</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            }
                
        //Captura de la excepción
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