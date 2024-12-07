<?php
	include('conex.php');
	
	$caixas = $_POST['caixas'];
	$nome = $_POST['nome'];
	
	$resultado = mysqli_query($conn, "UPDATE produtos set caixas = '$caixas' where nome = '$nome';");

        echo json_encode('true');
?>
