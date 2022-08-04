<!DOCTYPE html>
<?=$headGNRL?>
<body>
  
<?=$header?>


<div class="padding-v-100 uk-container" style="max-width:500px;">
  <div class="uk-card uk-card-default uk-card-body">
    <div>
      <h4 class="color-primary">¿Has perdido tu contraseña?</h4>
    </div>
    <div>
      <label for="email-recovery" class="text-8">Solicita instrucciones para generar una nueva</label>
      <input type="email" class="uk-input uk-width-1-1 uk-margin input-personal" id="email" placeholder="Ingresa tu email" autofocus>
      <button class="uk-button uk-button-personal uk-margin" id="send-link">Enviar</button>
    </div>
  </div>
</div>

<?=$footer?>

<?=$scriptGNRL?>

<script type="text/javascript">
// Envío de correo
  $(document).ready(function() {
    $("#send-link").click(function(){
      var email = $("#email").val();

      var fallo = 0;      
      var alerta = "";
      
      $("input").removeClass("uk-form-danger");
      
      if (email=="") { 
        fallo=1; alerta="Falta email"; id="footeremail";
      }else{
        var n = email.indexOf("@");
        var l = email.indexOf(".");
        if ((n*l)<2) { 
          fallo=1; alerta="Proporcione un email válido"; id="footeremail";
        } 
      }

      var parametros = {
        "passrecovery" : email
      };
      if (fallo == 0) {
        $.ajax({
          data:  parametros,
          url:   "includes/acciones.php",
          type:  "post",
          beforeSend: function () {
            $("#send-link").html("<div uk-spinner></div>");
            $("#send-link").prop("disabled",true);
            $("#send-link").disabled = true;
            UIkit.notification.closeAll();
            UIkit.notification('<div class="uk-text-center color-blanco bg-blue padding-10 text-lg"><i uk-spinner></i> Espere...</div>');
          },
          success:  function (response) {
            $("#send-link").html("Enviar");
            $("#send-link").disabled = false;
            $("#send-link").prop("disabled",false);
            $("#footeremail").val("");
            console.log(response);
            datos = JSON.parse(response);
            UIkit.notification.closeAll();
            UIkit.notification(datos.msj);
          }
        })
      }else{
        UIkit.notification.closeAll();
        UIkit.notification('<div class="uk-text-center color-blanco bg-danger padding-10 text-lg"><i uk-icon="icon:warning;ratio:2;"></i> &nbsp; '+alerta+'</div>');
        $("#"+id).focus();
        $("#"+id).addClass("uk-form-danger");
      }
    })
  })
</script>

</body>
</html>