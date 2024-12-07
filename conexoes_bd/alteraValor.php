<?php
    include('conex.php');

    $nome = $_POST['nome'];
    $quantidade = floatval($_POST['quantidade']);
    
    $resultado = mysqli_query($conn, "UPDATE produtos SET preco = $quantidade WHERE nome = '$nome'");

    $data = ['text' => 'reduzir'];
    echo json_encode($nome);
?>

