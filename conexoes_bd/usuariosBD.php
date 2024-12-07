<?php
	include('conex.php');
	$resultado = mysqli_query($conn, "SELECT `nome`,`caixa` FROM `usuarios`");
	$usuarios = array();

	while ($linha = mysqli_fetch_assoc($resultado)) {
		$usuarios[$linha['nome']] = array(
			'caixa' => $linha['caixa']
		);
	}
	echo json_encode($usuarios);
?>