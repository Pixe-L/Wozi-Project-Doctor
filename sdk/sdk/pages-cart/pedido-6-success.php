<!DOCTYPE html>
<?=$headGNRL?>
<body onload="cuentaRegresiva()">
  
<?=$header?>

<div class="min-height-150px">  
</div>

<div class="padding-v-100">
  <div class="uk-container">
    <div class="uk-alert-primary uk-text-center" uk-alert>
      <p class="text-xxl">Gracias por su pago</p>
      <p class="text-xl">Será redirigido a su panel de cliente</p>
      <p class="text-xxxl" id="numero">10</p>
    </div>
  </div>
</div>

<?=$footer?>

<?=$scriptGNRL?>

<script>
function cuentaRegresiva() {
  var count = 10;
  var number = document.getElementById('numero');
  var intervalo = setInterval(function(){
    count--; 
    number.innerHTML = count;
    if(count == 0){
      clearInterval(intervalo);
      window.location = ('mi-cuenta');
    }
  }, 1000);
}

</script>

</body>
</html>