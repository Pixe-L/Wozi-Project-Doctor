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
<body id="productos-ofertas">
  
<?=$header?>

<div class="padding-v-50">
  <h2 class="uk-text-center">Ofertas</h2>
  <div class="uk-flex uk-flex-center">
    <div style="background: #fe4c50; height: 3px; width: 130px;">
    </div>
  </div>
</div>

<div class="uk-container">
  <div uk-grid class="uk-text-center uk-flex-center" uk-height-match="target: .texto" uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 100">
    <?php
      $CONSULTA   = $CONEXION -> query("SELECT id FROM productos WHERE estatus = 1 AND descuento > 0");
      $numItems   = $CONSULTA->num_rows;
      $prodInicial= $prodsPagina*$pag;

      if ($numItems>0) {
        $CONSULTA   = $CONEXION -> query("SELECT id FROM productos WHERE estatus = 1 AND descuento > 0 ORDER BY sku,id LIMIT $prodInicial, $prodsPagina");
        while($row_Consulta = $CONSULTA -> fetch_assoc()){
          echo '<div>'.item($row_Consulta['id']).'</div>';
        }
      }else{
        echo '
        <div class="uk-width-1-1">
          <div class="uk-alert uk-alert-danger uk-text-center">
            No hay productos en oferta
          </div>
        </div>
        ';
      }
    ?>

  </div>
</div>



<!-- PAGINATION -->
  <div class="uk-container uk-flex uk-flex-center uk-flex-middle padding-v-50">
    <ul class="uk-dotnav">
      <?php
      $txt=urlencode(str_replace($caracteres_no_validos,$caracteres_si_validos,html_entity_decode(strtolower($catName))));
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
        $link=$i.'_ofertas';
        echo '
          <li class="'.$clase.'"><a href="'.$link.'"></a></li>';
      }
      ?>
    </ul>
  </div><!-- PAGINATION -->


<?=$footer?>

<?=$scriptGNRL?>

</body>
</html>