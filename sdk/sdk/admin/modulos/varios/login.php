<?=$head?>

<div class="uk-inline uk-width-1-1" style="min-height: 100vh;">

  <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slideshow="animation:fade; autoplay:true; autoplay-interval:3000; pause-on-hover:false;">
    <ul class="uk-slideshow-items" uk-height-viewport="min-height: 700">
      <?php
      for ($i=1; $i < 10; $i++) {
        $fotos[] = '
        <li>
          <div class="uk-position-cover">
            <img src="../img/contenido/wozial/wozial'.$i.'.jpg" alt="" uk-cover>
          </div>
        </li>';
      }
      shuffle($fotos);
      foreach ($fotos as $foto) {
        echo $foto;
      }
      ?>
      
    </ul>
  </div>

  <div class="uk-position-center" style="width:300px;">
    <div class="uk-border-rounded uk-overlay uk-overlay-default" uk-scrollspy="cls:uk-animation-slide-bottom-medium; delay:800;">
      <div class="uk-text-center">
        <img src="../img/design/logo-wozial.png" class="margin-bottom-10" style="max-height: 100px;">
      </div>

      <form action="index.php" method="post">
        <div class="uk-inline">
          <span class="uk-form-icon uk-form-icon-flip" href="" uk-icon="icon: user"></span>
          <input name="user" id="user" type="text" class="uk-input uk-margin uk-width-1-1 uk-form-large" autofocus>
        </div>
        <div class="uk-inline">
          <span class="uk-form-icon uk-form-icon-flip" href="" uk-icon="icon: lock"></span>
          <input name="pass" id="pass" type="password" class="pass uk-input uk-margin uk-width-1-1 uk-form-large" placeholder="Contraseña">
        </div>
        <span class="password-revelar uk-margin">Revelar contraseña</span>
        <span class="password-ocultar uk-hidden uk-margin">Ocultar contraseña</span>
        <button class="uk-width-1-1 uk-margin uk-button uk-button-primary uk-button-large">Entrar</button>
      </form>

    </div>
  </div>

</div>


<?=$jquery?>

<?=$footer?>
