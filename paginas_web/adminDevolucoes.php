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
				background-color: #a0b7d7;
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
			h3{
				margin: 10px;
			}
			.menu{
				background-color: #4d81be; 
				display: block;
				margin-top: -7px;
				margin-left: -8px;
				margin-right: -7px;
			}
			.redirect{
				width: 170px;
				transition: letter-spacing 0.2s;
				height: 50px;
				display: block;
				float: right;
				color: white;
				cursor: pointer;
				padding-right: 25px;
				transition: background-color 0.2s;
				font-size: 29px;
				background-image: url('../imagens/devolucoes/voltar.png');
				background-repeat: no-repeat;
	    		background-position: 123px center;
	    		background-size: 32px 32px;
			}
			.redirect:hover{
				letter-spacing: 2px;
				background-color: rgba(255, 255, 255, 0.3);
				background-position: 127px center;
			}
			.div-branco{
				background-color: white;
				border-radius: 50px;
			}
			.div-item{
				background-color: #e4e8f0;
				margin-bottom: 10px;
				border-radius: 10px;
                padding-top: 15px;
				margin-top: 20px;
				font-size: 30px;
			}
			.div-item input{
				width: 100%;
				border-radius: 10px;
				border: none;
				font-size: 30px;
			}
			.titulo{
				padding-bottom: 20px;
			}
			.final-pagina{
				height:	60px;
				margin-left: -8px;
				width: 100%;
				background-color: white;
				bottom: 0;
				align-items: center;
				display: flex;
				justify-content: center;
				font-size: 25px;
				position: absolute;
			}
			.botaoEnviar{
				font-size: 35px;
				height: 50px!important;
				background-color: transparent;
				border: 3px solid black;
				border-radius: 10px;
				color: black;
			}
			.operadores{
				position: relative;
				top: 16%;
				font-size:30px;
				border-radius: 5px;
				width:100%;
				text-align: center;
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
							<button class="redirect" name='voltar'>Voltar</button>
						</li>
					</ul>
				</nav>
			</form>
		</div>
		<div class="itens" id="itens">
            <div class="cadastrarItem" id="cadastrarItem" style="display: block;">
				<center>
					<div class="div-item titulo">
						<h3>Informe o produto para Devolução</h3>
					</div>
					<div class="div-item nome">
						<span>Nome</span>
						<div class="div-branco">
							<select id="nomeProduto" class="operadores"></select>	
						</div>
					</div>
					<div class="div-item preco">
						<span>Preço</span>
						<div class="div-branco">
							<input type="text" inputmode="decimal" id="precoProduto">
						</div>
					</div>
					<div class="div-item quantidade">
						<span>Quantidade</span>
						<div class="div-branco">
							<input type="number" id="quantidadeProduto">	
						</div>
					</div>
					<div class="div-item caixa">
						<span>Caixa</span>
						<div class="div-branco">
							<select id="operadoresRetirada" class="operadores"></select>	
						</div>
					</div>
					<div class="final-pagina" action="finalizaVenda.php">
						<button class="botaoEnviar" onclick="realizarEstorno()">Estornar</button>
					</div>
				</center>
			</div>
        </div>
	</body>
	<?php include('../codigos_js/codigosAdminDevolucoes.php')?>
</html>