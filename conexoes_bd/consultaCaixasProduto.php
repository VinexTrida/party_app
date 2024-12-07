<?php
	include('conex.php');
	$resultado = mysqli_query($conn, "SELECT nome, caixas FROM produtos");
	$precos = array();

	while($linha = mysqli_fetch_assoc($resultado)){
		$precos[$linha['nome']] = $linha['caixas'];
	}
	
	echo json_encode($precos);
?>