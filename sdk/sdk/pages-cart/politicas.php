<?php
  $campo1="tyct".$id;
  $campo2="tyc".$id;

  $CONSULTA    = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 1");
  $rowCONSULTA = $CONSULTA -> fetch_assoc();
  $title=$rowCONSULTA[$campo1];
  $txt=$rowCONSULTA[$campo2];
?>
<!DOCTYPE html>
<?=$headGNRL?>
<body>
  
<?=$header?>

<div class="uk-container uk-container-small padding-v-100">
  <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-text-justify min-height-500px">
    <h3><?=$title?></h3>
    <?=$txt?>
  </div>
</div>

<?=$footer?>

<?=$scriptGNRL?>

</body>
</html>