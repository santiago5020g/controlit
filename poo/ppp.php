<?php
// ezSQL
// Zebra Pagination

require_once 'paginacion/Zebra_Pagination.php';

$total_paises = 40;
$resultados   = 2;

$paginacion = new Zebra_Pagination();
$paginacion->records($total_paises);
$paginacion->records_per_page($resultados);
// Quitar ceros en numeros con 1 digito en paginacion
$paginacion->padding(false);

?>
<!DOCTYPE html>
<html lang="es">
        <head>
                <meta charset="utf-8">
                <title>JV Software | Tutorial 13</title>
             
        </head>
        <body>
                <div class="container">
                        <div class="hero-unit">
                                <h1>Tutorial Paginaci&oacute;n en PHP</h1>
                        </div>
                        <div class="page-header">
                                <h2>Lista de pa&iacute;ses</h2>
                        </div>
                        <table class="bordered-table zebra-striped">
                                <thead>
                                        <tr>
                                                <th>ID</th>
                                                <th>Nombre Corto</th>
                                                <th>Nombre Largo</th>
                                                <th>Abreviaci&oacute;n</th>
                                        </tr>
                                </thead>
                                <tbody>
                                        
                                </tbody>
                        </table>

                        <?php $paginacion->render(); ?>

                        <footer>
                                <p>
                                         &copy; JV Software 2012
                                </p>
                        </footer>
                </div>
        </body>
</html>