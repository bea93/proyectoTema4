<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 1_2</title>
    </head>
    <body>
        <?php
        /**
          @author: Bea Merino Macía
          @since: 07/04/2021
          @description: Conexión a la base de datos con la cuenta usuario y tratamiento de errores. mysqli
         */
        echo "<h1>Conexión correcta</h1><br>";
        
        //Crea la conexión a la BBDD
        $miBD = new mysqli('192.168.20.19:3306', 'usuarioDAW213DBDepartamentos', 'paso', 'DAW213DBDepartamentos');
        
        //Mensaje que se mostrará si la conexión se realiza correctamente
        echo "<h2 style='color: green'>Conexión realizada correctamente</h2>" . "<br>";

        echo "<h2>Atributos de la conexión</h2>";
        echo "Información del servidor: " . $miBD->server_info . "<br>";
        echo "Host de la conexión: " . $miBD->host_info . "<br>";
        
        $miBD->close();
        ?>
    </body>
</html>