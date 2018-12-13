
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

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
  
<!-- parte de cadastro -->


<?php

$nome = $_POST['nome'];
  $atividade = $_POST['atividade'];
  $local = $_POST['local'];
  $data_evento = $_POST['data_evento'];
  $coordenada = "-50.337571,-27.805085";
  //Criar a conexao
  $where =  $atividade;
  $bdcon = pg_connect("dbname=pareador");
//conecta a um banco de dados chamado "pareador"

  $con_string = "host=localhost port=5432 dbname=pareador user=postgres password=postgres";
  if(!$dbcon = pg_connect($con_string)) die ("Erro ao conectar ao banco<br>".pg_last_error($dbcon));
  $query = "INSERT INTO eventos (nome,atividade, local, data_evento) VALUES ('$nome','$atividade',ST_SetSRID(st_makepoint($local),4326), '$data_evento')";
  $insert = pg_query($dbcon, $query);
  $localString = str_replace(',',' ', $local);
  
 
//voltar
//  $var = "<script>javascript:history.back(-2)</script>";
//    echo $var;


// header('Location: resultado.php?atividade='.$where); 
?>




<!-- parte de resultados -->

                 <?php

$bdcon = pg_connect("dbname=pareador");
//conecta a um banco de dados chamado "pareador"

$con_string = "host=localhost port=5432 dbname=pareador user=postgres password=postgres";
if(!$dbcon = pg_connect($con_string)) die ("Erro ao conectar ao banco<br>".pg_last_error($dbcon));
//coneta a um banco de dados chamado "cliente" na máquina "localhost" com um usuário e senha
$recebido = $atividade; //pega a variavel por get
// $result = pg_query($dbcon, "SELECT * FROM eventos WHERE atividade = '$recebido'");
// $result = pg_query($dbcon, "SELECT * from eventos WHERE ST_Distance(ST_Transform(eventos.local,900913),ST_Transform(ST_SetSRID(ST_GeometryFromText('POINT('$cordenada')'),4326),900913)) < 5000 AND eventos.atividade = '$recebido'");
$result = pg_query($dbcon, "SELECT * from eventos WHERE ST_Distance(ST_Transform(eventos.local,900913),ST_Transform(ST_SetSRID(ST_GeometryFromText('POINT(-50.322416 -27.810209)'),4326),900913)) < 5000 AND eventos.atividade = '$recebido'");
$resultCoredenadas = pg_query($dbcon, "SELECT ST_X(local),ST_Y(local) from eventos WHERE ST_Distance(ST_Transform(eventos.local,900913),ST_Transform(ST_SetSRID(ST_GeometryFromText('POINT($localString)'),4326),900913)) < 5000 AND eventos.atividade = '$recebido'");

if (!$result) {
  echo "pau  $result";
  echo "Erro na consulta.<br>";
  exit;
}
?>

<?php

while ($row = pg_fetch_row($resultCoredenadas)) {

  // $dadosCordenadas[] = ["local"=> sprintf("%.8",$row[1]).sprintf("%.8",$row[0])];
  $dadosCordenadas[] = ["long"=> $row[0], "lat"=> $row[1]];
}
//var_dump($dadosCordenadas);


 foreach ($dadosCordenadas as $chave) { 
       $variavel[]=$chave['long'].",".$chave['lat'];
      }
      // var_dump($variavel);
while ($row = pg_fetch_row($result)) {

  $dadosRet[] = ["nome"=> $row[0],
  "atividade"=> $row[1],
  "local"=> $row[2]];
 
}
$arrayDados = implode("|", $variavel);
// var_dump($dadosRet);
?>









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
        //variavel

        var iconStyle = new ol.style.Style({
  image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
    anchor: [0.5, 46],
    anchorXUnits: 'fraction',
    anchorYUnits: 'pixels',
    opacity: 0.75,
    src: 'data/icon.png'
  }))
});
var centro = "<?php echo $local;?>";
        var centroLonLat = centro.split(",");
        var centroLon = parseFloat(centroLonLat[0]);
        var centroLat = parseFloat(centroLonLat[1]);
var vectorSource = new ol.source.Vector({});
        var map = new ol.Map({
          target: "map",
          layers: [
            new ol.layer.Tile({
              source: new ol.source.OSM()
            }),
            new ol.layer.Vector({
              source: vectorSource,
              style: iconStyle
            })
          ],
          view: new ol.View({
             center: ol.proj.fromLonLat([centroLon,centroLat]),

            zoom: 14
          })
        });
        
     var vetorLocaisString = "<?php echo $arrayDados;?>";
     var vetorLocais = vetorLocaisString.split("|");
function dados(item){
  var t = item.split(",");
  var lat = parseFloat(t[0]);
  var lon = parseFloat(t[1]);
  vectorSource.addFeature(new ol.Feature({
    name:"q",
    geometry: new ol.geom.Point(new ol.proj.transform([lat,lon], 'EPSG:4326', 'EPSG:3857'))
  }));
}
 vetorLocais.forEach(dados);
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
            <span class="sr-only">navegação </span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html">Home </a>
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
                    <p id="gg">Clique no botão para receber sua localização em Latitude e Longitude:</p>
                          <button class="btn btn-default" onclick="getLocation()">Localização</button>
                          <script>
                          var x=document.getElementById("gg");
                          function getLocation()
                            {
                            if (navigator.geolocation)
                              {
                              navigator.geolocation.getCurrentPosition(showPosition);
                              }
                            else{x.innerHTML="O seu navegador não suporta Geolocalização.";}
                            }
                          function showPosition(position)
                            {
                          var preenche = document.getElementById('inputlocal');
                          preenche.value= position.coords.longitude +
                            ","+ position.coords.latitude;
                          
                            x.innerHTML="Latitude: " + position.coords.latitude +
                            "<br>Longitude: " + position.coords.longitude; 
                            }
                          </script>
                    <form class="form-horizontal" method="POST" action="resultado.php">
                        <div class="form-group">
                          
                            <div class="container-fluid">
                            <div class="input-group mb-3">




                              
                          <input class="form-control" type="text" name="atividade"  placeholder="Escolha sua atividade" readonly>
                          <input class="form-control" type="text" name="nome" placeholder="Nome">
                          <input class="form-control" id="inputlocal" type="text" name="local" placeholder="Local">

                          


                          <input class="form-control" type="date" name="data_evento" placeholder="Data">
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
            <?php

  

while ($row = pg_fetch_row($result)) {

  $dadosRet[] = ["nome"=> $row[0],
  "atividade"=> $row[1],
  "local"=> $row[2]];

}

//var_dump($dadosRet);
?>
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

<!--***************************************                        -->

<div class="container-fluid">

  <ul class="list-group">
    <li class="list-group-item">
    

  <div class="mygrid-wrapper-div" style="overflow-y: scroll; height:200px; width: auto;">

  <table class="table">
  <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Evento</th>
                        <th>Geo</th>
                    </tr>
</thead>
<tbody>
                    <?php foreach ($dadosRet as $chave) { ?>
                      
                    <tr>
                        <td><?=$chave['nome']?></td>
                        <td><?=$chave['atividade']?></td>
                        <td><?=$chave['local']?></td>
                    </tr>
                    </tbody>
                    <?php } ?>                      
                </table>
                    </div>

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