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
				background-color: #a0b7d7;
			}
			button{
				border: none;
				background-color: transparent;
				height: 50px;
				width: 50px;
			}
			.menu{
				background-color: #4d81be; 
				display: block;
				margin-top: -7px;
				margin-left: -8px;
				margin-right: -7px;
	  			overflow: auto;
			}
			.menu button{
				width: 175px!important;
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
			    background-image: url('../imagens/reimprimir/voltar.png');
			    background-repeat: no-repeat;
	    	    background-position: 123px center;
	    	    background-size: 32px 32px;
			}
			.redirect:hover{
				letter-spacing: 2px;
				background-color: rgba(255, 255, 255, 0.3);
				background-position: 127px center;
			}
			.item{
				padding-left: 10px;
				margin-top: 15px;
				background-color: #e4e8f0;
				height: 65px;
				border-radius: 10px;
				font-size: 20px;	
				display: grid;
				align-items: center;
				position: relative;
			}
			.item button{
				font-size: 20px;
			    width: 210px;
			    float: right;
			    color: black;
			    transform: translateY(-28%);
			    position:relative;	
			    transition: background-color 0.2s;
			    font-size: 25px;
			    background-image: url('../imagens/reimprimir/impressora.png');
			    background-repeat: no-repeat;
	    	    background-position: 170px 5px;
	    	    background-size: 35px 35px;
			}	
			.item span{
				margin-left: 10px;
				float: left;
				position:relative;
				top: 10px			
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
