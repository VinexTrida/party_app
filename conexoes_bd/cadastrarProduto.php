<?php
    include('conex.php');

    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $quantidade = intval($_POST['quantidade']);
    $ilimitado = $_POST['ilimitado'];
    $emUso = $_POST['emUso'];
    $posicao = $_POST['posicao'];
    $combo = $_POST['combo'];
    $itens = $_POST['itens'];
    
    $resultado = mysqli_query($conn, "INSERT INTO `produtos`(`nome`, `preco`, `quantidade`, `inerente`, `emUso`, `posicao`, `combo`, `itens`) VALUES ('$nome','$preco','$quantidade','$ilimitado','$emUso', '$posicao', '$combo', '$itens')");

    $data = ['text' => 'reduzir'];
    echo json_encode($data);
?>

