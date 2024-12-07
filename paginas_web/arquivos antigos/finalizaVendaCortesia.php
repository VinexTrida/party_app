<?php
	//Tela de finalização da venda
	//Redirecionamento direto da tela de vendas(caixa.php)
	
	//Chamada do arquivo de conexão com o banco de dados
	include('../conexoes_bd/conex.php');
	session_start();
	
	//Confere se o usuario logou na sessão, caso não, joga ele de volta para o index
	if(!isset($_SESSION['nome'])){
		session_destroy();
		header("Location: ../index.php");
		exit;
	}
	//Verifica a opção de redirecionamento que o usuario escolheu
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		//Volta para a pagina de vendas restaurando o pedido atual
		if(isset($_POST['voltar'])){
			//Variavel da sessão que informa se a pagina de vendas deve voltar os itens da pedido atual ou zerar o pedido
			$_SESSION['carregaBody'] = 1;
			header("Location: adminCortesias.php");
			exit;
		}
		//Volta para a pagina de vendas zerando o pedido
		if(isset($_POST['sair'])){
			header("Location: adminCortesias.php");
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
				background-color: #2f2e2e;
				font-size: 40px;
			}
			button{
				border: none;
				background-color: transparent;
				color: white;
				font-size: 40px;
				transition: letter-spacing 0.2s;
				transition: background-color 0.2s;
				border-radius: 10px;
				margin-bottom: 30px;
			}
			button:hover{
				letter-spacing: 2px;
				background-color: rgba(255, 255, 255, 0.3);
			}
			.subTotal{
				background-color: #707070;
				width:500px;
				height: 850px;
				border-radius: 20px;
				position: relative;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				display: flex;
				justify-content: center;
				text-align: center;
				color: white;
			}
			.valores{
				font-size: 35px;
				padding:30px;
				position: relative;
			}
			.valorCliente{
				margin-top: 30px;
				margin-bottom: 60px;
				height: 40px;
				width: 300px;
				font-size: 40px;
				border-radius: 10px;
				border: none;
			}
			.finaliza{
				color: #00d000;
				position: absolute;
				bottom: 100px;
				left: 50%;
	    			transform: translateX(-50%);
			}
			.sair{
				position: absolute;
				bottom: 0;
				right: 0;
				left: 0;
				margin-bottom: 30px;
				color: #c00000;
			}
			.Cortesia{
				color: black;
			}
			.alert {
				font-size: 100px;
				color: red;
			}
		</style>
	</head>
	<body>
		<div id="foco" class="subTotal">
			<div class="valores">
				<p>Valor total estimado <span id="subTotal">0</span></p>
				<p>Forma de pagamento:</p>
				<button class="Cortesia" id="Cortesia">Cortesia</button>
				<br>
				<text class="resultado" id="resultado"></text>
				<br>
				<button class="finaliza" id="finaliza">Finalizar Venda</button>
				<form method="post">
		        		<button class="sair" id='sair' name='voltar'>Voltar</button>
		    		</form>
			</div>
		</div>
		<?php include("../codigos_js/codigosFinalizaVendaCortesia.php");?>
	</body>
</html>
