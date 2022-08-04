<?php
$num=0;
$CONSULTA = $CONEXION -> query("SELECT id FROM usuarios");
while($row_CONSULTA = $CONSULTA -> fetch_assoc()){
  $idmd5=md5($row_CONSULTA['id']);
  if ($id==$idmd5) {
    $num=$row_CONSULTA['id'];
  }
}
?>
<!DOCTYPE html>
<?=$headGNRL?>
<body>
  
<?=$header?>

<div class="padding-v-100 uk-container" style="max-width:500px;">
  <div class="uk-card uk-card-default uk-card-body">
    <div>
      <h4 class="color-primary">Recuperación de contraseña</h4>
    </div>
    <div>
      <label for="email-recovery" class="uk-form-label">Ingresa la contraseña deseada</label>
      <input type="password" id="pass1" name="pass1" class="uk-input" required autofocus>
      <label for="pass2" class="uk-form-label">Repetir contraseña</label>
      <input type="password" id="pass2" name="pass2" class="uk-input" required>
      <button class="uk-button uk-button-personal uk-margin" id="enviarpass">Enviar</button>
    </div>
  </div>
</div>

<?=$footer?>

<?=$scriptGNRL?>

<script type="text/javascript">
  $(document).ready(function(){
    $("#pass1").keyup(function() {
      var pass  = $("#pass1").val();
      var len   = (pass).length;

      if(len>6){
        $('#pass1').removeClass("uk-form-danger");
        $('#pass1').addClass("uk-form-success");
      }else{
        $('#pass1').removeClass("uk-form-success");
        $('#pass1').addClass("uk-form-danger");
      }
    });

    $("#pass2").keyup(function() {
      var pass  = $("#pass1").val();
      var len   = (pass).length;
      var passc = $(this).val();

      if(len>6){
        $('#pass1').removeClass("uk-form-danger");
        $('#pass2').addClass("uk-form-danger");
        if(pass!=passc){
          $('#pass1').addClass("uk-form-success");
        }else{
          $('#pass2').addClass("uk-form-success");
        }
      }else{
        $('#pass1').addClass("uk-form-danger");
      }

    });
  });

  $('#enviarpass').click(function(){
    var pass1 = $('#pass1').val();
    var pass2 = $('#pass2').val();

    var len   = (pass1).length;
    if (pass1==pass2 && len > 6) {
      $.ajax({
        method: "POST",
        url: "includes/acciones.php",
        data: { 
          passwordrecovery: 1,
          uid: <?=$num?>,
          pass1: pass1,
          pass2: pass2
        }
      })
      .done(function( response ) {
        console.log(response);
        datos = JSON.parse(response);
        UIkit.notification.closeAll();
        UIkit.notification(datos.msj);
        if (datos.estatus==0) {
           setTimeout(function(){ location.reload(); },2000);
        }
      });
    }
  })
</script>

</body>
</html>