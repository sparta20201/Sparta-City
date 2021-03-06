<?php 
if (!empty($_POST['titulo']) and !empty($_POST['parrafo']) and !empty($_FILES['imagen'])) {
	if($_FILES['imagen']['type']=="image/jpeg" or $_FILES['imagen']['type']=="image/png" or $_FILES['imagen']['type']=="image/jpg"){
		/*Cambiar el nombre del archivo*/
		$nombrefoto = $conn->prepare("SELECT id FROM tblgaleriainicio ORDER BY id DESC LIMIT 1");
		$nombrefoto->execute();
		if ($nombrefoto->rowCount() > 0){
			foreach ($nombrefoto as $nuevonombre) {
				$nombreimg = $nuevonombre['id'] + 1;
			}
		}else{
			$nombreimg = 1;
		}
		if ($_FILES['imagen']['type']=="image/jpeg") {
			$nombreimg = $nombreimg.".jpeg";
		}elseif ($_FILES['imagen']['type']=="image/png") {
			$nombreimg = $nombreimg.".png";
		}elseif ($_FILES['imagen']['type']=="image/jpg") {
			$nombreimg = $nombreimg.".jpg";
		}else{
			$message = "Error al cambiar el nombre.";
		}
		$sql = "INSERT INTO tblgaleriainicio (titulo,parrafo,foto) VALUES (:titulo,:parrafo,:imagen)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':titulo', $_POST['titulo']);
		$stmt->bindParam(':parrafo', $_POST['parrafo']);
		/*insertar una imagen al servidor*/
		$stmt->bindParam(':imagen', $ruta);
		$archivo=$_FILES['imagen']['tmp_name'];
		$ruta='introduccion/'.$nombreimg;
		move_uploaded_file($archivo, '../../img/'.$ruta);
		/*------------------------------*/
		   
		if ($stmt->execute()) {
		  $message = 'Foto subida';
		} else {
		  $message = 'No se pudo guardar la foto';
		}
	}else{
		$message = " <br> Archivos no permitidos. <br> Solo se permite JPG, JPEG Y PNG.";
	}


}

if (!empty($_POST['titulo']) and !empty($_POST['parrafo'])) {
	if(!empty($_FILES['imagen-act'])){
		if ($_FILES['imagen-act']['type']=="image/jpeg" or $_FILES['imagen-act']['type']=="image/png" or $_FILES['imagen-act']['type']=="image/jpg") {
			$nombrefoto = $conn->prepare("SELECT id FROM tblgaleriainicio ORDER BY id DESC LIMIT 1");
			$nombrefoto->execute();
			if ($nombrefoto->rowCount() > 0){
				foreach ($nombrefoto as $nuevonombre) {
					$nombreimg = $nuevonombre['id'] + 1;
				}
			}else{
				$nombreimg = 1;
			}
			if ($_FILES['imagen-act']['type']=="image/jpeg") {
				$nombreimg = $nombreimg.".jpeg";
			}elseif ($_FILES['imagen-act']['type']=="image/png") {
				$nombreimg = $nombreimg.".png";
			}elseif ($_FILES['imagen-act']['type']=="image/jpg") {
				$nombreimg = $nombreimg.".jpg";
			}else{
				$message = "Error al cambiar el nombre.";
			}
			$sql = "INSERT INTO tblgaleriainicio (titulo,parrafo,foto) VALUES (:titulo,:parrafo,:imagen)";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':titulo', $_POST['titulo']);
			$stmt->bindParam(':parrafo', $_POST['parrafo']);
			/*insertar una imagen al servidor*/
			$stmt->bindParam(':imagen', $ruta);
			$archivo=$_FILES['imagen']['tmp_name'];
			$ruta='introduccion/'.$nombreimg;
			move_uploaded_file($archivo, '../../img/'.$ruta);
		}else{
			$message = " <br> Archivos no permitidos. <br> Solo se permite JPG, JPEG Y PNG.";
		}
	}elseif (!empty($_POST['fotor-act'])) {
			$sql = "INSERT INTO tblgaleriainicio (titulo,parrafo,foto) VALUES (:titulo,:parrafo,:imagen)";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':titulo', $_POST['titulo']);
			$stmt->bindParam(':parrafo', $_POST['parrafo']);
			$stmt->bindParam(':imagen', $_POST['fotor-act']);
	}
	if ($stmt->execute()) {
	  $message = 'Foto subida';
	} else {
	  $message = 'No se pudo guardar la foto';
	}
}
?>
<link rel="stylesheet" type="text/css" href="../css/tablas-Style/dataTables.bootstrap.css">
<link rel="stylesheet" type="text/css" href="../css/tablas-Style/dataTables.responsive.css">
<!-- Content page -->
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-book zmdi-hc-fw"></i><?= $user['tipo']; ?><small> - Galería de Presentaión</small></h1>
	</div>
	<p class="lead">Galería! 
		<?php if(!empty($message)){
			echo $message;
		}?>
	</p>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<ul class="nav nav-tabs" style="margin-bottom: 15px;">
			  	<li class="active"><a href="#list" data-toggle="tab">Galería</a></li>
				<li><a href="#new" data-toggle="tab">Nueva Foto</a></li>
			</ul>
			<div id="myTabContent" class="tab-content">
				<div class="tab-pane fade" id="new">
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12 col-md-10 col-md-offset-1">
							    <form method="post" enctype="multipart/form-data">
									<div class="form-group label-floating">
									  <label class="control-label">Título</label>
								       <input type="text" class="form-control" name="titulo" required>
									</div>
									<div class="form-group label-floating">
									  <label class="control-label">Párrafo</label>
								       <input type="text" class="form-control" name="parrafo" required>
									</div>
								    <div class="form-group">
								      <label class="control-label">Imagen</label>
								      <div>
								        <input type="text" readonly class="form-control" placeholder="Selecciona una imagen...">
								        <input type="file" name="imagen" >
								      </div>
								    </div>
								    <p class="text-center">
								    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i>Guardar</button>
								    </p>
							    </form>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade active in" id="list">
					<div id="page-wrapper"> 
						<!-- /.row -->
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">

									<!-- /.panel-heading -->
									<div class="panel-body">
										<table id="dataTables-example" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
										<!--<table id="customers">-->
										<thead>
										<tr>
										<th class="text-center">Título</th>
										<th class="text-center">Párrafo</th>
										<th class="text-center">Foto</th>
										<th class="text-center">Modificar</th>
										<th class="text-center">Eliminar</th>
										</tr>
										</thead>
										<?php 
										$records1 = $conn->prepare('SELECT * FROM tblgaleriainicio');
										$records1->execute();
										while($results1 = $records1->fetch(PDO::FETCH_ASSOC)) { 
										?>
										<tr class="gradeA">
										<td class="text-center"><?php echo $results1['titulo']; ?></td>
										<td class="text-center"><?php echo $results1['parrafo']; ?></td>
										<td class="text-center dashboard-sideBar-UserInfo"><figure><?php echo '<img src="../../img/'.$results1['foto'].'" width="100" height="100">'; ?></figure></td>
										<td class="text-center"><a class="btn btn-success btn-raised btn-xs" type="button" data-toggle="modal" data-target="#ActualizarPresentacion<?php echo $results1['id']; ?>"><i class="zmdi zmdi-refresh"></i></a></td>

										<td class="text-center"><a href='../php/eliminar/eliminarPresen.php?id=<?php echo $results1['id']; ?>' class="btn btn-danger btn-raised btn-xs" onclick="return confirm('¿Estas seguro que desea eliminar la presentación?\n <?php echo $results1['foto']; ?>');"><i class="zmdi zmdi-delete"></i></a></td>
										</tr>
										<div class="modal fade" id="ActualizarPresentacion<?php echo $results1['id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
											  <div class="modal-dialog">
											    <div class="modal-content">
											      <div class="modal-header">
											        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											          <span aria-hidden="true">&times;</span>
											        </button>
											      </div>
											      <div class="modal-body">
											        <form method="post" enctype="multipart/form-data">
														<div class="form-group label-floating">
														  <label class="control-label">Título</label>
													       <input type="text" class="form-control" name="titulo-act" required value="<?php echo $results1['titulo']; ?>">
														</div>
														<div class="form-group label-floating">
														  <label class="control-label">Párrafo</label>
													       <input type="text" class="form-control" name="parrafo-act" required value="<?php echo $results1['parrafo']; ?>">
														</div>
													    <div class="form-group">
													      <label class="control-label">Imagen</label>
													      <div>
													      	<input type="hidden" name="fotor-act" value="<?php echo $results1['foto']; ?>">
													        <input type="text" readonly class="form-control" placeholder="Selecciona una imagen...">
													        <input type="file" name="imagen-act" >
													      </div>
													    </div>
											      </div>
											      <div class="modal-footer">
											        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

													<button type="submit" class="btn btn-info btn-raised btn-sm">Actualizar </button>
												    </form>
											      </div>
											    </div>
											  </div>
											</div>
										<?php 
										} 
										?>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>			
				</div>
			</div>
		</div>
	</div>
</div>
<!-- DataTables JavaScript Traducir-->
<script src="../js/tablas-Scripts/jquery.js"></script>
<script src="../js/tablas-Scripts/jquery.dataTables.js"></script>
<script src="../js/tablas-Scripts/dataTables.bootstrap.js"></script>
<script src="../js/tablas-Scripts/dataTables.responsive.js"></script>
<script>
	$(document).ready(function() {
		$('#dataTables-example').DataTable({
		responsive: true
		});
	});
</script>