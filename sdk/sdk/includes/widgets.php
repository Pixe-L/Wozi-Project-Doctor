<?php
// CARRO DE COMPRA       
  //unset($_SESSION['carro']);
  if (isset($_POST['emptycart'])) {
    unset($_SESSION['carro']);
  }

  if(isset($_SESSION['carro'])){
    $arreglo=$_SESSION['carro'];
  }

  // Remover artículos del carro
  if (isset($_POST['removefromcart'])) {
    $id=$_POST['id'];
    $arregloAux=$_SESSION['carro'];
    unset($arreglo);
    $num=0;
    foreach ($arregloAux as $key => $value) {
      if ($id!=$value['Id']) {
        $arreglo[]=array('Id'=>$arregloAux[$num]['Id'],'Cantidad'=>$arregloAux[$num]['Cantidad']);
      }
      $num++;
    }
    $_SESSION['carro']=$arreglo;
  }

  // Agregar artículos al carro
  if (isset($_POST['addtocart'])) {
    if (isset($_POST['cantidad']) and $_POST['cantidad']!==0 and $_POST['cantidad']!=='') {
      $id=$_POST['id'];

      $carroTotalProds+=$_POST['cantidad'];
      $arregloNuevo[]=array('Id'=>$id,'Cantidad'=>$_POST['cantidad']);

      if (!isset($arreglo)) {
        $arreglo=$arregloNuevo;
      }else{
        $arregloAux=$arreglo;
        unset($arreglo);
        $num=0;
        foreach ($arregloAux as $key => $value) {
          if ($id!=$arregloAux[$num]['Id']) {
            $arreglo[]=array('Id'=>$arregloAux[$num]['Id'],'Cantidad'=>$arregloAux[$num]['Cantidad']);
          }else{
            $carroTotalProds-=$arregloAux[$num]['Cantidad'];
          }
          $num++;
        }
        if ($_POST['cantidad']>0) {
          $arreglo[]=array('Id'=>$id,'Cantidad'=>$_POST['cantidad']);
        }
      }
      
      echo '{ "msj":"<div class=\'uk-text-center color-blanco bg-success padding-10 text-lg\'><i class=\'fa fa-check\'></i> &nbsp; Agregado al pedido</div>", "count":'.$carroTotalProds.' }';

      $_SESSION['carro']=$arreglo;
    }
  }

  if (isset($_POST['actualizarcarro'])) {
    $arregloAux=$_SESSION['carro'];
    unset($arreglo);
    $carroTotalProds=0;
    $num=0;
    foreach ($arregloAux as $key => $value) {
      if ($_POST['cantidad'.$num]>0) {
        $arreglo[]=array('Id'=>$arregloAux[$num]['Id'],'Cantidad'=>$_POST['cantidad'.$num]);
        $carroTotalProds+=$_POST['cantidad'.$num];
      }
      $num++;
    }
    $_SESSION['carro']=$arreglo;
  }

  // Si ya hay productos en el carro
  $carroTotalProds=0;
  if(isset($arreglo)){
    foreach ($arreglo as $key => $value) {
      $carroTotalProds+=$value['Cantidad'];
    }
  }

// LIMITAR PALABRAS      
  function wordlimit($string, $length , $ellipsis)
  {
    $words = explode(' ', strip_tags($string));
    if (count($words) > $length)
    {
      return implode(' ', array_slice($words, 0, $length)) ." ". $ellipsis;
    }
    else
    {
      return $string;
    }
  }

// FECHA                 
  // FECHA CORTA
    function fechaCorta($fechaSQL){
      $fechaSegundos=strtotime($fechaSQL);
      $fechaY=date('Y',$fechaSegundos);
      $fechaM=date('m',$fechaSegundos);
      $fechaD=date('d',$fechaSegundos);
      $fechaDay=strtolower(date('D',$fechaSegundos));

      return $fechaD.'-'.$fechaM.'-'.$fechaY;
    }
    
  // FECHA Y HORA
    function fechaHora($fechaSQL){
      $fechaSegundos=strtotime($fechaSQL);
      $fechaY=date('Y',$fechaSegundos);
      $fechaM=date('m',$fechaSegundos);
      $fechaD=date('d',$fechaSegundos);
      $fechaH=date('H',$fechaSegundos);
      $fechaI=date('i',$fechaSegundos);
      $fechaDay=strtolower(date('D',$fechaSegundos));

      return $fechaD.'-'.$fechaM.'-'.$fechaY.'<br>'.$fechaH.':'.$fechaI;
    }
    
  // SOLO HORA
    function soloHora($fechaSQL){
      $fechaSegundos=strtotime($fechaSQL);
      $fechaH=date('H',$fechaSegundos);
      $fechaI=date('i',$fechaSegundos);

      return $fechaH.':'.$fechaI;
    }

  function fechaSQL($fechaSQL){
    $fechaSegundos=strtotime($fechaSQL);

    $fechaY=date('Y',$fechaSegundos);
    $fechaM=date('m',$fechaSegundos);
    $fechaD=date('d',$fechaSegundos);
   
    return $fechaY.'/'.$fechaM.'/'.$fechaD;
  }
  
  // FECHA DIA
    function fechaDisplayDia($fechaSQL){
      $fechaSegundos=strtotime($fechaSQL);
      $fechaY=date('Y',$fechaSegundos);
      $fechaM=date('m',$fechaSegundos);
      $fechaD=date('d',$fechaSegundos);
      $fechaDay=strtolower(date('D',$fechaSegundos));

      switch ($fechaDay) {
        case 'mon':
        $fechaDia='Lunes';
        break;
        case 'tue':
        $fechaDia='Martes';
        break;
        case 'wed':
        $fechaDia='Miércoles';
        break;
        case 'thu':
        $fechaDia='Jueves';
        break;
        case 'fri':
        $fechaDia='Viernes';
        break;
        case 'sat':
        $fechaDia='Sábado';
        break;
        default:
        $fechaDia='Domingo';
        break;
      }
      return $fechaDia;
    }

  // FECHA MES
    function fechaDisplayMes($fechaSQL){
      $fechaSegundos=strtotime($fechaSQL);
      $fechaY=date('Y',$fechaSegundos);
      $fechaM=date('m',$fechaSegundos);
      $fechaD=date('d',$fechaSegundos);
      $fechaDay=strtolower(date('D',$fechaSegundos));

      switch ($fechaM) {
        case 1:
        $mes='enero';
        break;
        
        case 2:
        $mes='febrero';
        break;
        
        case 3:
        $mes='marzo';
        break;
        
        case 4:
        $mes='abril';
        break;
        
        case 5:
        $mes='mayo';
        break;
        
        case 6:
        $mes='junio';
        break;
        
        case 7:
        $mes='julio';
        break;
        
        case 8:
        $mes='agosto';
        break;
        
        case 9:
        $mes='septiembre';
        break;
        
        case 10:
        $mes='octubre';
        break;
        
        case 11:
        $mes='noviembre';
        break;
        
        default:
        $mes='diciembre';
        break;
      }

      return $mes;
    }

  // FECHA LARGA
    function fechaDisplay($fechaSQL){
      $fechaSegundos=strtotime($fechaSQL);
      $fechaY=date('Y',$fechaSegundos);
      $fechaM=date('m',$fechaSegundos);
      $fechaD=date('d',$fechaSegundos);
      $fechaDay=strtolower(date('D',$fechaSegundos));

      switch ($fechaM) {
        case 1:
        $mes='enero';
        break;
        
        case 2:
        $mes='febrero';
        break;
        
        case 3:
        $mes='marzo';
        break;
        
        case 4:
        $mes='abril';
        break;
        
        case 5:
        $mes='mayo';
        break;
        
        case 6:
        $mes='junio';
        break;
        
        case 7:
        $mes='julio';
        break;
        
        case 8:
        $mes='agosto';
        break;
        
        case 9:
        $mes='septiembre';
        break;
        
        case 10:
        $mes='octubre';
        break;
        
        case 11:
        $mes='noviembre';
        break;
        
        default:
        $mes='diciembre';
        break;
      }

      switch ($fechaDay) {
        case 'mon':
        $fechaDia='Lunes';
        break;
        case 'tue':
        $fechaDia='Martes';
        break;
        case 'wed':
        $fechaDia='Miércoles';
        break;
        case 'thu':
        $fechaDia='Jueves';
        break;
        case 'fri':
        $fechaDia='Viernes';
        break;
        case 'sat':
        $fechaDia='Sábado';
        break;
        default:
        $fechaDia='Domingo';
        break;
      }

      return $fechaDia.' '.$fechaD.' de '.$mes.' de '.$fechaY;
    }

// DEPURAR VARIABLES     
  function debug ( $var, $html = true, $backtrace = null ) {

    $id = uniqid ( );

    if ( is_null ( $backtrace ) )
      $backtrace = debug_backtrace ( );

    $debug = "<div id='$id'>" . "<code class=''>" . "<strong>FILE: " . $backtrace [ 0 ] [ 'file' ] . "</strong>" . "<BR />" . PHP_EOL . "<strong>LINE: " . $backtrace [ 0 ] [ 'line' ] . "</strong>" . "<BR />" . PHP_EOL . "<pre>";

    ob_start ( );
    print_r ( $var );
    $dump = ob_get_clean ( );
    $debug .= htmlentities ( $dump );
    $debug .= "</pre>" . "</code>" . "</div>";

    if ( !$html )
      $debug = strip_tags ( $debug );

    echo $debug;
  }

  function breakpoint ( $var, $show_source = false ) {
    $break = debug_backtrace ( );
    debug ( $var, true, $break );
    /*if ( isset ( $this ) )
      unset ( $this );*/
    if($show_source)
      show_source ( $break [ 0 ] [ 'file' ] );
    die ( 'Fin del Brakepoint: ' . date('Y-m-d H:i:s'));

  }

// CARRUSEL              
  // Carousel Inicio
    function carousel($carousel){
      global $CONEXION;
      global $dominio;

      $CONSULTA= $CONEXION -> query("SELECT * FROM configuracion WHERE id = 1");
      $row_CONSULTA = $CONSULTA -> fetch_assoc();
      switch ($row_CONSULTA['slideranim']) {
        case 0:
          $animation='fade';
          break;
        case 1:
          $animation='slide';
          break;
        case 2:
          $animation='scale';
          break;
        case 3:
          $animation='pull';
          break;
        case 4:
          $animation='push';
          break;
        default:
          $animation='fade';
          break;
      }
      $CAROUSEL = $CONEXION -> query("SELECT * FROM $carousel ORDER BY orden");
      $numPics=$CAROUSEL->num_rows;
      if ($numPics>0) {
        echo '
            <!-- Start Carousel -->
            <div uk-slideshow="autoplay:true;ratio:'.$row_CONSULTA['sliderproporcion'].';animation:'.$animation.';min-height:'.$row_CONSULTA['sliderhmin'].';max-height:'.$row_CONSULTA['sliderhmax'].';" class="uk-grid-collapse" uk-grid>
              <div class="uk-visible-toggle uk-width-1-1 uk-flex-first">
                <div class="uk-position-relative">
                  <ul class="uk-slideshow-items">';
                    $num=0;
                    while ($row_CAROUSEL = $CAROUSEL -> fetch_assoc()) {
                      if (strlen($row_CAROUSEL['video'])>0) {
                        $videoUrl=$row_CAROUSEL['video'];
                        $videoPic=$videoUrl;
                        if (strpos($videoPic, 'youtube')) {
                          $pos=strpos($videoPic, 'v');
                          $videoPic=substr($videoPic, ($pos+2));
                        }elseif (strpos($videoPic, 'youtu.be')) {
                          $pos=strrpos($videoPic, '/');
                          $videoPic=substr($videoPic, ($pos+1));
                        }
                        echo '
                          <li>
                          <iframe src="https://www.youtube-nocookie.com/embed/'.$videoPic.'?autoplay=0&amp;showinfo=0&amp;rel=0&amp;modestbranding=1&amp;playsinline=1" frameborder="0" allowfullscreen uk-video="automute: true" uk-cover></iframe>
                          </li>';
                      }else{
                        $caption='';
                        if (strlen($row_CAROUSEL['url'])>0) {
                          $pos=strpos($row_CAROUSEL['url'], $dominio);
                          $target=($pos>0)?'':'target="_blank"';
                          if ($row_CONSULTA['slidertextos']==1 AND strlen($row_CAROUSEL['titulo'])>0 AND strlen($row_CAROUSEL['url'])>0) {
                            $caption='
                            <div class="uk-position-bottom uk-transition-slide-bottom">
                              <div style="min-width:200px;min-height:100px;" class="uk-text-center">
                                <a href="'.$row_CAROUSEL['url'].'" '.$target.' class=" uk-button uk-button-white uk-button-large">
                                  '.$row_CAROUSEL['titulo'].'
                                </a>
                              </div>
                            </div>';
                          }
                        }
                        echo '
                        <li>
                            <img src="img/contenido/'.$carousel.'/'.$row_CAROUSEL['id'].'.jpg" uk-cover>
                        </li>';
                      }
                    }

                    echo '
                  </ul>

                  <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
                  <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>

                </div>
                <ul class="uk-slideshow-nav uk-dotnav uk-flex-center uk-margin"></ul>
              </div>
            </div>
            <!-- End Carousel -->
            ';
      }
      mysqli_free_result($CAROUSEL);
    }

// ITEM                  
  function item($id){
    global $CONEXION;
    global $caracteres_si_validos;
    global $caracteres_no_validos;

    $widget    = '';
    $style     = 'max-width:200px;';  
    $noPic     = 'img/design/camara.jpg';
    $rutaPics  = 'img/contenido/productos/';
    $firstPic  = $noPic;

    $CONSULTA1 = $CONEXION -> query("SELECT * FROM productos WHERE id = $id");
    $row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
    $link=$id.'_'.urlencode(str_replace($caracteres_no_validos,$caracteres_si_validos,html_entity_decode(strtolower($row_CONSULTA1['titulo'])))).'-.html';

    // Fotografía
      $CONSULTA3 = $CONEXION -> query("SELECT * FROM productospic WHERE producto = $id ORDER BY orden,id LIMIT 1");
      while ($rowCONSULTA3 = $CONSULTA3 -> fetch_assoc()) {
        $firstPic = $rutaPics.$rowCONSULTA3['id'].'.jpg';
      }

      $picWidth=0;
      $picHeight=0;
      $picSize=getimagesize($firstPic);
      foreach ($picSize as $key => $value) {
        if ($key==3) {
          $arrayCadena1=explode(' ',$value);
          $arrayCadena1=str_replace('"', '', $arrayCadena1);
          foreach ($arrayCadena1 as $key1 => $value1) {

            $arrayCadena2=explode('=',$value1);
            foreach ($arrayCadena2 as $key2 => $value2) {
              if (is_numeric($value2)) {
                $picProp[]=$value2;
              }
            }
          }
        }
      }
      if (isset($picProp)) {
        $picWidth=$picProp[0];
        $picHeight=$picProp[1];

        $style=($picWidth<$picHeight)?'max-height:200px;':$style;
      }

    $widget.='
      <div id="item'.$id.'" class="uk-text-center">
        <div class="bg-white padding-20" style="border:solid 1px #CCC;">
          <a href="'.$link.'" class="" style="color:black;">
            <div class="margin-10">
              <div class="uk-flex uk-flex-center uk-flex-middle" style="height: 200px;">
                <img data-src="'.$firstPic.'" uk-img style="'.$style.'">
              </div>
              <div style="min-height:100px;">
                <div>
                  '.$row_CONSULTA1['sku'].'
                </div>
                <div class="uk-flex uk-flex-center">
                  <div class="line-yellow"></div>
                </div>
                <div class="padding-v-10">
                </div>
                <div>
                  '.$row_CONSULTA1['titulo'].'
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>';

    return $widget;
  }

// FILTROS               
  function filtros ($cat,$marca){
    global $CONEXION;
    global $caracteres_si_validos;
    global $caracteres_no_validos;
    global $noPic;

    $consulta0 = $CONEXION -> query("SELECT * FROM productoscat WHERE id = $cat");
    $row_consulta0 = $consulta0 -> fetch_assoc();
    $parentId=$row_consulta0['parent'];

    $estatusCatAll=($cat==0)?'active':'';
    $estatusMarcaAll=($marca==0)?'active':'';

    $linkAllMarca = $cat.'_0_0_tienda_wozial';
    $linkAllCat   = '0_'.$marca.'_0_tienda_wozial';

    $widget = '
      <!-- Filtros -->
      <h2 class="uk-text-center color-primary">Categorías</h2>

      <div>
        <a href="'.$linkAllCat.'" class="'.$estatusCatAll.'">Todo</a>
        <ul class="uk-nav" uk-nav>';
          $sql="SELECT * FROM productoscat ORDER BY orden,txt,id";
          $Consulta2 = $CONEXION -> query($sql);
          $numSub = $Consulta2->num_rows;
          if ($numSub > 0) {
            while ($row_Consulta2 = $Consulta2 -> fetch_assoc()) {
              $subMenuId = $row_Consulta2['id'];
              $estatus = ($subMenuId!=$cat)?'':'active';
              $link = $subMenuId.'_'.$marca.'_0_'.urlencode(str_replace($caracteres_no_validos,$caracteres_si_validos,html_entity_decode(strtolower($row_Consulta2['txt'])))).'_wozial';
              $widget .= '
              <li><a href="'.$link.'" class="'.$estatus.'">'.$row_Consulta2['txt'].'</a></li>';
            }
          }
          $widget .= '
        </ul>
      </div>

      <h2 class="uk-text-center color-primary">Marcas</h2>

      <div>
        <ul class="uk-nav">
          <li><a href="'.$linkAllMarca.'" class="'.$estatusMarcaAll.'">Todo</a></li>
          ';
          $sql="SELECT * FROM productosmarcas ORDER BY orden,txt,id";
          $Consulta2 = $CONEXION -> query($sql);
          $numSub = $Consulta2->num_rows;
          if ($numSub > 0) {
            while ($row_Consulta2 = $Consulta2 -> fetch_assoc()) {
              $marcaId=$row_Consulta2['id'];
              $link = $cat.'_'.$marcaId.'_0_'.urlencode(str_replace($caracteres_no_validos,$caracteres_si_validos,html_entity_decode(strtolower($row_Consulta2['txt'])))).'_wozial';
              $estatus = ($marca==$marcaId)? 'active':'';
              $widget .= '
              <li><a href="'.$link.'" class="'.$estatus.'">'.$row_Consulta2['txt'].'</a></li>';
            }
          }
          $link = $cat.'_0_0_tienda_wozial';
          $widget .= '
        </ul>
      </div>';

    return $widget;
  }


