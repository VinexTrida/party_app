<?php
	//Tela de vendas do caixa
	//Redirecionamento direto da tela de login(index)
	
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
		//Volta para a pagina de login(index)
		if(isset($_POST['sair'])){
			session_unset();
			session_destroy();
			header("Location: ../index.php");
			exit;
		}
			
		//Vai para a página que mostra o historico de vendas do dia
		if(isset($_POST['log'])){
			header("Location: logVendas.php");
			exit;
		}
		
		//Vai para a página que permite fazer a retirada de dinheiro do caixa
		if(isset($_POST['saque'])){
			//Verifica se o usuario tem permissão de administrador para ser redirecionado
			if($_SESSION['admin'] == 1){
				header("Location: adminSaqueCaixa.php");
				exit;
			}else{
				echo "<script>
					alert('Usuario sem permissão para acessar essa página.');
				</script>";
			}
		}
		//Vai para a página que permite fazer a devolução de produtos
		if(isset($_POST['devolucoes'])){
			//Verifica se o usuario tem permissão de administrador para ser redirecionado
			if($_SESSION['admin'] == 1){
				header("Location: adminDevolucoes.php");
				exit;
			}else{
				echo "<script>
					alert('Usuario sem permissão para acessar essa página.');
				</script>";
			}
		}
		
		//Vai para pagina de configuração de produtos
		if(isset($_POST['produtos'])){
			//Verifica se o usuario tem permissão de administrador para ser redirecionado
			if($_SESSION['admin'] == 1){
				header("Location: adminProdutos.php");
				exit;
			}else{
				echo "<script>
					alert('Usuario sem permissão para acessar essa página.');
				</script>";
			}
		}
		
		//Vai para a pagina de configuração de operadores
		if(isset($_POST['operadores'])){
			//Verifica se o usuario tem permissão de administrador para ser redirecionado
			if($_SESSION['admin'] == 1){
				header("Location: adminOperadores.php");
				exit;
			}else{
				echo "<script>
					alert('Usuario sem permissão para acessar essa página.');
				</script>";
			}
		}
		
		//Vai para a pagina de geração de relatorios
		if(isset($_POST['relatorios'])){
			//Verifica se o usuario tem permissão de administrador para ser redirecionado
			if($_SESSION['admin'] == 1){
				header("Location: adminRelatorios.php");
				exit;
			}else{
				echo "<script>
					alert('Usuario sem permissão para acessar essa página.');
				</script>";
			}
		}
		
		//Vai para a pagina de exclusão de cupons
		if(isset($_POST['cupons'])){
			//Verifica se o usuario tem permissão de administrador para ser redirecionado
			if($_SESSION['admin'] == 1){
				header("Location: adminCupons.php");
				exit;
			}else{
				echo "<script>
					alert('Usuario sem permissão para acessar essa página.');
				</script>";
			}
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
				background-image: url('../imagens/caixa/logobrancatransparenteperpetuosocorro.png');
				background-repeat: no-repeat;
	    			background-position: center center;
	    			background-size: 670px 670px;
	    			transition: background-size 0.2s;
	    			height: 50px;
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
				background-color: #4d81be; 
				display: block;
				margin-top: -8px;
				margin-left: -8px;
				margin-right: -8px;
			}
			.sair{
				width: 170px;
				transition: letter-spacing 0.2s;
				height: 50px;
				display: block;
				float: right;
				color: white;
				cursor: pointer;
				padding-right: 20px;
				transition: background-color 0.2s;
				font-size: 29px;
				background-image: url('../imagens/caixa/sair.png');
				background-repeat: no-repeat;
		    		background-position: 115px center;
		    		background-size: 30px 30px;
			}
			.sair:hover{
				letter-spacing: 2px;
				background-color: rgba(2, 81, 123, 0.3);
				background-position: 119px center;
			}
			.log{
				width: 220px;
				transition: letter-spacing 0.2s;
				height: 50px;
				display: block;
				float: right;
				color: white;
				cursor: pointer;
				padding-right: 40px;
				transition: background-color 0.2s;
				font-size: 29px;
				background-image: url('../imagens/caixa/reimprimir.png');
				background-repeat: no-repeat;
		    		background-position: 175px center;
		    		background-size: 35px 35px;
			}
			.log:hover{
				letter-spacing: 2px;
				background-color: rgba(2, 81, 123, 0.3);
				background-position: 179px center;
			}
			.dropdown-menu{
				margin-top:50px;
				position: absolute;
				display: none;
				border: solid #3772aa;
				background-color: white;
			}
			.dropdown-menu button{
				display: block;
				color: #0484c8;
				font-size: 25px;
				width: 195px;
				text-align: left;
				padding-left: 25px;
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
				width: 200px;
				background-image: url('../imagens/caixa/menu.png');
				background-repeat: no-repeat;
	    			background-position: center center;
	    			background-size: 55px 55px;
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
				background-color: rgba(2, 81, 123, 0.3);
			}
			.item{
				padding-left: 10px;
				margin-top: 7.2px;
				background-color: #e4e8f0;
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
				padding-left: 40px;
				color: red;
			}
			.mais{
				padding-right: 40px;
				color: #009400;
			}
			.item p{
				display:flex;
				margin-left: 10px;
				float: right;
				position:relative;			
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
				background-color: #e4e8f0;
			}
			.final-pagina{
				height:	50px;
				margin-left: -8px;                   
				width: 100%;
				background-color: white;
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
				color: #009400;
				font-weight: bold;
				
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
							<button class="sair" name='sair'>Sair</button>
						</li>
							    			
						<li>
							<button class="log" name="log">Reimprimir</button>
						</li>
						
						<li id="dropdown" class="dropdown">
							<a class="config" name=''></a>
							<div class="dropdown-menu">
								<button class="dropdown-button" name="produtos">Produtos</button>
								<button class="dropdown-button" name="saque">Sangria</button>
								<button class="dropdown-button" name="cupons">Cupons</button>
								<button class="dropdown-button" name="devolucoes">Devoluções</button>
								<button class="dropdown-button" name="operadores">Usuários</button>
								<button class="dropdown-button" name="relatorios">Relatorios</button>
							</div>
						</li>
					</ul>
				</nav>
			</form>
		</div>
		<div class="itens" id="itens"></div>
		<div class="final-pagina-espaco"></div>
				     
		<div class="final-pagina" action="finalizaVenda.php"> 
			<p class="valorSubTotal">Valor Total <span id="subTotal">0</span></p> 
			<form method="post" id="formularioSubTotal" action="finalizaVenda.php" class="formSubTotal" onsubmit="return validarEnvio()">
				<button class="enviaSubTotal" id="enviaSubTotal" name='enviaSubTotal' value="0">SubTotal</button>
				<input type="text" class="valoresListaEnvio" id="valoresLista" value="">
			</form>
		</div>
	</body>
	<?php include('../codigos_js/codigosCaixa.php')?>
</html>
