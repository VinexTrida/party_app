<?php
	$banconame = "festas";
	$username = "root";
	$password = "Carol1993@srv..";
	$host = 'localhost';

	$conn = new mysqli($host, $username, $password, $banconame);

	if($conn->error){
		die("falha ao conectar ao banco de dados : " . $conn->error);
	}
?>
