<?php
include('conex.php');
$data = [
    'text' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT emUso FROM produtos WHERE nome = '".$_POST['nome']."'"))['emUso']
];
echo json_encode($data);
?>
