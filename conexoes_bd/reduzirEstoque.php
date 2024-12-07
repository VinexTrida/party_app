<?php
    include('conex.php');

    $nome = $_POST['nome'];
    $quantidade = intval($_POST['quantidade']);
    
    $resultado = mysqli_query($conn, "UPDATE produtos SET quantidade = $quantidade WHERE nome = '$nome'");

    $data = ['text' => 'reduzir'];
    echo json_encode($nome);
?>

