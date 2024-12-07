<?php
	include('conex.php');
	$resultado = mysqli_query($conn, "SELECT nome, preco, quantidade, inerente, emUso, posicao, combo, itens, caixas FROM produtos ORDER BY posicao ASC");
	$produtos = array();

	while ($linha = mysqli_fetch_assoc($resultado)) {
		$produtos[$linha['nome']] = array(
			'preco' => $linha['preco'],
			'quantidade' => $linha['quantidade'],
			'inerente' => $linha['inerente'],
			'emUso' => $linha['emUso'],
			'posicao' => $linha['posicao'],
			'combo' => $linha['combo'],
			'itens' => $linha['itens'],
			'caixas' => $linha['caixas'],
		);
	}
	echo json_encode($produtos);
?>
