<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 8</title>
        <meta charset="UTF-8">
        <meta name="author" content="Bea Merino">
    </head>
    <body>
        <?php
        /**
         * @author Bea Merino
         * @since 29/10/2020
         * Página web que toma datos (código y descripción) de la tabla Departamento y guarda en un fichero departamento.xml. (COPIA DE SEGURIDAD / EXPORTAR)
         */
        
        //Fichero de configuración de la BBDD
        require_once '../config/confDB.php';
        
        try{
            //Objeto PDO con los datos de conexión
            $miBD = new PDO(HOST,USER,PASS);
            $miBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $excepcion){
            die("No se pudo establecer la conexión a la base de datos");
        }
        try{
            //Mete el query en una variable
            $resultado = $miBD->query("SELECT * FROM Departamento;");
            //Fichero en el que añadirá los valores del query
            $ficheroXML = new DOMDocument("1.0", "utf-8");
            //Hace que salga espaciado y tabulado
            $ficheroXML->formatOutput =true;
            //Crea la rama hijos de departamentos
            $raiz = $ficheroXML->appendChild($ficheroXML->createElement("Departamentos"));
            
            //Bucle que otorga los valores
            while($oDepartamento = $resultado->fetchObject()){
                $departamento = $raiz->appendChild($ficheroXML->createElement("Departamento"));
                $departamento->appendChild($ficheroXML->createElement("CodDepartamento", $oDepartamento->CodDepartamento));
                $departamento->appendChild($ficheroXML->createElement("DescDepartamento", $oDepartamento->DescDepartamento));
            }
            //Crea un documento XML desde la representación DOM. 
            $ficheroXML->saveXML();
            //Establece la ruta en la que se guardará el archivo
            $ficheroXML->save("../tmp/DBXML.xml");
                
            //Mensaje que se mostrará si no ha ocurrido ningún error
            echo "<h3 style='color: green'>El archivo se ha exportado correctamente</h3>";
        }catch(PDOException $excepcion){
            echo "<h1 style='color: red'>No se ha podido exportar el archivo</h1>";
            //Mensaje de salida
            echo $excepcion->getMessage();
        }finally{
            //Cerramos la conexión
            unset($miBD);
        }
        ?>
    </body>
</html>