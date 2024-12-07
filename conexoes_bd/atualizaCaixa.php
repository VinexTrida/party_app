<?php
    include('conex.php');

    $nome = $_POST['nome'];
    $caixa = $_POST['caixa'];
    
    $resultado = mysqli_query($conn, "UPDATE usuarios SET caixa = $caixa WHERE nome = '$nome'");

    $data = ['text' => 'reduzir'];
    echo json_encode($nome);
?>
