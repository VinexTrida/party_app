<?php
	include('conex.php');
	
	$consulta = $_POST['consulta'];
	$resultado = mysqli_query($conn, "SELECT `id`, `nome`, `caixa`, `pagamento`, `data`, `hora`, `info`, `valor` FROM `log` WHERE $consulta");
	$produtos_temp = array();

	while ($linha = mysqli_fetch_assoc($resultado)) {
		$produtos_temp[$linha['id']] = array(
			'id' => $linha['id'],
			'nome' => $linha['nome'],
			'caixa' => $linha['caixa'],
			'pagamento' => $linha['pagamento'],
			'data' => $linha['data'],
			'hora' => $linha['hora'],
			'info' => $linha['info'],
			'valor' => $linha['valor']
		);
	}
	$produtos = array_reverse($produtos_temp);
	echo json_encode($produtos);
?>
