<?php
	//Tela de sangria do caixa
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
	//Confere se o usuario tem permissão de administrador para poder acessar essa pagina, caso não, joga ele de volta para o index
  	if($_SESSION['admin'] !== '1'){
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
				height: 50px;
				width: 50px;
			}
			nav ul{
				height: 50px;
				margin: 0px;
				margin-bottom: 0px;
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
			.item{
				padding-left: 10px;
				margin-top: 2px;
				background-color: white;
				height: 65px;
				border-radius: 10px;
				font-size: 20px;	
				display: flex;
				align-items: center;
				position: relative;
			}
			.item button{
				font-size: 30px;
				font-weight: bold;
		
			}
			.item span{
				margin-left: 5px;
			}
			.item p{
				display:flex;
				margin-left: 10px;
				float: right;
				position:relative;			
			}
			.saque{
				background-color: #707070;
				width: 99.5%;
				height: 500px;
				border-radius: 20px;
				position: relative;
				display: column;
				top: 30%;
				left: 50%;
				transform: translate(-50%, -50%);
				justify-content: center;
				text-align: center;
				color: black;
				font-size: 35px;
			}
			.saque input{
				height: 25px;
				position: relative;
				top: 30%;
			}
			.titulo{
				border-top: 50px;
				margin-bottom: 100px;
				font-size: 50px;
			}
			.tituloCaixa{
				position: relative;
				top: 16%;
			}
			.operadores{
				position: relative;
				top: 16%;
				font-size:30px;
				border-radius: 5px;
				width:98%;
				text-align: center;
			}
			.tituloValor{
				position: relative;
				top: 26%;
			}
	
			.valor{
				width:98%;
				height: 37px!important;
				font-size: 30px;
				border-radius: 5px;
				border: none;
				text-align: center;
			}
			.botaoEnviar{
				font-size: 35px;
				height: 50px!important;
				background-color: transparent;
				border: 3px solid black;
				border-radius: 10px;
				color: black;
			}
			.final-pagina{
				height:	60px;
				margin-left: -8px;
				width: 100%;
				background-color: #707070;
				bottom: 0;
				align-items: center;
				display: flex;
				justify-content: center;
				font-size: 25px;
				position: absolute;
			}
			.valorSubTotal{
				margin-right: 20px;
			}
			.final-pagina-espaco{
				height: 60%;
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
		<div id="foco" class="saque">
			<br>
			<text class="titulo">Sangria</text>
			<br>
			<text class="tituloCaixa">Informe o operador para a retirada:</text>
			<br>
			<select id="operadoresRetirada" class="operadores"></select>
			<br>
			<text class="tituloValor">Informe o valor da retirada:</text>
			<br>
			<input id="valorRetirada" class="valor" type="text" inputmode="decimal">
			<br>
			<br>
			<br>
			
			<div class="final-pagina-espaco"></div>
		</div>
		<div class="final-pagina" action="finalizaVenda.php">
			<input class="botaoEnviar"type="button" value="Gerar" onclick="geraSangria()">
		</div>
	</body>
	<?php include('../codigos_js/codigosAdminSaqueCaixa.php')?>
</html>
