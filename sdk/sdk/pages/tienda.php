<!DOCTYPE html>
<html lang="<?=$languaje?>">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <title><?=$title?></title>
  <meta name="description" content="<?=$description?>">
  
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=$title?>">
  <meta property="og:description" content="<?=$description?>">
  <meta property="og:url" content="<?=$rutaEstaPagina?>">
  <meta property="og:image" content="<?=$ruta?>img/design/logo-og.jpg">
  <meta property="fb:app_id" content="<?=$appID?>">

  <?=$headGNRL?>

</head>
<body id="tienda">
<?=$header?>

<div uk-grid style="margin-bottom:-100px;">

  <div class="uk-visible@m uk-card uk-card-default uk-height-viewport" id="sidebar">
    <div style="width:280px;">
      <div class="uk-container padding-top-50">
        <?=filtros($cat,$marca)?>
      </div>
    </div>
  </div><!-- / Filtros -->


  <!-- Productos -->
    <div class="uk-width-expand">
      <!-- Navegación moviles -->
      <div class="uk-text-center padding-top-50 uk-hidden@m">
        <a href="#filtrosmovil" uk-toggle class="uk-button uk-button-personal"><i uk-icon="icon:menu;ratio:1.4"></i> &nbsp; Filtros</a>
      </div>
      <div id="filtrosmovil" uk-offcanvas="overlay: true">
        <div class="uk-offcanvas-bar uk-flex uk-flex-column">
          <button class="uk-offcanvas-close" type="button" uk-close></button>
          <?=filtros($cat,$marca)?>
        </div>
      </div>  

      <!-- Productos -->  
      <div class="padding-h-20 padding-top-50">
        <h2 class="uk-text-center"><?=$title?></h2>
        <div uk-grid class="uk-text-center uk-flex-center" uk-height-match="target: .texto" uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 100">
          <?php
          // echo '<div class="uk-width-1-1">'.$sqlProd.'</div>';
          $Consulta = $CONEXION -> query($sqlProd);
          $numItems = $Consulta->num_rows;
          $pag = (!isset($pag))?0:$pag;
          $prodInicial = $prodsPagina*$pag;
          $Consulta = $CONEXION -> query($sqlProd." ORDER BY sku,orden,id DESC LIMIT $prodInicial, $prodsPagina");
          while ($row_Consulta = $Consulta -> fetch_assoc()) {
            echo '<div>'.item($row_Consulta['id']).'</div>';
          }
          ?> 
        </div>
      </div>

      <!-- PAGINATION -->
      <div class="uk-container uk-flex uk-flex-center uk-flex-middle padding-v-50">
        <ul class="uk-dotnav">
          <?php
          $txt=urlencode(str_replace($caracteres_no_validos,$caracteres_si_validos,html_entity_decode(strtolower($title))));
          $pagTotal=intval($numItems/$prodsPagina);
          $modulo=$numItems % $prodsPagina;
          if (($modulo) == 0){
            $pagTotal=($numItems/$prodsPagina)-1;
          }
          for ($i=0; $i <= $pagTotal; $i++) { 
            $clase='';
            if ($pag==$i) {
              $clase='uk-active';
            }
            $link=$cat.'_'.$marca.'_'.$i.'_'.$txt.'_autsol';
            echo '
            <li class="'.$clase.'"><a href="'.$link.'"></a></li>';
          }
          ?>
        </ul>
      </div><!-- PAGINATION -->
  
    </div>


</div>

<?=$footer?>

<?=$scriptGNRL?>

</body>
</html>