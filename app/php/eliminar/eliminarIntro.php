<?php
	session_start();
	require '../../../php/database.php';

if (isset($_SESSION['user_id'])) {
	$fotodata = $conn->prepare("SELECT foto FROM tblintroduccion WHERE id = :id");
	$fotodata->bindParam(":id", $_GET['id']);
	$fotodata->execute();
	$results = $fotodata->fetch(PDO::FETCH_ASSOC);
    if (count($results) > 0) {
      $foto = $results;
	  unlink("../../../img/".$foto['foto']);
    }
    $records = $conn->prepare('DELETE FROM tblintroduccion WHERE id = :id');
    $records->bindParam(":id", $_GET['id']);
	if($records->execute()) {
		header('location: ../../secciones/homea.php?p=verintro');
	}
}else{
  header('location: ../error.html');
}
?>
