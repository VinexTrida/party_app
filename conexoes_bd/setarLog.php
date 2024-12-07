<?php
	include('conex.php');
	
	$stringRecebido = mysqli_real_escape_string($conn, $_POST['stringRecebido']);
	$nome = mysqli_real_escape_string($conn, $_POST['usuarioPagina']);
	$caixa = mysqli_real_escape_string($conn, $_POST['caixa']);
	$pagamento = mysqli_real_escape_string($conn, $_POST['formaPagamento']);
	$data = date('Y-m-d');
	$hora = date('H:i:s');
	$valor = mysqli_real_escape_string($conn, floatval($_POST['valor']));
	
	$resultado = mysqli_query($conn, "INSERT INTO `log` (`nome`, `caixa`, `pagamento`,`data`, `hora`, `info`, `valor`) VALUES ('$nome', '$caixa', '$pagamento', '$data', '$hora', '$stringRecebido', '$valor')");
	echo json_encode($resultado);
?>
