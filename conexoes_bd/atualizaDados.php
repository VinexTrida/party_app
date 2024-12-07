<?php
	include('conex.php');
	$resultado = mysqli_query($conn, "SELECT id, nome, quantidade, inerente, combo, itens FROM produtos");
	$produtos = array();

	while ($linha = mysqli_fetch_assoc($resultado)) {
		$produtos[$linha['nome']] = array(
			'id' => $linha['id'],
			'quantidade' => $linha['quantidade'],
			'inerente' => $linha['inerente'],
			'combo' => $linha['combo'],
			'itens' => $linha['itens']
		);
	}
	echo json_encode($produtos);
?>
