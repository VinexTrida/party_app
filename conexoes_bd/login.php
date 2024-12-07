<?php
  include('conex.php');
  
  if(isset($_POST['nome']) || isset($_POST['senha'])){
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $sql_code = "SELECT * FROM usuarios WHERE nome = '$nome' AND senha = '$senha'";
    $sql_query = $conn->query($sql_code);

    $quantidade = $sql_query->num_rows;
    session_start();
  if($quantidade == 1){
    $usuario = $sql_query->fetch_assoc();
    
    $_SESSION['nome'] = $nome;
    $_SESSION['admin'] = $usuario['admin'];
    header("Location: ../paginas_web/caixa.php");
    
  }else{
      $_SESSION['nao_autenticado'] = true;
      header("Location: ../index.php");
      
    }
  }
  
?>
