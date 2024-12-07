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
				background-color: #2f2e2e;
			}
			button{
				border: none;
				background-color: transparent;
				height: 50px;
				width: 80px;
			}
			.menu{
				background-color: #707070; 
				margin-top: -7px;
				margin-left: -8px;
				margin-right: -7px;
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
			.combos{
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
			.combos:hover{
				letter-spacing: 1.5px;
				background-color: rgba(255, 255, 255, 0.3);
			}
			.item{
				padding-left: 10px;
				margin-top: 2px;
				background-color: white;
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
				border-radius: 15px;
			}
			.item p{
				display:block;
				position:relative;
				margin-bottom: 0px;
				margin-top: 0px;
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
				font-size: 20px;
				background-color: white;  
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
				background-color: #DDDD;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.editarEstoque input{
				font-size: 20px;  
				width: 300!important;
				height: 50px;
				background-color: #DDDD;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.editarPreco{
				display: none;
				font-size: 20px;
				background-color: white;  
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
				background-color: #DDDD;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.editarPreco input{
				font-size: 20px;  
				width: 300!important;
				height: 50px;
				background-color: #DDDD;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.cadastrarItem{
				display: none;
				font-size: 20px;
				background-color: white;  
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
				background-color: #DDDD;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.cadastrarItem input{
				font-size: 20px;  
				width: 370!important;
				height: 50px;
				background-color: #DDDD;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.removerProduto{
				display: none;
				font-size: 20px;
				background-color: white;  
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
				background-color: #DDDD;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.removerProduto input{
				font-size: 20px;  
				width: 370!important;
				height: 50px;
				background-color: #DDDD;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.castrarCombos{
				display: none;
				font-size: 20px;
				background-color: white;  
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
				background-color: #DDDD;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.castrarCombos input{
				font-size: 20px;  
				width: 370!important;
				height: 50px;
				background-color: #DDDD;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.itensCombo{
				border: solid 1px black;
				border-radius: 5px;
				position: relative;
				width: 90%;
			}
			.posicao{
				display: flex;
				position: relative;
				margin-top: 50px;
			}
			.posicaoProduto{
				display: none;
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
				<button class="novo" id="novo" name="novo" onclick="mostraCadastrar(1)">Adicionar</button>
				<button class="Remover" id="Remover" name="Remover" onclick="mostraRemover(1)">Remover</button>
				<button class="combos" id="combos" name="combos" onclick="mostraCombos(1)">Combos</button>
			</div>
		</div>
		<center>
			<div class="editarEstoque" id="editarEstoque">
				<center>
					<h3>Informe a quantidade a ser alterada do produto desejado:</h3>
					<br>
					<input type="number" id="quantidadeEstoque" value="0">
					<br>
					<button onclick="adicionarEstoque()">Adicionar</button>
					<br>
					<button onclick="removerEstoque()">Remover</button>
					<br>
					<button onclick="limitarEstoque()">limitado/ilimitado</button>
					<br>
					<button onclick="cancelarEstoque()">Cancelar</button>
				</center>
			</div>
			<div class="editarPreco" id="editarPreco">
				<center>
					<h3>Informe o novo preço do produto desejado:</h3>
					<br>
					<input type="text" inputmode="decimal" id="precoItem" value="">
					<br>
					<button onclick="alterarPreco()">Alterar</button>
					<br>
					<button onclick="cancelarPreco()">Cancelar</button>
				</center>
			</div>
			<div class="cadastrarItem" id="cadastrarItem">
				<center>
					<h3>Informe os dados do novo produto</h3>
					<br>
					<span>Nome:</span>
					<input type="text" id="nomeCadastro">
					<br>
					<span>Preço:</span>
					<input type="text" inputmode="decimal" id="precoCadastro">
					<br>
					<span>Quantidade:</span>
					<input type="number" id="quantidadeCadastro">
					<br>
					<span>Ilimitado:</span>
					<input type="checkbox" id="ilimitadoCadastro">
					<br>
					<span>Venda disponivel:</span>
					<input type="checkbox" id="emUsoCadastro">
					<br>
					<button onclick="realizarCadastro()">Cadastrar</button>
					<br>
					<button onclick="cancelarCadastro()">Cancelar</button>
				</center>
			</div>
			<div class="removerProduto" id="removerProduto">
				<center>
					<h3>Informe o nome do produto a ser removido:</h3>
					<br>
					<input type="text" id="nomeRemover" list="listaProdutos">
					<datalist id="listaProdutos"></datalist>
					<br>
					<button onclick="realizarRemover()">Remover</button>
					<br>
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
					<h3>Informe a nova posição do produto:</h3>
					<br>
					<input type="number" id="numeroPosicao" value="0">
					<br>
					<button onclick="realizarAlteraPosicao()">Alterar</button>
					<br>
					<button onclick="cancelarAlteraPosicao()">Cancelar</button>
				</center>
			</div>
		</center>
		<div id="itens">
		</div>
		<?php include('../codigos_js/codigosAdminProdutos.php')?>
		
	</body>
</html>