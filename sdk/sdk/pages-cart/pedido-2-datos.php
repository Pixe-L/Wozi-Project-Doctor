<?php
  $domicilio2=(isset($_SESSION['domicilio2']))?$_SESSION['domicilio2']:0;
  $domicilio2Icon =(isset($_SESSION['domicilio2']) AND $_SESSION['domicilio2']==1)?'fas fa-check color-verde':'far fa-square uk-text-muted';
  $domicilio2Class=(isset($_SESSION['domicilio2']) AND $_SESSION['domicilio2']==1)?'':'uk-hidden';

  $paypalbutton=(strlen($payPalCliente)==0)?'
  <div class="uk-text-left@m uk-text-center">
    <button data-enlace="procesar-pedido" class="uk-button uk-button-default" disabled="true">PayPal no disponible</button>
  </div>':'
  <div class="uk-text-left@m uk-text-center">
    <a href="#spinner" uk-toggle data-enlace="procesar-pedido" class="siguiente uk-button uk-button-personal">Paga con PayPal</a>
  </div>';

  $descuentoCupon=0;
  $descuentoCuponTxt='';
  if (isset($_SESSION['cupon'])) {
    $cupon=$_SESSION['cupon'];
    $CONSULTA= $CONEXION -> query("SELECT * FROM cupones WHERE codigo = '$cupon'");
    $numCupones=$CONSULTA->num_rows;
    if ($numCupones>0) {
      $rowCONSULTA = $CONSULTA -> fetch_assoc();
      $descuentoCupon=$rowCONSULTA['descuento'];
      $descuentoCuponTxt=$rowCONSULTA['txt'];
    }
  }

?>
<!DOCTYPE html>
<?=$headGNRL?>
<body>
  
<?=$header?>

<div class="uk-container margin-top-50">
  <div class="uk-width-1-1">
    <div id="revisardatos">
      <div>
        <p class="text-xl">Revise que todos los datos sean correctos &nbsp; <a href="#editarinfopersonalmodal" uk-toggle class="uk-button uk-button-default border-orange">Editar datos personales</a></p>
      </div>
      <div class="uk-child-width-1-3@m" uk-grid>
        <div>
          <div>
            <h2>Datos de cliente</h2>
          </div>
          <div>
            <label for="nombre" class="uk-form-label uk-text-capitalize">nombre:</label>
            <?=$row_USER['nombre']?>
          </div>
          <div>
            <label for="telefono" class="uk-form-label uk-text-capitalize">telefono:</label>
            <?=$row_USER['telefono']?>
          </div>
          <div>
            <label for="email" class="uk-form-label uk-text-capitalize">email:</label>
            <?=$row_USER['email']?>
          </div>
          <div>
            <label for="empresa" class="uk-form-label uk-text-capitalize">empresa:</label>
            <?=$row_USER['empresa']?>
          </div>
          <div class="uk-text-uppercase">
            <label for="rfc" class="uk-form-label">rfc:</label>
            <?=$row_USER['rfc']?>
          </div>
        </div>
        <div>
          <div>
            <h2>Domicilio Fiscal</h2>
          </div>
          <div>
            <label class="uk-form-label uk-text-capitalize">calle:</label>
            <?=$row_USER['calle']?>
          </div>
          <div>
            <label class="uk-form-label uk-text-capitalize">no. exterior:</label>
            <?=$row_USER['noexterior']?>
          </div>
          <div>
            <label class="uk-form-label uk-text-capitalize">no. interior:</label>
            <?=$row_USER['nointerior']?>
          </div>
          <div>
            <label class="uk-form-label uk-text-capitalize">entrecalles:</label>
            <?=$row_USER['entrecalles']?>
          </div>
          <div>
            <label class="uk-form-label uk-text-capitalize">pais:</label>
            <?=$row_USER['pais']?>
          </div>
          <div>
            <label class="uk-form-label uk-text-capitalize">estado:</label>
            <?=$row_USER['estado']?>
          </div>
          <div>
            <label class="uk-form-label uk-text-capitalize">municipio:</label>
            <?=$row_USER['municipio']?>
          </div>
          <div>
            <label class="uk-form-label uk-text-capitalize">colonia:</label>
            <?=$row_USER['colonia']?>
          </div>
          <div>
            <label class="uk-form-label uk-text-uppercase">cp:</label>
            <?=$row_USER['cp']?>
          </div>
        </div>
        <div>
          <?php
            echo '
            <div>
              <h2>
                <a href="#domicilioentregamodal" uk-toggle id="domicilioentregabutton" class="'.$domicilio2Icon.' fa-2x pointer" data-domicilio2="'.$domicilio2.'"></a> &nbsp;&nbsp;Enviar a otro domicilio</a>
              </h2>
            </div>
            <div class="'.$domicilio2Class.'">
              <div>
                <label class="uk-form-label uk-text-capitalize">calle:</label>
                '.$row_USER['calle2'].'
              </div>
              <div>
                <label class="uk-form-label uk-text-capitalize">no. exterior:</label>
                '.$row_USER['noexterior2'].'
              </div>
              <div>
                <label class="uk-form-label uk-text-capitalize">no. interior:</label>
                '.$row_USER['nointerior2'].'
              </div>
              <div>
                <label class="uk-form-label uk-text-capitalize">entrecalles:</label>
                '.$row_USER['entrecalles2'].'
              </div>
              <div>
                <label class="uk-form-label uk-text-capitalize">pais:</label>
                '.$row_USER['pais2'].'
              </div>
              <div>
                <label class="uk-form-label uk-text-capitalize">estado:</label>
                '.$row_USER['estado2'].'
              </div>
              <div>
                <label class="uk-form-label uk-text-capitalize">municipio:</label>
                '.$row_USER['municipio2'].'
              </div>
              <div>
                <label class="uk-form-label uk-text-capitalize">colonia:</label>
                '.$row_USER['colonia2'].'
              </div>
              <div>
                <label class="uk-form-label uk-text-uppercase">cp:</label>
                '.$row_USER['cp2'].'
              </div>
            </div>'
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="uk-width-1-1 margin-top-50">
    <div class="uk-panel uk-panel-box">
      <h3 class="uk-text-center"><i class="uk-icon uk-icon-small uk-icon-check-square-o"></i> &nbsp; Productos y cantidades:</h3>
      <table class="uk-table uk-table-striped uk-table-hover uk-table-middle" id="tabla">
        <thead>
          <tr>
            <th >Producto</th>
            <th width="100px" class="">Talla</th>
            <th width="100px" class="">Color</th>
            <th width="100px" class="uk-text-right">Cantidad</th>
            <th width="100px" class="uk-text-right">Precio lista</th>
            <th width="100px" class="uk-text-right">Precio final</th>
            <th width="100px" class="uk-text-right">Importe</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $subtotal=0;
          $num=0;
          if(isset($_SESSION['carro'])){
            foreach ($arreglo as $key) {

              $itemId=$key['Id'];
              
              $CONSULTA0 = $CONEXION -> query("SELECT * FROM productosexistencias WHERE id = $itemId");
              $row_CONSULTA0 = $CONSULTA0 -> fetch_assoc();
              $prodId=$row_CONSULTA0['producto'];
              $tallaId=$row_CONSULTA0['talla'];
              $colorId=$row_CONSULTA0['color'];
              
              $CONSULTA1 = $CONEXION -> query("SELECT * FROM productos WHERE id = $prodId");
              $row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
              $producto=$row_CONSULTA1['sku'].' - '.$row_CONSULTA1['titulo'];

              $CONSULTA2 = $CONEXION -> query("SELECT * FROM productostalla WHERE id = $tallaId");
              $row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
              $talla=$row_CONSULTA2['txt'];

              $CONSULTA3 = $CONEXION -> query("SELECT * FROM productoscolor WHERE id = $colorId");
              $row_CONSULTA3 = $CONSULTA3 -> fetch_assoc();
              $imagen   = 'img/contenido/productoscolor/'.$row_CONSULTA3['imagen'];
              $color=(strlen($row_CONSULTA3['imagen'])>0)?'<img src="'.$imagen.'" class="uk-border-circle" style="width:35px;height:35px;">':'<div class="uk-border-circle" style="background:'.$row_CONSULTA3['txt'].';width:32px;height:32px;border:solid 1px #999;">&nbsp;</div>';
              $colorName=$row_CONSULTA3['name'];

              $link=$prodId.'_'.urlencode(str_replace($caracteres_no_validos,$caracteres_si_validos,html_entity_decode(strtolower($row_CONSULTA1['titulo'])))).'-.html';

              $importe=($row_CONSULTA1['precio']*(100-$row_CONSULTA1['descuento'])/100)*$key['Cantidad'];
              $subtotal+=$importe;

              echo '
              <tr>
                <td>
                  <a href="'.$link.'" target="_blank">'.$producto.'</a>
                </td>
                <td>
                  '.$talla.'
                </td>
                <td>
                  '.$colorName.'
                </td>
                <td class="uk-text-right">
                  '.$key['Cantidad'].'
                </td>
                <td class="uk-text-right">
                  '.number_format(($row_CONSULTA1['precio']),2).'
                </td>
                <td class="uk-text-right">
                  '.number_format(($row_CONSULTA1['precio']*(100-$row_CONSULTA1['descuento'])/100),2).'
                </td>
                <td class="uk-text-right">
                  '.number_format($importe,2).'
                </td>
              </tr>';

              $num++;
            }
          }

          $envio=$shipping*$carroTotalProds;
          $subtotal=$subtotal+$envio+$shippingGlobal;
          $iva=($taxIVA>0)?$subtotal*$taxIVA:0;
          $total=$subtotal+$iva;

          if ($total>0) {
            if ($shippingGlobal>0) {
              echo '
              <tr>
                <td style="text-align: left;" colspan="4">
                  Envío global
                </td>
                <td style="text-align: right; ">
                  1
                </td>
                <td style="text-align: right; ">
                  '.number_format($shippingGlobal,2).'
                </td>
                <td style="text-align: right; ">
                  '.number_format($shippingGlobal,2).'
                </td>
              </tr>';
            }
            if ($shipping>0) {
              echo '
              <tr>
                <td style="text-align: left; " colspan="4">
                  Envío por pieza
                </td>
                <td style="text-align: right; ">
                  '.$carroTotalProds.'
                </td>
                <td style="text-align: right; ">
                  '.number_format($shipping,2).'
                </td>
                <td style="text-align: right; ">
                  '.number_format($envio,2).'
                </td>
              </tr>';
            }

            if($taxIVA>0){
              echo '
              <tr>
                <td colspan="6" class="uk-text-right">
                  Subtotal
                </td>
                <td class="uk-text-right">
                  '.number_format($subtotal,2).'
                </td>
              </tr>
              <tr>
                <td colspan="6" class="uk-text-right">
                  IVA
                </td>
                <td class="uk-text-right">
                  '.number_format($iva,2).'
                </td>
              </tr>';
              $descuentoNum=$total*$descuentoCupon/100;
              if ($descuentoCupon>0) {
                echo '
                <tr>
                  <td colspan="6" class="uk-text-right">
                    Total
                  </td>
                  <td class="uk-text-right">
                    <del>'.number_format($total,2).'</del>
                  </td>
                </tr>
                <tr>
                  <td colspan="6" class="uk-text-right color-verde">
                    '.$descuentoCuponTxt.'
                    <i>'.$descuentoCupon.'% de descuento</i>
                  </td>
                  <td class="uk-text-right">
                    -'.number_format($descuentoNum,2).'
                  </td>
                </tr>
                <tr>
                  <td colspan="6" class="uk-text-right">
                    Total a pagar
                  </td>
                  <td class="uk-text-right">
                    '.number_format(($total-$descuentoNum),2).'
                  </td>
                </tr>';
              }else{
                echo '
                <tr>
                  <td colspan="6" class="uk-text-right">
                    Total
                  </td>
                  <td class="uk-text-right">
                    '.number_format($total,2).'
                  </td>
                </tr>';
              }
            }else{
              if (!isset($_SESSION['cupon'])) {
                echo '
                <tr>
                  <td colspan="6" class="uk-text-right">
                    Total
                  </td>
                  <td class="uk-text-right">
                    '.number_format($subtotal,2).'
                  </td>
                </tr>';
              }else{
                $descuentoNum=$subtotal*$descuentoCupon/100;
                echo '
                <tr>
                  <td colspan="6" class="uk-text-right">
                    Total
                  </td>
                  <td class="uk-text-right">
                    <del class="uk-text-muted">'.number_format($subtotal,2).'</del>
                  </td>
                </tr>
                <tr>
                  <td colspan="6" class="uk-text-right color-verde">
                    Cupón aplicado:
                    <b>'.$cupon.'</b>
                    <i>'.$descuentoCupon.'% de descuento</i>
                  </td>
                  <td class="uk-text-right">
                    -'.number_format($descuentoNum,2).'
                  </td>
                </tr>
                <tr>
                  <td colspan="6" class="uk-text-right">
                    Total a pagar
                  </td>
                  <td class="uk-text-right">
                    '.number_format(($subtotal-$descuentoNum),2).'
                  </td>
                </tr>';
              }
            }
          }
    echo '
        </tbody>
      </table>
    </div>
  </div>
  <div class="uk-width-1-1 uk-text-center padding-v-50">
    <div uk-grid class="uk-child-width-1-2@s">
      <div class="uk-text-right@m uk-text-center">
        <a href="#spinner" uk-toggle data-enlace="procesar-deposito" class="siguiente uk-button uk-button-personal">Depósito o transferencia</a>
      </div>
      '.$paypalbutton.'
    </div>
    <div uk-grid class="uk-child-width-1-2@s">
      <div class="uk-text-right@m uk-text-center">
        <img src="img/design/pago-oxxo.jpg">
      </div>
      <div class="uk-text-left@m uk-text-center">
        <img src="img/design/pago-paypal.jpg">
      </div>
    </div>
  </div>';
?>

</div>

<div class="padding-v-50">
</div>

<?=$footer?>

<div id="spinner" class="uk-modal-full" uk-modal>
  <div class="uk-modal-dialog uk-height-viewport uk-flex uk-flex-center uk-flex-middle">
    <div uk-spinner="ratio: 4">
    </div>
  </div>
</div>

<div id="editarinfopersonalmodal" uk-modal class="modal uk-modal-container" uk-modal>
  <div class="uk-modal-dialog uk-modal-body">
    <button class="uk-modal-close-default" type="button" uk-close></button>
    <p class="text-xl">Editar datos fiscales</p>

    <div class="uk-child-width-1-2@m" uk-grid>
      <div>
        <div>
          <h2>Personales</h2>
        </div>
        <div>
          <label for="nombre" class="uk-form-label uk-text-capitalize">nombre</label>
          <input type="text" data-campo="nombre" value="<?=$row_USER['nombre']?>" class="editarinfopersonalinput uk-input uk-input-grey">
        </div>
        <div>
          <label for="email" class="uk-form-label uk-text-capitalize">email</label>
          <input type="text" data-campo="email" value="<?=$row_USER['email']?>" class="editarinfopersonalinput uk-input uk-input-grey">
        </div>
        <div>
          <label for="telefono" class="uk-form-label uk-text-capitalize">telefono</label>
          <input type="text" data-campo="telefono" value="<?=$row_USER['telefono']?>" class="editarinfopersonalinput uk-input uk-input-grey">
        </div>
        <div>
          <label for="empresa" class="uk-form-label uk-text-capitalize">empresa</label>
          <input type="text" data-campo="empresa" value="<?=$row_USER['empresa']?>" class="editarinfopersonalinput uk-input uk-input-grey">
        </div>
        <div>
          <label for="rfc" class="uk-form-label uk-text-uppercase">rfc</label>
          <input type="text" data-campo="rfc" value="<?=$row_USER['rfc']?>" class="editarinfopersonalinput uk-input uk-input-grey uk-text-uppercase">
        </div>
      </div>
      <div>
        <div>
          <h2>Domicilio fiscal</h2>
        </div>
        <div>
          <label for="calle" class="uk-form-label uk-text-capitalize">calle</label>
          <input type="text" data-campo="calle" value="<?=$row_USER['calle']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
        <div>
          <label for="noexterior" class="uk-form-label uk-text-capitalize">no. exterior</label>
          <input type="text" data-campo="noexterior" value="<?=$row_USER['noexterior']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
        <div>
          <label for="nointerior" class="uk-form-label uk-text-capitalize">no. interior</label>
          <input type="text" data-campo="nointerior" value="<?=$row_USER['nointerior']?>" class="editarinfopersonalinput uk-input uk-input-grey">
        </div>
        <div>
          <label for="entrecalles" class="uk-form-label uk-text-capitalize">entrecalles</label>
          <input type="text" data-campo="entrecalles" value="<?=$row_USER['entrecalles']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
        <div>
          <label for="pais" class="uk-form-label uk-text-capitalize">pais</label>
          <input type="text" readonly value="México" class="uk-input uk-input-grey" >
        </div>
        <div>
          <label for="estado" class="uk-form-label uk-text-capitalize">estado</label>
          <input type="text" data-campo="estado" value="<?=$row_USER['estado']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
        <div>
          <label for="municipio" class="uk-form-label uk-text-capitalize">municipio</label>
          <input type="text" data-campo="municipio" value="<?=$row_USER['municipio']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
        <div>
          <label for="colonia" class="uk-form-label uk-text-capitalize">colonia</label>
          <input type="text" data-campo="colonia" value="<?=$row_USER['colonia']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
        <div>
          <label for="cp" class="uk-form-label uk-text-uppercase">cp</label>
          <input type="text" data-campo="cp" value="<?=$row_USER['cp']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
      </div>
    </div>
    <div class="uk-text-center uk-margin">
      <button class="uk-modal-close uk-button uk-button-default uk-button-large" type="button">Terminar</button>
    </div>
  </div>
</div>

<div id="domicilioentregamodal" uk-modal class="modal uk-modal-container" uk-modal>
  <div class="uk-modal-dialog uk-modal-body">
    <button class="uk-modal-close-default" type="button" uk-close></button>
    <p class="text-xl">Domicilio de entrega</p>

    <div class="uk-child-width-1-3@m" uk-grid>
      <div>
        <label for="calle" class="uk-form-label uk-text-capitalize">calle</label>
        <input type="text" data-campo="calle2" value="<?=$row_USER['calle2']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
      </div>
      <div>
        <label for="noexterior" class="uk-form-label uk-text-capitalize">no. exterior</label>
        <input type="text" data-campo="noexterior2" value="<?=$row_USER['noexterior2']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
      </div>
      <div>
        <label for="nointerior" class="uk-form-label uk-text-capitalize">no. interior</label>
        <input type="text" data-campo="nointerior2" value="<?=$row_USER['nointerior2']?>" class="editarinfopersonalinput uk-input uk-input-grey">
      </div>
      <div>
        <label for="entrecalles" class="uk-form-label uk-text-capitalize">entrecalles</label>
        <input type="text" data-campo="entrecalles2" value="<?=$row_USER['entrecalles2']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
      </div>
      <div>
        <label for="pais" class="uk-form-label uk-text-capitalize">pais</label>
        <input type="text" readonly value="México" class="uk-input uk-input-grey" >
      </div>
      <div>
        <label for="estado" class="uk-form-label uk-text-capitalize">estado</label>
        <input type="text" data-campo="estado2" value="<?=$row_USER['estado2']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
      </div>
      <div>
        <label for="municipio" class="uk-form-label uk-text-capitalize">municipio</label>
        <input type="text" data-campo="municipio2" value="<?=$row_USER['municipio2']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
      </div>
      <div>
        <label for="colonia" class="uk-form-label uk-text-capitalize">colonia</label>
        <input type="text" data-campo="colonia2" value="<?=$row_USER['colonia2']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
      </div>
      <div>
        <label for="cp" class="uk-form-label uk-text-uppercase">cp</label>
        <input type="text" data-campo="cp2" value="<?=$row_USER['cp2']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
      </div>
    </div>
    <div class="uk-text-center uk-margin">
      <button class="uk-modal-close uk-button uk-button-default uk-button-large" type="button">Terminar</button>
    </div>
  </div>
</div>


<?=$scriptGNRL?>

<script>

  $('.siguiente').click(function(){
    var enlace = $(this).attr("data-enlace");
    window.location = (enlace);
  });

  $(".editarinfopersonalinput").focusout(function() {
    var campo = $(this).attr("data-campo");
    var valor = $(this).val();
    $.ajax({
      method: "POST",
      url: "includes/acciones.php",
      data: { 
        editacliente: 1,
        campo: campo,
        valor: valor
      }
    })
    .done(function( response ) {
      console.log( response )
      datos = JSON.parse(response);
      UIkit.notification.closeAll();
      if (datos.estatus==0) {
        UIkit.notification(datos.msj);
      }
    });
  });

  UIkit.util.on('#editarinfopersonalmodal', 'hidden', function () {
    location.reload();
  });
  UIkit.util.on('#domicilioentregamodal', 'hidden', function () {
    location.reload();
  });

  $('#domicilioentregabutton').click(function(){
    var domicilio2 = $(this).attr("data-domicilio2");
    if (domicilio2==0) {
      domicilio2 = 1;
      $(this).removeClass("fa-square");
      $(this).removeClass("far");
      $(this).removeClass("uk-text-muted");
      $(this).addClass("fa-check");
      $(this).addClass("fas");
      $(this).addClass("color-verde");
    }else{
      domicilio2 = 0;
      $(this).removeClass("fa-check");
      $(this).removeClass("fas");
      $(this).removeClass("color-verde");
      $(this).addClass("fa-square");
      $(this).addClass("far");
      $(this).addClass("uk-text-muted");
    }
    $(this).attr("data-domicilio2",domicilio2);
    $.ajax({
      method: "POST",
      url: "includes/acciones.php",
      data: {
        domicilio2: domicilio2
      }
    })
    .done(function( response ) {
      console.log( response );
      datos = JSON.parse( response );
      if (datos.domicilio2==0) {
        location.reload();
      }
    });
  });

</script>

</body>
</html>