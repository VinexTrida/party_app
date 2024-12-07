<?php
	//Tela de geração de relatório
	//Redirecionamento direto da tela de vendas(caixa)
	
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
	//Volta para a tela de vendas
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
				font-size: 40px;
			}
			button{
				border: none;
				background-color: transparent;
				height: 50px;
				width: 80px;
			}
			select{
				font-size: 20px;  
				width: 370!important;
				height: 50px;
				background-color: #DDDD;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.menu{
				background-color: #707070; 
				margin-top: -7px;
				margin-left: -8px;
				margin-right: -7px;
				margin-bottom: 5px;
	  			height: 50px;
			}
			.botoesMenu{
				display: inline;	
			}
			.voltar{
				width: 80px;
				transition: letter-spacing 0.2s;
				height: 50px;
				display: block;
				float: right;
				color: black;
				cursor: pointer;
				transition: background-color 0.2s;
				font-size: 25px;
			}
			.voltar:hover{
				letter-spacing: 1.5px;
				background-color: rgba(255, 255, 255, 0.3);
			}
			.novo{
				width: 130px;
				transition: letter-spacing 0.2s;
				height: 50px;
				display: block;
				float: right;
				color: black;
				cursor: pointer;
				transition: background-color 0.2s;
				font-size: 25px;
			}
			.novo:hover{
				letter-spacing: 1.5px;
				background-color: rgba(255, 255, 255, 0.3);
			}
			.remover{
				width: 120px;
				transition: letter-spacing 0.2s;
				height: 50px;
				display: block;
				float: right;
				color: black;
				cursor: pointer;
				transition: background-color 0.2s;
				font-size: 25px;
			}
			.remover:hover{
				letter-spacing: 1.5px;
				background-color: rgba(255, 255, 255, 0.3);
			}
			.usuarios{
				padding-left: 10px;
				margin-top: 2px;
				background-color: white;
				height: 100px;
				border-radius: 5px;
				font-size: 20px;	
				display: flex;
				align-items: center;
				position: relative;
			}
			.usuarios button{
				width: auto!important;
				font-size: 20px;  
			}
			.usuarios p{
				display:flex;
				float: right;
				position:relative;			
			}
			.usuarios label{
				font-size: 20px;
				margin-right: 50px;		
			}
			.botoes{
				position: absolute;
				right: 10px;
				margin-left: auto;
				top: 50%;
				transform: translateY(-50%);
				font-size: 10px;
				display: flex;
				flex-direction: column;
				display: inline-block;
			}
			.quantidade{
				position: absolute;
				right: 10px;
				margin-left: auto;
				margin-right: 200px;
				top: 50%;
				transform: translateY(-50%);
				border-radius: 20px;
				color: black;
				font-weight: bold;
			}
			.opcoes{
				display: block;
				background-color: #707070;
				border-radius: 20px;
				padding: 50px;
				width: 500px;
			}
			.opcoes *{
				font-size: 35px;
			}
			.opcoes button{
				width: auto;
			}
			.opcoes input{
				margin-top: 10px;
				border-radius: 5px;
				border: none;
				background-color: transparent;
			}
			.data-conteudo{
				width: 450px;
			}
			.data-conteudo input{
				width: 310px;
				border: 2px solid black;
				float: right;
				transform: translateY(-25%);
			}
		</style>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Caixa</title>
	</head>
	
	<body>
		<div class="menu">
			<div class="botoesMenu">
				<form method="post">
					<button class="voltar" name='voltar'>Voltar</button>	
				</form>
				<form method="post" action="../conexoes_bd/relatorios.php" onsubmit="return chamarRelatorio()">
					<button class="novo" id="gerar" name="gerar">Gerar</button>
					<input type="hidden" name="tipo" id="enviaTipo" value="">
					<input type="hidden" name="caixas" id="enviaCaixas" value="">
					<input type="hidden" name="operadores" id="enviaOperadores" value="">
					<input type="hidden" name="pagamentos" id="enviaPagamentos" value="">
					<input type="hidden" name="dataInicio" id="enviaDataInicio" value="">
					<input type="hidden" name="dataFim" id="enviaDataFim" value="">
					<input type="hidden" name="horaInicio" id="enviaHoraInicio" value="">
					<input type="hidden" name="horaFim" id="enviaHoraFim" value="">
				</form>
			</div>
		</div>
		<center>
			<div class="opcoes">
				<span>Selecione os itens que irão aparecer no relatório:</span>
				<br>
				<br>
				<div class="caixas">
					<span>Tipo do relatório:</span>
					<br>
					<button id="tipo1" value="1" onclick="selecionaTipo(1)">Completo</button>
					<br>
					<button id="tipo2" value="2" onclick="selecionaTipo(2)">Resumido</button>
					
				</div>
				<div class="caixas">
					<br>
					<span>Caixas:</span>
					<br>
					<button id="caixa0" value="1" onclick="selecionaCaixa(-1)">Todos</button>
					<br>
					<button id="caixa1" value="1" onclick="selecionaCaixa(1)">01</button>
					<button id="caixa2" value="2" onclick="selecionaCaixa(2)">02</button>
					<button id="caixa3" value="3" onclick="selecionaCaixa(3)">03</button>
					<button id="caixa4" value="4" onclick="selecionaCaixa(4)">04</button>
					<button id="caixa5" value="5" onclick="selecionaCaixa(5)">05</button>
					<br>
					<button id="caixa6" value="6" onclick="selecionaCaixa(6)">06</button>
					<button id="caixa7" value="7" onclick="selecionaCaixa(7)">07</button>
					<button id="caixa8" value="8" onclick="selecionaCaixa(8)">08</button>
					<button id="caixa9" value="9" onclick="selecionaCaixa(9)">09</button>
					<button id="caixa10" value="10" onclick="selecionaCaixa(10)">10</button>
					<br>
					<button id="caixa11" value="11" onclick="selecionaCaixa(11)">11</button>
					<button id="caixa12" value="12" onclick="selecionaCaixa(12)">12</button>
					<button id="caixa13" value="13" onclick="selecionaCaixa(13)">13</button>
					<button id="caixa14" value="14" onclick="selecionaCaixa(14)">14</button>
				</div>
				<div class="operadores">
					<br>
					<span>Operadores:</span>
					<br>
					<button id="operador0" value="1" onclick="selecionaOperador(-1)">Todos</button>
					<br>
					<div id="lista-operadores">
					</div>
				</div>
				<div class="pagamento">
					<br>
					<span>Formas de pagamento:</span>
					<br>
					<button id="pagamento0" value="1" onclick="selecionaPagamento(-1)">Todos</button>
					<br>
					<button id="pagamentocartao" value="cartao" onclick="selecionaPagamento('cartao')">cartao</button>
					<button id="pagamentodinheiro" value="dinheiro" onclick="selecionaPagamento('dinheiro')">dinheiro</button>
					<button id="pagamentopix" value="pix" onclick="selecionaPagamento('pix')">pix</button>
					<br>
					<button id="pagamentocortesia" value="cortesia" onclick="selecionaPagamento('cortesia')">cortesias</button>
					<button id="pagamentosangria" value="sangria" onclick="selecionaPagamento('sangria')">sangrias</button>
				</div>
				<div class="data">
					<br>
					<span>Data:</span>
					<br>
					<div class="data-conteudo">
						<span>Início:</span>
						<input id="data-inicio" type="date" >
					</div>
					<br>
					<div class="data-conteudo">
						<span>Fim:</span>
						<input id="data-fim" type="date" >
					</div>
					<br>
					<span>Hora:</span>
					<br>
					<div class="data-conteudo">
						<span>Início:</span>
						<input id="hora-inicio" type="text" inputmode="decimal">
					</div>
					<br>
					<div class="data-conteudo">
						<span>Fim:</span>
						<input id="hora-fim" type="text" inputmode="decimal">
					</div>
				</div>
			</div>
		</center>
		<?php include('../codigos_js/codigosAdminRelatorios.php')?>
	</body>
</html>
