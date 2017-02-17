<div id="cuerpo">
  <?php

  require("solicitudes.php");
  require "PDO_Pagination.php";
  $sql_solicitudes = "";

  $pagination = new PDO_Pagination();
  $obj_solicitudes=new solicitudes();
  $solicitudes_num=array('60' => 0,0);
  //echo $solicitudes_num[0][0];

  $pagination->rowCount($solicitudes_num);
  $pagination->config(10, 20);

  $pagination->btn_first_page = 'Primera';
  $pagination->btn_last_page = 'Ultima';
  $pagination->btn_next_page = 'Siguiente';
  $pagination->btn_back_page = 'Atras';
  $pagination->btn_page = 'Pag.';
  $pagination->btn_active = 'active';

  ?>


  <html>
  <head>
    <meta http-equiv="Content-type" content="text/htal; charset=UTF-8">
    <title>prueba</title>
  </head>
  <body>



   
          <br>
          <br>
          <style>
          /* CSS */
          .btn
          {
            text-decoration: none;
            color: #FFFFFF;
            padding-left: 10px;
            padding-right: 10px;
            margin-left: 1px;
            margin-right: 1px;
            border-radius: 3px;
            background: #7F83AD;
          }

          .btn:hover
          {
            background: #474C80;
          }
          .active
          {
            background: #E7814A;
          }
          /* CSS */
          </style>






          <?php
          $pagination->pages("btn");
          ?>

        </body>
        </html>

      </div>

