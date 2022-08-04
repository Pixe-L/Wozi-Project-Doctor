<?php
$archivoes[] = array(
	  'title' => 'Tallas',
    'archivo' => 'cfgtallaclasif',
	   'icon' => 'file');

$archivoes[] = array(
	  'title' => 'Colores',
    'archivo' => 'cfgcolores',
	   'icon' => 'palette');

$archivoes[] = array(
	  'title' => 'Marcas',
    'archivo' => 'cfgmarcas',
	   'icon' => 'copyright');

$archivoes[] = array(
	  'title' => 'Catálogo',
    'archivo' => 'catalogo',
	   'icon' => 'file-pdf');

$archivoes[] = array(
	  'title' => 'Contacto',
    'archivo' => 'contacto',
	   'icon' => 'envelope');

$archivoes[] = array(
	  'title' => 'cupones',
	'archivo' => 'cupones',
	   'icon' => 'ticket');

$archivoes[] = array(
	  'title' => 'FAQ',
    'archivo' => 'faq',
	   'icon' => 'question');

$archivoes[] = array(
	  'title' => 'Generales',
    'archivo' => 'general',
	   'icon' => 'cogs');

$archivoes[] = array(
	  'title' => 'Nosotros',
    'archivo' => 'about',
	   'icon' => 'copyright');

$archivoes[] = array(
	  'title' => 'Políticas',
    'archivo' => 'politicas',
	   'icon' => 'info');

$archivoes[] = array(
	  'title' => 'Respaldos',
    'archivo' => 'respaldar',
	   'icon' => 'server');

$archivoes[] = array(
	  'title' => 'Slider',
    'archivo' => 'slider',
	   'icon' => 'images');

$archivoes[] = array(
	  'title' => 'Usuarios',
    'archivo' => 'usuarios',
	   'icon' => 'users');


echo '
<div class="uk-width-auto@m margin-top-20">
	<ul class="uk-breadcrumb uk-text-capitalize">
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'" class="color-red">Configuración</a></li>
	</ul>
</div>';


echo '
<div class="uk-width-1-1">
	<div class="uk-container" style="max-width:1000px;">
		<div uk-grid class="uk-flex-center uk-grid-small" style="margin-top: 30px;">';

		foreach ($archivoes as $key => $value) {
			echo '
			<div class="uk-width-auto">
				<a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&archivo='.$value['archivo'].'">
					<div class="uk-card uk-card-default uk-flex uk-flex-center uk-flex-middle uk-text-center uk-text-capitalize" style="width: 180px;height: 180px;">
						<div>
							<i class="fa fa-3x fa-'.$value['icon'].'"></i>
							<br><br>
							'.$value['title'].'
						</div>
					</div>
				</a>
			</div>';
		}

		echo '
		</div>
	</div>
</div>';



