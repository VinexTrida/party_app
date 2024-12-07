<?php
	//Tela de cupons cortesia
	//Redirecionamento direto da tela de vendas do caixa
	
	//Chamada do arquivo de conexão com o banco de dados
	include('../conexoes_bd/conex.php');
	session_start();
	
	//Confere se o usuario logou na sessão, caso não, joga ele de volta pro index
	if(!isset($_SESSION['nome'])){
		session_destroy();
		header("Location: ../index.php");
		exit;
	}
	//Verifica a opção de redirecionamento que o usuario escolheu
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		//Volta para a pagina de vendas
		if(isset($_POST['voltar'])){
			header("Location: caixa.php");
			exit;
		}
	}
?>

<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script src="../node_modules/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
<html>
	<head>
		<style type="text/css">
			body{
	  			box-sizing: border-box;
				background-color: #2f2e2e;
			}
			img{
				height: 100px;
				width: auto;
			}
			button{
				border: none;
				background-color: transparent;
			}
			nav ul{
				height: 50px;
				margin: 0px;
				padding: 0px;
			}
			nav li{
				display: inline-block;
				float: right;
			}
			nav li button{
				display: inline-block;
			}
			.menu{
				background-color: #707070; 
				display: block;
				margin-top: -7px;
				margin-left: -8px;
				margin-right: -7px;
			}
			.redirect{
				width: 150px;
				transition: letter-spacing 0.2s;
				height: 50px;
				display: block;
				float: right;
				color: black;
				cursor: pointer;
				transition: background-color 0.2s;
				font-size: 25px;
			}
			.redirect:hover{
				letter-spacing: 2px;
				background-color: rgba(255, 255, 255, 0.3);
			}
		</style>
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Caixa</title>
	</head>
	
	<body>
		<div class="menu">
			<form method="post">
				<nav>
					<ul>
						<li>
							<button class="redirect" name='voltar'>voltar</button>
						</li>
					</ul>
				</nav>
			</form>
		</div>
		<div class="itens" id="itens">
            <div class="cadastrarItem" id="cadastrarItem" style="display: block;">
				<center>
					<h3>Informe os dados do novo produto</h3>
					<br>
					<span>Nome:</span>
					<input type="text" id="nomeProduto" list="listaProdutos">
					<datalist id="listaProdutos"></datalist>
					<br>
					<span>Preço:</span>
					<input type="text" inputmode="decimal" id="precoProduto">
					<br>
					<span>Quantidade:</span>
					<input type="number" id="quantidadeProduto">
					<br>
					<button onclick="realizarEstorno()">Estornar</button>
					<br>
					<button onclick="cancelarEstorno()">Cancelar</button>
				</center>
			</div>
        </div>
	</body>
	<?php include('../codigos_js/codigosAdminDevolucoes.php')?>
</html>