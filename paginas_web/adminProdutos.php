<?php
	include('../conexoes_bd/conex.php');
  	session_start();
  	if(!isset($_SESSION['nome'])){
    		session_destroy();
    		header("Location: ../index.php");
		exit;
  	}
  	if($_SESSION['admin'] !== '1'){
  		session_destroy();
    		header("Location: ../index.php");
		exit;
  	}
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
			}
			button{
				border: none;
				background-color: transparent;
				height: 50px;
				width: 80px;
			}
			.menu{
				background-color: #4d81be; 
				margin-top: -7px;
				margin-left: -8px;
				margin-right: -7px;
	  			height: 50px;
			}
			.botoesMenu{
				display: inline;	
			}
			.voltar{
				width: 115px;
				transition: letter-spacing 0.2s;
				height: 50px;
				display: block;
				float: right;
				color: white;
				cursor: pointer;
				padding-right: 35px;
				transition: background-color 0.2s;
				font-size: 27px;
				background-image: url('../imagens/produtos/voltar.png');
				background-repeat: no-repeat;
		    		background-position: 80px;
		    		background-size: 35px 35px;
			}
			.voltar:hover{
				letter-spacing: 1.5px;
				background-color: rgba(255, 255, 255, 0.3);
				background-position: 84px center;
			}
			.novo{
				width: 168px;
				transition: letter-spacing 0.2s;
				height: 50px;
				display: block;
				float: right;
				color: white;
				cursor: pointer;
				padding-right: 35px;
				transition: background-color 0.2s;
				font-size: 27px;
				background-image: url('../imagens/produtos/adicionarproduto.png');
				background-repeat: no-repeat;
		    		background-position: 130px;
		    		background-size: 35px 35px;
			}
			.novo:hover{
				letter-spacing: 1.5px;
				background-color: rgba(255, 255, 255, 0.3);
				background-position: 134px center;
			}
			.remover{
				width: 158px;
				transition: letter-spacing 0.2s;
				height: 50px;
				display: block;
				float: right;
				color: white;
				cursor: pointer;
				padding-right: 38px;
				transition: background-color 0.2s;
				font-size: 27px;
				background-image: url('../imagens/produtos/removerproduto.png');
				background-repeat: no-repeat;
	    			background-position: 120px;
	    			background-size: 35px 35px;
			}
			.remover:hover{
				letter-spacing: 1.5px;
				background-color: rgba(255, 255, 255, 0.3);
				background-position: 124px center;
			}
			.combos{
				width: 149px;
				transition: letter-spacing 0.2s;
				height: 50px;
				display: block;
				float: right;
				color: white;
				cursor: pointer;
				padding-right: 48px;
				transition: background-color 0.2s;
				font-size: 27px;
				background-image: url('../imagens/produtos/combo.png');
				background-repeat: no-repeat;
	    			background-position: 111px;
	    			background-size: 35px 35px;
			}
			.combos:hover{
				letter-spacing: 1.5px;
				background-color: rgba(255, 255, 255, 0.3);
				background-position: 114px center;
			}
			.item{
				padding-left: 10px;
				margin-top: 8px;
				background-color: #e4e8f0;
				height: 110px;
				border-radius: 5px;
				font-size: 20px;	
				display: flex;
				align-items: center;
				position: relative;
			}
			.item button{
				width: auto!important;
				height: 35px;
				font-size: 15px;  
				border-radius: 7px;
			}
			.item p{
				display:block;
				position:relative;
				margin-bottom: 0px;
				margin-top: 30px;
			}
			.botoes{
				position: absolute;
				right: 10px;
				margin-left: auto;
				top: 50%;
				transform: translateY(-50%);
				display: flex;
				flex-direction: column;
				
			}
			.quantidade{
				position: absolute;
				right: 5px;
				margin-left: auto;
				margin-right: 150px;
				top: 50%;
				transform: translateY(-50%);
				border-radius: 5px;
				color: black;
				font-weight: bold;
			}
			.editarEstoque{
				display: none;
				padding-top: 5px;
				font-size: 20px;
				background-color: #e4e8f0;  
				border-radius: 10px;
				width: 400px;
				justify-content: center;
				text-align: center;
				flex-direction: column;
				align-items: center;
			}
			.editarEstoque button{
				font-size: 20px;  
				width: 300!important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.editarEstoque input{
				font-size: 20px;  
				width: 300!important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.editarPreco{
				display: none;
				padding-top: 5px;
				font-size: 20px;
				background-color: #e4e8f0;  
				border-radius: 10px;
				width: 400px;
				justify-content: center;
				text-align: center;
				flex-direction: column;
				align-items: center; 
			}
			.editarPreco button{
				font-size: 20px;  
				width: 300!important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.editarPreco input{
				font-size: 20px;  
				width: 300!important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.cadastrarItem{
				display: none;
				font-size: 20px;
				padding-top: 5px;
				background-color: #e4e8f0;  
				border-radius: 10px;
				width: 400px;
				justify-content: center;
				text-align: center;
				flex-direction: column;
				align-items: center; 
			}
			.cadastrarItem button{
				font-size: 20px;  
				width: 300!important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.cadastrarItem input{
				font-size: 20px;  
				width: 370!important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.removerProduto{
				display: none;
				font-size: 20px;
				padding-top: 5px;
				background-color: #e4e8f0;;  
				border-radius: 10px;
				width: 400px;
				justify-content: center;
				text-align: center;
				flex-direction: column;
				align-items: center; 
			}
			.removerProduto button{
				font-size: 20px;  
				width: 300!important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.removerProduto input{
				font-size: 20px;  
				width: 370!important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.castrarCombos{
				display: none;
				font-size: 20px;
				padding-top: 5px;
				background-color: #e4e8f0;
				border-radius: 10px;
				width: 400px;
				justify-content: center;
				text-align: center;
				flex-direction: column;
				align-items: center; 
			}
			.castrarCombos button{
				font-size: 20px;  
				width: 300!important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.castrarCombos input{
				font-size: 20px;  
				width: 370!important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.itensCombo{
				border: solid 1px black;
				border-radius: 5px;
				position: relative;
				width: 90%;
				background-color: white;
			}
			.posicao{
				display: flex;
				position: relative;
				margin-top: 20px;
			}
			.posicaoProduto{
				display: none;
			}
			.cadastrarItem{
				background-color: #e4e8f0;
			}
			.posicaoproduto{
				padding-top: 5px;
				display: none;
				font-size: 20px;
				background-color: #e4e8f0;
				border-radius: 10px;
				width: 400px;
				justify-content: center;
				text-align: center;
				flex-direction: column;
				align-items: center; 
			}
			.posicaoproduto button{
				font-size: 20px;
				width: 300 !important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
	 		}
			.posicaoproduto input{
				font-size: 20px;
				width: 300 !important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.caixas{
				margin-right: 350px;
			}
			.botaoCaixas{
				margin-right: 280px;
			}
			.caixasProduto{
				display: none;
			}
			.caixasProduto{
				padding-top: 5px;
				display: none;
				font-size: 20px;
				background-color: #e4e8f0;
				border-radius: 10px;
				width: 400px;
				justify-content: center;
				text-align: center;
				flex-direction: column;
				align-items: center; 
			}
			.caixasProduto button{
				font-size: 20px;
				width: 300 !important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
	 		}
			.caixasProduto input{
				font-size: 5px;
				width: 25px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.numerosCaixas{
				word-spacing: 10px;
			}
		</style>
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Caixa</title>
	</head>
	
	<body>
		<div id="menu" class="menu">
			<div class="botoesMenu">
				<form method="post">
					<button class="voltar" name='voltar'>Voltar</button>	
				</form>
				<button class="combos" id="combos" name="combos" onclick="mostraCombos(1)">Combos</button>
				<button class="Remover" id="Remover" name="Remover" onclick="mostraRemover(1)">Remover</button>
				<button class="novo" id="novo" name="novo" onclick="mostraCadastrar(1)">Adicionar</button>
			</div>
		</div>
		<center>
			<div class="editarEstoque" id="editarEstoque">
				<center>
					<h3>Informe a quantidade a ser alterada do produto desejado</h3>
					<input type="number" id="quantidadeEstoque" value="0">
					<button onclick="adicionarEstoque()">Adicionar</button>
					<button onclick="removerEstoque()">Remover</button>
					<button onclick="limitarEstoque()">limitado/ilimitado</button>
					<button onclick="cancelarEstoque()">Cancelar</button>
				</center>
			</div>
			<div class="editarPreco" id="editarPreco">
				<center>
					<h3>Informe o novo preço do produto desejado</h3>
					<input type="text" inputmode="decimal" id="precoItem" value="">
					<button onclick="alterarPreco()">Alterar</button>
					<button onclick="cancelarPreco()">Cancelar</button>
				</center>
			</div>
			<div class="cadastrarItem" id="cadastrarItem">
				<center>
					<h3>Informe os dados do novo produto</h3>
					<span>Nome:</span>
					<input type="text" id="nomeCadastro">
					<span>Preço:</span>
					<input type="text" inputmode="decimal" id="precoCadastro">
					<span>Quantidade:</span>
					<input type="number" id="quantidadeCadastro">
					<span>Ilimitado:</span>
					<input type="checkbox" id="ilimitadoCadastro">
					<span>Venda disponivel:</span>
					<input type="checkbox" id="emUsoCadastro">
					<button onclick="realizarCadastro()">Cadastrar</button>
					<button onclick="cancelarCadastro()">Cancelar</button>
				</center>
			</div>
			<div class="removerProduto" id="removerProduto">
				<center>
					<h3>Informe o produto a ser removido</h3>
					<input type="text" id="nomeRemover" list="listaProdutos">
					<datalist id="listaProdutos">
					</datalist>
					<button onclick="realizarRemover()">Remover</button>
					<button onclick="cancelarRemover()">Cancelar</button>
				</center>
			</div>
			<div class="castrarCombos" id="castrarCombos">
				<center>
					<h3>Informe os dados do novo combo</h3>
					<br>
					<span>Informe o nome do combo:</span>
					<input type="text" id="nomeCombo">
					<br>
					<span>Informe o preço do combo:</span>
					<input type="text" id="precoCombo" inputmode="decimal">
					<br>
					<span>Quantidade do Combo:</span>
					<input type="number" id="quantidadeCombo">
					<br>
					<span>Ilimitado:</span>
					<input type="checkbox" id="ilimitadoCombo">
					<br>
					<span>Venda disponivel:</span>
					<input type="checkbox" id="emUsoCombo">
					<br>
					<span>Produtos do combo:</span>
					<div class="itensCombo" id="itensCombo"></div>
					<br>
					<span>Nome do produto:</span>
					<input type="text" id="inputItemCombo" list="listaProdutos">
					<datalist id="listaProdutos"></datalist>
					<span>Quantidade do produto:</span>
					<input type="number" id="inputNumeroCombo" value="">
					<br>
					<button onclick="adicionarProdutoCombo()">Adicionar Produto</button>
					<br>
					<br>
					<button onclick="realizarCombo()">Confirmar</button>
					<br>
					<button onclick="cancelarCombo()">Cancelar</button>
				</center>
			</div>
			<div class="posicaoProduto" id="posicaoProduto">
				<center>
					<h3>Informe a nova posição do produto</h3>
					<input type="number" id="numeroPosicao" value="0">
					<button onclick="realizarAlteraPosicao()">Alterar</button>
					<button onclick="cancelarAlteraPosicao()">Cancelar</button>
				</center>
			</div>
			<div class="caixasProduto" id="caixasProduto">
				<center>
					<h3>Informe os caixas no qual o produto vai aparecer</h3>
					<span class="numerosCaixas">01 02 03 04 05 06 07</span>
					<br>
					<input type="checkbox" id="caixasProdutos1" value="1">
					<input type="checkbox" id="caixasProdutos2" value="2">
					<input type="checkbox" id="caixasProdutos3" value="3">
					<input type="checkbox" id="caixasProdutos4" value="4">
					<input type="checkbox" id="caixasProdutos5" value="5">
					<input type="checkbox" id="caixasProdutos6" value="6">
					<input type="checkbox" id="caixasProdutos7" value="7">
					<br>
					<span class="numerosCaixas">08 09 10 11 12 13 14</span>
					<br>
					<input type="checkbox" id="caixasProdutos8" value="8">
					<input type="checkbox" id="caixasProdutos9" value="9">
					<input type="checkbox" id="caixasProdutos10" value="10">
					<input type="checkbox" id="caixasProdutos11" value="11">
					<input type="checkbox" id="caixasProdutos12" value="12">
					<input type="checkbox" id="caixasProdutos13" value="13">
					<input type="checkbox" id="caixasProdutos14" value="14">
					
					<button onclick="realizarAlteraCaixa()">Alterar</button>
					<button onclick="cancelarAlteraCaixa()">Cancelar</button>
				</center>
			</div>
		</center>
		<div id="itens">
		</div>
		<?php include('../codigos_js/codigosAdminProdutos.php')?>
		
	</body>
</html>
