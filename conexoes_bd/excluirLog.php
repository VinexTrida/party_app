<?php
    include('conex.php');

    $id = $_POST['id'];
    
    $resultado = mysqli_query($conn, "DELETE FROM log WHERE id = '$id'");

    $data = ['text' => 'reduzir'];
    echo json_encode($data);
?>
