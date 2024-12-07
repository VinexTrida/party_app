<?php
	//Tela que mostra as compras que esse usuario fez no dia atual
	//Redirecionamento direto da tela de vendas(caixa)
	
	//Chamada do arquivo de conexão com o banco de dados
	include('../conexoes_bd/conex.php');
	session_start();
	
	//Confere se o usuario logou na sessão, caso não, joga ele de volta pro index
	if(!isset($_SESSION['nome'])){
		session_destroy();
		header("Location: ../index.php");
		exit;
	}
	//Volta para a tela de vendas
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(isset($_POST['Voltar'])){
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
			button{
				border: none;
				background-color: transparent;
				height: 50px;
				width: 50px;
			}
			.menu{
				background-color: #707070; 
				display: block;
				margin-top: -7px;
				margin-left: -8px;
				margin-right: -7px;
	  			overflow: auto;
			}
			.menu button{
				width: 85px!important;
			}
			.redirect{
				width: 50px;
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
				height: 60px;
				border-radius: 10px;
				font-size: 20px;	
				display: grid;
				align-items: center;
				position: relative;
			}
			.item button{
				font-size: 20px;
				width: auto!important;
				float: right;
				top: 50%;
				transform: translateY(-35%);
				position:relative;	
			}	
			.item span{
				margin-left: 10px;
				float: left;
				position:relative;			
			}
			
		</style>
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Caixa</title>
	</head>
	<body>
		<div class="menu">
			<form method="post">
				<button class="redirect" name='Voltar'>Voltar</button>
			</form>
		</div>
		<div class="itens" id="itens"></div>
		
		<?php include('../codigos_js/codigosLogVendas.php')?>
	</body>
</html>
