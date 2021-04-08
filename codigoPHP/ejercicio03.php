<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 03</title>
        <style>
            td, tr{
                padding: 10px;
            }
            .error{
                color: red;
            }
            .obligatorio{
                background-color: lightgray;
            }
        </style>
    </head>
    <body>  
        <?php
        /**
          @author: Bea Merino
          @since: 07/04/2021
          @description: Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores.
         */
        
        //Importa la librería de validación
        require_once '../core/210322ValidacionFormularios.php';
        
        //Fichero de configuración de la BBDD
        require_once '../config/confDB.php';
       
        //Inicializa una variable que nos ayudará a controlar si todo esta correcto
        $entradaOK = true;
        
        //Inicializa un array que se encargará de recoger los errores(Campos vacíos)
        $aErrores = [
            'CodDepartamento' => null,
            'DescDepartamento' => null,
            'VolumenNegocio' => null
        ];
        
        //Inicializa un array que se encargará de recoger los datos del formulario
        $aFormulario = [
            'CodDepartamento' => null,
            'DescDepartamento' => null,
            'VolumenNegocio' => null
        ];
        //Código que se ejecuta cuando se envía el formulario
        if (isset($_POST['enviar']) && $_POST['enviar'] == 'Enviar') { 
            //La posición del array de errores recibe el mensaje de error si hubiera
            //Los números indican los valores máximo, mínimo y la opcionalidad del campo
            $aErrores['CodDepartamento'] = validacionFormularios::comprobarAlfabetico($_POST['CodDepartamento'], 3, 3, 1); 
            $aErrores['DescDepartamento'] = validacionFormularios::comprobarAlfabetico($_POST['DescDepartamento'], 255, 1, 1);
            $aErrores['VolumenNegocio'] = validacionFormularios::comprobarFloat($_POST['VolumenNegocio'], 999999, 1, 1);
            
            try{
                //Objeto PDO con los datos de conexión
                $miBD = new PDO(HOST,USER,PASS);
                $miBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                //Consulta SQL
                $sentenciaSQL2 = "SELECT CodDepartamento FROM Departamento WHERE CodDepartamento='{$_POST['CodDepartamento']}'";
                $consultaSelect = $miBD->prepare($sentenciaSQL2);
                $consultaSelect->execute();
                //Si la consulta devuelve algún valor es porque el código está duplicado, da error
                if($consultaSelect->rowCount()>0){
                    $aErrores['CodDepartamento']= "El código de Departamento introducido ya existe";

                }
                
            } catch (PDOException $mensajeError){
                //Mensaje de salida
                echo "Error " . $mensajeError->getMessage() . "<br>"; 
                //Código del error
                echo "Codigo del error " . $mensajeError->getCode() . "<br>"; 
            } finally {
                //Cerramos la conexión
                unset($miBD);
            }
            
            //Recorre el array en busca de mensajes de error
            foreach ($aErrores as $campo => $error) { 
                //Si hay errores
                if ($error != null) { 
                    //Cambia la condición de la variable
                    $entradaOK = false; 
                }else{
                    //Si el campo se ha rellenado
                    if(isset($_POST[$campo])){
                        $aFormulario[$campo] = $_POST[$campo];
                    }
                } 
            }
        } else {
            //Cambia el valor de la variable
            $entradaOK = false;
        }
        //Si el valor es true es que no hay errores, muestra los datos recogidos
        if ($entradaOK) {
            //Guarda los datos en el array del formulario
            //El método strtoupper pone el string en mayúsculas, ucfirst pone la primera letra en mayúscula
            $aFormulario['CodDepartamento'] = strtoupper($_POST['CodDepartamento']);
            $aFormulario['DescDepartamento'] = $_POST['DescDepartamento'];
            $aFormulario['VolumenNegocio'] = $_POST['VolumenNegocio'];
            
        try {
            //Objeto PDO con los datos de conexión
            $miBD = new PDO(HOST,USER,PASS);
            //$miBD = new PDO('mysql:host=192.168.20.19:3306;dbname=DAW213DBDepartamentos', 'usuarioDAW213DBDepartamentos', 'paso');
            $miBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Consulta SQL para insertar el departamento nuevo
            $sentenciaSQL = $miBD->prepare("INSERT INTO Departamento (CodDepartamento,DescDepartamento, VolumenNegocio) VALUES (:codigo, :descripcion, :volumen);");
            //El método bindParam asigna valores a los parámetros
            $sentenciaSQL->bindParam(":codigo", $aFormulario['CodDepartamento']);
            $sentenciaSQL->bindParam(":descripcion", $aFormulario['DescDepartamento']);
            $sentenciaSQL->bindParam(":volumen", $aFormulario['VolumenNegocio']);
            $sentenciaSQL->execute();
            //Consulta sql para mostrar  los departamentos
            $selectSQL = $miBD->prepare("SELECT * FROM Departamento");
            //Ejecuta la consulta
            $selectSQL->execute();
            
            //Muestra el resultado
            echo "Número de registros en la tabla Departamento: " . $selectSQL->rowCount();
            echo "<br><br>";

            //Crea una tabla para introducir los datos que hay en la BBDD
            echo "<table border='0'>";
            echo "<tr>";
                echo "<th>Codigo</th>";
                echo "<th>Descripción</th>";
                echo "<th>VolumenNegocio</th>";
            echo "</tr>";
            //Al realizar el fetchObject, se pueden sacar los datos de $registro como si fuera un objeto
            while ($registro = $selectSQL->fetchObject()) { 
                echo "<tr>";
                echo "<td>$registro->CodDepartamento</td>";
                echo "<td>$registro->DescDepartamento</td>";
                echo "<td>$registro->VolumenNegocio</td>";
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
        //Muestra el formulario hasta que se rellene correctamente
        } else {
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <fieldset>
                    <legend>Creación de departamentos</legend>
                    <br>
                    <div>
                        <label for="codigo">Código Departamento:</label>
                        <input type="text" name="CodDepartamento" id="codigo" placeholder="EN MAYÚSCULAS" class="obligatorio"
                               value="<?php if($aErrores['CodDepartamento'] == NULL && isset($_POST['CodDepartamento'])){ echo $_POST['CodDepartamento'];} ?>"><br> <!--//Si el valor es bueno, lo escribe en el campo-->
                        <?php if ($aErrores['CodDepartamento'] != NULL) { ?>
                        <div class="error">
                            <?php echo $aErrores['CodDepartamento'];?>
                        </div>   
                    <?php } ?>                
                    </div>
                    <br>
                    <div>
                        <label for="descripcion">Descripción Departamento: </label>
                        <input type="text" name="DescDepartamento" id="descripcion" class="obligatorio"
                               value="<?php if($aErrores['DescDepartamento'] == NULL && isset($_POST['DescDepartamento'])){ echo $_POST['DescDepartamento'];} ?>"><br> <!--//Si el valor es bueno, lo escribe en el campo-->
                        <?php if ($aErrores['DescDepartamento'] != NULL) { ?>
                        <div class="error">
                            <?php echo $aErrores['DescDepartamento'];?>
                        </div>   
                    <?php } ?>                
                    </div>
                    <br>
                    <div>
                        <label for="volumen">Volumen negocio: </label>
                        <input type="text" name="VolumenNegocio"id="volumen" class="obligatorio"
                               value="<?php if($aErrores['VolumenNegocio'] == NULL && isset($_POST['VolumenNegocio'])){ echo $_POST['VolumenNegocio'];} ?>"><br> <!--//Si el valor es bueno, lo escribe en el campo-->
                        <?php if ($aErrores['VolumenNegocio'] != NULL) { ?>
                        <div class="error">
                            <?php echo $aErrores['VolumenNegocio'];?>
                        </div>   
                    <?php } ?>                
                    </div>
                    <br>
                    <div>
                        <input type="submit" name="enviar" value="Enviar">
                    </div>
                </fieldset>
            </form>
        <?php } ?>   
    </body>
</html>