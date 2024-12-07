<?php
	include('conex.php');

    $chave = $_POST['chave'];
    $posicao = intval($_POST['posicao']);

	$resultado = mysqli_query($conn, "UPDATE produtos SET posicao = $posicao WHERE nome = '$chave'");
    echo true;
?>
