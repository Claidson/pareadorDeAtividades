
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="/css/ol.css" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" />
    <title>Pareador mapeado tabajara</title>
    <style type="text/css">
      body { overflow: hidden; }

      .navbar-offset { margin-top: 50px; }
      #map { position: absolute; top: 50px; bottom: 0px; left: 0px; right: 0px; }
      #map .ol-zoom { font-size: 1.2em; }

      .zoom-top-opened-sidebar { margin-top: 5px; }
      .zoom-top-collapsed { margin-top: 45px; }

      .mini-submenu{
        display:none;  
        background-color: rgba(255, 255, 255, 0.46);
        border: 1px solid rgba(0, 0, 0, 0.9);
        border-radius: 4px;
        padding: 9px;  
        /*position: relative;*/
        width: 42px;
        text-align: center;
      }

      .mini-submenu-left {
        position: absolute;
        top: 60px;
        left: .5em;
        z-index: 40;
      }

      #map { z-index: 35; }

      .sidebar { z-index: 45; }

      .main-row { position: relative; top: 0; }

      .mini-submenu:hover{
        cursor: pointer;
      }

      .slide-submenu{
        background: rgba(0, 0, 0, 0.45);
        display: inline-block;
        padding: 0 8px;
        border-radius: 4px;
        cursor: pointer;
      }

    </style>
  

   <script type="text/javascript" src=" https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/build/ol.js"></script>-
   <!--<script type="text/javascript" src="js/ol.js"></script>-->
    <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">

      function applyMargins() {
        var leftToggler = $(".mini-submenu-left");
        if (leftToggler.is(":visible")) {
          $("#map .ol-zoom")
            .css("margin-left", 0)
            .removeClass("zoom-top-opened-sidebar")
            .addClass("zoom-top-collapsed");
        } else {
          $("#map .ol-zoom")
            .css("margin-left", $(".sidebar-left").width())
            .removeClass("zoom-top-opened-sidebar")
            .removeClass("zoom-top-collapsed");
        }
      }

      function isConstrained() {
        return $(".sidebar").width() == $(window).width();
      }

      function applyInitialUIState() {
        if (isConstrained()) {
          $(".sidebar-left .sidebar-body").fadeOut('slide');
          $('.mini-submenu-left').fadeIn();
        }
      }

      $(function(){
        $('.sidebar-left .slide-submenu').on('click',function() {
          var thisEl = $(this);
          thisEl.closest('.sidebar-body').fadeOut('slide',function(){
            $('.mini-submenu-left').fadeIn();
            applyMargins();
          });
        });

        $('.mini-submenu-left').on('click',function() {
          var thisEl = $(this);
          $('.sidebar-left .sidebar-body').toggle('slide');
          thisEl.hide();
          applyMargins();
        });

        $(window).on("resize", applyMargins);

        var map = new ol.Map({
          target: "map",
          layers: [
            new ol.layer.Tile({
              source: new ol.source.OSM()
            })
          ],
          view: new ol.View({
             center: ol.proj.fromLonLat([-50.322416,-27.810209]),
            //center: [-100222.295949,-180074.3989],
            zoom: 16
          })
        });
        applyInitialUIState();
        applyMargins();
      });
    </script>
  </head>
  <body>
    <div class="container">
      <nav class="navbar navbar-fixed-top navbar-default" role="navigation">
        <div class="container-fluid">
          <!-- togle menu app -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Tnavegação </span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Mapa </a>
          </div>
          <!-- menu drop  -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">menu drop <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Alguma opção</a></li>
                  <li><a href="#">Alguma opção</a></li>
                  <li><a href="#">Alguma opção</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Alguma outra opção</a></li>
                  <li class="divider"></li>
                  <li><a href="#">mais uma</a></li>
                </ul>
              </li>
            </ul>
            <form class="navbar-form navbar-left" role="search">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="buscar">
              </div>
              <button type="submit" class="btn btn-default">Enviar</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="#">Link</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu drop <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Alguma opção</a></li>
                  <li><a href="#">Alguma opção</a></li>
                  <li><a href="#">Alguma opção</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Alguma opção</a></li>
                </ul>
              </li>
            </ul>
            </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
          </nav>
        </div>
      </nav>
      <div class="navbar-offset"></div>
      <div id="map">
      </div>
      <div class="row main-row">
        <div class="col-sm-4 col-md-3 sidebar sidebar-left pull-left">
          <div class="panel-group sidebar-body" id="accordion-left">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#layers">
                    <i class="fa fa-list-alt"></i>
                    Clique no ponto do mapa desejado encontramos parceiros para o que você quer fazer agora
                  </a>
                  <span class="pull-right slide-submenu">
                    <i class="fa fa-chevron-left"></i>
                  </span>
                </h4>
              </div>
              <div id="layers" class="panel-collapse collapse in">
                <div class="panel-body list-group">
                  
                    <form class="form-horizontal" method="POST" action="cadastrar.php">
                        <div class="form-group">
                          
                            <div class="container-fluid">
                            <div class="input-group mb-3">
                          <input class="form-control" type="text" name="atividade"  placeholder="Escolha sua atividade" readonly>
                          <input class="form-control" type="text" name="nome" placeholder="Nome">
                          <input class="form-control" type="text" name="local" placeholder="Local">
                          <input class="form-control" type="datetime" name="data_evento" placeholder="Data">
                          <label class="radio-inline"> 
                            <input type="radio" name="atividade" value="Truco"><span class="label label-success">Truco</span> 
                          </label> 
                            
                          <label class="radio-inline"> 
                            <input type="radio" name="atividade" value="Cerveja"><span class="label label-warning">Cerveja</span> 
                          </label> 
                          
                          <label class="radio-inline"> 
                            <input type="radio" name="atividade" value="Duelo Mortal"><span class="label label-danger">Duelo Mortal</span> 
                          </label> 
                        </div>
</div>



                        </div>
                        <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-danger">Buscar matchs</button>
                          </div>
                        </div>
                      </form>


                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#properties">
                    <i class="fa fa-list-alt"></i>
                    Resultados
                  </a>
                </h4>
              </div>
              <div id="properties" class="panel-collapse collapse in">
                <div class="panel-body">


                 <?php

$bdcon = pg_connect("dbname=pareador");
//conecta a um banco de dados chamado "pareador"

$con_string = "host=localhost port=5432 dbname=pareador user=postgres password=postgres";
if(!$dbcon = pg_connect($con_string)) die ("Erro ao conectar ao banco<br>".pg_last_error($dbcon));
//coneta a um banco de dados chamado "cliente" na máquina "localhost" com um usuário e senha

$result = pg_query($dbcon, "SELECT * FROM eventos");

if (!$result) {
  echo "Erro na consulta.<br>";
  exit;
}
?>

<div class="container-fluid">

  <ul class="list-group">
    <li class="list-group-item">
    
<?php
$amiguinhos = array();
while ($row = pg_fetch_array($result)) {
  // echo "Nome $row[0]  Atividade: $row[1] ";
  // echo "<br />\n";
  // $amiguinhos[] =  $row;
  $dadosRet[] = array("nome"=> $row['nome'],
  "atividade"=> $row['atividade'],
  "local"=> $row['local'],);
}

?>

<table border='1px'>
                    <tr>
                        <td>Nome</td>
                        <td>Evento</td>
                        <td>Geo</td>
                    </tr>
                    
                    <?php foreach ($array as $key) { ?>
                    <tr>
                        <td><?=$key['nome']?></td>
                        <td><?=$key['atividade']?></td>
                        <td><?=$key['local']?></td>
                    </tr>
                    <?php } ?>                      
                </table>


</li>
</ul></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="mini-submenu mini-submenu-left pull-left">
        <i class="fa fa-list-alt"></i>
      </div>
    </div>
  </body>
</html>