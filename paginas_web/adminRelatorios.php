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
				background-color: #a0b7d7;
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
				background-color: #4d81be; 
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
				background-image: url('../imagens/relatorio/voltar.png');
				background-repeat: no-repeat;
	    		background-position: 123px center;
	    		background-size: 32px 32px;
			}
			.voltar:hover{
				letter-spacing: 1.5px;
				background-color: rgba(255, 255, 255, 0.3);
				background-position: 127px center;
			}
			.novo{
				width: 150px;
				transition: letter-spacing 0.2s;
				height: 50px;
				display: block;
				float: right;
				color: white;
				cursor: pointer;
				padding-right: 40px;
				transition: background-color 0.2s;
				font-size: 29px;
				background-image: url('../imagens/relatorio/reimprimir.png');
				background-repeat: no-repeat;
	    		background-position: 105px center;
	    		background-size: 35px 35px;
			}
			.novo:hover{
				letter-spacing: 1.5px;
				background-color: rgba(255, 255, 255, 0.3);
				background-position: 107px center;
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
			.data-conteudo{
				width: 450px;
				
			}
			.data-conteudo input{
				width: 310px;
				border: 2px solid black;
				float: right;
				transform: translateY(-25%);
			}
			.caixaFundo{
				background-color: #e4e8f0;
				margin-bottom: 10px;
				border-radius: 10px;
				padding-top: 15px;
				padding-bottom: 15px;
			}
			.relatorio{
				background-color: #e4e8f0;
				margin-bottom: 10px;
				border-radius: 10px;
			}
			.relatorio button{
				font-size: 32px;
				width: auto
			}
			.caixas{
				background-color: #e4e8f0;
				margin-bottom: 10px;
				border-radius: 10px;
				align-items: center;
			}
			.caixas button{
				font-size: 32px;
				width: 70!important;
			}
			.operadores{
				background-color: #e4e8f0;
				margin-bottom: 10px;
				border-radius: 10px;
				display: none;
			}
			.operadores button{
				font-size: 32px;
				width: 120!important;
			}
			.saidasCaixa{
				background-color: #e4e8f0;
				margin-bottom: 10px;
				border-radius: 10px;
			}
			.saidasCaixa button{
				font-size: 32px;
				width: auto
			}
			.pagamento{
				background-color: #e4e8f0;
				margin-bottom: 10px;
				border-radius: 10px;
			}
			.pagamento button{
				font-size: 32px;
				width: 100;
			}
			.relatorio button{
				font-size: 32px;
				width: auto
			}
			.data{
				background-color: #e4e8f0;
				margin-bottom: 10px;
				border-radius: 10px;
			}
			.fundo-branco-relatorio{
				background-color: #ffffff;
				margin-bottom: 5px;
				border-radius: 5px;
			}
			.fundo-branco-caixas{
				background-color: #ffffff;
				margin-bottom: 5px;
				border-radius: 5px;
			}
			.fundo-branco-pagamentos{
				background-color: #ffffff;
				margin-bottom: 5px;
				border-radius: 5px;
			}
			.titulo-caixa{
				margin-top: 25px!important;
			}
			.pagamentocartao{
				width: 110px!important;
			}
			.pagamentodinheiro{
				width: 130px!important;
			}
			.pagamentoPix{
				width: 60px!important;
			}
			.pagamentocortesia{
				width: 120px!important;
			}
			.pagamentosangria{
				width: 100px!important;
			}
			.fundo-branco-saidas{
				background-color: #ffffff;
				margin-bottom: 5px;
				border-radius: 5px;
			}
			.fundo-branco-operadores{
				background-color: #ffffff;
				margin-bottom: 5px;
				border-radius: 5px;
			}
			.fundo-branco-operadores button{
				width: 130px!important;
			}
			#data-inicio{
				margin-top: 19px;
			}
			#data-fim{
				margin-top: 19px;
			}
			#hora-inicio{
				margin-top: 19px;
			}
			#hora-fim{
				margin-top: 19px;
			}
			.margem-titulo-data-hora{
				margin-left: 130px;
			}
			#saidatodos{
				color: black;
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
			<div class="caixaFundo">
				<span>Selecione os Itens que irão aparecer no Relatório</span>
			</div>
				<div class="relatorio">
					<span>Tipo do Relatório</span>
					<img src="../imagens/relatorio/relatorio.png" alt="Caixa Icon" style="width: 37px; height: 37px; vertical-align: middle; margin-top: -8px;">
					<div class="fundo-branco-relatorio">
						<button id="tipo1" value="1" onclick="selecionaTipo(1)">Completo</button>
						<button id="tipo2" value="2" onclick="selecionaTipo(2)">Resumido</button>
					</div>
				</div>
				<div class="caixas">
					<span class="titulo-caixa">
						Caixas
						<img src="../imagens/relatorio/caixas.png" alt="Caixa Icon" style="width: 35px; height: 35px; vertical-align: middle; margin-top: -8px;">
					</span>
					<br>
					<div class="fundo-branco-caixas">
						<button id="caixa1" value="1" onclick="selecionaCaixa(1)">01</button>
						<button id="caixa2" value="2" onclick="selecionaCaixa(2)">02</button>
						<button id="caixa3" value="3" onclick="selecionaCaixa(3)">03</button>
						<button id="caixa4" value="4" onclick="selecionaCaixa(4)">04</button>
						<button id="caixa5" value="5" onclick="selecionaCaixa(5)">05</button>
						<button id="caixa6" value="6" onclick="selecionaCaixa(6)">06</button>
						<button id="caixa7" value="7" onclick="selecionaCaixa(7)">07</button>
						<br>
						<button id="caixa8" value="8" onclick="selecionaCaixa(8)">08</button>
						<button id="caixa9" value="9" onclick="selecionaCaixa(9)">09</button>
						<button id="caixa10" value="10" onclick="selecionaCaixa(10)">10</button>
						<button id="caixa11" value="11" onclick="selecionaCaixa(11)">11</button>
						<button id="caixa12" value="12" onclick="selecionaCaixa(12)">12</button>
						<button id="caixa13" value="13" onclick="selecionaCaixa(13)">13</button>
						<button id="caixa14" value="14" onclick="selecionaCaixa(14)">14</button>
						<br>
						<button id="caixa0" value="1" onclick="selecionaCaixa(-1)">Todos</button>
					</div>
				</div>
				<div class="operadores">
					<span class="titulo-operadores">
						Operadores
						<img src="../imagens/relatorio/operador.png" alt="Caixa Icon" style="width: 48px; height: 48px; vertical-align: middle; margin-top: -8px;">
					</span>
					<br>
					<div class="fundo-branco-operadores">
						<button id="tablet1" value="1" onclick="selecionaOperador('tablet1')">Tablet01</button>
						<button id="tablet2" value="2" onclick="selecionaOperador('tablet2')">Tablet02</button>
						<button id="tablet3" value="3" onclick="selecionaOperador('tablet3')">Tablet03</button>
						<button id="tablet4" value="4" onclick="selecionaOperador('tablet4')">Tablet04</button>
						<button id="tablet5" value="5" onclick="selecionaOperador('tablet5')">Tablet05</button>
						<button id="tablet6" value="6" onclick="selecionaOperador('tablet6')">Tablet06</button>
						<button id="tablet7" value="7" onclick="selecionaOperador('tablet7')">Tablet07</button>
						<button id="tablet8" value="8" onclick="selecionaOperador('tablet8')">Tablet08</button>
						<button id="tablet9" value="9" onclick="selecionaOperador('tablet9')">Tablet09</button>
						<button id="tablet10" value="10" onclick="selecionaOperador('tablet10')">Tablet10</button>
						<button id="tablet11" value="11" onclick="selecionaOperador('tablet11')">Tablet11</button>
						<button id="tablet12" value="12" onclick="selecionaOperador('tablet12')">Tablet12</button>
						<button id="tablet13" value="13" onclick="selecionaOperador('tablet13')">Tablet13</button>
						<button id="tablet14" value="14" onclick="selecionaOperador('tablet14')">Tablet14</button>
						<br>
						<button id="tablet0" value="1" onclick="selecionaOperador(-1)">Todos</button>
					</div>
				</div>
				<div class="pagamento">
					<span>
						Formas de Pagamento
						<img src="../imagens/relatorio/pagamentos.png" alt="Ícone de Formas de Pagamento" style="width: 42px; height: 35px; vertical-align: middle; margin-left: 2px;">
					</span>
					<div class="fundo-branco-pagamentos">
						<button id="pagamentocartao" class="pagamentocartao" value="cartao" onclick="selecionaPagamento('cartao')">Cartão</button>
						<button id="pagamentodinheiro" class="pagamentodinheiro" value="dinheiro" onclick="selecionaPagamento('dinheiro')">Dinheiro</button>
						<button id="pagamentopix" class="pagamentoPix" value="pix" onclick="selecionaPagamento('pix')">Pix</button>
						<button id="pagamentocortesia" class="pagamentocortesia" value="cortesia" onclick="selecionaPagamento('cortesia')">Cortesia</button>
						<br>
						<button id="pagamento0" value="1" onclick="selecionaPagamento(-1)">Todos</button>
					</div>
				</div>
				<div class="saidasCaixa">
					<span>
						Saídas do caixa
						<img src="../imagens/relatorio/saidas.png" alt="Ícone de Formas de Pagamento" style="width: 40px; height: 40px; vertical-align: middle; margin-left: 2px; margin-top: -8px;">
					    
					<div class="fundo-branco-saidas">
						<button id="saidasangria" class="saidasangria" value="sangria" onclick="selecionaSaida('sangria')">Sangrias</button>
						<button id="saidadevolucao" class="saidadevolucao" value="devolucao" onclick="selecionaSaida('devolucao')">Devoluções</button>
						<br>
						<button id="saida0" value="1" onclick="selecionaSaida(-1)">Todos</button>
					    </div>
				    </div>
				<div class="data">
					<span class="margem-titulo-data-hora">
						Data
						<img src="../imagens/relatorio/calendario.png" alt="Ícone de Formas de Pagamento" style="width: 40px; height: 40px; vertical-align: middle;">
					</span>
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
					<span class="margem-titulo-data-hora">
						Hora
						<img src="../imagens/relatorio/relogio.png" alt="Ícone de Formas de Pagamento" style="width: 40px; height: 40px; vertical-align: middle;">
					</span>
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
			
		</center>
		<?php include('../codigos_js/codigosAdminRelatorios.php')?>
	</body>
</html>
