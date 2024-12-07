<?php
    include('conex.php');

    $nome = $_POST['nome'];
    $caixa = $_POST['caixa'];
    
    $resultado = mysqli_query($conn, "INSERT INTO usuarios(`nome`, `caixa`, `senha`, `admin`) VALUES ('$nome','$caixa','456852','0')");

    $data = ['text' => 'reduzir'];
    echo json_encode($data);
?>
