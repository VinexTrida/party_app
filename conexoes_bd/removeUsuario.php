<?php
    include('conex.php');

    $nome = $_POST['nome'];
    
    $resultado = mysqli_query($conn, "DELETE FROM usuarios WHERE nome = '$nome' and admin = 0");

    $data = ['text' => 'reduzir'];
    echo json_encode($data);
?>
