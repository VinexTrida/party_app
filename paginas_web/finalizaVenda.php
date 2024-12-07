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
			header("Location: caixa.php");
			exit;
		}
		//Volta para a pagina de vendas zerando o pedido
		if(isset($_POST['sair'])){
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
				background-color: #a0b7d7;
				font-size: 40px;
			}
			button{
				border: none;
				background-color: transparent;
				color: black;
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
			h4{
				margin: 0px;
				margin-bottom: 15px;
			}
			h3{
				margin: 0px;
			}
			.subTotal{
				width:550px;
				height: auto;
				border-radius: 20px;
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				display: flex;
				justify-content: center;
				text-align: center;
				color: black;
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
			}
			.sair{
				color: #4d81be;
				padding-right: 30px;
				background-image: url('../imagens/finaliza_venda/voltar.png');
				background-repeat: no-repeat;
	    		background-position: 133px center;
	    		background-size: 38px 38px;
				width: 180px;
			}
			.sair:hover{
				background-position: 137px center;
			}
			.dinheiro{
				color: black;
			}
			.alert {
				font-size: 100px;
				color: red;
			}
			.base{
				background-color: #e4e8f0;
				width: 550px;
				margin: 0px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.div-dados-cliente{
				height: 195px;
			}
			.div-finaliza{
				border: black solid 3px;
				height: 50px;
				width: 544px;
			}
			.div-sair{
				height: 50px;
			}
			.cortesia{
				display: none;
				color: white;
			}
			.cartao{
				color: white;
			}
			.pix{
				color: white;
			}
		</style>
	</head>
	<body>
		<div id="foco" class="subTotal">
			<div class="valores">
				<div class="div-valor-total base">
					<h3>Valor Total <span id="subTotal">0</span></h3>
				</div>
				<div class="div-forma-pagamento base">
					<h4>Forma de Pagamento</h4>
					<button class="dinheiro" id="dinheiro">Dinheiro</button>
					<button class="cartao" id="cartao">Cartão</button>
					<button class="pix" id="pix">Pix</button>
					<center>
						<button class="cortesia" id="cortesia">Cortesia</button>
					</center>
				</div>
				<div id="dadosCliente" class="div-dados-cliente base">
					<span id="labelValorCliente" >Valor</span>
					<input type="text" inputmode="decimal" value="" id="valorCliente" class="valorCliente">
					<br>
					<text class="resultado" id="resultado"></text>
				</div>
				<div class="div-finaliza base">
					<button class="finaliza" id="finaliza">Finalizar Venda</button>
				</div>
				<div class="div-sair base">
					<form method="post">
						<button class="sair" id='sair' name='voltar'>Voltar</button>
					</form>
				</div>
			</div>
		</div>
		<?php include("../codigos_js/codigosFinalizaVenda.php");?>
	</body>
</html>
