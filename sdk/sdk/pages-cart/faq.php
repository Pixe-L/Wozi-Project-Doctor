<!DOCTYPE html>
<?=$headGNRL?>
<body>
  
<?=$header?>

<div class="uk-container">

  <div class="text-xxl padding-top-20">
    Preguntas frecuentes
  </div>
  
  <div class="padding-v-50">
    <ul uk-accordion="multiple: true">
      <?php
      $open='uk-open';
      $CONSULTA = $CONEXION -> query("SELECT * FROM faq ORDER BY orden");
      while ($row_CONSULTA = $CONSULTA  -> fetch_assoc()) { 
        echo '
      <li class="'.$open.' border-grey">
        <a class="uk-accordion-title color-blanco bg-primary" href="#">
          <div class="padding-20">
          '.$row_CONSULTA['pregunta'].'
          </div>
        </a>
        <div class="uk-accordion-content">
          <div class="padding-h-20 padding-bottom-20 text-10">
            '.$row_CONSULTA['respuesta'].'
          </div>
        </div>
      </li>';
      $open='';
      }
      ?>

    </ul>
  </div>
</div>

<?=$footer?>

<?=$scriptGNRL?>

</body>
</htm>