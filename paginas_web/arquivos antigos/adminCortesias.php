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
			.dropdown-menu{
				margin-top:50px;
				position: absolute;
				display: none;
				background-color: #707070;
			}
			.dropdown-menu button{
				display: block;
				color: black;
				font-size: 25px;
				width: 150px;
			}
			.dropdown:hover .dropdown-menu{
				display: block;
				z-index: 2;
			}
			.dropdown-button:hover{
				letter-spacing: 2px;
				background-color: rgba(255, 255, 255, 0.3);
			}
			.config{
				width: 150px;
				background-image: url('../imagens/config.png');
				background-repeat: no-repeat;
	    			background-position: center center;
	    			background-size: 50px 50px;
	    			transition: background-size 0.2s;
	    			height: 50px;
				display: block;
				float: right;
				color: black;
				cursor: pointer;
				transition: background-color 0.2s;

			}
			.config:hover{
				background-size: 60px 60px;
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
			.menos{
				color: red;
			}
			.mais{
				color: #009400;
			}
			.item p{
				display:flex;
				margin-left: 10px;
				float: right;
				position:relative;			
			}
			.preco{
				text-decoration: line-through;
			}
			.botoes{
				position: absolute;
				right: 10px;
				margin-left: auto;
				top: 50%;
				transform: translateY(-50%);
				font-size: 30px;  
			}
			.insert{
				width: 40px;
				height: 30px;
				font-size: 20px;
				border: none;
				text-align: center;
			}
			.final-pagina{
				height:	50px;
				margin-left: -8px;                   
				width: 100%;
				background-color: #707070;
				bottom: 0;
				position: fixed;
				align-items: center;
				display: flex;
				justify-content: flex-end;
				font-size: 25px;
			}
			.valorSubTotal{
				margin-right: 20px;
			}
			.final-pagina-espaco{
				height: 45px;
			}
			.formSubTotal{
				margin-right: 70px;
				height:	50px;
				font-size: 25px;
				display: flex;
			}
			.enviaSubTotal{
				transform: translateY(25%);
				height:	50px;
				font-size: 25px;
			}
			.quantidade{
				position: absolute;
				right: 20px;
				margin-left: auto;
				margin-right: 130px;
				top: 50%;
				transform: translateY(-50%);
				border-radius: 5px;
				color: black;
				font-weight: bold;
			}
			.valoresListaEnvio{
				display: none;
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
		<div class="itens" id="itens"></div>
		<div class="final-pagina-espaco"></div>
				     
		<div class="final-pagina" action="finalizaVenda.php"> 
			<p class="valorSubTotal">Valor total estimado <span id="subTotal">0</span></p> 
			<form method="post" id="formularioSubTotal" action="finalizaVendaCortesia.php" class="formSubTotal" onsubmit="return validarEnvio()">
				<button class="enviaSubTotal" id="enviaSubTotal" name='enviaSubTotal' value="0">SubTotal</button>
				<input type="text" class="valoresListaEnvio" id="valoresLista" value="">
			</form>
		</div>
	</body>
	<?php include('../codigos_js/codigosAdminCortesias.php')?>
</html>
