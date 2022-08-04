<!DOCTYPE html>
<?=$headGNRL?>
<body id="menu-dark">
<?=$header?>

<?php 
	  $style     	 = 'max-width:200px;';  
    $noPic     	 = 'img/design/camara.jpg';
    $rutaPics  	 = 'img/contenido/productos/';
    $firstPic  	 = $noPic;
    $firstTalla  = '';
    $firstColor  = '';
    $existencias = '';
    //Fotografía
      $CONSULTA3 = $CONEXION -> query("SELECT * FROM productospic WHERE producto = $id ORDER BY orden LIMIT 1");
      while ($rowCONSULTA3 = $CONSULTA3 -> fetch_assoc()) {
        $firstPic = $rutaPics.$rowCONSULTA3['id'].'-sm.jpg';
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

    $precio='';
    $preciocampo = ($campo == 0)?'precio':'precio1';
    $descuento = ($campo == 0)?$rowCONSULTA['descuento']:0;

	  if ($rowCONSULTA[$preciocampo]>0) {
	    $precio = ($descuento>0)?'
	    <del class="text-8 uk-text-light uk-text-muted">Precio: $'.number_format(($rowCONSULTA[$preciocampo]),2).'</del><br>
	    <div class="" style="min-height: 35px; width: 250px;">
	      $ <span class="text-lg">'.number_format(($rowCONSULTA[$preciocampo]*(100-$descuento)/100),2).' Mx</span>
	    </div>':'
	    <div class="" style="height: 35px; min-width: 250px; max-width: 250px;">
	      $ <span class="text-lg">'.number_format(($rowCONSULTA[$preciocampo]*(100-$descuento)/100),2).' Mx</span>
	    </div>';
	  }
?>


<div class="uk-container detalle-contenedor" style="padding-top: 150px;">
	<div uk-grid>
		<div class="uk-width-1-2@s uk-text-center">
			<div class="uk-card uk-card-default uk-flex uk-flex-center uk-flex-middle" style="height: 500px;">
        <?php 
        if (file_exists($picOg)) {
          $pic=$picOg;
        }else{
          $pic='img/design/camara.jpg';
        }
        echo '
          <img id="pic" data-zoom-image="'.$pic.'" src="'.$pic.'" style="max-height: 450px;">';
        ?>
      </div><!-- END Card -->
      <div class="padding-v-50">
        <div uk-grid class="uk-grid-small uk-child-width-1-4 uk-flex-center">
        <?php
        $num=0;
        $consultafotos = $CONEXION -> query("SELECT * FROM productospic WHERE producto = $id ORDER BY orden");
        $numPics=$consultafotos->num_rows;
        if ($numPics>1) {
          while($rowConsultaFotos = $consultafotos -> fetch_assoc()){

            if (isset($arregloPics)) {
              $arregloPics .= ',"'.$rowConsultaFotos['id'].'"';
            }else{
              $arregloPics = '"'.$rowConsultaFotos['id'].'"';
            }

            $pic=$rutaImg.$rowConsultaFotos['id'].'-sm.jpg';    
            if (file_exists($pic)) {
              $lightboxA1=($es_movil===TRUE)?'<a href="'.$picLG.'">':'';
              $lightboxA2=($es_movil===TRUE)?'</a>':'';
              echo '
              <div>
                '.$lightboxA1.'
                  <div class="pic uk-border-rounded pointer uk-flex uk-flex-center uk-flex-middle" style="height:120px;" data-id="'.$num.'" >
                    <img src="'.$pic.'" style="max-height:100%">
                  </div>
                '.$lightboxA2.'
              </div>';
              $num++;
            }
          }
        }
        ?>

        </div><!-- End grid -->
      </div><!-- End padding-v-50 -->
		</div>
		<div class="uk-width-1-2@s">
			<div class="uk-width-large uk-position-relative">
				<div class="uk-position-top-right" style="right: 20px;">
					<a href="javascript:window.history.back();">
						<i uk-icon="icon:close;ratio:2;"></i>
					</a>
				</div>
				<div class="detalle-titulo">
					<?=$rowCONSULTA['titulo']?>
				</div>

				<div class="detalle-precio padding-top-20 uk-width-small">
					
					<?=$precio?>
					<div style="height: 2px; width: 100%; background: black; margin-top: 10px;"></div>
				</div>
				<div class="detalle-descripcion">
					<?=$rowCONSULTA['txt']?>
				</div>

        <?php
        echo '
          <div class="uk-margin">
            
            <div>
              Tallas disponibles
            </div>
            
            <ul class="uk-subnav uk-subnav-pill uk-flex-left" uk-switcher="connect: #colores">';
              $sql="SELECT DISTINCT 
                productosexistencias.talla,
                productostalla.txt
                FROM productosexistencias 
                INNER JOIN productostalla ON productostalla.id = productosexistencias.talla
                WHERE productosexistencias.producto = $id 
                AND productosexistencias.estatus = 1
                ORDER BY productostalla.txt";
              //echo $sql;    
              $CONSULTA1 = $CONEXION -> query($sql);
              while ($rowCONSULTA1 = $CONSULTA1 -> fetch_assoc()) {
                $tallaID=$rowCONSULTA1['talla'];
                echo '
                    <li><a href="#">'.$rowCONSULTA1['txt'].'</a></li>';
              }

              echo '
            </ul>
            
            <div class="padding-top-50">
              Colores disponibles
            </div>
          </div>

          <div>
            <ul id="colores" class="uk-switcher uk-margin seleccionproducto">';
            $cuentaTalla = 0;
              $sql="SELECT DISTINCT 
                productosexistencias.talla,
                productostalla.txt
                FROM productosexistencias 
                INNER JOIN productostalla ON productostalla.id = productosexistencias.talla
                WHERE productosexistencias.producto = $id 
                AND productosexistencias.estatus = 1
                ORDER BY productostalla.txt";
              $CONSULTA1 = $CONEXION -> query($sql);
              $numTallas = $CONSULTA1->num_rows;
              if ($numTallas>0) {
                while ($rowCONSULTA1 = $CONSULTA1 -> fetch_assoc()) {
                  $tallaID=$rowCONSULTA1['talla'];
                  $tallaName=$rowCONSULTA1['txt'];
                  echo '
                      <li>
                        <div uk-grid>';
                  $CONSULTA2 = $CONEXION -> query("SELECT * FROM productosexistencias WHERE producto = $id AND talla = $tallaID AND estatus = 1");
                  while($rowCONSULTA2 = $CONSULTA2 -> fetch_assoc()){

                    $itemId=$rowCONSULTA2['id'];
                    $colorID=$rowCONSULTA2['color'];
                    $colorName=$rowCONSULTA2['name'];
                    $existencias=$rowCONSULTA2['existencias'];
                    $existenciasTooltip=($existencias==0)?'uk-tooltip="Agotado"':'';
                    $seleccionable=($existencias==0)?'':'item';

                    if(!isset($selectedId) AND $existencias>0){
                      $selectedId=$itemId;
                      $max=$existencias;
                      $selectedClass='colorseleccionado';
                      $firstTalla=$tallaName;
                    }else{
                      $selectedClass='';
                    }

                    $CONSULTA3 = $CONEXION -> query("SELECT * FROM productoscolor WHERE id = $colorID");
                    $numColors = $CONSULTA3->num_rows;
                    if ($numColors>0) {
                      $rowCONSULTA3 = $CONSULTA3 -> fetch_assoc();

                      if(!isset($colorCanged) AND $existencias>0){
                        $colorCanged=1;
                        $firstColor=$rowCONSULTA3['name'];
                      }

                      $imagen   = 'img/contenido/productoscolor/'.$rowCONSULTA3['imagen'];
                      $colorTxt = (strlen($rowCONSULTA3['imagen'])>0 AND file_exists($imagen))?'background:url('.$imagen.');background-size:cover;':'background:'.$rowCONSULTA3['txt'].';';

                      echo '
                          <div>
                            <div id="'.$itemId.'" class="'.$seleccionable.' uk-border-circle pointer '.$selectedClass.'" '.$existenciasTooltip.' style="'.$colorTxt.'width:30px;height:30px;" data-inventario="'.$existencias.'" data-id="'.$itemId.'">
                              &nbsp;
                            </div>
                          </div>';
                    }
                  }
                  echo '
                        </div>
                      </li>';
                }
              }
              echo '
            </ul>
          </div>';

        if ($rowCONSULTA['precio']>0) {
          echo $precio.'
          <div class="uk-margin text-8 padding-top-50" id="productoselectedtxt">
            Talla seleccionada: '.$firstTalla.'<br>
            Color seleccionado: '.$firstColor.'
          </div>
          <div class="uk-margin">
            <input class="cantidad" type="hidden" value="1">
            <button class="buybutton uk-button uk-text-nowrap uk-button-personal" data-id="'.$selectedId.'"><i class="fas fa-cart-plus fa-lg"></i> &nbsp; AGREGAR AL CARRO</button>
          </div>
          ';
        }
        ?>

			</div>
		</div>
	</div>
</div>

<?=$footer?>

<?=$scriptGNRL?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php
if($es_movil!==TRUE){
  echo "<script src='library/elevatezoom/jquery.elevatezoom.js'></script>";
}
?>
<script>
  $("#pic").elevateZoom({ 
    zoomType : "lens", 
    lensShape : "round", 
    lensSize : 130,
    scrollZoom: true
  });

  <?php 
    if (isset($arregloPics)) {
    ?>
    $('.pic').click(function(){
      var arreglo = [<?=$arregloPics?>];
      var id = $(this).attr('data-id');
      $('#actual').val(id);
      $( "#pic" ).addClass( "alpha0", 200 );
      setTimeout(function() {
        $('#pic').attr('src','<?=$rutaImg?>'+arreglo[id]+'.jpg');
        $('#pic').attr('data-zoom-image','<?=$rutaImg?>'+arreglo[id]+'.jpg');
        $('#pic').removeClass( "alpha0", 500 );
        var ez = $('#pic').data('elevateZoom');
        ez.swaptheimage('<?=$rutaImg?>'+arreglo[id]+'.jpg', '<?=$rutaImg?>'+arreglo[id]+'.jpg');
      }, 200 );
    });
    <?php 
    }
  ?>

  $('#seleccionartalla').change(function() {
    var talla = $(this).val();
    console.log(talla);
    $('.item').removeClass('colorseleccionado');
    $('.item-'+talla+'-0').addClass('colorseleccionado');
    var id = $('.item-'+talla+'-0').attr('data-id');
    var inventario = $('.item-'+talla+'-0').attr('data-inventario');
    dameItem(id,inventario);

  });

  $('.item').click(function(){
    var id = $(this).attr('data-id');
    var inventario = $(this).attr('data-inventario');
    dameItem(id,inventario);
  });

  function dameItem(id,inventario){
    $('.buybutton').attr('data-id', id);
    $('.cantidad').attr('max', inventario);
    $('.item').removeClass('colorseleccionado');
    $('#'+id).addClass('colorseleccionado');
    $.ajax({
      method: "POST",
      url: "includes/acciones.php",
      data: {
        tallaycolor: 1,
        id: id,
        inventario: inventario
      }
    })
    .done(function( response ) {
      console.log(response);
      datos = JSON.parse(response);
      $('#productoselectedtxt').html(datos.xtras);
    });
  }
  
  // Agregar al carro
  $(".buybutton").click(function(){
    var id=$(this).attr("data-id");
    var cantidad=$(".cantidad").val();
    var l=id.length;
    //console.log( id + ' - ' + cantidad );
    if (l>0) {
      $.ajax({
        method: "POST",
        url: "addtocart",
        data: { 
          id: id,
          cantidad: cantidad,
          campo: "<?=$campo?>",
          addtocart: 1
        }
      })
      .done(function( response ) {
        console.log( response );
        datos = JSON.parse(response);
        UIkit.notification.closeAll();
        UIkit.notification(datos.msj);
        $(".cartcount").html(datos.count);
        $("#cotizacion-fixed").removeClass("uk-hidden");
      });
    }
  });


  $(".cantidad").keyup(function() {
    var inventario = $(this).attr("data-inventario");
    var cantidad = $(this).val();
    inventario=1*inventario;
    cantidad=1*cantidad;
    if(inventario<=cantidad){
      $(this).val(inventario);
    }
    console.log(inventario+" - "+cantidad);
  })
  $(".cantidad").focusout(function() {
    var inventario = $(this).attr("data-inventario");
    var cantidad = $(this).val();
    inventario=1*inventario;
    cantidad=1*cantidad;
    if(inventario<=cantidad){
      //console.log(inventario*2+" - "+cantidad);
      $(this).val(inventario);
    }
  })



  $("#seleccionartalla").change(function(){
    var valor = $(this).val();
    UIkit.switcher("#colores").show(valor);
  });

</script>
</body>
</html>