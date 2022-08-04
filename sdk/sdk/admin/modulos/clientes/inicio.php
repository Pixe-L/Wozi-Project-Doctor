<?php 
echo '
<div class="uk-width-1-1 margin-v-20">
	<ul class="uk-breadcrumb">
		<li><a href="index.php?rand='.rand(1,2000).'&modulo='.$modulo.'" class="color-red">'.$modulo.'</a></li>
	</ul>
</div>

<div class="uk-width-1-1 margin-bottom-20">
	<table class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-middle uk-table-responsive" id="ordenar">
		<thead>
			<tr>
				<th style="width:100px"></th>
				<th onclick="sortTable(1)" width="50px">ID</th>
				<th onclick="sortTable(2)">Nombre</th>
				<th onclick="sortTable(3)">Email</th>
				<th onclick="sortTable(4)" width="120px" class="uk-text-center">Alta</th>
				<th onclick="sortTable(5)" width="120px" class="uk-text-center">Pedidos</th>
				<th width="90px"></th>
			</tr>
		</thead>
		<tbody>';

		$consulta = $CONEXION -> query("SELECT * FROM usuarios ORDER BY nombre");
		$numRows = $consulta ->num_rows;
		while($rowConsulta = $consulta -> fetch_assoc()){
			$id=$rowConsulta['id'];
			$nivel=$rowConsulta['nivel'];
			$link='index.php?rand='.rand(1,1000).'&modulo=clientes&archivo=detalle&id='.$id;

			$CONSULTA1 = $CONEXION -> query("SELECT * FROM pedidos WHERE uid = $id");
			$numPedidos=$CONSULTA1->num_rows;

			$picDefault=$rutaFinal.'default.jpg';
			$picTxt='
				<div>
					<div class="uk-cover-container uk-border-circle" style="width:40px;height:40px;">
						<img src="'.$picDefault.'" uk-cover>
					</div>
				</div>';
			$pic=$rutaFinal.$rowConsulta['imagen'].'.jpg';
			if(strlen($rowConsulta['imagen'])>0 AND file_exists($pic)){
				$picTxt='
					<div class="uk-inline">
						<div class="uk-cover-container uk-border-circle" style="width:50px;height:50px;">
							<img src="'.$pic.'" uk-cover>
						</div>
						<div uk-drop="pos: right-justify">
							<img src="'.$pic.'" class="uk-border-rounded">
						</div>
					</div>';
			}

			echo '
			<tr>
				<td>
					<div uk-grid class="uk-grid-collapse">
						<div id="item'.$id.'" class="uk-flex uk-flex-middle" uk-width-auto@m >
							&nbsp;&nbsp; <i class="fas fa-circle color-white"></i>&nbsp;
						</div>
						<div>
							'.$picTxt.'
						</div>
					</div>
				</td>
				<td>
					<span class="uk-hidden@m uk-text-muted">ID:</span>
					'.$id.'
				</td>
				<td>
					<span class="uk-hidden@m uk-text-muted">Nombre:</span>
					'.$rowConsulta['nombre'].'
				</td>
				<td>
					<span class="uk-hidden@m uk-text-muted">Email:</span>
					'.$rowConsulta['email'].'
				</td>
				<td class="uk-text-center@m">
					<span class="uk-hidden@m uk-text-muted">Alta:</span>
					<span class="uk-hidden">'.date('Y-m-d',strtotime($rowConsulta['alta'])).'</span>
					'.date('d-m-Y',strtotime($rowConsulta['alta'])).'
				</td>
				<td class="uk-text-center@m">
					<span class="uk-hidden@m uk-text-muted">Pedidos:</span>
					'.$numPedidos.'
				</td>
				<td class="uk-text-nowrap">
					<button data-id="'.$id.'" class="eliminauser color-red" uk-icon="icon:trash"></button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="'.$link.'" class="uk-text-primary" uk-icon="search"></a>
				</td>
			</tr>';
		}

echo'
		</tbody>
	</table>
</div>

';


$scripts='
	$(".eliminauser").click(function() {
		var statusConfirm = confirm("Realmente desea eliminar este usuario?");
		var id=$(this).data("id");
		if (statusConfirm == true) { 
			window.location = ("index.php?rand='.rand(1,1000).'&modulo='.$modulo.'&borrarUser&id="+id);
		} 
	});
	


	// Verificar activos
	var w;
	function startWorker() {
	  if(typeof(Worker) !== "undefined") {
	    if(typeof(w) == "undefined") {
	      w = new Worker("../js/activityClient.js");
	    }
	    w.onmessage = function(event) {
			datos = JSON.parse(event.data);';
	// Usuarios
	$consulta = $CONEXION -> query("SELECT * FROM usuarios");
	while($rowConsulta = $consulta -> fetch_assoc()){
		$id = $rowConsulta['id'];
		$scripts.='
			$("#item'.$id.'").html(datos.estatus'.$id.');';
	}

	$scripts.='
	    };
	  } else {
	    document.getElementById("result").innerHTML = "Por favor, utiliza un navegador moderno";
	  }
	}
	startWorker();

	';