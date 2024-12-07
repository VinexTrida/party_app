<?php
	include('conex.php');
	$nome = $_POST['nome'];
	$resultado = mysqli_query($conn, "SELECT caixa FROM usuarios where nome = '$nome'");

	$caixa = mysqli_fetch_assoc($resultado)['caixa'];

        echo json_encode($caixa);
?>
