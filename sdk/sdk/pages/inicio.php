<!DOCTYPE html>
<?=$headGNRL?>
<body>
  
<?=$header?>

<div>
	<?=carousel('carousel')?>
</div>


<!-- Productos de muestra -->
  <?php
  $sql="SELECT * FROM productos WHERE estatus = 1 AND inicio = 1 ORDER BY RAND() LIMIT 16";
  $Consulta = $CONEXION -> query($sql);
  $numProds = $Consulta->num_rows;
  if ($numProds>0) {
    echo '
      <div class="margin-top-50">
        <div class="uk-container padding-v-50" style="visibility:hidden;" uk-scrollspy="cls:uk-animation-fade;delay:500;">
          <h2 class="uk-text-center">Productos</h2>
          <div class="uk-flex uk-flex-center">
            <div class="bg-primary" style="height: 3px; width: 130px;">
            </div>
          </div>
          <div class="uk-text-center padding-v-20">
            <a href="0_ofertas" class="uk-button uk-button-personal">Todas las ofertas</a>
          </div>
          <div class="uk-position-relative uk-visible-toggle" tabindex="-1" uk-slider="sets:true; autoplay:true; autoplay-interval:3000;">
            <ul class="uk-slider-items uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l uk-text-center" uk-height-match="target: .texto">';
              while ($row_Consulta = $Consulta -> fetch_assoc()) {
                echo '<li><div class="padding-20">'.item($row_Consulta['id']).'</div></li>';
              }
              echo '
            </ul>

            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin uk-visible@m"></ul>

            <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>

          </div>
        </div>
      </div>';
  }
  ?>

<!-- Marcas -->
	<div class="bg-gris-claro margin-top-100">
	  <div class="uk-container padding-v-50">
	    <h2 class="uk-text-center">Marcas</h2>
	    <div class="uk-flex uk-flex-center padding-bottom-20">
	      <div class="bg-primary" style="height: 3px; width: 130px;">
	      </div>
	    </div>
	    <div class="uk-position-relative uk-visible-toggle" tabindex="-1" uk-slider="sets:true; autoplay:true; autoplay-interval:3000;" uk-scrollspy="cls:uk-animation-fade;delay:300;">
	      
	      <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-4@s uk-child-width-1-5@m uk-grid">
	        <?php
	        $rutaPicCat='img/contenido/varios/';
	        $Consulta = $CONEXION -> query("SELECT * FROM productosmarcas ORDER BY orden,txt,id");
	        while ($row_Consulta = $Consulta -> fetch_assoc()) {
	          $pic=(strlen($row_Consulta['imagen'])>0 AND file_exists($rutaPicCat.$row_Consulta['imagen']))?$rutaPicCat.$row_Consulta['imagen']:$noPic;
	          $link = '0_'.$row_Consulta['id'].'_0_'.urlencode(str_replace($caracteres_no_validos,$caracteres_si_validos,html_entity_decode(strtolower($row_Consulta['txt'])))).'_wozial';
	          echo '
	          <li class="uk-flex uk-flex-center uk-flex-middle">
	            <a href="'.$link.'">
	              <img src="'.$pic.'" alt="">
	            </a>
	          </li>
	          ';
	        }
	        ?>
	      </ul>
	  
	      <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>

	      <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
	      <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>
	  
	    </div>
	  </div>
	</div>

<!-- Formulario -->
	<div class="uk-container uk-container-small uk-flex uk-flex-middle" style="min-height: 80vh;">
		<div class="uk-width-1-1 uk-card uk-card-default uk-card-body">
			<div uk-grid class="uk-child-width-1-3@s">
				<div>
					<label>Nombre
					<input type="text" class="uk-input input-personal" id="footernombre"></label>
				</div>
				<div>
					<label>Correo
					<input type="email" class="uk-input input-personal" id="footeremail"></label>
				</div>
				<div>
					<label>Teléfono
					<input type="text" class="uk-input input-personal" id="footertelefono"></label>
				</div>
			</div>
			<div class="margin-top-20">
				<div>
					<label>Mensaje
					<textarea type="text" class="uk-textarea input-personal" id="footercomentarios"></textarea></label>
				</div>
			</div>
			<div class="margin-top-20 uk-text-center">
				<button class="uk-button uk-button-personal footer-enviar" id="footersend">Enviar</button>
			</div>
		</div>

	</div><!-- Formulario -->

<?=$footer?>

<?=$scriptGNRL?>

</body>
</html>