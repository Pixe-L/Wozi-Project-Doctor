
<div class="uk-width-auto margin-top-20 uk-text-left">
	<ul class="uk-breadcrumb">
		<?php 
		echo '
		<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$modulo.'" class="color-red">'.$modulo.'</a></li>
		';
		?>
	</ul>
</div>



<div class="uk-width-expand margin-top-20 uk-text-right">
	<a href="index.php?rand=<?=rand(1,1000)?>&modulo=<?=$modulo?>&archivo=nuevo" id="add-button" class="uk-button uk-button-success"><i uk-icon="icon: plus;ratio:1.4"></i> &nbsp; Nuevo</a>
</div>



<div class="uk-width-medium-1-1 margin-v-50">
	<table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-small uk-table-responsive">
		<thead>
			<tr>
				<th width="50px"></th>
				<th >Título</th>
				<th width="30px"></th>
			</tr>
		</thead>
		<tbody class="sortable" data-tabla="blog">
		<?php
		$blog = $CONEXION -> query("SELECT * FROM blog ORDER BY orden");
		while ($row_blog = $blog -> fetch_assoc()) {
			$prodID=$row_blog['id'];

			$blogpic = $CONEXION -> query("SELECT * FROM blogpic WHERE item = $prodID ORDER BY orden");
			$row_blogpic = $blogpic -> fetch_assoc();
			$picROW='';
			$pic=$rutaFinal.$row_blogpic['id'].'-nat500.jpg';
			if(file_exists($pic)){
				$picROW='
					<div class="uk-inline">
						<i uk-icon="camera"></i>
						<div uk-drop="pos: right-justify">
							<img uk-img data-src="'.$pic.'" class="uk-border-rounded">
						</div>
					</div>';
			}


			$link='index.php?rand='.rand(1,1000).'&modulo=blog&archivo=detalle&id='.$row_blog['id'];

			echo '
			<tr id="'.$row_blog['id'].'">
				<td>
					'.$picROW.'
				</td>
				<td class="uk-text-truncate">
					'.$row_blog['titulo'].'
				</td>
				<td>
					<a href="'.$link.'" class="uk-text-primary" uk-icon="search"></a>
				</td>
			</tr>';
		$picROW='';
		}
		?>

		</tbody>
	</table>
</div>

