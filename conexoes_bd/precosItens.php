<?php
	include('conex.php');
	$resultado = mysqli_query($conn, "SELECT nome, preco FROM produtos");
	$precos = array();

	while($linha = mysqli_fetch_assoc($resultado)){
		$precos[$linha['nome']] = $linha['preco'];
	}
	
	echo json_encode($precos);
?>

