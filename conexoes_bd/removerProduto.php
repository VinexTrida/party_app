<?php
    include('conex.php');

    $nome = $_POST['nome'];
    
    $resultado = mysqli_query($conn, "DELETE FROM `produtos` WHERE nome = '$nome'");

    $data = ['text' => 'reduzir'];
    echo json_encode($data);
?>
