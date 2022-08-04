<?php
$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE idmd5 = '$idmd5'");
$row_CONSULTA = $CONSULTA -> fetch_assoc();
$pedido=$row_CONSULTA['id'];
$user=$row_CONSULTA['uid'];

$CONSULTA1 = $CONEXION -> query("SELECT bank FROM configuracion WHERE id = 1");
$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();

$CONSULTA2 = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $user");
$row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
?>

<page
    orientation="paysage"

    backcolor="#ffffff"
    backimg="./img/design/logo-pdf.jpg"
    backimgx="0"
    backimgy="top"
    backimgw="145%"

    backtop="20px"
    backbottom="10px"
    backleft="70px"
    backright="70px"

    style="font-size: 10pt;">

    <br><br>
    <table cellspacing="0" style="width: 100%; text-align: left;">
        <tr>
            <td style="width:50%;">
                <table cellspacing="0" style="width: 100%; text-align: left;">
                    <tr>
                        <td>
                            <p>
                                <i>
                                    <b><u>Orden No</u>: &laquo; <?=$pedido?> &raquo;</b><br><br>
                                    Guadalajara, Jalisco, a <?=date('d-m-Y',strtotime($row_CONSULTA['fecha']))?>
                                </i>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width:50%;">
                <table cellspacing="0" style="width: 100%; text-align: left;">
                    <tr>
                        <td style="width:28%; text-align:right;">Cliente: &nbsp; </td>
                        <td style="width:72%"><?=$row_CONSULTA2['nombre']?></td>
                    </tr>
                    <tr>
                        <td style="width:28%; text-align:right;">Email: &nbsp; </td>
                        <td style="width:72%"><?=$row_CONSULTA2['email']?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <br><br><br><br>

    <?php
    echo $row_CONSULTA['tabla'].'
    <table cellspacing="0" style="width: 100%; text-align: center;">
        <tr>
            <td style="width:100%;">
                '.nl2br($row_CONSULTA1['bank']).'
            </td>
        </tr>
    </table>';
    ?>
    
</page>



