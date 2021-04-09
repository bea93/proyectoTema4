<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Bea Merino Macía">
        <meta name="application-name" content="Sitio web">

        <title>Bea Merino Macía</title>
    </head>
	
	<body>
            <h2>Creación de la tabla</h2>
            <?php
                highlight_file("../scriptDB/CreaDAW213DBDepartamentos.sql");
            ?>
            <h2>Programa PHP que ejecuta el script de creación de la tabla</h2>
            <?php
                highlight_file("../scriptDB/crear.php");
            ?>
            
            <h2>Carga inicial en la tabla</h2>
            <?php
                    highlight_file("../scriptDB/CargaInicialDAW213DBDepartamentos.sql");
            ?>
            <h2>Programa PHP que ejecuta el script de carga en la tabla</h2>
            <?php
                highlight_file("../scriptDB/cargar.php");
            ?>
            
            <h2>Eliminación de la tabla</h2>
            <?php
                    highlight_file("../scriptDB/BorraDAW213DBDepartamentos.sql");
            ?>
	</body>
</html>